@extends('layouts.admin')

@section('title', 'Configuración')

@section('content')
    <div class="topbar">
        <h1>Configuración del sitio</h1>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf
            @method('PUT')

            <div class="settings-grid">
                @foreach ($fields as $key => $config)
                    <div class="form-group">
                        <label for="{{ $key }}">{{ $config['label'] }}</label>
                        @if ($config['type'] === 'textarea')
                            <textarea id="{{ $key }}" name="{{ $key }}" rows="{{ $config['rows'] }}">{{ $values[$key] ?? '' }}</textarea>
                        @else
                            <input id="{{ $key }}" type="{{ $config['type'] }}" name="{{ $key }}" value="{{ $values[$key] ?? '' }}">
                        @endif
                    </div>
                @endforeach
            </div>

            <button class="btn" type="submit">Guardar configuración</button>
        </form>
    </div>
@endsection