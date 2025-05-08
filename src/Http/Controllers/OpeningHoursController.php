<?php

namespace Candide\StatamicOpeningHours\Http\Controllers;

use Candide\StatamicOpeningHours\Blueprints\OpeningHoursBlueprint;
use Candide\StatamicOpeningHours\Facades\OpeningHoursStorage;
use Statamic\Facades\Site;
use Statamic\Facades\Entry;

use Statamic\Facades\Collection;
use Illuminate\Support\Facades\Log;
use Statamic\Events\EntrySaved;
use Statamic\Events\GlobalSetSaved;
use Statamic\Events\GlobalVariablesSaved;
use Statamic\Facades\Blueprint;

class OpeningHoursController
{
    public function __invoke()
    {
        $data = $this->getData();

        $blueprint = $this->getBlueprint();
        $fields = $blueprint->fields()->addValues($data)->preProcess();

        return view('statamic-opening-hours::index', [
            'blueprint' => $blueprint->toPublishArray(),
            'meta' => $fields->meta(),
            'title' => __('statamic-opening-hours::opening-hours.opening-hours'),
            'values' => $fields->values(),
        ]);
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $blueprint = $this->getBlueprint();

        $fields = $blueprint->fields()->addValues($request->all());
        $fields->validate();

        $this->putData($fields->process()->values()->toArray());
    }

    public function getData()
    {
        $entries = Entry::query()
        ->where('collection', 'opening-hours')
        ->where('slug', '!=', 'global')
        ->get();

        $global = Entry::query()->where('collection', 'opening-hours')->where('slug', 'global')->first();
        $result = [
          "sections" => $entries->map(function ($entry) {
            return $entry->data()->toArray();
          })->toArray(),
          "is_closed" => $global ? $global->data()->get("is_closed") : "",
          "reason" => $global ? $global->data()->get("reason") : "",
        ];

        return $result;
    }

    public function getBlueprint()
    {
        return OpeningHoursBlueprint::get();
    }

    public function putData($data)
    {
        $site = Site::selected(); // Get the site handle

        if (!Collection::find('opening-hours')) {
          Collection::make('opening-hours')->save();
        }
        try {
          foreach ($data["sections"] as $section) {
            $entry = Entry::query()->where('collection', 'opening-hours')->where('slug', $section["slug"])->first();

            if ($entry) {
              // Force no update to ID.
              unset($section["id"]);
              foreach ($section as $dataKey => $dataValue) {
                $entry->set($dataKey, $dataValue);
              }
            } else {
              $entry = Entry::make()
              ->collection('opening-hours')
              ->slug($section["slug"])
              ->data([...$section, "template" => "opening-hours"]);
            }

            $entry->save();
          };
        } catch (\Exception $e) {
          Log::error("Error : ".$e->getMessage());
          return false;
        }

        $replica = $data;
        unset($data["sections"]);

        $entry = Entry::query()->where('collection', 'opening-hours')->where('slug', 'global')->first();
        if ($entry) {
          foreach ($data as $dataKey => $dataValue) {
            $entry->set($dataKey, $dataValue);
          }
        } else {
          $entry = Entry::make()
            ->collection('opening-hours')
            ->slug('global')
            ->data([...$section, "template" => "opening-hours"]);
        }
        $entry->save();

        return $replica;
    }
}
