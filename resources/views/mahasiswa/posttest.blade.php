@extends('master.panel.layout')

@section('title', 'Post-Test')

@section('content')
<div class="bg-white rounded-4 shadow-sm mt-3 p-4">
    <h4 class="mb-3">Post-Test TPACK-IPA Inklusif</h4>

    {{-- tampilkan error kalau ada --}}
    @if ($errors->any())
        <div class="alert rounded-4 p-4 alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    @if (!$posttest)
        <div class="alert rounded-4 p-4 alert-warning">
            Post-Test belum disiapkan oleh dosen.
        </div>
    @elseif ($attempt)
        <div class="alert rounded-4 p-4 alert-success">
            <strong>Anda sudah mengerjakan post-test ini.</strong><br>
            Nilai Anda: <span class="fw-bold">{{ $attempt->score ?? 0}} / 15</span>
        </div>
    @elseif(!$canAccess)
        <div class="alert alert-warning rounded-4 p-4">
            <p class="fw-bold mb-2">Anda belum dapat mengerjakan post-test.</p>
            <ul class="mb-0">
                @foreach($reasons as $reason)
                    <li>{{ $reason }}</li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="mb-3">
            <p>Post-Test ini wajib dikerjakan sebagai penilaian dari materi yang telah dipelajari. </p>
            <p>Durasi: <strong>{{$posttest->duration_minutes}} menit</strong></p>
            <p>Periode pengerjaan: 
                <strong>{{ \Carbon\Carbon::parse($posttest->start_date)->format('d M Y') }}</strong> 
                - 
                <strong>{{ \Carbon\Carbon::parse($posttest->end_date)->format('d M Y') }}</strong>
            </p>
        </div>

        @if(now()->between($posttest->start_date, $posttest->end_date))
            <form action="{{ route('mahasiswa.posttest.do') }}" method="GET">
                @csrf
                <button type="submit" class="btn btn-primary">Mulai Post-Test</button>
            </form>
        @else
            <div class="alert rounded-4 p-4 alert-warning">
                Post-Test hanya bisa dikerjakan pada tanggal 
                {{ \Carbon\Carbon::parse($posttest->start_date)->format('d M Y') }} - 
                {{ \Carbon\Carbon::parse($posttest->end_date)->format('d M Y') }}.
            </div>
        @endif
    @endif
</div>
@endsection
