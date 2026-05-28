<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['booked', 'cancelled'])->default('booked');
            $table->timestamps();
            
            // Mencegah double booking user yang sama di schedule yang sama
            $table->unique(['schedule_id', 'user_id'], 'unique_user_booking');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};