@extends('master.panel.layout')

@section('title')
   Pembahasan
@endsection

@section('content')
<div class="bg-white rounded-4 mt-3 p-4">
    <div class="d-flex flex-column flex-lg-row align-items-start justify-content-between">
        <div class="me-2">
            <h4 class="text-dark">{{ $subtopic->title }}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('mahasiswa.topic') }}">Topik</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('mahasiswa.subtopic', ['topic_id' => 
                    $topic->id]) }}">{{$topic->title}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$subtopic->title}}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="mt-3">
        @foreach ($contents as $dt)
            <div class="border rounded-4 mb-3 p-3 d-flex flex-row align-items-center gap-3">
                @if ($dt->progress_by_user)
                <i class="iconsax text-success fs-4" icon-name="tick-circle"></i>
                @else
                <i class="iconsax text-danger fs-4" icon-name="x-circle"></i>
                @endif
                <a href="{{ route('mahasiswa.content', ['topic_id' => $topic->id, 'subtopic_id' => $subtopic->id, 'content_id' => $dt->id]) }}" class="link-underline link-underline-opacity-0 col-8">
                    <h5 class="text-dark mb-0">{{ $dt->title }}</h5>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection