<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $date = Carbon::tomorrow();

        Schedule::create([
            'title' => 'Konsultasi Pagi',
            'start_time' => $date->copy()->setTime(9, 0, 0),
            'end_time' => $date->copy()->setTime(10, 0, 0),
            'slot_capacity' => 2,
        ]);
        
        Schedule::create([
            'title' => 'Konsultasi Siang',
            'start_time' => $date->copy()->setTime(13, 0, 0),
            'end_time' => $date->copy()->setTime(14, 0, 0),
            'slot_capacity' => 1,
        ]);
        
        Schedule::create([
            'title' => 'Konsultasi Sore',
            'start_time' => $date->copy()->setTime(15, 0, 0),
            'end_time' => $date->copy()->setTime(16, 0, 0),
            'slot_capacity' => 3,
        ]);
        
        User::create([
            'name' => 'Budi',
            'email' => 'budi@test.com',
            'password' => Hash::make('11111111'),
        ]);
    }
}