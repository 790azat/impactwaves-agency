<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vacancy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class VacancyController extends Controller
{
    public function index(): View
    {
        return view('admin.vacancies.index', ['vacancies' => Vacancy::latest()->get()]);
    }

    public function create(): View
    {
        return view('admin.vacancies.form', ['vacancy' => new Vacancy([
            'department' => array_key_first(config('agency.departments')),
            'employment_type' => 'Full-time',
            'location' => 'Remote',
            'published' => true,
        ])]);
    }

    public function edit(Vacancy $vacancy): View
    {
        return view('admin.vacancies.form', ['vacancy' => $vacancy]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge(['slug' => Str::slug($request->input('slug') ?: $request->input('title'))]);
        $vacancy = Vacancy::create($this->validated($request));

        return redirect()->route('admin.vacancies.edit', $vacancy)->with('status', 'Vacancy created.');
    }

    public function update(Request $request, Vacancy $vacancy): RedirectResponse
    {
        $request->merge(['slug' => Str::slug($request->input('slug') ?: $request->input('title'))]);
        $vacancy->update($this->validated($request, $vacancy));

        return redirect()->route('admin.vacancies.edit', $vacancy)->with('status', 'Vacancy saved.');
    }

    public function destroy(Vacancy $vacancy): RedirectResponse
    {
        $vacancy->delete();

        return redirect()->route('admin.vacancies.index')->with('status', 'Vacancy deleted.');
    }

    protected function validated(Request $request, ?Vacancy $vacancy = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['required', 'string', 'max:120', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('vacancies')->ignore($vacancy)],
            'department' => ['required', Rule::in(array_keys(config('agency.departments')))],
            'location' => ['nullable', 'string', 'max:120'],
            'employment_type' => ['required', Rule::in(config('agency.employment_types'))],
            'salary' => ['nullable', 'string', 'max:120'],
            'apply_url' => ['nullable', 'url:https', 'max:300'],
            'summary' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
        ], ['slug.unique' => 'A vacancy with this URL already exists.']);

        return $data + ['published' => $request->boolean('published')];
    }
}
