@extends('layouts.admin')

@section('title', $service->id ? 'Editar servicio' : 'Nuevo servicio')

@section('content')
    <div class="topbar">
        <h1>{{ $service->id ? 'Editar servicio' : 'Nuevo servicio' }}</h1>
        <a class="btn btn-gray" href="{{ route('admin.services.index') }}">← Volver</a>
    </div>

    <div class="card">
        <form method="POST" action="{{ $service->id ? route('admin.services.update', $service) : route('admin.services.store') }}">
            @csrf
            @if ($service->id) @method('PUT') @endif

            <div class="form-group">
                <label for="name">Nombre</label>
                <input id="name" type="text" name="name" value="{{ old('name', $service->name) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea id="description" name="description" rows="3">{{ old('description', $service->description) }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price">Precio (opcional)</label>
                    <input id="price" type="number" step="0.01" min="0" name="price" value="{{ old('price', $service->price) }}">
                </div>
                <div class="form-group">
                    <label for="duration_minutes">Duración (minutos)</label>
                    <input id="duration_minutes" type="number" min="5" max="480" name="duration_minutes" value="{{ old('duration_minutes', $service->duration_minutes ?? 45) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $service->is_active ?? true))>
                    Visible en la página pública
                </label>
            </div>

            <button class="btn" type="submit">Guardar</button>
        </form>
    </div>
@endsection