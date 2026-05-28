@extends('layouts.app')

@section('title', 'Booking Saya')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-bookmark"></i> Riwayat Booking Saya</h4>
            </div>
            <div class="card-body">
                <div id="bookingsContainer">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary"></div>
                        <p>Memuat data...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const API_URL = '{{ url("/api") }}';
    
    async function loadBookings() {
        const container = document.getElementById('bookingsContainer');
        const token = getToken();
        
        if (!token) {
            container.innerHTML = '<div class="alert alert-warning">Silakan login terlebih dahulu</div>';
            return;
        }
        
        try {
            const response = await fetch(`${API_URL}/bookings/me`, {
                headers: { 'Authorization': `Bearer ${token}` }
            });
            const result = await response.json();
            
            if (result.success && result.data.length > 0) {
                let html = `<table class="table table-bordered">
                    <thead class="table-dark">
                        <tr><th>No</th><th>Jadwal</th><th>Waktu</th><th>Status</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>`;
                result.data.forEach((b, i) => {
                    html += `<tr>
                        <td>${i+1}</td>
                        <td><strong>${b.schedule.title}</strong></td>
                        <td>${new Date(b.schedule.start_time).toLocaleString('id-ID')}</td>
                        <td><span class="badge ${b.status === 'booked' ? 'badge-booked' : 'badge-cancelled'}">${b.status}</span></td>
                        <td>${b.status === 'booked' ? `<button class="btn btn-danger btn-sm" onclick="cancelBooking(${b.id})">Batalkan</button>` : '-'}</td>
                    </tr>`;
                });
                html += '</tbody></table>';
                container.innerHTML = html;
            } else {
                container.innerHTML = '<div class="alert alert-info">Belum ada booking</div>';
            }
        } catch (error) {
            container.innerHTML = '<div class="alert alert-danger">Gagal memuat data</div>';
        }
    }
    
    async function cancelBooking(id) {
        if (!confirm('Yakin ingin membatalkan booking ini?')) return;
        const token = getToken();
        try {
            const response = await fetch(`${API_URL}/bookings/${id}`, {
                method: 'DELETE',
                headers: { 'Authorization': `Bearer ${token}` }
            });
            const result = await response.json();
            if (result.success) {
                showAlert(result.message, 'success');
                loadBookings();
            } else {
                showAlert(result.message, 'danger');
            }
        } catch (error) {
            showAlert('Gagal membatalkan booking', 'danger');
        }
    }
    
    loadBookings();
</script>
@endpush
@endsection