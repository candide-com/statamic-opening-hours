<?php

namespace Candide\StatamicOpeningHours\Storage;

use Statamic\Facades\Config;
use Statamic\Sites\Site as SiteObject;
use Statamic\Facades\File;
use Statamic\Facades\Site;
use Statamic\Facades\YAML;

class Storage
{
    /**
     * Retrieve YAML data from storage
     */
    public static function getYaml(SiteObject $site, bool $returnCollection = false): array
    {

        $data = YAML::parse(File::get(Config::get('statamic-opening-hours.storage.file')));

        $site_data = collect($data)->get($site->handle());

        if ($returnCollection) {
            return collect($site_data);
        }

        return collect($site_data)->toArray() ?: [];
    }

    /**
     * Put YAML data into storage
     */
    public static function putYaml(SiteObject $site, array $data): void
    {

        $file = Config::get('statamic-opening-hours.storage.file');

        $existing = collect(YAML::parse(File::get($file)));

        $combined_data = $existing->merge([
            "{$site->handle()}" => $data,
        ]);

        File::put($file, YAML::dump($combined_data->toArray()));
    }
}
