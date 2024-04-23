<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Resources\Report\ReportPhotoRepairResource;
use App\Models\Report\ReportPhotoRepair;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class ReportPhotoRepairController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'report_segment_id' => 'required',
                'upload_dump_id' => 'required',
                'filename' => 'required',
                'file_url' => 'required',
            ]);

            $photo_repair = ReportPhotoRepair::findOrFail($validatedData['report_segment_id']);

            $photo_repair = ReportPhotoRepair::create($validatedData);

            return response()->json([
                'message' => 'Photo Photo Repair created successfully',
                'data' => new ReportPhotoRepairResource(($photo_repair)),
            ], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Photo Repair not found with provided ID',
                'message' => $e->getMessage(),
            ], 404);
        } catch (ValidationException $err) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $err->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update Photo Photo Repair',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
