<?php

declare(strict_types=1);

namespace App\Http\Composers;

use App\Support\OnSiteDivisions;
use Illuminate\View\View;

class SiteComposer
{
    public const AOD_DIVISIONS = OnSiteDivisions::CACHE_KEY;

    public function compose(View $view): void
    {
        $view->with(self::AOD_DIVISIONS, OnSiteDivisions::get());
    }
}
