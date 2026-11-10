@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
<div class="card">
    <h1>Masuk</h1>
    <form method="post" action="{{ route('login.post') }}">
        @csrf
        <label>Email</label>
        <input name="email" type="email" maxlength="100" required value="{{ old('email') }}">

        <label>Password</label>
        <input name="password" type="password" required autocomplete="current-password">

        <p><button type="submit">Masuk</button></p>
    </form>
</div>
@endsection
