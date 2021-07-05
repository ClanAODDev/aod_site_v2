<?php


namespace App\Http\Composers;

use App\Support\RssReader;
use App\Support\Twitter;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class SiteComposer
{
    public function compose(View $view)
    {
        /**
         * non-cached data
         */
        $view->with('aod_announcements', (new RssReader())->setPath(
            config('services.aod.announcements_rss_feed')
        )->getItems());

        /**
         * cached data points
         */
        $view->with('aod_divisions', cache()->remember('aod_divisions', 300, function () {
            return $this->getDivisions();
        }));
        $view->with('aod_tweets', cache()->remember('aod_tweets', 300, function () {
            return (new Twitter())->getfeed();
        }));
    }

    /**
     * @return array
     */
    protected function getDivisions(): array
    {
        try {
            return Http::withToken(config('services.aod.access_token'))
                    ->acceptJson()
                    ->get(config('services.aod.tracker_url')."/api/v1/divisions")
                    ->json('data') ?? [];
        } catch (\Exception $exception) {
            return [];
        }
    }
}