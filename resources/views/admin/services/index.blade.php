@extends('layouts.admin')

@section('title', 'Servicios')

@section('content')
    <div class="topbar">
        <h1>Servicios</h1>
        <a class="btn" href="{{ route('admin.services.create') }}">+ Nuevo servicio</a>
    </div>

    <div class="table-wrap">
        <table class="data">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Duración</th>
                    <th>Citas</th>
                    <th>Activo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($services as $service)
                    <tr>
                        <td>{{ $service->name }}</td>
                        <td>{{ $service->price !== null ? '$' . number_format($service->price, 0) : '—' }}</td>
                        <td>{{ $service->duration_minutes }} min</td>
                        <td>{{ $service->appointments_count }}</td>
                        <td>{{ $service->is_active ? 'Sí' : 'No' }}</td>
                        <td>
                            <a class="btn btn-sm btn-outline" href="{{ route('admin.services.edit', $service) }}">Editar</a>
                            <form method="POST" action="{{ route('admin.services.destroy', $service) }}" style="display:inline" onsubmit="return confirm('¿Eliminar este servicio?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6">No hay servicios registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection