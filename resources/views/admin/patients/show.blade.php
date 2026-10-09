@extends('layouts.admin')

@section('title', 'Paciente · ' . $patient->name)

@section('content')
    <div class="topbar">
        <h1>{{ $patient->name }}</h1>
        <a class="btn btn-gray" href="{{ route('admin.patients.index') }}">← Volver</a>
    </div>

    <div class="card mb-2">
        <p>
            <strong>Teléfono:</strong> {{ $patient->phone }}<br>
            <strong>Correo:</strong> {{ $patient->email ?? '—' }}<br>
            <strong>Notas:</strong> {{ $patient->notes ?? '—' }}
        </p>
    </div>

    <div class="card">
        <h3>Historial de citas</h3>

        @if ($patient->appointments->isEmpty())
            <p>Este paciente aún no tiene citas.</p>
        @else
            <div class="table-wrap">
                <table class="data">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Servicio</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patient->appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->starts_at->format('d/m/Y H:i') }}</td>
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