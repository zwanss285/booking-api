<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Schedule;

class StoreBookingRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'schedule_id' => 'required|exists:schedules,id',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $scheduleId = $this->schedule_id;
            $userId = Auth::id();
            
            $schedule = Schedule::find($scheduleId);
            
            if (!$schedule) {
                return;
            }
            
            // Validasi start_time < end_time
            if ($schedule->start_time >= $schedule->end_time) {
                $validator->errors()->add('schedule_id', 'Jadwal tidak valid (start_time harus sebelum end_time)');
                return;
            }
            
            // Cek jadwal sudah lewat
            if ($schedule->start_time < now()) {
                $validator->errors()->add('schedule_id', 'Tidak bisa booking jadwal yang sudah lewat');
                return;
            }
            
            // Cek double booking user yang sama
            $userAlreadyBooked = Booking::where('schedule_id', $scheduleId)
                ->where('user_id', $userId)
                ->where('status', 'booked')
                ->exists();
                
            if ($userAlreadyBooked) {
                $validator->errors()->add('schedule_id', 'Anda sudah booking jadwal ini');
                return;
            }
            
            // Cek slot capacity
            $currentBookings = Booking::where('schedule_id', $scheduleId)
                ->where('status', 'booked')
                ->count();
                
            if ($currentBookings >= $schedule->slot_capacity) {
                $validator->errors()->add('schedule_id', 'Jadwal sudah penuh');
            }
        });
    }
}