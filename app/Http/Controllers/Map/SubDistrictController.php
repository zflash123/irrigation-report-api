<?php

namespace App\Http\Controllers\Map;

use App\Http\Controllers\Controller;
use App\Http\Resources\Map\SubDistrictResource;
use App\Models\Map\SubDistrict;
use Illuminate\Support\Facades\DB;

class SubDistrictController extends Controller
{
    public function index()
    {
        $sub_district = SubDistrict::paginate();

        $sub_district->getCollection()->transform(function ($item) {
            $geojson = DB::selectOne('SELECT ST_AsGeoJSON(ST_Transform(geom, 4326)) as geojson FROM master.sub_district WHERE id = ?', [$item->id])->geojson;
            $item->geojson = $geojson;
            return $item;
        });

        return SubDistrictResource::collection($sub_district);
    }

    public function show($id)
    {
        $subDistrict = SubDistrict::findOrFail($id);

        $geojson = DB::selectOne('SELECT ST_AsGeoJSON(ST_Transform(geom, 4326)) as geojson FROM master.sub_district WHERE id = ?', [$subDistrict->id])->geojson;
        $subDistrict->geojson = $geojson;

        return new SubDistrictResource($subDistrict);
    }
}
