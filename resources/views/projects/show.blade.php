@extends('layouts.app')

@section('title', $project->judul)

@section('content')
<div class="card">
    <h1>
        {{ $project->judul }}
        <span class="badge {{ $project->status === 'terbuka' ? 'open' : 'closed' }}">{{ $project->status }}</span>
    </h1>
    <p class="muted">
        Kategori: {{ $project->kategori }} | Klien: {{ $project->client->nama }} |
        Budget: Rp {{ number_format($project->budget_min, 0, ',', '.') }} - Rp {{ number_format($project->budget_max, 0, ',', '.') }} |
        Batas lelang: {{ $project->batas_lelang->format('Y-m-d') }}
    </p>
    <p>{!! nl2br(e($project->deskripsi)) !!}</p>
</div>

<div class="card">
    <h2>Penawaran ({{ $project->bids->count() }})</h2>
    @if($project->bids->isEmpty())
        <p>Belum ada penawaran.</p>
    @else
        <table>
            <tr>
                <th>Developer</th>
                <th>Harga</th>
                <th>Durasi</th>
                <th>Proposal</th>
                <th></th>
            </tr>
            @foreach($project->bids as $b)
                <tr class="{{ $b->is_winner ? 'winner' : '' }}">
                    <td>
                        {{ $b->developer->nama }}
                        @if($b->is_winner)
                            <span class="badge win">Pemenang</span>
                        @endif
                    </td>
                    <td>Rp {{ number_format($b->harga, 0, ',', '.') }}</td>
                    <td>{{ $b->durasi }} hari</td>
                    <td>{!! nl2br(e($b->proposal)) !!}</td>
                    <td>
                        @if(Auth::check() && Auth::user()->role === 'klien' && Auth::id() === $project->client_id && $project->status === 'terbuka')
                            <form method="post" action="{{ route('bids.pick') }}" onsubmit="return confirm('Pilih penawaran ini sebagai pemenang?')">
                                @csrf
                                <input type="hidden" name="project_id" value="{{ $project->id }}">
                                <input type="hidden" name="bid_id" value="{{ $b->id }}">
                                <button class="sm" type="submit">Pilih pemenang</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
</div>

@if(Auth::check() && Auth::user()->role === 'developer')
    @if($project->isOpen())
        <div class="card">
            <h2>Ajukan Penawaran</h2>
            <form method="post" action="{{ route('bids.store') }}">
                @csrf
                <input type="hidden" name="project_id" value="{{ $project->id }}">
                <div class="row">
                    <div>
                        <label>Harga (Rp)</label>
                        <input type="number" name="harga" min="1" required>
                    </div>
                    <div>
                        <label>Durasi (hari)</label>
                        <input type="number" name="durasi" min="1" required>
                    </div>
                </div>
                <label>Proposal</label>
                <textarea name="proposal" required></textarea>
                <p><button type="submit">Kirim penawaran</button></p>
            </form>
        </div>
    @else
        <div class="card"><p class="muted">Lelang sudah ditutup; penawaran tidak dapat diajukan.</p></div>
    @endif
@elseif(!Auth::check() && $project->isOpen())
    <div class="card"><p><a href="{{ route('login') }}">Masuk</a> sebagai developer untuk mengajukan penawaran.</p></div>
@endif
@endsection
