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
        return OpeningHoursStorage::getYaml(Site::selected());
    }

    public function getBlueprint()
    {
        return OpeningHoursBlueprint::get();
    }

    public function putData($data)
    {
        $site = Site::selected(); // Get the site handle
        $result = OpeningHoursStorage::putYaml($site, $data);

        Log::info('GlobalSetSaved event dispatched. '. json_encode($data));

        if (!Collection::find('opening-hours')) {
            Collection::make('opening-hours')->save();
        }

        if ($data["sections"] !== null) {
          foreach ($data["sections"] as $section) {
            $entry = Entry::make()
                ->collection('opening-hours')
                ->slug('opening-hours')
                ->data([...$section, "template" => "opening-hours"])
                ->id($section["id"]);
            $entry->save();
            $entry->delete();
          };
        }

        $entry = Entry::make()
            ->collection('opening-hours')
            ->slug('opening-hours')
            ->data($data);
        $entry->save();
        $entry->delete();

        return $result;
    }
}
