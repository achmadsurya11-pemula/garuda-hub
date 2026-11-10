@extends('layouts.app')

@section('title', 'Dasbor')

@section('content')
@if($user->role === 'klien')
    <div class="card">
        <h1>Proyek Saya</h1>
        <p><a href="{{ route('projects.create') }}">Pasang proyek baru</a></p>
    </div>
    @if($projects->isEmpty())
        <div class="card"><p>Anda belum memasang proyek.</p></div>
    @else
        @foreach($projects as $p)
            <div class="card">
                <h2>
                    <a href="{{ route('projects.show', $p->id) }}">{{ $p->judul }}</a>
                    <span class="badge {{ $p->status === 'terbuka' ? 'open' : 'closed' }}">{{ $p->status }}</span>
                </h2>
                <p class="muted">
                    Budget: Rp {{ number_format($p->budget_min, 0, ',', '.') }} - Rp {{ number_format($p->budget_max, 0, ',', '.') }} |
                    Batas: {{ $p->batas_lelang->format('Y-m-d') }} | {{ $p->bids_count }} penawaran
                </p>
            </div>
        @endforeach
    @endif
@else
    <div class="card"><h1>Penawaran Saya</h1></div>
    @if($bids->isEmpty())
        <div class="card"><p>Anda belum mengajukan penawaran.</p></div>
    @else
        @foreach($bids as $b)
            <div class="card">
                <h2>
                    <a href="{{ route('projects.show', $b->project_id) }}">{{ $b->project->judul }}</a>
                    <span class="badge {{ $b->project->status === 'terbuka' ? 'open' : 'closed' }}">{{ $b->project->status }}</span>
                    @if($b->is_winner)
                        <span class="badge open">Pemenang</span>
                    @endif
                </h2>
                <p class="muted">
                    Klien: {{ $b->project->client->nama }} |
                    Harga: Rp {{ number_format($b->harga, 0, ',', '.') }} |
                    Durasi: {{ $b->durasi }} hari |
                    Batas: {{ $b->project->batas_lelang->format('Y-m-d') }}
                </p>
            </div>
        @endforeach
    @endif
@endif
@endsection
