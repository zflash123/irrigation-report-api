<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\ReportList;

class ReportController extends Controller
{
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
