<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Segment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\ReportList;

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
        $photo = "report_photo_".Str::random(100);
        DB::table('report.report_list')->insert([
            'segment_id' => $segment_id,
            'user_id' => '748c90a1-25ba-4fc1-a9f9-63879cf4fe90',
            'status_id' => 'c78b942c-2fd8-4876-b6d6-07933d7326be',
            'no_ticket' => $no_ticket,
            'note' => $note,
            'maintenance_by' => null,
            'survey_status' => null,
            'damage_severity' => $damage_severity,
            'photo' => $photo,
        ]);
        return response()->json($request->all());
    }

    function report_detail($id) {
        $reportList = ReportList::where('id', $id)->first();
        return response()->json($reportList);
    }
}
