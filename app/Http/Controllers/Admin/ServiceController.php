<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\ServiceTexts;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        return view('admin.services.index', [
            'services' => config('agency.services'),
            'edited' => ServiceTexts::edits(),
        ]);
    }

    public function edit(string $slug): View
    {
        abort_unless($service = config("agency.services.$slug"), 404);

        return view('admin.services.form', [
            'slug' => $slug,
            'service' => $service,
            'edited' => isset(ServiceTexts::edits()[$slug]),
        ]);
    }

    public function update(Request $request, string $slug): RedirectResponse
    {
        abort_unless(config("agency.services.$slug"), 404);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'eyebrow' => ['nullable', 'string', 'max:60'],
            'short' => ['required', 'string', 'max:300'],
            'headline' => ['required', 'string', 'max:200'],
            'intro' => ['required', 'string', 'max:2000'],
            'platforms' => ['nullable', 'string', 'max:300'],
            'features' => ['array', 'max:12'],
            'features.*.title' => ['nullable', 'string', 'max:120'],
            'features.*.text' => ['nullable', 'string', 'max:500'],
        ]);

        $data['eyebrow'] = (string) ($data['eyebrow'] ?? '');
        $data['platforms'] = array_values(array_filter(array_map('trim', explode(',', $data['platforms'] ?? ''))));
        $data['features'] = collect($data['features'] ?? [])
            ->filter(fn ($f) => filled($f['title'] ?? null))
            ->map(fn ($f) => ['title' => trim($f['title']), 'text' => trim($f['text'] ?? '')])
            ->values()->all();

        ServiceTexts::save($slug, $data);

        return redirect()->route('admin.services.edit', $slug)->with('status', 'Service saved.');
    }

    public function destroy(string $slug): RedirectResponse
    {
        ServiceTexts::save($slug, null);

        return redirect()->route('admin.services.edit', $slug)->with('status', 'Original text restored.');
    }
}
