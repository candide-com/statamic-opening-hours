<?php

namespace Candide\StatamicOpeningHours;

use Candide\StatamicOpeningHours\Tags\OpeningHoursTag;
use Statamic\Providers\AddonServiceProvider;
use Statamic\Facades\CP\Nav;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;

class ServiceProvider extends AddonServiceProvider
{
    protected $viewNamespace = 'candide-com-opening-hours';

    protected $routes = [
        'cp' => __DIR__.'/../routes/cp.php',
        'api' => [
            'prefix' => 'api',
            'middleware' => 'api',
            'path' => __DIR__.'/../routes/web.php'
        ]
    ];

    protected $tags = [
        OpeningHoursTag::class,
    ];

    public function bootAddon()
    {

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'statamic-opening-hours');

        $this->publishes([
            __DIR__ . '/../config/' => config_path(),
        ], 'statamic-google-opening-hours-config');

        Nav::extend(function ($nav) {
            $nav->content(__('statamic-opening-hours::opening-hours.opening-hours'))
                ->route('opening-hours.index')
                ->icon('time');
        });
    }

    public function boot()
    {
        parent::boot();

        if (config('statamic.api.enabled')) {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        }
    }
}
