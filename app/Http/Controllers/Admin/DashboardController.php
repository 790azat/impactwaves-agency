<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\User;
use App\Support\Articles;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                ['label' => 'New leads', 'value' => Lead::where('status', 'new')->count(), 'href' => route('admin.leads.index', ['status' => 'new'])],
                ['label' => 'Leads this month', 'value' => Lead::where('created_at', '>=', now()->startOfMonth())->count(), 'href' => route('admin.leads.index')],
                ['label' => 'Users', 'value' => User::count(), 'href' => route('admin.users.index')],
                ['label' => 'Published articles', 'value' => Articles::all()->count(), 'href' => route('admin.articles.index')],
            ],
            'leads' => Lead::latest()->take(6)->get(),
            'users' => User::latest()->take(5)->get(),
        ]);
    }
}
