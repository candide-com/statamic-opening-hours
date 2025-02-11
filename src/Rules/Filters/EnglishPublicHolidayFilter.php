<?php

namespace Candide\StatamicOpeningHours\Rules\Filters;

use Ujamii\OsmOpeningHours\Filters\GermanPublicHolidayFilter;

class EnglishPublicHolidayFilter extends GermanPublicHolidayFilter
{
    protected array $openingHours = [];

    public function applyFilter(\DateTimeImmutable $date): ?array
    {
        $year = (int)$date->format('Y');
        $holidays = [
            new \DateTimeImmutable("$year-12-25"),
            // new \DateTimeImmutable("$year-12-26"),
            // new \DateTimeImmutable("$year-01-01"),
            // Add more UK holidays as needed
        ];

        $dateToCheck = $date->format('m-d');
        foreach ($holidays as $holiday) {
            if ($dateToCheck === $holiday->format('m-d')) {
                return $this->openingHours;
            }
        }

        return null;
    }
}
