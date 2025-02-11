<?php

namespace Candide\StatamicOpeningHours\Tags;

use DateTime;
use Candide\StatamicOpeningHours\Facades\OpeningHoursStorage;
use Candide\StatamicOpeningHours\Parser;
use Spatie\OpeningHours\OpeningHours;
use Statamic\Tags\Tags;
use Statamic\Facades\Site;

class OpeningHoursTag extends Tags
{

    /**
     * The {{ openingHours }} tag.
     */

    protected static $handle = 'openingHours';

    protected ?array $data = null;

    public function isOpen(): bool
    {

        if ($this->params->get('at')) {
            // {{ openingHours:isOpen at="2022-12-31 15:00:00" }}
            return $this->openingHours()->isOpenAt(new DateTime($this->params->get('at')));
        } elseif ($this->params->get('on')) {
            // {{ openingHours:isOpen on="2022-12-31" }}
            // {{ openingHours:isOpen on="monday" }}
            return $this->openingHours()->isOpenOn($this->params->get('on'));
        } else {
            // {{ openingHours:isOpen }}
            return $this->openingHours()->isOpen();
        }

    }

    public function isClosed(): bool
    {

        if ($this->params->get('at')) {
            // {{ openingHours:isClosed at="2022-12-31 15:00:00" }}
            return $this->openingHours()->isClosedAt(new DateTime($this->params->get('at')));
        } elseif ($this->params->get('on')) {
            // {{ openingHours:isClosed on="2022-12-31" }}
            // {{ openingHours:isClosed on="monday" }}
            return $this->openingHours()->isClosedOn($this->params->get('on'));
        } else {
            // {{ openingHours:isClosed }}
            return $this->openingHours()->isClosed();
        }

    }

    public function forDay(): array
    {

        return $this->openingHours()->forDay($this->params->get('day'))->map(function ($item) {
            return [
                "from" => $item->start()->format($this->params->get('format')),
                "to" => $item->end()->format($this->params->get('format'))
            ];
        });

    }

    public function forWeek(): array
    {

        $days = [];

        foreach ($this->openingHours()->forWeek() as $day => $openingHours) {
            if (!$openingHours->isEmpty()) {
                $item = [
                    "day" => $day,
                    "hours" => $openingHours->map(function ($item) {
                        return [
                            "from" => $item->start()->format($this->params->get('format')),
                            "to" => $item->end()->format($this->params->get('format'))
                        ];
                    })
                ];
                $days[] = $item;
            }
        }

        return $days;

    }

    public function forDate(): array
    {

        return $this->openingHours()->forDate(new DateTime($this->params->get('date')))->map(function ($item) {
            return [
                "from" => $item->start()->format($this->params->get('format')),
                "to" => $item->end()->format($this->params->get('format'))
            ];
        });

    }

    public function nextOpen(): string
    {

        return $this->openingHours()->nextOpen(new DateTime($this->params->get('date')))->format($this->params->get('format'));

    }

    public function nextClose(): string
    {

        return $this->openingHours()->nextClose(new DateTime($this->params->get('date')))->format($this->params->get('format'));

    }

    public function previousOpen(): string
    {

        return $this->openingHours()->previousOpen(new DateTime($this->params->get('date')))->format($this->params->get('format'));

    }

    public function exceptions(): array
    {

        $exceptions = [];

        foreach ($this->openingHours()->exceptions() as $day => $openingHours) {
            $item["day"] = $day;
            $item["reason"] = $openingHours->getData();

            if (!$openingHours->isEmpty()) {
                $item["hours"] = $openingHours->map(function ($item) {
                    return [
                        "from" => $item->start()->format($this->params->get('format')),
                        "to" => $item->end()->format($this->params->get('format'))
                    ];
                });
            }
            else {
                $item["hours"] = [];
            }

            $exceptions[] = $item;
        }

        return $exceptions;

    }

    public function diffInOpenHours(): float
    {

        return $this->openingHours()->diffInOpenHours(new DateTime($this->params->get('from')), new DateTime($this->params->get('to')));

    }

    public function diffInOpenMinutes(): float
    {

        return $this->openingHours()->diffInOpenMinutes(new DateTime($this->params->get('from')), new DateTime($this->params->get('to')));

    }

    public function diffInOpenSeconds(): float
    {

        return $this->openingHours()->diffInOpenSeconds(new DateTime($this->params->get('from')), new DateTime($this->params->get('to')));

    }

    public function diffInClosedHours(): float
    {

        return $this->openingHours()->diffInClosedHours(new DateTime($this->params->get('from')), new DateTime($this->params->get('to')));

    }

    public function diffInClosedMinutes(): float
    {

        return $this->openingHours()->diffInClosedMinutes(new DateTime($this->params->get('from')), new DateTime($this->params->get('to')));

    }

    public function diffInClosedSeconds(): float
    {

        return $this->openingHours()->diffInClosedSeconds(new DateTime($this->params->get('from')), new DateTime($this->params->get('to')));

    }

    protected function getData(): array
    {

        return OpeningHoursStorage::getYaml(Site::selected());

    }

    protected function openingHours(): OpeningHours
    {

        if (!$this->data) {
            $this->data = (new Parser)->parse($this->getData());
        }

        return OpeningHours::create($this->data);

    }

}
