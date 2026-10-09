<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Setting;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $settings = Setting::query()->pluck('value', 'key');

        return view('landing.index', compact('services', 'settings'));
    }
}
