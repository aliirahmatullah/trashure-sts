@extends('templates.nav')
@section('navbar')
<div class="container">
    <h5 class="mt-3">Selamat Datang di Dashboard Staff</h5>
    @if (Session::get('success'))
        <div class="w-full bg-green-100 text-green-700 px-4 py-3 rounded relative font-sans">{{Session::get('success')}} <b>Selamat Datang, {{Auth::user()->nama}}</b></div>
    @endif
</div>

@endsection