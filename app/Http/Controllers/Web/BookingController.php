<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        return view('my-bookings');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id'
        ]);
        
        $schedule = Schedule::find($request->schedule_id);
        $userId = Auth::id();
        
        // Cek double booking
        $existingBooking = Booking::where('schedule_id', $request->schedule_id)
            ->where('user_id', $userId)
            ->where('status', 'booked')
            ->exists();
            
        if ($existingBooking) {
            return redirect()->back()->with('error', 'Anda sudah booking jadwal ini');
        }
        
        // Cek kapasitas
        $bookedCount = Booking::where('schedule_id', $request->schedule_id)
            ->where('status', 'booked')
            ->count();
            
        if ($bookedCount >= $schedule->slot_capacity) {
            return redirect()->back()->with('error', 'Jadwal sudah penuh');
        }
        
        // Buat booking
        Booking::create([
            'schedule_id' => $request->schedule_id,
            'user_id' => $userId,
            'status' => 'booked'
        ]);
        
        return redirect()->route('my-bookings')->with('success', 'Booking berhasil!');
    }
    
    public function cancel($id)
    {
        $booking = Booking::where('user_id', Auth::id())
            ->where('status', 'booked')
            ->findOrFail($id);
            
        $booking->update(['status' => 'cancelled']);
        
        return redirect()->back()->with('success', 'Booking dibatalkan');
    }
}