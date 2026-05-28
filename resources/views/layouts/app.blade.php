<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Booking API')</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { background-color: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .navbar-brand, .nav-link { color: white !important; font-weight: 500; }
        .card { border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); border: none; margin-bottom: 20px; }
        .card-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0 !important; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; }
        .btn-primary:hover { background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%); }
        .schedule-card { transition: transform 0.3s; cursor: pointer; }
        .schedule-card:hover { transform: translateY(-5px); }
        .badge-available { background-color: #28a745; }
        .badge-full { background-color: #dc3545; }
        .badge-booked { background-color: #ffc107; color: #000; }
        .badge-cancelled { background-color: #6c757d; }
        .toast-notification { position: fixed; top: 80px; right: 20px; z-index: 9999; min-width: 300px; }
        footer { background-color: #fff; padding: 20px; text-align: center; margin-top: 50px; box-shadow: 0 -2px 10px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-calendar-check"></i> Booking API
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('my-bookings') }}">
                                <i class="fas fa-bookmark"></i> Booking Saya
                            </a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link" style="color: white;">
                                    <i class="fas fa-sign-out-alt"></i> Logout ({{ auth()->user()->name }})
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus"></i> Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="toast-notification" id="toastContainer"></div>

    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer>
        <div class="container">
            <p class="mb-0">&copy; 2026 Booking API - Project PKL</p>
            <small class="text-muted">Laravel dengan Sanctum, Form Request, dan Resource</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showAlert(message, type = 'danger') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `alert alert-${type} alert-dismissible fade show`;
            toast.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i>
                <strong>${type === 'success' ? 'Sukses!' : 'Error!'}</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            container.appendChild(toast);
            setTimeout(() => toast.remove(), 5000);
        }
        
        function setToken(token) { localStorage.setItem('api_token', token); }
        function getToken() { return localStorage.getItem('api_token'); }
        function removeToken() { localStorage.removeItem('api_token'); }
    </script>
    @stack('scripts')
</body>
</html>