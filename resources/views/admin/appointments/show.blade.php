@extends('layouts.admin')

@section('title', 'Cita · ' . $appointment->patient->name)

@section('content')
    <div class="topbar">
        <h1>Cita #{{ $appointment->id }}</h1>
        <a class="btn btn-gray" href="{{ route('admin.appointments.index') }}">← Volver</a>
    </div>

    <div class="card mb-2">
        <h3>Detalle</h3>
        <p>
            <strong>Paciente:</strong> <a href="{{ route('admin.patients.show', $appointment->patient) }}">{{ $appointment->patient->name }}</a><br>
            <strong>Teléfono:</strong> {{ $appointment->patient->phone }}<br>
            <strong>Correo:</strong> {{ $appointment->patient->email ?? '—' }}<br>
            <strong>Servicio:</strong> {{ $appointment->service?->name ?? '—' }}<br>
            <strong>Fecha y hora:</strong> {{ $appointment->starts_at->format('d/m/Y H:i') }} (hasta {{ $appointment->ends_at?->format('H:i') }})<br>
            <strong>Estado:</strong> <span class="badge badge-{{ $appointment->status }}">{{ __("citas.{$appointment->status}") }}</span>
        </p>
        @if ($appointment->patient_notes)
            <p><strong>Notas del paciente:</strong><br>{{ $appointment->patient_notes }}</p>
        @endif
    </div>

    <div class="card">
        <h3>Actualizar estado</h3>

        <form method="POST" action="{{ route('admin.appointments.update', $appointment) }}">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label for="status">Estado</label>
                    <select id="status" name="status">
                        @foreach (\App\Models\Appointment::STATUSES as $status)
                            <option value="{{ $status }}" @selected($appointment->status === $status)>{{ __("citas.{$status}") }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="starts_at">Reprogramar fecha y hora</label>
                    <input id="starts_at" type="datetime-local" name="starts_at" value="{{ optional($appointment->starts_at)->format('Y-m-d\TH:i') }}">
                </div>
            </div>

            <div class="form-group">
                <label for="admin_notes">Notas internas</label>
                <textarea id="admin_notes" name="admin_notes" rows="3">{{ $appointment->admin_notes }}</textarea>
            </div>

            <button class="btn" type="submit">Guardar cambios</button>
        </form>
    </div>
@endsection