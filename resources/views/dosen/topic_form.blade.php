@extends('master.panel.layout')

@section('title')
   Form Topik
@endsection

@section('content')
<div class="bg-white rounded-4 mt-3 p-4">
    <div class="d-flex flex-column flex-lg-row align-items-start justify-content-between">
        <div class="me-2">
            <h4 class="text-dark">Form Topik</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dosen.topic') }}">Topik</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$topic != null ? 'Edit' : 'Tambah'}} Data</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="mt-3">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form class="row" method="POST">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Judul</label>
                <input type="title" class="form-control @error('title') is-invalid @enderror" 
                    id="title" name="title" placeholder="Masukkan judul..." value="{{ old('title', $topic?->title) }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="start_date" class="form-label">Tanggal Mulai</label>
                <input type="datetime-local" name="start_date" id="start_date"
                    value="{{ old('start_date', $topic?->start_date?->format('Y-m-d\TH:i')) }}"
                    class="form-control">
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">Tanggal Selesai</label>
                <input type="datetime-local" name="end_date" id="end_date"
                    value="{{ old('end_date', $topic?->end_date?->format('Y-m-d\TH:i')) }}"
                    class="form-control">
            </div>
            <div class="mt-2">
                <button type="submit" class="btn btn-primary rounded-pill py-2 col-12">Simpan</button>
            </div>
        </form>
    </div>
</div>
</div>
@endsection