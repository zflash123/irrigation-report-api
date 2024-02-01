<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Segment;
use Illuminate\Support\Facades\DB;

class AppController extends Controller
{
    function all_segment() {
        $all_segment = DB::select("SELECT *, ST_AsGeoJSON(ST_Transform(geom, 4326)) as geojson FROM master.segments WHERE id='870664d1-213f-4f6b-98b1-bc4528c601c7' LIMIT 30");

        return response()->json($all_segment);
    }
}
