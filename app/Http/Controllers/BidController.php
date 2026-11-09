<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BidController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|integer|exists:projects,id',
            'harga' => 'required|integer|min:1|max:999999999999',
            'durasi' => 'required|integer|min:1|max:3650',
            'proposal' => 'required|string|max:5000',
        ]);

        $project = Project::findOrFail($request->project_id);

        if (!$project->isOpen()) {
            return redirect()->route('projects.show', $project->id)
                ->with('err', 'Lelang sudah ditutup; penawaran tidak dapat diajukan.');
        }

        $exists = Bid::where('project_id', $project->id)
            ->where('developer_id', Auth::id())
            ->exists();

        if ($exists) {
            return redirect()->route('projects.show', $project->id)
                ->with('err', 'Anda sudah mengajukan penawaran pada proyek ini.');
        }

        Bid::create([
            'project_id' => $project->id,
            'developer_id' => Auth::id(),
            'harga' => $request->harga,
            'durasi' => $request->durasi,
            'proposal' => trim($request->proposal),
            'is_winner' => false,
        ]);

        return redirect()->route('projects.show', $project->id)
            ->with('ok', 'Penawaran berhasil dikirim.');
    }

    public function pickWinner(Request $request)
    {
        $request->validate([
            'project_id' => 'required|integer',
            'bid_id' => 'required|integer',
        ]);

        $error = DB::transaction(function () use ($request) {
            $project = Project::where('id', $request->project_id)
                ->where('client_id', Auth::id())
                ->lockForUpdate()
                ->first();

            if (!$project) {
                return 'Proyek tidak ditemukan atau bukan milik Anda.';
            }

            if ($project->status !== 'terbuka') {
                return 'Pemenang sudah dipilih atau lelang sudah ditutup.';
            }

            $bid = Bid::where('id', $request->bid_id)
                ->where('project_id', $project->id)
                ->first();

            if (!$bid) {
                return 'Penawaran tidak valid untuk proyek ini.';
            }

            $bid->update(['is_winner' => true]);
            $project->update(['status' => 'ditutup']);

            return '';
        });

        if ($error !== '') {
            return redirect()->route('projects.show', $request->project_id)->with('err', $error);
        }

        return redirect()->route('projects.show', $request->project_id)
            ->with('ok', 'Pemenang berhasil dipilih.');
    }
}
