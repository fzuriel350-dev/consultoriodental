<?php

namespace Database\Seeders;

use App\Models\Availability;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Dra. Ana Martínez',
            'email' => 'admin@consultorio.test',
            'password' => bcrypt('dentista2026'),
        ]);

        $services = [
            ['name' => 'Consulta general', 'price' => 50, 'duration_minutes' => 30, 'sort_order' => 1,
                'description' => 'Revisión completa de tu salud dental y recomendaciones de cuidado.'],
            ['name' => 'Limpieza dental', 'price' => 70, 'duration_minutes' => 45, 'sort_order' => 2,
                'description' => 'Limpieza profesional que elimina placa y sarro.'],
            ['name' => 'Blanqueamiento', 'price' => 150, 'duration_minutes' => 60, 'sort_order' => 3,
                'description' => 'Tratamiento estético para una sonrisa más brillante.'],
            ['name' => 'Ortodoncia', 'price' => 250, 'duration_minutes' => 45, 'sort_order' => 4,
                'description' => 'Corrección de la posición de los dientes con alineadores transparentes.'],
            ['name' => 'Endodoncia', 'price' => 180, 'duration_minutes' => 60, 'sort_order' => 5,
                'description' => 'Tratamiento de conducto para salvar el diente afectado.'],
            ['name' => 'Extracción', 'price' => 60, 'duration_minutes' => 30, 'sort_order' => 6,
                'description' => 'Extracción segura de piezas dentales.'],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        $schedule = [
            [1, '09:00', '17:00'],
            [2, '09:00', '17:00'],
            [3, '09:00', '17:00'],
            [4, '09:00', '17:00'],
            [5, '09:00', '17:00'],
            [6, '09:00', '13:00'],
        ];

        foreach ($schedule as [$day, $opens, $closes]) {
            Availability::create([
                'day_of_week' => $day,
                'opens_at' => $opens,
                'closes_at' => $closes,
                'is_active' => true,
            ]);
        }

        $settings = [
            'site_name' => 'SonrisaSana Dental',
            'tagline' => 'Cuidado dental de confianza',
            'phone' => '+504 9999-0000',
            'email' => 'contacto@sonrisasana.test',
            'address' => 'Col. Palmira, Tegucigalpa',
            'working_hours' => 'Lun a Vie 9:00-17:00 · Sáb 9:00-13:00',
            'hero_title' => 'Una sonrisa',
            'hero_subtitle' => 'Atención dental profesional y personalizada. Agenda tu cita en minutos.',
            'about' => 'Soy una profesional de la salud dental comprometida con el cuidado integral de la sonrisa de cada paciente. Me especializo en diagnósticos claros, tratamientos sin dolor y acompañamiento en cada etapa del proceso.',
            'meta_description' => 'Consultorio dental con atención profesional. Agenda tu cita en línea: consulta, limpieza, ortodoncia, blanqueamiento y más.',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }

        Testimonial::create([
            'author_name' => 'María López',
            'author_role' => 'Paciente',
            'message' => 'Excelente atención, me explicaron todo el tratamiento y me sentí en confianza desde el primer día.',
            'rating' => 5,
            'is_published' => true,
        ]);

        Testimonial::create([
            'author_name' => 'Carlos Rivera',
            'author_role' => 'Paciente',
            'message' => 'Agendar fue muy fácil y me confirmaron al día siguiente. La limpieza impecable.',
            'rating' => 5,
            'is_published' => true,
        ]);
    }
}
