@extends('layouts.admin')

@section('title', 'Testimonios')

@section('content')
    <div class="topbar">
        <h1>Testimonios</h1>
        <a class="btn" href="{{ route('admin.testimonials.create') }}">+ Nuevo testimonio</a>
    </div>

    <div class="table-wrap">
        <table class="data">
            <thead>
                <tr>
                    <th>Autor</th>
                    <th>Mensaje</th>
                    <th>Puntuación</th>
                    <th>Publicado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($testimonials as $testimonial)
                    <tr>
                        <td>{{ $testimonial->author_name }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($testimonial->message, 80) }}</td>
                        <td>{{ $testimonial->rating ? str_repeat('★', $testimonial->rating) : '—' }}</td>
                        <td>{{ $testimonial->is_published ? 'Sí' : 'No' }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.testimonials.toggle', $testimonial) }}" style="display:inline">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm btn-soft" type="submit">{{ $testimonial->is_published ? 'Ocultar' : 'Publicar' }}</button>
                            </form>
                            <a class="btn btn-sm btn-outline" href="{{ route('admin.testimonials.edit', $testimonial) }}">Editar</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5">No hay testimonios.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">{{ $testimonials->links() }}</div>
@endsection