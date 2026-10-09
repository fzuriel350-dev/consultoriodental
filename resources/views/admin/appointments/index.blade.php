@extends('layouts.admin')

@section('title', 'Citas')

@section('content')
    <div class="topbar">
        <h1>Gestión de citas</h1>
        <a class="btn btn-gray" href="{{ route('admin.dashboard') }}">Volver al resumen</a>
    </div>

    <form class="filters" method="GET" action="{{ route('admin.appointments.index') }}">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar paciente o teléfono...">
        <select name="status">
            <option value="">Todos los estados</option>
            @foreach ($statuses as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>{{ __("citas.{$status}") }}</option>
            @endforeach
        </select>
        <button class="btn" type="submit">Filtrar</button>
    </form>

    <div class="table-wrap">
        <table class="data">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Paciente</th>
                    <th>Teléfono</th>
                    <th>Servicio</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->starts_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $appointment->patient->name }}</td>
                        <td>{{ $appointment->patient->phone }}</td>
                        <td>{{ $appointment->service?->name ?? '—' }}</td>
                        <td><span class="badge badge-{{ $appointment->status }}">{{ __("citas.{$appointment->status}") }}</span></td>
                        <td><a class="btn btn-sm btn-outline" href="{{ route('admin.appointments.show', $appointment) }}">Gestionar</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6">No hay citas para mostrar.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">{{ $appointments->links() }}</div>
@endsection