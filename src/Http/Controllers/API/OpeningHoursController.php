<?php

namespace Candide\StatamicOpeningHours\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Statamic\Http\Controllers\API\ApiController;
use Statamic\Facades\GlobalSet;

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

        $currentSite = Site::current();
        $openingHours = Storage::getYaml($currentSite);


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

        $currentSite = Site::current();
        $openingHours = Storage::getYaml($currentSite);

        if (!$openingHours) {
            return response()->json(['error' => 'Opening hours not found'], 404);
        }

        $matchingLocation = collect($openingHours)->first(function ($location) use ($slug) {
            return isset($location['header']['slug']) && $location['header']['slug'] === $slug;
        });

        if (!$matchingLocation) {
            return response()->json(['error' => 'Opening hours not found for ' . $slug], 404);
        }

        return response()->json([
            'data' => $matchingLocation
        ]);
    }
}
