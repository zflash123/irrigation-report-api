<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Segment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AppController extends Controller
{
    function all_segment() {
        $all_segment = DB::table('master.irrigations_segmen')->where('id', '0000c2b6-7984-4f1f-9385-dcf6e53743a0')->get();

        return response()->json($all_segment);
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
