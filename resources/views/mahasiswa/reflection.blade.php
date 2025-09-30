@extends('master.panel.layout')

@section('title')
    Refleksi
@endsection

@section('content')
<div class="bg-white rounded-4 mt-3 p-4">
    <div class="d-flex flex-column flex-lg-row align-items-start justify-content-between">
        <div class="me-2">
            <h4 class="text-dark">Refleksi</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('mahasiswa.topic') }}">Topik</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('mahasiswa.subtopic', ['topic_id' => 
                    $topic->id]) }}">{{$topic->title}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Refleksi</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="mt-3">
        <form action="{{ route('mahasiswa.reflection.store', ['topic_id' => $topic->id]) }}" method="POST">
            @csrf
            @foreach($questions as $index => $question)
                <div class="mb-3">
                    <label class="form-label">{{ $question }}</label>
                    <textarea name="answer{{ $index+1 }}" class="form-control" rows="2">{{ old('answer'.($index+1), $reflection->{'answer'.($index+1)} ?? '') }}</textarea>
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary">Simpan Refleksi</button>
        </form>
    </div>
</div>
@endsection