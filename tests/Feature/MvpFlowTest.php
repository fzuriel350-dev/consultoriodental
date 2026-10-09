<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MvpFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_display_public_content(): void
    {
        $this->seed();

        $this->get('/')
            ->assertOk()
            ->assertSee('SonrisaSana Dental')
            ->assertSee('Consulta general');
    }

    public function test_guest_can_request_an_appointment(): void
    {
        $this->seed();

        $this->post('/citas/solicitar', [
            'name' => 'Juan Pérez',
            'phone' => '+504 8888-7777',
            'requested_date' => now()->addDays(2)->toDateString(),
            'requested_time' => '10:30',
        ])->assertRedirect('/');

        $this->assertDatabaseHas('patients', ['phone' => '+504 8888-7777']);

        $this->assertDatabaseHas('appointments', [
            'status' => Appointment::STATUS_PENDING,
        ]);

        $appointment = Appointment::query()->latest()->first();
        $this->assertEquals('Juan Pérez', $appointment->patient->name);
    }

    public function test_repeat_patient_is_not_duplicated(): void
    {
        $this->seed();

        $payload = [
            'name' => 'Juan Pérez',
            'phone' => '+504 8888-7777',
            'requested_date' => now()->addDays(2)->toDateString(),
            'requested_time' => '10:30',
        ];

        $this->post('/citas/solicitar', $payload)->assertRedirect('/');
        $this->post('/citas/solicitar', $payload)->assertRedirect('/');

        $this->assertEquals(1, Patient::query()->where('phone', '+504 8888-7777')->count());
        $this->assertEquals(2, Appointment::count());
    }

    public function test_admin_login_and_dashboard(): void
    {
        $this->seed();

        $this->get(route('admin.dashboard'))->assertRedirect('/admin/login');

        $this->post('/admin/login', [
            'email' => 'admin@consultorio.test',
            'password' => 'dentista2026',
        ])->assertRedirect(route('admin.dashboard'));

        $this->get(route('admin.dashboard'))->assertOk()->assertSee('Resumen');
    }

    public function test_admin_can_confirm_an_appointment(): void
    {
        $this->seed();

        $patient = Patient::create(['name' => 'Ana Torres', 'phone' => '+504 7777-1234']);

        $appointment = Appointment::create([
            'patient_id' => $patient->id,
            'starts_at' => now()->addDays(2)->setTime(10, 0),
            'ends_at' => now()->addDays(2)->setTime(10, 45),
            'status' => Appointment::STATUS_PENDING,
        ]);

        $admin = User::query()->first();

        $this->actingAs($admin)->put(
            route('admin.appointments.update', $appointment),
            ['status' => Appointment::STATUS_CONFIRMED]
        )->assertRedirect();

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'status' => Appointment::STATUS_CONFIRMED,
        ]);
    }

    public function test_admin_can_update_availability_and_settings(): void
    {
        $this->seed();

        $admin = User::query()->first();

        $this->actingAs($admin)->put(route('admin.availability.update'), [
            'days' => [
                '1' => ['active' => '1', 'opens_at' => '09:00', 'closes_at' => '17:00'],
                '2' => ['active' => '0', 'opens_at' => null, 'closes_at' => null],
            ],
        ])->assertRedirect();

        $this->assertDatabaseHas('availabilities', ['day_of_week' => 1, 'opens_at' => '09:00']);
        $this->assertDatabaseMissing('availabilities', ['day_of_week' => 2]);

        $this->actingAs($admin)->put(route('admin.settings.update'), [
            'site_name' => 'Mi Consultorio',
            'about' => 'Texto de prueba',
        ])->assertRedirect();

        $this->assertDatabaseHas('settings', ['key' => 'site_name', 'value' => 'Mi Consultorio']);
        $this->assertDatabaseHas('settings', ['key' => 'about', 'value' => 'Texto de prueba']);
    }
}
