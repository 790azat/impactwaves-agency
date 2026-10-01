<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $search = trim((string) $request->query('q'));

        $leads = Lead::query()
            ->when(isset(Lead::STATUSES[$status]), fn ($q) => $q->where('status', $status))
            ->when($search !== '', fn ($q) => $q->where(fn ($q) => $q
                ->whereLike('name', "%$search%")
                ->orWhereLike('email', "%$search%")
                ->orWhereLike('company', "%$search%")))
            ->latest()
            ->paginate(25)
            ->withQueryString();

        return view('admin.leads.index', [
            'leads' => $leads,
            'status' => $status,
            'search' => $search,
            'counts' => Lead::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status'),
        ]);
    }

    public function show(Lead $lead): View
    {
        return view('admin.leads.show', ['lead' => $lead->load('user')]);
    }

    public function update(Request $request, Lead $lead): RedirectResponse
    {
        $lead->update($request->validate([
            'status' => ['required', Rule::in(array_keys(Lead::STATUSES))],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]));

        return back()->with('status', 'Lead updated.');
    }

    public function destroy(Lead $lead): RedirectResponse
    {
        $lead->delete();

        return redirect()->route('admin.leads.index')->with('status', 'Lead deleted.');
    }
}
