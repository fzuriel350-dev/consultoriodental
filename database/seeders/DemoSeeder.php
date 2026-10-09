<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Service;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $patient = Patient::create([
            'name' => 'Laura Méndez',
            'email' => 'laura.mendez@example.com',
            'phone' => '+504 9000-1111',
        ]);

        $service = Service::query()->where('name', 'like', '%limpieza%')->first()
            ?? Service::query()->where('is_active', true)->first();

        Appointment::create([
            'patient_id' => $patient->id,
            'service_id' => $service?->id,
            'starts_at' => now()->addDay()->setTime(10, 0),
            'ends_at' => now()->addDay()->setTime(10, 45),
            'status' => Appointment::STATUS_PENDING,
        ]);
    }
}