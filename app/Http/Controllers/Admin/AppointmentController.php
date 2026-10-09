<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    public function index(Request $request): View
    {
        $appointments = Appointment::query()
            ->with(['patient', 'service'])
            ->when($request->query('status'), function ($query, string $status) {
                $query->where('status', $status);
            })
            ->when($request->query('q'), function ($query, string $search) {
                $query->whereHas('patient', function ($patientQuery) use ($search) {
                    $patientQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->orderBy('starts_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.appointments.index', [
            'appointments' => $appointments,
            'statuses' => Appointment::STATUSES,
        ]);
    }

    public function show(Appointment $appointment): View
    {
        $appointment->load(['patient', 'service']);

        return view('admin.appointments.show', compact('appointment'));
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment): RedirectResponse
    {
        $data = $request->validated();

        if (! empty($data['starts_at'])) {
            $startsAt = now()->parse($data['starts_at']);
            $duration = $appointment->service?->duration_minutes ?? 45;
            $data['ends_at'] = $startsAt->copy()->addMinutes($duration);
        } else {
            unset($data['starts_at']);
        }

        $appointment->update($data);

        return back()->with('success', 'Cita actualizada correctamente.');
    }
}
