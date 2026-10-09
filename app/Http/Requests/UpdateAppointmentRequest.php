<?php

namespace App\Http\Requests;

use App\Models\Appointment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'string', Rule::in(Appointment::STATUSES)],
            'starts_at' => ['nullable', 'date'],
            'admin_notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
