<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public const FIELDS = [
        'site_name' => ['label' => 'Nombre del consultorio', 'type' => 'text', 'rows' => null],
        'tagline' => ['label' => 'Eslogan', 'type' => 'text', 'rows' => null],
        'phone' => ['label' => 'Teléfono / WhatsApp', 'type' => 'text', 'rows' => null],
        'email' => ['label' => 'Correo de contacto', 'type' => 'email', 'rows' => null],
        'address' => ['label' => 'Dirección', 'type' => 'text', 'rows' => null],
        'working_hours' => ['label' => 'Horario de atención (texto)', 'type' => 'text', 'rows' => null],
        'instagram' => ['label' => 'Instagram (usuario)', 'type' => 'text', 'rows' => null],
        'facebook' => ['label' => 'Facebook (perfil)', 'type' => 'text', 'rows' => null],
        'hero_title' => ['label' => 'Título principal (portada)', 'type' => 'text', 'rows' => null],
        'hero_subtitle' => ['label' => 'Subtítulo (portada)', 'type' => 'textarea', 'rows' => 2],
        'about' => ['label' => 'Texto "Acerca de mí"', 'type' => 'textarea', 'rows' => 5],
        'meta_description' => ['label' => 'Descripción SEO', 'type' => 'textarea', 'rows' => 2],
    ];

    public function index(): View
    {
        $values = Setting::query()->pluck('value', 'key');

        return view('admin.settings.index', [
            'fields' => self::FIELDS,
            'values' => $values,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $rules = [];

        foreach (self::FIELDS as $key => $config) {
            $rules[$key] = ['nullable', 'string', 'max:2000'];
        }

        $data = $request->validate($rules);

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'Configuración guardada.');
    }
}
