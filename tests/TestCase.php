<?php

namespace Candide\StatamicOpeningHours\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            \Candide\StatamicOpeningHours\ServiceProvider::class,
            \Statamic\Providers\StatamicServiceProvider::class,
        ];
    }

    protected function resolveApplicationConfiguration($app): void
    {
        parent::resolveApplicationConfiguration($app);

        // Save opening hours to a separate test yaml file
        $app['config']->set('statamic-opening-hours.storage.file', __DIR__.'/storage/opening-hours-test.yaml');

    }
}
