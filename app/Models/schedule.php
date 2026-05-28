<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['title', 'start_time', 'end_time', 'slot_capacity'];
    
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
    
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    
    // Tambahkan accessor untuk available_slots
    public function getAvailableSlotsAttribute()
    {
        $bookedCount = $this->bookings()->where('status', 'booked')->count();
        return max(0, $this->slot_capacity - $bookedCount);
    }
}