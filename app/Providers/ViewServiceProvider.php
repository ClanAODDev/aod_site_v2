<?php

namespace App\Providers;

use App\Http\Composers\SiteComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // register site composer
        View::composer('*', SiteComposer::class);
    }
}
