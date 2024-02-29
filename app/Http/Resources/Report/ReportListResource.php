<?php

namespace App\Http\Resources\Report;

use App\Http\Resources\User\UserResource;
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
            'user' => UserResource::collection($this->whenLoaded('user_id')),
        ];

        if ($request->has('embed') && $request->get('embed') === 'user_id') {
            $data['user'] = new UserResource($this->user);
        }

        if ($request->has('embed') && $request->get('embed') === 'status_id') {
            $data['status_id'] = new UserResource($this->status_id);
        }

        return $data;
    }
}
