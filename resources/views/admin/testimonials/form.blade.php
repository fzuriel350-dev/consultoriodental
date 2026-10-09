@extends('layouts.admin')

@section('title', $testimonial->id ? 'Editar testimonio' : 'Nuevo testimonio')

@section('content')
    <div class="topbar">
        <h1>{{ $testimonial->id ? 'Editar testimonio' : 'Nuevo testimonio' }}</h1>
        <a class="btn btn-gray" href="{{ route('admin.testimonials.index') }}">← Volver</a>
    </div>

    <div class="card">
        <form method="POST" action="{{ $testimonial->id ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}">
            @csrf
            @if ($testimonial->id) @method('PUT') @endif

            <div class="form-row">
                <div class="form-group">
                    <label for="author_name">Nombre del paciente</label>
                    <input id="author_name" type="text" name="author_name" value="{{ old('author_name', $testimonial->author_name) }}" required>
                </div>
                <div class="form-group">
                    <label for="author_role">Referencia (ej. "Paciente")</label>
                    <input id="author_role" type="text" name="author_role" value="{{ old('author_role', $testimonial->author_role) }}">
                </div>
            </div>

            <div class="form-group">
                <label for="message">Mensaje</label>
                <textarea id="message" name="message" rows="4" required>{{ old('message', $testimonial->message) }}</textarea>
            </div>

            <div class="form-group">
                <label for="rating">Puntuación (1-5)</label>
                <select id="rating" name="rating">
                    <option value="">Sin puntuación</option>
                    @for ($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" @selected(old('rating', $testimonial->rating) == $i)>{{ $i }} estrellas</option>
                    @endfor
                </select>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $testimonial->is_published))>
                    Publicar en la página
                </label>
            </div>

            <button class="btn" type="submit">Guardar</button>
        </form>
    </div>
@endsection