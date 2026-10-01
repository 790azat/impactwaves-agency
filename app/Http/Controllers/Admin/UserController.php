<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));

        return view('admin.users.index', [
            'search' => $search,
            'users' => User::query()
                ->withCount('leads')
                ->when($search !== '', fn ($q) => $q->where(fn ($q) => $q
                    ->whereLike('name', "%$search%")
                    ->orWhereLike('email', "%$search%")
                    ->orWhereLike('company', "%$search%")))
                ->latest()
                ->paginate(25)
                ->withQueryString(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate(['is_admin' => ['required', 'boolean']]);

        if ($user->is($request->user())) {
            return back()->with('error', 'You cannot change your own admin rights.');
        }

        $user->forceFill(['is_admin' => $request->boolean('is_admin')])->save();

        return back()->with('status', $user->is_admin ? "$user->name is now an admin." : "$user->name is no longer an admin.");
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->is($request->user())) {
            return back()->with('error', 'You cannot delete your own account here.');
        }

        $user->delete();

        return back()->with('status', 'User deleted.');
    }
}
