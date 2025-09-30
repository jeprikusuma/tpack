@extends('master.panel.layout')

@section('title')
    Dashboard Mahasiswa
@endsection

@section('content')
<div class="container py-5">
    <div class="bg-white rounded-4 mt-3 p-4">
        <h2 class="mb-4">Welcome, {{ auth()->user()->name }}!</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="bg-white card mb-3 rounded-4">
                    <div class="card-body">
                        <h5 class="card-title">Profile Information</h5>
                        <p class="card-text">
                            <strong>Name:</strong> {{ auth()->user()->name }}<br>
                            <strong>Email:</strong> {{ auth()->user()->email }}<br>
                            <strong>NIM:</strong> {{ auth()->user()->num }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection