@extends('layouts.app')

@section('title', 'Detail Jadwal')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-info-circle"></i> Detail Jadwal</h4>
            </div>
            <div class="card-body">
                @if($schedule)
                    <h3>{{ $schedule->title }}</h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Mulai:</strong><br>
                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('d/m/Y H:i:s') }}</p>
                            <p><strong>Selesai:</strong><br>
                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('d/m/Y H:i:s') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Kapasitas:</strong><br>
                            {{ $schedule->slot_capacity }} orang</p>
                            <p><strong>Sisa Slot:</strong><br>
                            {{ $schedule->available_slots ?? $schedule->slot_capacity }}</p>
                        </div>
                    </div>
                    
                    @php
                        $bookedCount = $schedule->bookings()->where('status', 'booked')->count();
                        $isAvailable = ($bookedCount < $schedule->slot_capacity);
                    @endphp
                    
                    <div class="alert {{ $isAvailable ? 'alert-success' : 'alert-danger' }} text-center">
                        {{ $isAvailable ? '✓ Jadwal tersedia!' : '✗ Maaf, jadwal sudah penuh' }}
                    </div>
                    
                    @auth
                        @if($isAvailable)
                            <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
                                @csrf
                                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-bookmark"></i> Booking Sekarang
                                </button>
                            </form>
                        @endif
                    @else
                        <div class="alert alert-info text-center">
                            Silakan <a href="{{ route('login') }}">login</a> terlebih dahulu untuk booking
                        </div>
                    @endauth
                @else
                    <div class="alert alert-danger">Jadwal tidak ditemukan</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection