@extends('master.panel.layout')

@section('title', 'Instrumen Persepsi')

@section('content')
<div class="bg-white rounded-4 mt-3 p-4 shadow-sm">
    <div class="d-flex flex-column flex-lg-row align-items-start justify-content-between mb-3">
        <div>
            <h4 class="text-dark">Pengaturan Instrumen Persepsi</h4>
            <p class="text-muted">Atur tanggal mulai dan berakhir pengerjaan instrumen persepsi</p>
        </div>
    </div>

    {{-- Notifikasi sukses --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Form pengaturan tanggal --}}
    <form method="POST" action="{{ route('dosen.perception.update') }}" class="mt-3">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="start_date" class="form-label fw-semibold">Tanggal Mulai</label>
                <input type="datetime-local"
                       id="start_date"
                       name="start_date"
                       class="form-control @error('start_date') is-invalid @enderror"
                       value="{{ old('start_date', optional($setting?->start_date)->format('Y-m-d\TH:i')) }}">
                @error('start_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="end_date" class="form-label fw-semibold">Tanggal Berakhir</label>
                <input type="datetime-local"
                       id="end_date"
                       name="end_date"
                       class="form-control @error('end_date') is-invalid @enderror"
                       value="{{ old('end_date', optional($setting?->end_date)->format('Y-m-d\TH:i')) }}">
                @error('end_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary px-4">
                Simpan
            </button>
        </div>
    </form>

    {{-- Info tambahan --}}
    <div class="mt-4">
        <h6 class="fw-semibold">Status Saat Ini:</h6>
        @if ($setting && $setting->isActive())
            <span class="badge bg-success">Sedang Aktif</span>
            <small class="text-muted ms-2">
                ({{ $setting->start_date->format('d M Y H:i') }} - {{ $setting->end_date->format('d M Y H:i') }})
            </small>
        @elseif($setting)
            <span class="badge bg-secondary">Tidak Aktif</span>
            <small class="text-muted ms-2">
                ({{ $setting->start_date->format('d M Y H:i') }} - {{ $setting->end_date->format('d M Y H:i') }})
            </small>
        @else
            <span class="text-muted">Belum ada pengaturan tanggal.</span>
        @endif
    </div>
</div>
<div class="bg-white rounded-4 mt-3 p-4">
    <div class="d-flex flex-column flex-lg-row align-items-start justify-content-between mb-3">
        <div class="me-2">
            <h4 class="text-dark">Instrumen Persepsi</h4>
            <p class="text-muted mb-0">Daftar hasil mahasiswa</p>
        </div>
    </div>

    @if($responses->isEmpty())
        <p class="text-muted">Belum ada mahasiswa yang mengisi instrumen.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Total Skor</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                      @foreach ($responses as $i => $res)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $res->student->num }}</td>
                            <td>{{ $res->student->name }}</td>
                            <td>{{ $res->total_score }}</td>
                            <td><a class="btn btn-sm btn-outline-primary" href="{{ route('dosen.perception.show', $res->student_id) }}">Lihat Detail</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection
