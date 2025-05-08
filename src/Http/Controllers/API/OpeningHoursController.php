<?php

namespace Candide\StatamicOpeningHours\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Statamic\Http\Controllers\API\ApiController;
use Statamic\Facades\GlobalSet;
use Statamic\Facades\Entry;

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
            return [
              "id" => $entry->id(),
              ...$entry->data()->toArray()
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
