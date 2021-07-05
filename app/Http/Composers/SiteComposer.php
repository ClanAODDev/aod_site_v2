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
        $view->with('aod_announcements', (new RssReader())->setPath(
            config('services.aod.announcements_rss_feed')
        )->getItems());

        $view->with('aod_divisions', cache()->remember('aod_divisions', 300, function () {
            return Http::withToken(config('services.aod.access_token'))
                ->acceptJson()
                ->get('//4f688d40a360.ngrok.io/api/v1/divisions/')
                ->json('data');
        }));

        $view->with('aod_tweets', cache()->remember('aod_tweets', 300, function () {
            return (new Twitter())->getfeed();
        }));
    }
}