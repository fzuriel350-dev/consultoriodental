<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'service_id' => ['nullable', 'exists:services,id'],
            'requested_date' => ['required', 'date', 'after:today'],
            'requested_time' => ['required', 'date_format:H:i'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Por favor ingresa tu nombre.',
            'phone.required' => 'Por favor ingresa tu teléfono.',
            'requested_date.required' => 'Selecciona un día para tu cita.',
            'requested_date.after' => 'La fecha debe ser posterior a hoy.',
            'requested_time.required' => 'Selecciona una hora para tu cita.',
            'requested_time.date_format' => 'La hora seleccionada no es válida.',
        ];
    }
}
