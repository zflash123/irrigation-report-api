<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ReportList;
use App\Models\ReportSegment;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    function create_report(Request $request) {
        $no_ticket = date('y').date('m').rand(10000, 99999);
        $segment_id1 = $request->segment_id1;
        $level1 = $request->level1;
        $note1 = $request->note1;
        $segment_id2 = $request->segment_id2;
        $level2 = $request->level2;
        $note2 = $request->note2;
        $segment_id3 = $request->segment_id3;
        $level3 = $request->level3;
        $note3 = $request->note3;
        $photo = "report_photo_".Str::random(100);
        $report = ReportList::create([
            'user_id' => auth()->user()->id,
            'status_id' => 'PROG',
            'no_ticket' => $no_ticket,
            'maintenance_by' => null,
        ]);
        $report->report_segment()->create([
            'segment_id' => $segment_id1,
            'level' => $level1,
            'note' => $note1
        ]);
        if($segment_id2!=null){
            $report->report_segment()->create([
                'segment_id' => $segment_id2,
                'level' => $level2,
                'note' => $note2
            ]);
        }
        if($segment_id3!=null){
            $report->report_segment()->create([
                'segment_id' => $segment_id3,
                'level' => $level3,
                'note' => $note3
            ]);
        }
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
