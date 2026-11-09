<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $q = mb_substr($q, 0, 100);

        $query = Project::with('client')->withCount('bids')->orderByDesc('id');

        if ($q !== '') {
            $escaped = addcslashes($q, '\\%_');
            $query->where(function ($sub) use ($escaped) {
                $sub->where('judul', 'like', "%{$escaped}%")
                    ->orWhere('kategori', 'like', "%{$escaped}%");
            });
        }

        $projects = $query->get();

        return view('projects.index', compact('projects', 'q'));
    }

    public function show($id)
    {
        $project = Project::with(['client', 'bids' => function ($query) {
            $query->with('developer')
                ->orderByDesc('is_winner')
                ->orderBy('harga')
                ->orderBy('id');
        }])->findOrFail($id);

        return view('projects.show', compact('project'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:200',
            'deskripsi' => 'required|string|max:5000',
            'kategori' => 'required|string|max:50',
            'budget_min' => 'required|integer|min:0|max:999999999999',
            'budget_max' => 'required|integer|min:0|max:999999999999|gte:budget_min',
            'batas_lelang' => 'required|date|after_or_equal:today',
        ], [
            'budget_max.gte' => 'Budget tidak valid (maks harus >= min).',
            'batas_lelang.after_or_equal' => 'Batas lelang harus tanggal yang valid dan belum lewat.',
        ]);

        Project::create([
            'client_id' => Auth::id(),
            'judul' => trim($request->judul),
            'deskripsi' => trim($request->deskripsi),
            'kategori' => trim($request->kategori),
            'budget_min' => $request->budget_min,
            'budget_max' => $request->budget_max,
            'batas_lelang' => $request->batas_lelang,
            'status' => 'terbuka',
        ]);
        return redirect()->route('dashboard')->with('ok', 'Proyek berhasil dipasang.');
    }
}
