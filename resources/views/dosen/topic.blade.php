@extends('master.panel.layout')

@section('title')
    Topik
@endsection

@section('content')
<div class="bg-white rounded-4 mt-3 p-4">
    <div class="d-flex flex-column flex-lg-row align-items-start justify-content-between">
        <div class="me-2">
            <h4 class="text-dark">Topik</h4>
            <p>Sesuaikan topik pembelajaran</p>
        </div>
        <a href="{{ route('dosen.topic.form') }}" class="btn btn-primary px-3 rounded-pill">Tambah Topik</a>
    </div>
    <div class="mt-3">
        @foreach ($data as $dt)
            <div class="border rounded-4 mb-3 p-4 d-flex flex-column flex-lg-row align-items-start justify-content-between">
                <a href="{{ route('dosen.subtopic', ['topic_id' => $dt->id]) }}" class="link-underline link-underline-opacity-0">
                    <h5 class="text-dark">{{ $dt->title }}</h5>
                    <p class="mb-3 text-dark">{{ $dt->subtopics_count == 0 ? 'Sub-topik belum tersedia' : $dt->subtopics_count.' sub-topik tersedia' }}</p>
                    <p class="mb-0 text-dark fs-7">Dibuka pada: {{ \Carbon\Carbon::parse($dt->start_date)->format('d M Y H:i') }} - {{ \Carbon\Carbon::parse($dt->end_date)->format('d M Y H:i') }}</p>
                </a>
                <div class="d-flex gap-3">
                    <div class="btn-group">
                         <i class="iconsax me-2" icon-name="menu-meatballs" type="button" data-bs-toggle="dropdown" aria-expanded="false"></i>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('dosen.topic.form', ['id' => $dt->id]) }}">Edit</a></li>
                            <li>
                                <p type="button" class="dropdown-item text-danger mb-0" onclick="deleteAction({
                                    url: '{{ route('dosen.topic.delete', ['id' => $dt->id]) }}',
                                    text: 'Apakah Anda yakin ingin menghapus topik ini?',
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