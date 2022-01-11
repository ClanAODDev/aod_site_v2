<?php

namespace App\Http\Controllers;

use App\Repositories\AOD\SocialRepository;
use Carbon\CarbonImmutable;

class HomeController extends Controller
{
    public function __invoke()
    {
        $this->getCommoStats(
            (app()->environment('local'))
                ? $this->getDummyData() : [
                'aod_teamspeak' => (new SocialRepository())->getTeamspeak()->json('data'),
                'aod_discord' => (new SocialRepository())->getDiscord()->json('data')
            ]
        );

        $startXmas = CarbonImmutable::createFromFormat('m-d', '12-01');
        $endXmas = $startXmas->addDay(45);
        $isItChristmas = now()->between($startXmas, $endXmas);

        return view('pages.home', [
            'teamspeak' => cache()->get('aod_teamspeak'),
            'discord' => cache()->get('aod_discord'),
            'isChristmas' => $isItChristmas
        ]);
    }

    private function getCommoStats($items)
    {
        foreach ($items as $cacheKey => $closure) {
            cache()->remember(
                $cacheKey,
                config('app.cache_length'),
                fn () => $closure
            );
        }
    }

    /**
     * @return array
     */
    private function getDummyData(): array
    {
        $items = [
            'aod_teamspeak' => 'teamspeak.json',
            'aod_discord' => 'discord.json',
        ];

        foreach ($items as $cacheKey => $file) {
            $items[$cacheKey] = json_decode(
                file_get_contents(storage_path("testing/{$file}")),
                true
            )['data'];
        }

        return $items;
    }
}
