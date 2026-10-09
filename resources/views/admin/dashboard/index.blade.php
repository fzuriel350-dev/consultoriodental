@extends('layouts.admin')

@section('title', 'Resumen')

@section('content')
    <div class="topbar">
        <h1>Resumen</h1>
        <span>{{ today()->translatedFormat('l, d \d\e F Y') }}</span>
    </div>

    <div class="stats-grid">
        <div class="stat-card"><div class="label">Citas de hoy</div><div class="value">{{ $stats['today'] }}</div></div>
        <div class="stat-card"><div class="label">Solicitudes pendientes</div><div class="value">{{ $stats['pending'] }}</div></div>
        <div class="stat-card"><div class="label">Próximas citas</div><div class="value">{{ $stats['upcoming'] }}</div></div>
        <div class="stat-card"><div class="label">Pacientes registrados</div><div class="value">{{ $stats['patients'] }}</div></div>
    </div>

    <div class="card mb-2">
        <h3>Citas de hoy</h3>

        @if ($todayAppointments->isEmpty())
            <p>No tienes citas para hoy.</p>
        @else
            <div class="table-wrap">
                <table class="data">
                    <thead>
                        <tr>
                            <th>Hora</th>
                            <th>Paciente</th>
                            <th>Teléfono</th>
                            <th>Servicio</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($todayAppointments as $appointment)
                            <tr>
                                <td>{{ $appointment->starts_at->format('H:i') }}</td>
                                <td>{{ $appointment->patient->name }}</td>
                                <td>{{ $appointment->patient->phone }}</td>
                                <td>{{ $appointment->service?->name ?? '—' }}</td>
                                <td><span class="badge badge-{{ $appointment->status }}">{{ __("citas.{$appointment->status}") }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection