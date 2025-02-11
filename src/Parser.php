<?php

namespace Candide\StatamicOpeningHours;

class Parser
{

    private array $weekDayNames = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

    public function parse(array $data): array
    {
        $data = $this->filter($data);

        foreach ($this->weekDayNames as $weekDayName) {
            $data[$weekDayName] = $this->mapWeekday($data[$weekDayName]);
        }

        $data['exceptions'] = $this->mapExceptions($data['exceptions']);

        return $data;
    }

    protected function filter(array $data): array
    {

        $allowedKeys = array_merge($this->weekDayNames, ['exceptions']);

        return array_filter(
            $data,
            function ($key) use ($allowedKeys) {
                return in_array($key, $allowedKeys);
            },
            ARRAY_FILTER_USE_KEY
        );

    }

    protected function mapWeekday(array $weekDay): array
    {

        return array_map(fn($day): string => sprintf("%s-%s", $day['from'], $day['to']), $weekDay);

    }

    protected function mapExceptions(array $exceptions): array
    {

        $data = [];

        foreach ($exceptions as $exception) {
            $data[$exception['date']]['data'] = key_exists('reason', $exception) ? $exception['reason'] : null;

            if (key_exists('hours', $exception) && $exception['hours']) {
                $hourRange = $exception['hours'];
                foreach ($hourRange as $range) {
                    $data[$exception['date']]['hours'][] = (key_exists('from', $range) && $range['from'] && key_exists('to', $range) && $range['to']) ? [sprintf("%s-%s", $range['from'], $range['to'])] : [];
                }
            } else {
                $data[$exception['date']]['hours'] = [];
            }

        }

        return $data;

    }

}
