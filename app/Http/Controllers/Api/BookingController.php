<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;

class BookingController extends Controller
{
    // AUTH MODE - Buat booking
    public function store(StoreBookingRequest $request)
    {
        $booking = Booking::create([
            'schedule_id' => $request->schedule_id,
            'user_id' => auth()->guard()->user() ? auth()->guard()->user()->id : null,
            'status' => 'booked'
        ]);
        
        try {
            return response()->json([
                'success' => true,
                'message' => 'Booking berhasil',
                'data' => new BookingResource($booking->load('schedule'))
            ], 201);    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    
    // AUTH MODE - List booking user login
    public function myBookings()
    {
        $userId = auth()->guard()->check() ? auth()->guard()->user()->id : null;
        $bookings = Booking::where('user_id', $userId)
            ->with('schedule')
            ->latest()
            ->get();
            
        return response()->json([
            'success' => true,
            'message' => 'Riwayat booking Anda',
            'data' => BookingResource::collection($bookings)
        ]);
    }
    
    // AUTH MODE - Cancel booking
    public function cancel($id)
    {
        $booking = Booking::where('user_id', auth()->guard()->user()->id)
            ->where('status', 'booked')
            ->findOrFail($id);
            
        $booking->update(['status' => 'cancelled']);
        
        return response()->json([
            'success' => true,
            'message' => 'Booking dibatalkan',
            'data' => new BookingResource($booking->load('schedule'))
        ]);
    }
}