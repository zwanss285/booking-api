<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    public function toArray($request)
    {
        $bookedCount = $this->bookings()->where('status', 'booked')->count();
        
        return [
            'id' => $this->id,
            'title' => $this->title,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'slot_capacity' => $this->slot_capacity,
            'available_slots' => max(0, $this->slot_capacity - $bookedCount),
            'is_available' => ($bookedCount < $this->slot_capacity)
        ];
    }
}