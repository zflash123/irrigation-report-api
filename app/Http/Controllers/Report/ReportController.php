<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ReportList;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    function create_report(Request $request) {
        $segment_id = $request->segment_id;
        $no_ticket = "ticket_".Str::random(100);
        $note = $request->note;
        $damage_severity = $request->damage_severity;
        $photo = "report_photo_".Str::random(100);
        $report = ReportList::create([
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
        return response()->json($report);
    }

    function report_by_id($id) {
        $reportList = ReportList::where('id', $id)->first();
        return response()->json($reportList);
    }

    function reports_by_user_id() {
        $userId = Auth::id();
        $report = ReportList::where('user_id', $userId)->get();
        return response()->json($report);
    }
}
