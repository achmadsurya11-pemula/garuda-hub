@extends('layouts.app')

@section('title', 'Daftar')

@section('content')
<div class="card">
    <h1>Daftar</h1>
    <form method="post" action="{{ route('register.post') }}">
        @csrf
        <label>Nama</label>
        <input name="nama" maxlength="100" required value="{{ old('nama') }}">

        <label>Email</label>
        <input name="email" type="email" maxlength="100" required value="{{ old('email') }}">

        <label>Password (min. 6 karakter)</label>
        <input name="password" type="password" minlength="6" maxlength="72" required autocomplete="new-password">

        <label>Peran</label>
        <select name="role">
            <option value="klien" {{ old('role') === 'klien' ? 'selected' : '' }}>Klien</option>
            <option value="developer" {{ old('role') === 'developer' ? 'selected' : '' }}>Developer</option>
        </select>

        <p><button type="submit">Daftar</button></p>
    </form>
</div>
@endsection
