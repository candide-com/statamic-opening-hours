<?php

namespace Candide\StatamicOpeningHours\Blueprints;

use Statamic\Facades\Blueprint;
use Statamic\Facades\YAML;
use Statamic\Facades\File;

class OpeningHoursBlueprint
{
    public static function get()
    {
        $path = __DIR__ . '/opening-hours.yaml';
        $contents = YAML::parse(File::get($path));

        return Blueprint::make()->setContents($contents);
    }
}
