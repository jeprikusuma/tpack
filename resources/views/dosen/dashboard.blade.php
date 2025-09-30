@extends('master.panel.layout')

@section('title')
    Dashboard Dosen
@endsection

@section('content')

<div class="mt-3 mb-4">
    <div class="col-12 col-md-7">
        <h4 class="text-primary">Selamat Datang, {{ auth()->user()->name }}!</h4>
        <p class="mb-0">Halaman dashboard Dosen</p>
    </div>
</div>

<div class="bg-white rounded-4 mt-3 p-4">
    <h5 class="card-title">Profile Information</h5>
    <p class="card-text mt-3">
        <strong>Name:</strong> {{ auth()->user()->name }}<br>
        <strong>Email:</strong> {{ auth()->user()->email }}<br>
        <strong>NIK:</strong> {{ auth()->user()->num }}
    </p>
</div>

@endsection