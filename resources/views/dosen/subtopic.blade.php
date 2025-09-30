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
                    <li class="breadcrumb-item"><a href="{{ route('dosen.topic') }}">Topik</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$topic->title}}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="mt-3 row">
        <div class="col-6">
            <div class="border rounded-4 mb-3 p-4 link-underline link-underline-opacity-0">
                <h5 class="text-dark">Diskusi</h5>
                <p class="mb-3 text-dark">{{ $topic->discussions->count() > 0 ? $topic->discussions->count().' diskusi tersedia' : 'Belum terdapat diskusi' }}</p>
                <a href="{{ route('dosen.discussion', ['topic_id' => $topic->id]) }}" class="link-underline link-underline-opacity-0 text-primary fs-7">
                    Lihat Diskusi<i class="iconsax ms-2" icon-name="arrow-right"></i>
                </a>
            </div>
        </div>
        <div class="col-6"> 
            <div class="border rounded-4 mb-3 p-4 link-underline link-underline-opacity-0">
                <h5 class="text-dark">Refleksi</h5>
                <p class="mb-3 text-dark">Belum terdapat refleksi</p>
                <a href="{{ route('dosen.reflection', ['topic_id' => $topic->id]) }}" class="link-underline link-underline-opacity-0 text-primary fs-7">
                    Lihat Refleksi<i class="iconsax ms-2" icon-name="arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="bg-white rounded-4 mt-3 p-4">
    <div class="d-flex flex-column flex-lg-row align-items-start justify-content-between">
        <div class="me-2">
            <h4 class="text-dark">Sub-Topik</h4>
            </nav>
        </div>
        <a href="{{ route('dosen.subtopic.form', ['topic_id' => $topic->id]) }}" class="btn btn-primary px-3 rounded-pill">Tambah Sub-Topik</a>
    </div>
    <div class="mt-3">
        @foreach ($subtopics as $dt)
            <div class="border rounded-4 mb-3 p-4 d-flex flex-column flex-lg-row align-items-start justify-content-between">
                <a href="{{ route('dosen.content', ['topic_id' => $topic->id, 'subtopic_id' => $dt->id]) }}" class="link-underline link-underline-opacity-0">
                    <h5 class="text-dark">{{ $dt->title }}</h5>
                    <p class="mb-0 text-dark">{{ $dt->contents_count == 0 ? 'Pembahasan belum tersedia' : $dt->contents_count.' pembahasan tersedia' }}</p>
                </a>
                <div class="d-flex gap-3">
                    <div class="btn-group">
                         <i class="iconsax me-2" icon-name="menu-meatballs" type="button" data-bs-toggle="dropdown" aria-expanded="false"></i>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('dosen.subtopic.form', ['topic_id' => $topic->id, 'id' => $dt->id]) }}">Edit</a></li>
                            <li>
                                <p type="button" class="dropdown-item text-danger mb-0" onclick="deleteAction({
                                    url: '{{ route('dosen.subtopic.delete', ['topic_id' => $topic->id, 'id' => $dt->id]) }}',
                                    text: 'Apakah Anda yakin ingin menghapus sub-topik ini?',
                                })">Hapus</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection