<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $settings['meta_description'] ?? ($settings['tagline'] ?? 'Atención dental profesional') }}">
    <title>@yield('title', $settings['site_name'] ?? 'Consultorio Dental')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
    <header class="site-header">
        <div class="container">
            <a class="brand" href="/">{{ $settings['site_name'] ?? 'Consultorio Dental' }}</a>
            <nav class="main-nav">
                <a href="#servicios">Servicios</a>
                <a href="#agendar">Agenda tu cita</a>
                <a class="nav-login" href="{{ route('admin.login') }}">Iniciar sesión</a>
            </nav>
        </div>
    </header>

    @if (session('success'))
        <div class="container"><div class="flash flash-success">{{ session('success') }}</div></div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container">
            <div>
                <h4>{{ $settings['site_name'] ?? 'Consultorio Dental' }}</h4>
                <p>{{ $settings['tagline'] ?? '' }}</p>
            </div>
            <div>
                <h4>Contacto</h4>
                <p>
                    @if (! empty($settings['phone'])) <a href="tel:{{ $settings['phone'] }}">{{ $settings['phone'] }}</a><br>@endif
                    @if (! empty($settings['email'])) <a href="mailto:{{ $settings['email'] }}">{{ $settings['email'] }}</a><br>@endif
                    {{ $settings['address'] ?? '' }}
                </p>
            </div>
            <div>
                <h4>Horario</h4>
                <p>{{ $settings['working_hours'] ?? '' }}</p>
                @if (! empty($settings['instagram'])) <p>Instagram: <a href="https://instagram.com/{{ $settings['instagram'] }}">{{ $settings['instagram'] }}</a></p>@endif
                @if (! empty($settings['facebook'])) <p>Facebook: <a href="https://facebook.com/{{ $settings['facebook'] }}">{{ $settings['facebook'] }}</a></p>@endif
            </div>
        </div>
        <div class="container">
            <div class="footer-bottom">© {{ date('Y') }} {{ $settings['site_name'] ?? 'Consultorio Dental' }}. Todos los derechos reservados.</div>
        </div>
    </footer>
</body>
</html>