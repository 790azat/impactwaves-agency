<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Company;
use App\Support\Settings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function edit(): View
    {
        return view('admin.company.edit', [
            'location' => Company::location(),
            'departments' => Company::departments(visibleOnly: false),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'location.city' => ['nullable', 'string', 'max:80'],
            'location.country' => ['nullable', 'string', 'max:80'],
            'location.address' => ['nullable', 'string', 'max:200'],
            'location.note' => ['nullable', 'string', 'max:200'],
            'team.*.size' => ['nullable', 'integer', 'min:0', 'max:10000'],
        ]);

        $team = [];
        foreach (array_keys(config('agency.departments')) as $key) {
            $size = $data['team'][$key]['size'] ?? null;
            $team[$key] = [
                'size' => $size === null ? null : (int) $size,
                'visible' => $request->boolean("team.$key.visible"),
            ];
        }

        Settings::set('company.location', json_encode(array_map(fn ($v) => $v ?: null, $data['location'] ?? [])));
        Settings::set('company.team', json_encode($team));

        return back()->with('status', 'Company details saved.');
    }
}
