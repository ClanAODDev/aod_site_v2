<?php

namespace App\Providers;

use App\Http\Composers\SiteComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // register site composer
        View::composer('*', SiteComposer::class);
    }
}
