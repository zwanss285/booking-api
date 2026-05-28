@extends('layouts.app')

@section('title', 'Daftar Jadwal')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-calendar-alt"></i> Daftar Jadwal Tersedia</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="availableOnly">
                        <label class="form-check-label" for="availableOnly">
                            <i class="fas fa-filter"></i> Hanya tampilkan jadwal tersedia
                        </label>
                    </div>
                </div>
                <div id="schedulesContainer">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary"></div>
                        <p class="mt-3">Memuat data jadwal...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const API_URL = '{{ url("/api") }}';
    
    async function loadSchedules() {
        const container = document.getElementById('schedulesContainer');
        const availableOnly = document.getElementById('availableOnly').checked;
        let url = `${API_URL}/schedules`;
        if (availableOnly) url += '?available_only=1';
        
        try {
            const response = await fetch(url);
            const result = await response.json();
            
            if (result.success && result.data.length > 0) {
                let html = '<div class="row">';
                result.data.forEach(schedule => {
                    const isAvailable = schedule.available_slots > 0;
                    html += `
                        <div class="col-md-4 mb-4">
                            <div class="card schedule-card" onclick="viewDetail(${schedule.id})">
                                <div class="card-body">
                                    <h5 class="card-title">${schedule.title}</h5>
                                    <p class="card-text">
                                        <i class="far fa-clock"></i> Mulai: ${new Date(schedule.start_time).toLocaleString('id-ID')}<br>
                                        <i class="far fa-calendar"></i> Selesai: ${new Date(schedule.end_time).toLocaleString('id-ID')}<br>
                                        <i class="fas fa-users"></i> Kapasitas: ${schedule.slot_capacity}<br>
                                        <i class="fas fa-chair"></i> Sisa: ${schedule.available_slots}
                                    </p>
                                    <span class="badge ${isAvailable ? 'badge-available' : 'badge-full'}">
                                        ${isAvailable ? 'Tersedia' : 'Penuh'}
                                    </span>
                                </div>
                            </div>
                        </div>
                    `;
                });
                html += '</div>';
                container.innerHTML = html;
            } else {
                container.innerHTML = '<div class="alert alert-info">Tidak ada jadwal tersedia</div>';
            }
        } catch (error) {
            container.innerHTML = '<div class="alert alert-danger">Gagal memuat data</div>';
        }
    }
    
    function viewDetail(id) {
        window.location.href = `{{ url("/schedules") }}/${id}`;
    }
    
    document.getElementById('availableOnly').addEventListener('change', loadSchedules);
    loadSchedules();
</script>
@endpush
@endsection