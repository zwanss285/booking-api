@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-tachometer-alt"></i> Welcome, {{ auth()->user()->name }}!</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="fas fa-calendar-plus fa-3x text-primary mb-3"></i>
                                <h5>Booking Baru</h5>
                                <a href="{{ url('/') }}" class="btn btn-primary">Cek Jadwal</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="fas fa-bookmark fa-3x text-success mb-3"></i>
                                <h5>Booking Saya</h5>
                                <a href="{{ route('my-bookings') }}" class="btn btn-success">Lihat Booking</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection