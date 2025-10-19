@extends('master.panel.layout')

@section('title', 'Instrumen Persepsi')

@section('content')
<div class="bg-white rounded-4 shadow-sm mt-3 p-4">
    <h4 class="mb-3">Instrumen Persepsi Mahasiswa</h4>

    {{-- tampilkan error kalau ada --}}
    @if ($errors->any())
        <div class="alert rounded-4 p-4 alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- jika belum disetting oleh dosen --}}
    @if (!$setting)
        <div class="alert rounded-4 p-4 alert-warning">
            Instrumen persepsi belum disiapkan oleh dosen.
        </div>
    @elseif ($response)
        <div class="alert rounded-4 p-4 alert-success">
            <strong>Anda sudah mengisi instrumen persepsi ini.</strong>
        </div>
    @elseif(!$canAccess)
        {{-- jika belum bisa diakses --}}
        <div class="alert alert-warning rounded-4 p-4">
            <p class="fw-bold mb-2">Anda belum dapat mengisi instrumen persepsi.</p>
            <ul class="mb-0">
                @foreach($reasons as $reason)
                    <li>{{ $reason }}</li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="mb-3">
            <p>Instrumen persepsi ini bertujuan untuk mengetahui persepsi Anda terhadap pembelajaran TPACK-IPA inklusif.</p>
            <p>Periode pengisian: 
                <strong>{{ \Carbon\Carbon::parse($setting->start_date)->format('d M Y') }}</strong> 
                - 
                <strong>{{ \Carbon\Carbon::parse($setting->end_date)->format('d M Y') }}</strong>
            </p>
            <p>Silakan isi instrumen dengan jujur sesuai pendapat pribadi Anda.</p>
        </div>
        @if(now()->between($setting->start_date, $setting->end_date))
            <form action="{{ route('mahasiswa.perception.do') }}" method="GET">
                @csrf
                <button type="submit" class="btn btn-primary">Mulai Isi Instrumen Persepsi</button>
            </form>
        @else
            <div class="alert rounded-4 p-4 alert-warning">
                Instrumen persepsi hanya bisa diisi pada tanggal 
                {{ \Carbon\Carbon::parse($setting->start_date)->format('d M Y') }} - 
                {{ \Carbon\Carbon::parse($setting->end_date)->format('d M Y') }}.
            </div>
        @endif
    @endif
</div>
@endsection
