@extends('layouts.admin')

@section('title', 'Pacientes')

@section('content')
    <div class="topbar">
        <h1>Pacientes</h1>
    </div>

    <form class="filters" method="GET" action="{{ route('admin.patients.index') }}">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar por nombre, teléfono o correo...">
        <button class="btn" type="submit">Buscar</button>
    </form>

    <div class="table-wrap">
        <table class="data">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Citas</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($patients as $patient)
                    <tr>
                        <td>{{ $patient->name }}</td>
                        <td>{{ $patient->phone }}</td>
                        <td>{{ $patient->email ?? '—' }}</td>
                        <td>{{ $patient->appointments_count }}</td>
                        <td><a class="btn btn-sm btn-outline" href="{{ route('admin.patients.show', $patient) }}">Ver historial</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5">No hay pacientes registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">{{ $patients->links() }}</div>
@endsection