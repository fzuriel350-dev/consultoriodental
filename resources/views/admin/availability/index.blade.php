@extends('layouts.admin')

@section('title', 'Disponibilidad')

@section('content')
    <div class="topbar">
        <h1>Horario de atención</h1>
    </div>

    <form method="POST" action="{{ route('admin.availability.update') }}">
        @csrf
        @method('PUT')

        <div class="availability-grid mb-2">
            @foreach ($days as $day)
                <div class="day-card">
                    <h3>{{ $day['name'] }}</h3>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="days[{{ $day['day_of_week'] }}][active]" value="1" @checked($day['is_active'])>
                            Atiende
                        </label>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Apertura</label>
                            <input type="time" name="days[{{ $day['day_of_week'] }}][opens_at]" value="{{ $day['opens_at'] }}">
                        </div>
                        <div class="form-group">
                            <label>Cierre</label>
                            <input type="time" name="days[{{ $day['day_of_week'] }}][closes_at]" value="{{ $day['closes_at'] }}">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <button class="btn" type="submit">Guardar horario</button>
    </form>
@endsection