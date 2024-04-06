<?php

namespace App\Http\Resources\Report;

use App\Http\Resources\Map\MapSegmentResource;
use App\Http\Resources\User\UserResource;
use App\Models\Report\ReportSegment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        $data = [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'status_id' => $this->status_id,
            'no_ticket' => $this->no_ticket,
            'note' => $this->note,
            'maintenance_by' => $this->maintenance_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        if ($request->has('embed')) {
            $embedValues = explode(',', $request->get('embed'));

            if (in_array('user_id', $embedValues)) {
                $data['user'] = new UserResource($this->user);
            }

            if (in_array('status_id', $embedValues)) {
                $data['status'] = new StatusResource($this->status);
            }

            if (in_array('segments', $embedValues)) {
                $segments = $this->segments->map(function ($segment) {
                    $segmentResource = new ReportSegmentResource($segment);
                    $photoResource = new ReportPhotoResource($segment);
                    $photoRepairResource = new ReportPhotoRepairResource($segment);
                    if (isset($segment->segmen)) {
                        $segmentResource->segmen = new MapSegmentResource($segment->segmen);
                    }
                    if (isset($segment->report_photo)) {
                        $photoResource->report_photo = new ReportPhotoResource($segment->report_photo);
                    }
                    if (isset($segment->report_photo_repair)) {
                        $photoRepairResource->report_photo_repair = new ReportPhotoRepairResource($segment->report_photo_repair);
                    }
                    return $segmentResource;
                });
                $data['segments'] = $segments;
            }
        }

        return $data;
    }
}
