<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AvailabilityController extends Controller
{
    public const DAY_NAMES = [
        0 => 'Domingo',
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
    ];

    public function index(): View
    {
        $days = collect(self::DAY_NAMES)->map(function (string $name, int $dayOfWeek) {
            $availability = Availability::query()
                ->where('day_of_week', $dayOfWeek)
                ->first();

            return [
                'day_of_week' => $dayOfWeek,
                'name' => $name,
                'opens_at' => $availability?->opens_at,
                'closes_at' => $availability?->closes_at,
                'is_active' => $availability?->is_active ?? false,
            ];
        });

        return view('admin.availability.index', ['days' => $days]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'days' => ['required', 'array'],
            'days.*.active' => ['sometimes', 'boolean'],
            'days.*.opens_at' => ['required_if:days.*.active,1', 'nullable', 'date_format:H:i'],
            'days.*.closes_at' => ['required_if:days.*.active,1', 'nullable', 'date_format:H:i', 'after:days.*.opens_at'],
        ]);

        foreach ($data['days'] as $dayOfWeek => $config) {
            $active = ($config['active'] ?? false) === true || $config['active'] === '1';

            if (! $active) {
                Availability::query()->where('day_of_week', $dayOfWeek)->delete();

                continue;
            }

            Availability::updateOrCreate(
                ['day_of_week' => $dayOfWeek],
                [
                    'opens_at' => $config['opens_at'],
                    'closes_at' => $config['closes_at'],
                    'is_active' => true,
                ],
            );
        }

        return back()->with('success', 'Horario de atención actualizado.');
    }
}
