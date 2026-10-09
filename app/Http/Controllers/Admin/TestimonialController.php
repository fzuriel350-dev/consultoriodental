<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(): View
    {
        $testimonials = Testimonial::query()
            ->latest()
            ->paginate(15);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create(): View
    {
        return view('admin.testimonials.form', ['testimonial' => new Testimonial]);
    }

    public function store(Request $request): RedirectResponse
    {
        Testimonial::create($this->validated($request, includePublish: true));

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonio creado.');
    }

    public function edit(Testimonial $testimonial): View
    {
        return view('admin.testimonials.form', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $testimonial->update($this->validated($request, includePublish: true));

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonio actualizado.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonio eliminado.');
    }

    public function togglePublish(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->update(['is_published' => ! $testimonial->is_published]);

        return back()->with('success', 'Estado de publicación actualizado.');
    }

    private function validated(Request $request, bool $includePublish = false): array
    {
        $rules = [
            'author_name' => ['required', 'string', 'max:255'],
            'author_role' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
            'rating' => ['nullable', 'integer', 'between:1,5'],
        ];

        if ($includePublish) {
            $rules['is_published'] = ['sometimes', 'boolean'];
        }

        return $request->validate($rules, [
            'author_name.required' => 'El nombre del paciente es obligatorio.',
            'message.required' => 'El mensaje es obligatorio.',
        ]);
    }
}
