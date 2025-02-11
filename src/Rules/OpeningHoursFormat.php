<?php

namespace Candide\StatamicOpeningHours\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Log;

use Ujamii\OsmOpeningHours\OsmStringToOpeningHoursConverter;
use Candide\StatamicOpeningHours\Rules\Filters\EnglishPublicHolidayFilter;

class OpeningHoursFormat implements Rule
{
    public function passes($attribute, $value)
    {
        if (empty($value)) {
            return true;
        }

        try {
            OsmStringToOpeningHoursConverter::openingHoursFromOsmString($value, ['PH' => new EnglishPublicHolidayFilter()]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function message()
    {
        return __('statamic-opening-hours::opening-hours.section.hours.validation.invalid_format');
    }
}
