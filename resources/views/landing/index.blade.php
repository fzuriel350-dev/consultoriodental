@extends('layouts.public')

@section('title', $settings['site_name'] ?? 'Consultorio Dental')

@section('content')
    <section class="hero">
        <div class="container">
            <div>
                <span class="hero-badge">Cuidado dental de confianza</span>
                <h1>{{ $settings['hero_title'] ?? 'Tu sonrisa' }} <span>{{ $settings['site_name'] ?? 'en las mejores manos' }}</span></h1>
                <p>{{ $settings['hero_subtitle'] ?? 'Atención dental profesional y personalizada. Agenda tu cita en minutos.' }}</p>
                <a href="#agendar" class="btn btn-teal">Agenda tu cita</a>
                <a href="#servicios" class="btn btn-outline">Ver servicios</a>
            </div>
            <div class="hero-card">
                <h3>Información</h3>
                <p><strong>Teléfono:</strong> {{ $settings['phone'] ?? '—' }}</p>
                <p><strong>Correo:</strong> {{ $settings['email'] ?? '—' }}</p>
                <p><strong>Dirección:</strong> {{ $settings['address'] ?? '—' }}</p>
                <p><strong>Horario:</strong> {{ $settings['working_hours'] ?? '—' }}</p>
            </div>
        </div>
    </section>

    <section id="servicios" class="section">
        <div class="container">
            <div class="section-title">
                <h2>Nuestros servicios</h2>
                <p>Atención integral para toda la familia.</p>
            </div>
            <div class="card-grid">
                @forelse ($services as $service)
                    <div class="service-card">
                        <div class="icon">🦷</div>
                        <h3>{{ $service->name }}</h3>
                        @if ($service->price !== null)
                            <p class="meta">Desde ${{ number_format($service->price, 0) }}</p>
                        @endif
                        <p class="desc">{{ $service->description }}</p>
                    </div>
                @empty
                    <p>Próximamente.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section id="agendar" class="section appointment-section">
        <div class="container">
            <div class="appointment-info">
                <h2>Solicita tu cita</h2>
                <p>Déjanos tus datos y te confirmaremos la disponibilidad lo antes posible.</p>
                <div class="detail">
                    <div>
                        <strong>Teléfono / WhatsApp</strong><br>
                        <a href="tel:{{ $settings['phone'] ?? '' }}">{{ $settings['phone'] ?? '—' }}</a>
                    </div>
                </div>
                <div class="detail">
                    <div>
                        <strong>Correo</strong><br>
                        <a href="mailto:{{ $settings['email'] ?? '' }}">{{ $settings['email'] ?? '—' }}</a>
                    </div>
                </div>
            </div>

            <form class="appointment-form" method="POST" action="{{ route('appointments.request') }}">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Nombre completo *</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required>
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">Teléfono *</label>
                        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required>
                        @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Correo electrónico (opcional)</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}">
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="service_id">Servicio (opcional)</label>
                    <select id="service_id" name="service_id">
                        <option value="">— Sin servicio específico —</option>
                        @foreach ($services as $service)
                            <option value="{{ $service->id }}" @selected(old('service_id') == $service->id)>{{ $service->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="requested_date">Fecha preferida *</label>
                        <input id="requested_date" type="date" name="requested_date" value="{{ old('requested_date') }}" required>
                        @error('requested_date') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="requested_time">Hora preferida *</label>
                        <input id="requested_time" type="time" name="requested_time" value="{{ old('requested_time') }}" required>
                        @error('requested_time') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes">Motivo o comentario (opcional)</label>
                    <textarea id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                </div>

                <button type="submit" class="btn btn-teal" style="width:100%">Enviar solicitud</button>
            </form>
        </div>
    </section>
@endsection