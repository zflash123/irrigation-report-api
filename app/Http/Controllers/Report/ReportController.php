<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ReportList;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    function create_report(Request $request) {
        $segment_id = $request->segment_id;
        $no_ticket = date('y').date('m').rand(10000, 99999);
        $note = $request->note;
        $damage_severity = $request->damage_severity;
        $photo = "report_photo_".Str::random(100);
        $report = ReportList::create([
            'segment_id' => $segment_id,
            'user_id' => '7dcdfaaf-a5c9-4efe-8ae2-bb3976323e16',
            'status_id' => 'c78b942c-2fd8-4876-b6d6-07933d7326be',
            'no_ticket' => $no_ticket,
            'note' => $note,
            'maintenance_by' => null,
            'survey_status' => null,
            'damage_severity' => $damage_severity,
            'photo' => $photo,
        ]);
        return response()->json($report);
    }

    function report_by_id($id) {
        $report = DB::table('report.report_list')
                    ->where('report.report_list.id', '=', $id)
                    ->join('report.status', 'report.report_list.status_id', '=', 'report.status.id')
                    ->join('map.irrigations_segment', 'report.report_list.segment_id', '=', 'map.irrigations_segment.id')
                    ->join('map.irrigations', 'map.irrigations_segment.irrigation_id', '=', 'map.irrigations.id')
                    ->select('report.report_list.id', 'report.report_list.no_ticket', 'report.report_list.note', 'report.report_list.damage_severity', 'report.report_list.photo', 'report.status.name as status', 'map.irrigations.name as irrigation', 'map.irrigations.type as canal')
                    ->first();
        return response()->json($report);
    }

    function reports_by_user_id() {
        $userId = "7dcdfaaf-a5c9-4efe-8ae2-bb3976323e16";
        $report = DB::table('report.report_list')
                    ->where('report.report_list.user_id', '=', $userId)
                    ->join('report.status', 'report.report_list.status_id', '=', 'report.status.id')
                    ->join('map.irrigations_segment', 'report.report_list.segment_id', '=', 'map.irrigations_segment.id')
                    ->join('map.irrigations', 'map.irrigations_segment.irrigation_id', '=', 'map.irrigations.id')
                    ->select('report.report_list.id', 'report.report_list.no_ticket', 'report.report_list.note', 'report.report_list.damage_severity', 'report.report_list.photo', 'report.status.name as status', 'map.irrigations.name as irrigation', 'map.irrigations.type as canal')
                    ->get();
        return response()->json($report);
    }
}
