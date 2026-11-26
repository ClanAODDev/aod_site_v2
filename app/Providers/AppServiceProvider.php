<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\Embed\Bridge\OscaroteroEmbedAdapter;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('markdown.environment', function (Container $app): Environment {
            $config = $app['config']->get('markdown');
            $config['embed']['adapter'] = new OscaroteroEmbedAdapter;

            $environment = new Environment(Arr::except($config, ['extensions', 'views']));

            foreach ((array) Arr::get($config, 'extensions') as $extension) {
                $environment->addExtension($app->make($extension));
            }

            return $environment;
        });
    }

    public function boot(): void
    {
        //
    }
}
