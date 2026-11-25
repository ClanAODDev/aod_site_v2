<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function ranks(): Response
    {
        return Inertia::render('next/ranks')->withViewData([
            'metaTitle' => 'Ranking Structure | Angels of Death',
            'metaDescription' => 'Every rank in the Angels of Death gaming community, from Recruit to Sergeant Major.',
        ]);
    }

    public function codeOfConduct(): Response
    {
        return Inertia::render('next/code-of-conduct')->withViewData([
            'metaTitle' => 'Code of Conduct | Angels of Death',
            'metaDescription' => 'The standard of conduct every member of the Angels of Death gaming community agrees to.',
        ]);
    }
}
