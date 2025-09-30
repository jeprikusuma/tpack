@extends('master.panel.layout')

@section('title')
   Refleksi Mahasiswa
@endsection

@section('content')
<div class="bg-white rounded-4 shadow-sm mt-3 p-4">

    <div class="d-flex flex-column flex-lg-row align-items-start justify-content-between mb-3">
        <div class="me-2">
            <h4 class="text-dark mb-2">Refleksi Mahasiswa</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dosen.topic') }}">Topik</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dosen.subtopic', ['topic_id' => $topic->id]) }}">{{$topic->title}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Refleksi</li>
                </ol>
            </nav>
        </div>
    </div>

    @forelse($reflections as $reflection)
        <div class="mb-4 p-3 rounded-4 shadow-sm bg-white hover-shadow-sm">
            <div class="d-flex align-items-center mb-2">
                <div class="me-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($reflection->user->name) }}&background=8AADCA&color=fff" 
                         alt="avatar" class="rounded-circle border shadow-sm" width="40" height="40">
                </div>
                <div class="flex-grow-1">
                    <p class="fw-semibold text-dark mb-0">{{ $reflection->user->name }}</p>
                    <small class="text-muted">{{ $reflection->created_at->diffForHumans() }}</small>
                </div>
                <div>
                    {{-- Tombol Show/Hide Refleksi --}}
                    <button class="btn btn-sm text-primary" type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#reflection-{{ $reflection->id }}" 
                            aria-expanded="false" 
                            aria-controls="reflection-{{ $reflection->id }}">
                        Tampilkan Refleksi <i class="iconsax ms-2" icon-name="arrow-right"></i>
                    </button>
                </div>
            </div>

            {{-- Bagian Refleksi Collapse --}}
            <div class="collapse mt-3" id="reflection-{{ $reflection->id }}">
                @foreach($questions as $index => $question)
                    <div class="mb-3">
                        <p class="fw-semibold mb-1">{{ $question }}</p>
                        <p class="mb-0">{{ $reflection->{'answer'.($index+1)} }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <p class="text-muted fst-italic">Belum ada refleksi mahasiswa untuk topik ini.</p>
    @endforelse

</div>
@endsection
