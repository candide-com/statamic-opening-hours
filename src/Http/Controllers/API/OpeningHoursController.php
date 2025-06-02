<?php

namespace Candide\StatamicOpeningHours\Http\Controllers\API;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Statamic\Http\Controllers\API\ApiController;
use Statamic\Facades\GlobalSet;
use Statamic\Facades\Asset;
use Statamic\Facades\Entry;
use Statamic\Facades\AssetContainer;

use Statamic\Facades\Site;
use Candide\StatamicOpeningHours\Storage\Storage;
use Statamic\Facades\Config;
use Statamic\Sites\Site as SiteObject;
use Statamic\Facades\File;
use Statamic\Facades\YAML;


class OpeningHoursController extends ApiController
{
    protected $resourceConfigKey = 'opening-hours';
    protected $routeResourceKey = 'opening-hours';

    public function index(): JsonResponse
    {
        $this->abortIfDisabled();

        $entries = Entry::query()
        ->where('collection', 'opening-hours')
        ->where('slug', '!=', 'global')
        ->where("enabled", true)
        ->get();

        $global = Entry::query()->where('collection', 'opening-hours')->where('slug', 'global')->first();
        $openingHours = [
          "sections" => $entries->map(function ($entry) {
            $icon = Asset::query()->where("container", "opening-hours")->where("id", "opening-hours::".$entry->get("icon"))->get()->first();
            return [
              "id" => $entry->id(),
              ...$entry->data()->toArray(),
              "icon" => $icon ? $icon->contents() : null
            ];
          })->toArray(),
          "is_closed" => $global ? $global->data()->get("is_closed") : "",
          "reason" => $global ? $global->data()->get("reason") : "",
        ];

        if (!$openingHours) {
            return response()->json(['error' => 'Opening hours not found'], 404);
        }

        return response()->json([
            'data' => $openingHours
        ]);
    }

    public function show($slug)
    {
        $this->abortIfDisabled();

        $openingHours = Entry::query()->where('collection', 'opening-hours')->where('slug', $slug)->first();

        if (!$openingHours) {
            return response()->json(['error' => 'Opening hours not found'], 404);
        }

        return response()->json([
            'data' => $openingHours
        ]);
    }}
