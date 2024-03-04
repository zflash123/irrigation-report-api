<?php

namespace App\Http\Controllers\Map;

use App\Http\Controllers\Controller;
use App\Http\Resources\Map\MapSegmentResource;
use App\Models\Map\MapSegment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapSegmentController extends Controller
{
    public function index()
    {
        $segment = MapSegment::paginate();

        $segment->getCollection()->transform(function ($item) {
            $centerpoint = DB::selectOne('SELECT ST_AsGeoJSON(ST_Transform(geom, 4326)) as centerPoint FROM map.irrigations_segment WHERE id = ?', [$item->id])->center_point;
            $item->centerpoint = $centerpoint;
            return $item;
        });
        return MapSegmentResource::collection($segment);
    }
}
