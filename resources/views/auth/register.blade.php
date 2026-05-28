@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-user-plus"></i> Register</h4>
            </div>
            <div class="card-body">
                <form id="registerForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" id="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" id="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </form>
                <div class="text-center mt-3">
                    <a href="{{ route('login') }}">Sudah punya akun? Login</a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('registerForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const data = {
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            password_confirmation: document.getElementById('password_confirmation').value
        };
        
        try {
            const response = await fetch('{{ url("/api/register") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            const result = await response.json();
            
            if (result.success) {
                setToken(result.data.token);
                showAlert(result.message, 'success');
                setTimeout(() => window.location.href = '{{ route("dashboard") }}', 1000);
            } else {
                const errors = result.errors;
                let msg = '';
                for (let key in errors) msg += errors[key][0] + '\n';
                showAlert(msg || 'Registrasi gagal', 'danger');
            }
        } catch (error) {
            showAlert('Terjadi kesalahan', 'danger');
        }
    });
</script>
@endpush
@endsection