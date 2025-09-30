@extends('master.panel.layout')

@section('title')
    Sub-Topik
@endsection

@section('content')
<div class="bg-white rounded-4 mt-3 p-4">
    <div class="d-flex flex-column flex-lg-row align-items-start justify-content-between">
        <div class="me-2">
            <h4 class="text-dark">{{ $topic->title }}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('mahasiswa.topic') }}">Topik</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$topic->title}}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="mt-3">
        @foreach ($subtopics as $dt)
            <div class="border rounded-4 mb-3 p-4 d-flex flex-column flex-lg-row align-items-md-center justify-content-between gap-3">
                <a href="{{ route('mahasiswa.contents', ['topic_id' => $topic->id, 'subtopic_id' => $dt->id]) }}" class="link-underline link-underline-opacity-0 col-md-8">
                    <h5 class="text-dark">{{ $dt->title }}</h5>
                    @if($dt->read_contents == $dt->contents_count)
                    <p class="mb-0 text-success">Anda sudah menyelesaikan sub-topik ini</p>
                    @else
                    <p class="mb-0 text-danger">Anda belum menyelesaikan sub-topik ini ({{ $dt->read_contents."/".$dt->contents_count }})</p>
                    @endif
                </a>
                <div class="d-flex gap-3">
                    <a href="{{ route('mahasiswa.contents', ['topic_id' => $topic->id, 'subtopic_id' => $dt->id]) }}"  class="link-underline link-underline-opacity-0 text-primary">Lanjut belajar <i class="iconsax ms-2" icon-name="arrow-right"></i></a>
                </div>
            </div>
        @endforeach
        <div class="border rounded-4 mb-3 p-4 d-flex flex-column flex-lg-row align-items-md-center justify-content-between">
            <a href="{{ route('mahasiswa.discussion', ['topic_id' => $topic->id]) }}" class="link-underline link-underline-opacity-0 col-md-8">
                <h5 class="text-dark">Diskusi</h5>
            </a>
            <div class="d-flex gap-3">
                <a href="#"  class="link-underline link-underline-opacity-0 text-primary">Diskusi sekarang <i class="iconsax ms-2" icon-name="arrow-right"></i></a>
            </div>
        </div>
        <div class="border rounded-4 mb-3 p-4 d-flex flex-column flex-lg-row align-items-md-center justify-content-between">
            <a href="{{ route('mahasiswa.reflection', ['topic_id' => $topic->id]) }}" class="link-underline link-underline-opacity-0 col-md-8">
                <h5 class="text-dark">Refleksi</h5>
            </a>
            <div class="d-flex gap-3">
                <a href="#"  class="link-underline link-underline-opacity-0 text-primary">Tambahkan refleksi <i class="iconsax ms-2" icon-name="arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>
@endsection