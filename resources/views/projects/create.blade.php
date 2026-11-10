@extends('layouts.app')

@section('title', 'Pasang Proyek')

@section('content')
<div class="card">
    <h1>Pasang Proyek</h1>
    <form method="post" action="{{ route('projects.store') }}">
        @csrf
        <label>Judul</label>
        <input name="judul" maxlength="200" required value="{{ old('judul') }}">

        <label>Deskripsi</label>
        <textarea name="deskripsi" maxlength="5000" required>{{ old('deskripsi') }}</textarea>

        <label>Kategori</label>
        <input name="kategori" maxlength="50" placeholder="Web, Mobile, Desain, Data, AI..." required value="{{ old('kategori') }}">

        <div class="row">
            <div>
                <label>Budget minimum (Rp)</label>
                <input type="number" name="budget_min" min="0" required value="{{ old('budget_min') }}">
            </div>
            <div>
                <label>Budget maksimum (Rp)</label>
                <input type="number" name="budget_max" min="0" required value="{{ old('budget_max') }}">
            </div>
            <div>
                <label>Batas lelang</label>
                <input type="date" name="batas_lelang" required value="{{ old('batas_lelang') }}">
            </div>
        </div>
        <p><button type="submit">Pasang proyek</button></p>
    </form>
</div>
@endsection
