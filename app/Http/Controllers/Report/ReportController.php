<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report\ReportList;
use App\Models\Report\ReportSegment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\FirebaseStorage;
use App\Models\File\UploadDump;

class ReportController extends Controller
{
    function create_report(Request $request) {
        try{
            $request->validate([
                'image1' => 'required|string',
            ]);
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
            $user_ip = $request->ip();
            $report = ReportList::create([
                'user_id' => auth()->user()->id,
                'status_id' => 'PROG',
                'no_ticket' => $no_ticket,
                'maintenance_by' => null,
            ]);
            $report_segment1 = $report->report_segment()->create([
                'segment_id' => $segment_id1,
                'level' => $level1,
                'note' => $note1
            ]);
            function uploadImage($image, $user_ip) {
                $parts = explode(';', $image);
                $mimePart = explode(':', $parts[0]);
                $mime = end($mimePart);
                $imageExtension = explode('/', $mime)[1];
                $image = preg_replace('#^data:image/\w+;base64,#i', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = uniqid().'.'.$imageExtension;
                $imagePath = public_path('images'). '/' . $imageName;
                $image = base64_decode($image);
                File::put($imagePath, $image);
                $storage = FirebaseStorage::initialize();
                $bucket = $storage->bucket('irrigation-upload-dump.appspot.com');
        
                $bucket->upload(fopen($imagePath, 'r'), [
                    'name' => 'image/' . $imageName,
                ]);
                
                $uploadDump = UploadDump::create([
                    'filename' => $imageName,
                    'file_type' => File::extension($imagePath),
                    'size' => File::size($imagePath),
                    'folder' => 'image',
                    'file_url' => 'https://storage.googleapis.com/irrigation-upload-dump.appspot.com/image/' . $imageName,
                    'uploader_ip' => $user_ip,
                    'uploader_status' => true,
                ]);
                File::delete($imagePath);
                return $uploadDump->id;
            }
            $image1 = $request->image1;
            $upload_dump_id1 = uploadImage($image1, $user_ip);
            $report_segment1->report_photo()->create([
                'upload_dump_id' => $upload_dump_id1,
            ]);
            if($segment_id2!=null){
                $report_segment2 = $report->report_segment()->create([
                    'segment_id' => $segment_id2,
                    'level' => $level2,
                    'note' => $note2
                ]);
                $image2 = $request->image2;
                $upload_dump_id2 = uploadImage($image2, $user_ip);
                $report_segment2->report_photo()->create([
                    'upload_dump_id' => $upload_dump_id2,
                ]);
            }
            if($segment_id3!=null){
                $report_segment3 = $report->report_segment()->create([
                    'segment_id' => $segment_id3,
                    'level' => $level3,
                    'note' => $note3
                ]);
                $image3 = $request->image3;
                $upload_dump_id3 = uploadImage($image3, $user_ip);
                $report_segment3->report_photo()->create([
                    'upload_dump_id' => $upload_dump_id3,
                ]);
            }
            return response()->json([
                'message' => 'Report data successfuly sended',
                'data' =>$report
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to send report data',
                'message' => $e->getMessage(),
            ], 500);
        }
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
        $userId = auth()->user()->id;
        $report = DB::table('report.report_list')
                    ->where('report.report_list.user_id', '=', $userId)
                    ->join('report.status', 'report.report_list.status_id', '=', 'report.status.id')
                    ->join('report.report_segment', 'report.report_list.id', '=', 'report.report_segment.report_id')
                    ->join('map.irrigations_segment', 'report.report_segment.segment_id', '=', 'map.irrigations_segment.id')
                    ->join('map.irrigations', 'map.irrigations_segment.irrigation_id', '=', 'map.irrigations.id')
                    ->select('report.report_list.id', 'report.report_list.no_ticket', 'report.report_segment.level', 'report.status.name as status', 'map.irrigations.name as irrigation', 'map.irrigations.type as canal')
                    ->get();
        return response()->json($report);
    }
}
