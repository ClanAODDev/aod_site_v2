<?php

namespace App\Http\Composers;

use Facades\App\Repositories\AOD\DivisionRepository;
use Facades\App\Support\RssReader;
use Illuminate\View\View;

/**
 * Class SiteComposer.
 *
 * Handles data that needs to be available across the site.
 */
class SiteComposer
{
    /**
     * take care that these only change in conjunction with dependent views.
     */
    public const AOD_DIVISIONS = 'aod_divisions';

    public const AOD_TWEETS = 'aod_tweets';

    public const AOD_ANNOUNCEMENTS = 'aod_announcements';

    public function compose(View $view): void
    {
        $view->with(self::AOD_DIVISIONS, cache()->remember(
            self::AOD_DIVISIONS,
            config('app.cache_length'),
            fn () => $this->getDivisions()
        ));

        // no need to cache RSS feed
        $view->with(self::AOD_ANNOUNCEMENTS, $this->getAnnouncementsFeed());
    }

    protected function getDivisions(): array
    {
        if (! $divisions = DivisionRepository::all()->json('data')) {
            return [];
        }

        return $divisions;
    }

    private function getAnnouncementsFeed()
    {
        if ($this->isLocal()) {
            return simplexml_load_file(storage_path('testing/announcements.xml'))->channel;
        }

        $feed = RssReader::setPath(config('services.aod.announcements_rss_feed'));

        if (! $feed) {
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
