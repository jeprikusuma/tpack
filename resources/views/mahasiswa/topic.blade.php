@extends('master.panel.layout')

@section('title')
    Topik
@endsection

@section('content')
<div class="bg-white rounded-4 mt-3 p-4">
    <div class="d-flex flex-column flex-lg-row align-items-start justify-content-between">
        <div class="me-2">
            <h4 class="text-dark">Topik</h4>
            <p>Pilih topik pembelajaran</p>
        </div>
    </div>
    <div class="mt-3">
        @foreach ($topics as $dt)
            <div class="@if($dt->is_available) bg-white @else bg-light @endif border rounded-4 mb-3 p-4 d-flex flex-column flex-lg-row align-items-md-center justify-content-between">
                <a href="{{ route('mahasiswa.subtopic', ['topic_id' => $dt->id]) }}" class="link-underline link-underline-opacity-0 col-12 col-md-8">
                    <h5 class="text-dark">
                        @if(!$dt->is_available)
                        <i class="iconsax me-2" icon-name="lock-2"></i>
                        @endif
                        {{ $dt->title }}
                    </h5>
                    @if ($dt->blocked_reason)
                        <p class="mb-3 text-danger">{{ $dt->blocked_reason }}</p>
                    @else
                    <p class="mb-3 text-dark">
                        {{ $dt->subtopics_count == 0 ? 'Sub-topik belum tersedia' : $dt->subtopics_count.' sub-topik tersedia' }}
                    </p>
                    @endif

                    {{-- alert progress --}}
                    @if($dt->is_available || (!$dt->is_available && $dt->end_date <= now()) )
                    <div class="alert rounded-4 mt-3 p-3 @if($dt->progress == 100 && $dt->has_discussed && $dt->has_reflected) alert-success @else alert-warning @endif">
                        <p class="mb-2 fs-7 @if($dt->progress == 100) text-success @else text-danger @endif">
                            @if ($dt->progress == 100)
                            <i class="iconsax" icon-name="tick-circle"></i>
                            @else
                            <i class="iconsax text-danger" icon-name="x-circle"></i>
                            @endif
                            Membaca seluruh materi ({{ $dt->progress }}%)
                        </p>
                        <p class="mb-2 fs-7 @if($dt->has_discussed) text-success @else text-danger @endif">
                            @if ($dt->has_discussed)
                            <i class="iconsax" icon-name="tick-circle"></i>
                            @else
                            <i class="iconsax text-danger" icon-name="x-circle"></i>
                            @endif
                            Mengikuti diskusi 
                        </p>
                        <p class="mb-2 fs-7 @if($dt->has_reflected) text-success @else text-danger @endif">
                            @if ($dt->has_reflected)
                            <i class="iconsax" icon-name="tick-circle"></i>
                            @else
                            <i class="iconsax text-danger" icon-name="x-circle"></i>
                            @endif
                            Mengisi refleksi 
                        </p>
                    </div>
                    @endif
                    
                    <p class="mb-0 text-dark fs-7 mt-3">Dibuka pada: {{ \Carbon\Carbon::parse($dt->start_date)->format('d M Y H:i') }} - {{ \Carbon\Carbon::parse($dt->end_date)->format('d M Y H:i') }}</p>
                </a>
                @if($dt->is_available)
                <div class="d-flex gap-3 mt-3 mt-md-0">
                    <a role="button" href="{{ route('mahasiswa.subtopic', ['topic_id' => $dt->id]) }}" class="link-underline link-underline-opacity-0 text-primary">Lanjut belajar <i class="iconsax ms-2" icon-name="arrow-right"></i></a>
                </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection