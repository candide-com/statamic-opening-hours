<?php

namespace Candide\StatamicOpeningHours;


use Statamic\Providers\AddonServiceProvider;
use Statamic\Facades\CP\Nav;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

use Candide\StatamicOpeningHours\Tags\OpeningHoursTag;
use Candide\StatamicOpeningHours\Rules\OpeningHoursFormat;

class ServiceProvider extends AddonServiceProvider
{
    protected $viewNamespace = 'candide-com-opening-hours';

    protected $translations = true;

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
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/statamic-opening-hours'),
        ], 'statamic-opening-hours-config');

        Nav::extend(function ($nav) {
            $nav->content(__('statamic-opening-hours::opening-hours.opening-hours'))
                ->route('opening-hours.index')
                ->icon('time');
        });
    }

    public function boot()
    {
        parent::boot();

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'statamic-opening-hours');

        if (config('statamic.api.enabled')) {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        }

        Validator::extend('opening_hours_format', function ($attribute, $value, $parameters, $validator) {
            return (new OpeningHoursFormat)->passes($attribute, $value);
        }, __('statamic-opening-hours::opening-hours.section.hours.validation.invalid_format'));
    }
}
