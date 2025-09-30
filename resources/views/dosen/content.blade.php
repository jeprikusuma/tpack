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
                    <li class="breadcrumb-item"><a href="{{ route('dosen.topic') }}">Topik</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dosen.subtopic', ['topic_id' => $topic->id]) }}">{{$topic->title}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$subtopic->title}}</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('dosen.content.form', ['topic_id' => $topic->id, 'subtopic_id' => $subtopic->id]) }}" class="btn btn-primary px-3 rounded-pill">Tambah Pembahasan</a>
    </div>
    <div class="mt-3">
        @foreach ($contents as $dt)
            <div class="border rounded-4 mb-3 p-4 d-flex flex-column flex-lg-row align-items-start justify-content-between">
                <a href="{{ route('dosen.content.form', ['topic_id' => $topic->id, 'subtopic_id' => $subtopic->id, 'id' => $dt->id]) }}" class="link-underline link-underline-opacity-0">
                    <p class="text-dark fw-bold mb-0">{{ $dt->title }}</p>
                </a>
                <div class="d-flex gap-3">
                    <div class="btn-group">
                         <i class="iconsax me-2" icon-name="menu-meatballs" type="button" data-bs-toggle="dropdown" aria-expanded="false"></i>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('dosen.content.form', ['topic_id' => $topic->id, 'subtopic_id' => $subtopic->id, 'id' => $dt->id]) }}">Edit</a></li>
                            <li>
                                <p type="button" class="dropdown-item text-danger mb-0" onclick="deleteAction({
                                    url: '{{ route('dosen.content.delete', ['topic_id' => $topic->id, 'subtopic_id' => $subtopic->id, 'id' => $dt->id]) }}',
                                    text: 'Apakah Anda yakin ingin menghapus pembahasan ini?',
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