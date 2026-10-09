<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel') · {{ $settings['site_name'] ?? 'Dashboard' }}</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    @section('sidebar')
        <div class="sidebar">
            <div class="brand">{{ $settings['site_name'] ?? 'Dental' }} <span>· Panel</span></div>
            <nav>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Resumen</a>
                <a href="{{ route('admin.appointments.index') }}" class="{{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}">Citas</a>
                <a href="{{ route('admin.patients.index') }}" class="{{ request()->routeIs('admin.patients.*') ? 'active' : '' }}">Pacientes</a>
                <a href="{{ route('admin.services.index') }}" class="{{ request()->routeIs('admin.services.*') ? 'active' : '' }}">Servicios</a>
                <a href="{{ route('admin.testimonials.index') }}" class="{{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">Testimonios</a>
                <a href="{{ route('admin.availability.index') }}" class="{{ request()->routeIs('admin.availability.*') ? 'active' : '' }}">Disponibilidad</a>
                <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">Configuración</a>
            </nav>
            <div class="sidebar-footer">
                <p>{{ auth()->user()->name }}</p>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="btn btn-sm btn-gray" type="submit">Cerrar sesión</button>
                </form>
            </div>
        </div>
    @endsection

    <div class="admin-layout">
        @yield('sidebar')
        <div class="content">
            @if (session('success'))
                <div class="flash flash-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="flash flash-error">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</body>
</html>