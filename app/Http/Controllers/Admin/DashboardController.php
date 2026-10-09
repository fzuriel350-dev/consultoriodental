<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $todayAppointments = Appointment::onDate(now()->toDateString())
            ->orderBy('starts_at')
            ->get();

        $stats = [
            'pending' => Appointment::pending()->count(),
            'upcoming' => Appointment::upcoming()->count(),
            'today' => $todayAppointments->count(),
            'patients' => Patient::count(),
        ];

        return view('admin.dashboard.index', compact('todayAppointments', 'stats'));
    }
}
