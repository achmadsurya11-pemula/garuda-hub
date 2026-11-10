@extends('layouts.app')

@section('title', 'Proyek')

@section('content')
<div class="card">
    <h1>Daftar Proyek</h1>
    <form class="search" method="get" action="{{ route('home') }}">
        <input name="q" maxlength="100" placeholder="Cari judul atau kategori..." value="{{ $q }}">
        <button type="submit">Cari</button>
    </form>
    @if($q !== '')
        <p class="muted">Hasil pencarian untuk: <b>{{ $q }}</b> ({{ $projects->count() }} proyek)</p>
    @endif
</div>

@if($projects->isEmpty())
    <div class="card"><p>Belum ada proyek yang cocok.</p></div>
@else
    @foreach($projects as $p)
        <div class="card">
            <h2>
                <a href="{{ route('projects.show', $p->id) }}">{{ $p->judul }}</a>
                <span class="badge {{ $p->status === 'terbuka' ? 'open' : 'closed' }}">{{ $p->status }}</span>
            </h2>
            <p class="muted">
                Kategori: {{ $p->kategori }} | Klien: {{ $p->client->nama }} |
                Budget: Rp {{ number_format($p->budget_min, 0, ',', '.') }} - Rp {{ number_format($p->budget_max, 0, ',', '.') }} |
                Batas: {{ $p->batas_lelang->format('Y-m-d') }} | {{ $p->bids_count }} penawaran
            </p>
            <p>{{ Str::limit($p->deskripsi, 160) }}</p>
        </div>
    @endforeach
@endif
@endsection
