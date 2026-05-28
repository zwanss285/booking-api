<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ScheduleResource;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    // GUEST MODE - List jadwal
    public function index(Request $request)
    {
        $query = Schedule::withCount(['bookings as booked_count' => function ($q) {
            $q->where('status', 'booked');
        }]);
        
        // Filter available_only=1
        if ($request->available_only == 1) {
            $schedules = $query->get()->filter(function ($schedule) {
                return ($schedule->slot_capacity - $schedule->booked_count) > 0;
            });
        } else {
            $schedules = $query->paginate(10);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Daftar jadwal',
            'data' => ScheduleResource::collection($schedules)
        ]);
    }
    
    // GUEST MODE - Detail jadwal
    public function show(Schedule $schedule)
    {
        $bookedCount = $schedule->bookings()->where('status', 'booked')->count();
        
        return response()->json([
            'success' => true,
            'message' => 'Detail jadwal',
            'data' => [
                'id' => $schedule->id,
                'title' => $schedule->title,
                'start_time' => $schedule->start_time,
                'end_time' => $schedule->end_time,
                'slot_capacity' => $schedule->slot_capacity,
                'available_slots' => max(0, $schedule->slot_capacity - $bookedCount),
                'is_available' => ($bookedCount < $schedule->slot_capacity)
            ]
        ]);
    }
}