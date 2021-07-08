<?php

namespace App\Http\Composers;

use App\Support\RssReader;
use App\Support\Twitter;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

/**
 * Class SiteComposer
 *
 * Handles data that needs to be available across the site.
 *
 * @package App\Http\Composers
 */
class SiteComposer
{
    /**
     * take care that these only change in conjunction with dependent views
     */
    const AOD_DIVISIONS = 'aod_divisions';
    const AOD_TWEETS = 'aod_tweets';

    public function compose(View $view): void
    {
        if (App::environment('test')) {
            $this->deferToLocallyStoredData($view);
            return;
        }

        // no need to cache RSS feed
        $view->with('aod_announcements', (new RssReader())->setPath(
            config('services.aod.announcements_rss_feed')
        )->getItems());

        $view->with(self::AOD_DIVISIONS, cache()->remember(
            self::AOD_DIVISIONS,
            config('app.cache_length'),
            fn() => $this->getDivisions()
        ));

        $view->with(self::AOD_TWEETS, cache()->remember(
            self::AOD_TWEETS,
            config('app.cache_length'),
            fn() => (new Twitter())->getfeed()
        ));
    }

    /**
     * @return array
     */
    protected function getDivisions(): array
    {
        try {
            return Http::withToken(config('services.aod.access_token'))
                    ->acceptJson()
                    ->get(config('services.aod.tracker_url') . "/api/v1/divisions")
                    ->json('data') ?? [];
        } catch (\Exception $exception) {
            \Log::error('Unable to fetch division information.', $exception->getMessage());
            return [];
        }
    }

    /**
     * @param View $view
     */
    private function deferToLocallyStoredData(View $view)
    {
        $view->with(self::AOD_DIVISIONS, json_decode(
            file_get_contents(storage_path('testing/divisions.json')), true)['data']
        );

        $view->with(self::AOD_TWEETS, json_decode(file_get_contents(storage_path('testing/tweets.json'))));

        $view->with('aod_announcements', simplexml_load_file(storage_path('testing/announcements.xml'))->channel);
    }
}
