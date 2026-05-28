<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Schedule;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }
    
    public function detail($id)
    {
        // Ambil data schedule dari database
        $schedule = Schedule::findOrFail($id);
        
        // Kirim ke view
        return view('schedule-detail', [
            'schedule' => $schedule,
            'id' => $id
        ]);
    }
}