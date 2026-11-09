<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'klien') {
            $projects = Project::where('client_id', $user->id)
                ->withCount('bids')
                ->orderByDesc('id')
                ->get();

            return view('dashboard.index', compact('user', 'projects'));
        }

        $bids = Bid::with(['project.client'])
            ->where('developer_id', $user->id)
            ->orderByDesc('id')
            ->get();

        return view('dashboard.index', compact('user', 'bids'));
    }
}
