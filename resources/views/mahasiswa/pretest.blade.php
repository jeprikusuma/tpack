@extends('master.panel.layout')

@section('title', 'Pretest')

@section('content')
<div class="bg-white rounded-4 shadow-sm mt-3 p-4">
    <h4 class="mb-3">Pretest TPACK-IPA Inklusif</h4>

    {{-- tampilkan error kalau ada --}}
    @if ($errors->any())
        <div class="alert rounded-4 p-4 alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    @if (!$pretest)
        <div class="alert rounded-4 p-4 alert-warning">
            Pretest belum disiapkan oleh dosen.
        </div>
    @else
        @if ($attempt)
            <div class="alert rounded-4 p-4 alert-success">
                <strong>Anda sudah mengerjakan pretest ini.</strong><br>
                Nilai Anda: <span class="fw-bold">{{ $attempt->score ?? 0}} / 15</span>
            </div>
        @else
            <div class="mb-3">
                <p>Pretest ini wajib dikerjakan sebagai syarat untuk mengakses materi.</p>
                <p>Durasi: <strong>{{$pretest->duration_minutes}} menit</strong></p>
                <p>Periode pengerjaan: 
                    <strong>{{ \Carbon\Carbon::parse($pretest->start_date)->format('d M Y') }}</strong> 
                    - 
                    <strong>{{ \Carbon\Carbon::parse($pretest->end_date)->format('d M Y') }}</strong>
                </p>
            </div>

            @if(now()->between($pretest->start_date, $pretest->end_date))
                <form action="{{ route('mahasiswa.pretest.do') }}" method="GET">
                    @csrf
                    <button type="submit" class="btn btn-primary">Mulai Pretest</button>
                </form>
            @else
                <div class="alert rounded-4 p-4 alert-warning">
                    Pretest hanya bisa dikerjakan pada tanggal 
                    {{ \Carbon\Carbon::parse($pretest->start_date)->format('d M Y') }} - 
                    {{ \Carbon\Carbon::parse($pretest->end_date)->format('d M Y') }}.
                </div>
            @endif
        @endif
    @endif
</div>
@endsection
