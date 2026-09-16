<?php

declare(strict_types=1);

namespace App\Http\Composers;

use App\Support\OnSiteDivisions;
use App\Support\RssReader;
use Illuminate\View\View;
use SimpleXMLElement;

class SiteComposer
{
    // these keys must stay in sync with any view that reads them directly
    public const AOD_DIVISIONS = OnSiteDivisions::CACHE_KEY;

    public const AOD_ANNOUNCEMENTS = 'aod_announcements';

    public function compose(View $view): void
    {
        $view->with(self::AOD_DIVISIONS, OnSiteDivisions::get());

        if ($this->isLocal()) {
            $announcements = simplexml_load_file(storage_path('testing/announcements.xml'))->channel;
        } else {
            $announcements = cache()->remember('aod_announcements', 60, function () {
                $feed = $this->getAnnouncementsFeed();

                return $feed ? $feed->asXML() : null;
            });

            $announcements = $announcements
                ? simplexml_load_string($announcements, null, LIBXML_NOERROR | LIBXML_NOWARNING | LIBXML_NOCDATA)
                : null;
        }

        $view->with(self::AOD_ANNOUNCEMENTS, $announcements);
    }

    private function getAnnouncementsFeed(): SimpleXMLElement|array
    {
        $feed = (new RssReader)->setPath(config('services.aod.announcements_rss_feed'));

        if (! $feed) {
            return [];
        }

        return $feed->getItems();
    }

    private function isLocal(): bool
    {
        return app()->environment('local');
    }
}
