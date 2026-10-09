<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Service;

class AppointmentController extends Controller
{
    public function store(StoreAppointmentRequest $request)
    {
        $data = $request->validated();

        $patient = Patient::query()
            ->where('phone', $data['phone'])
            ->first();

        if ($patient === null) {
            $patient = Patient::create([
                'name' => $data['name'],
                'email' => $data['email'] ?? null,
                'phone' => $data['phone'],
            ]);
        }

        $startsAt = "{$data['requested_date']} {$data['requested_time']}";
        $duration = Service::query()->find($data['service_id'] ?? null)?->duration_minutes ?? 45;

        Appointment::create([
            'patient_id' => $patient->id,
            'service_id' => $data['service_id'] ?? null,
            'starts_at' => $startsAt,
            'ends_at' => now()->parse($startsAt)->addMinutes($duration),
            'status' => Appointment::STATUS_PENDING,
            'patient_notes' => $data['notes'] ?? null,
        ]);

        return back()->with('success', '¡Solicitud enviada! Te contactaremos para confirmar tu cita.');
    }
}
