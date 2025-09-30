@extends('master.panel.layout')

@section('title')
    Tugas Akhir
@endsection

@section('content')
<div class="bg-white rounded-4 mt-3 p-4">
    <div class="d-flex flex-column flex-lg-row align-items-start justify-content-between">
        <div class="me-2">
            <h4 class="text-dark">Tugas Akhir</h4>
        </div>
    </div>
    <div class="mt-3 d-flex justify-content-center align-items-center flex-column">
        <img src="{{ asset('assets/svg/error.svg') }}" height="200" width="200" />
        <p>Fitur dalam pengerjaan...</p>
    </div>
</div>
@endsection