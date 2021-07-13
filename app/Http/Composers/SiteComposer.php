<?php

namespace App\Http\Composers;

use Facades\App\Repositories\AOD\DivisionRepository;
use Facades\App\Support\RssReader;
use Facades\App\Support\Twitter;
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
    const AOD_ANNOUNCEMENTS = 'aod_announcements';

    public function compose(View $view): void
    {
        $view->with(self::AOD_DIVISIONS, cache()->remember(
            self::AOD_DIVISIONS,
            config('app.cache_length'),
            fn() => $this->getDivisions()
        ));

        $view->with(self::AOD_TWEETS, cache()->remember(
            self::AOD_TWEETS,
            config('app.cache_length'),
            fn() => $this->getTwitterFeed()
        ));

        // no need to cache RSS feed
        $view->with(self::AOD_ANNOUNCEMENTS, $this->getAnnouncementsFeed());
    }

    /**
     * @return array
     */
    protected function getDivisions(): array
    {
        if ($this->isLocal()) {
            return json_decode(
                file_get_contents(storage_path('testing/divisions.json')), true
            )['data'];
        }

        try {
            return DivisionRepository::all()->json('data');
        } catch (\Exception $exception) {
            \Log::error('Unable to fetch division information.', $exception->getMessage());
            return [];
        }
    }

    private function getTwitterFeed()
    {
        if ($this->isLocal() || app()->environment('testing')) {

            return json_decode(file_get_contents(storage_path('testing/tweets.json')));
        }

        return Twitter::getfeed();
    }

    private function getAnnouncementsFeed()
    {
        if ($this->isLocal()) {
            return simplexml_load_file(storage_path('testing/announcements.xml'))->channel;
        }

        $feed = RssReader::setPath(config('services.aod.announcements_rss_feed'));

        if (!$feed) {
            return [];
        }

        return $feed->getItems();
    }

    /**
     * @return bool|string
     */
    private function isLocal()
    {
        return app()->environment('local');
    }
}
