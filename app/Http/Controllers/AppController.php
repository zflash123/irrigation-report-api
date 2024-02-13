<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Segment;
use Illuminate\Support\Facades\DB;

class AppController extends Controller
{
    function close_segments(Request $request) {
        $latitude = (float)$request->input('lat');
        $longitude = (float)$request->input('long');
        $close_segment = DB::select("SELECT
            id,
            name,
            geojson,
            public.ST_Distance(geom, public.geography(public.ST_SetSRID(public.ST_MakePoint($longitude, $latitude), 4326))) AS distance
        FROM
            master.irrigations_segmen
        WHERE
            public.ST_Distance(geom, public.geography(public.ST_SetSRID(public.ST_MakePoint($longitude, $latitude), 4326)))<=200
        ORDER BY
            distance;");
        return response()->json($close_segment);
    }
}
