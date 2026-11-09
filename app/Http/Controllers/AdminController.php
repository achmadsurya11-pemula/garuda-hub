<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id')->get();
        $projects = Project::with('client')->orderByDesc('id')->get();

        return view('admin.index', compact('users', 'projects'));
    }

    public function updateRole(Request $request, User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('err', 'Anda tidak dapat mengubah peran akun sendiri.');
        }

        $request->validate([
            'role' => 'required|in:klien,developer,admin',
        ]);

        $user->update(['role' => $request->role]);

        return back()->with('ok', 'Peran user diubah.');
    }

    public function destroyUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('err', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return back()->with('ok', 'User dihapus.');
    }

    public function destroyProject(Project $project)
    {
        $project->delete();

        return back()->with('ok', 'Proyek dihapus.');
    }
}
