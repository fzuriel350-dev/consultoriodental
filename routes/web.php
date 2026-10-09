<?php

use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AvailabilityController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('home');

Route::post('/citas/solicitar', [AppointmentController::class, 'store'])->name('appointments.request');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);
    });

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('appointments', AdminAppointmentController::class)->only(['index', 'show', 'update']);
        Route::resource('patients', PatientController::class)->only(['index', 'show']);
        Route::resource('services', ServiceController::class);
        Route::resource('testimonials', TestimonialController::class);

        Route::patch('testimonials/{testimonial}/toggle', [TestimonialController::class, 'togglePublish'])
            ->name('testimonials.toggle');

        Route::get('availability', [AvailabilityController::class, 'index'])->name('availability.index');
        Route::put('availability', [AvailabilityController::class, 'update'])->name('availability.update');

        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    });
});
