<?php

namespace Candide\StatamicOpeningHours\Http\Controllers;

use Candide\StatamicOpeningHours\Blueprints\OpeningHoursBlueprint;
use Candide\StatamicOpeningHours\Facades\OpeningHoursStorage;
use Statamic\Facades\Site;

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
        return OpeningHoursStorage::putYaml(Site::selected(), $data);
    }

}
