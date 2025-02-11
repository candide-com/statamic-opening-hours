<?php

namespace Candide\StatamicOpeningHours\Facades;

use Candide\StatamicOpeningHours\Storage\Storage;
use Illuminate\Support\Facades\Facade;

class OpeningHoursStorage extends Facade
{

    protected static function getFacadeAccessor()
    {
        return Storage::class;
    }

}
