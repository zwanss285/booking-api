<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'schedule' => new ScheduleResource($this->whenLoaded('schedule')),
            'status' => $this->status,
            'booked_at' => $this->created_at->toDateTimeString(),
            'cancelled_at' => $this->updated_at->when($this->status === 'cancelled')
        ];
    }
}