<?php


namespace App\Http\Composers;

use App\Support\RssReader;
use App\Support\Twitter;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;


class SiteComposer
{
    public function compose(View $view)
    {
        if (App::environment('testing')) {
            $this->handleTestingEnvironment($view);
            return;
        }

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

    /**
     * Prevent talking out in testing
     *
     * @param  View  $view
     */
    private function handleTestingEnvironment(View $view)
    {
        $view->with('aod_divisions',cache()->remember('aod_divisions', 300, function () {
            return json_decode(file_get_contents(storage_path('testing/divisions.json')), true)['data'];
        }));

        $view->with('aod_tweets', json_decode(file_get_contents(storage_path('testing/tweets.json'))));

        $view->with('aod_announcements',
            simplexml_load_string(file_get_contents(storage_path('testing/announcements.xml')))
        );
    }
}