<?php

declare(strict_types=1);

namespace App\Http\Composers;

use App\Support\RssReader;
use Facades\App\Repositories\AOD\DivisionRepository;
use Illuminate\View\View;
use SimpleXMLElement;

class SiteComposer
{
    // these keys must stay in sync with any view that reads them directly
    public const AOD_DIVISIONS = 'aod_divisions';

    public const AOD_ANNOUNCEMENTS = 'aod_announcements';

    public function compose(View $view): void
    {
        $view->with(self::AOD_DIVISIONS, cache()->remember(
            self::AOD_DIVISIONS,
            config('app.cache_length'),
            fn () => $this->getDivisions()
        ));

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

    protected function getDivisions(): array
    {
        if (! $divisions = DivisionRepository::all()->json('data')) {
            return [];
        }

        return $this->shouldShowOnSite($divisions);
    }

    private function isLocal(): bool
    {
        return app()->environment('local');
    }

    private function shouldShowOnSite(array $divisions): array
    {
        return array_filter($divisions, fn ($division) => isset($division['show_on_site']) && $division['show_on_site'] !== false);
    }
}
