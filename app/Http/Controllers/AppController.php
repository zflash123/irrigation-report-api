<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Segment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
    function report(Request $request) {
        $segment_id = $request->segment_id;
        $no_ticket = "ticket_".Str::random(100);
        $note = $request->note;
        $damage_severity = $request->damage_severity;
        $photo = "report_".Str::random(100);
        DB::table('report.report_list')->insert([
            'segment_id' => $segment_id,
            'user_id' => 'da9c0989-1f98-4f1c-9f66-571762074fba',
            'status_id' => '623fb9aa-5d45-4657-b315-2a6c89d725b6',
            'no_ticket' => $no_ticket,
            'note' => $note,
            'maintenance_by' => null,
            'survey_status' => null,
            'damage_severity' => $damage_severity,
            'photo' => $photo,
        ]);
        return response()->json($request->all());
    }
}
