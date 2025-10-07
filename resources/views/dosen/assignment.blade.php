@extends('master.panel.layout')

@section('title', 'Tugas Akhir')

@section('content')
<div class="bg-white rounded-4 mt-3 p-4 shadow-sm">
    <div class="d-flex flex-column flex-lg-row align-items-start justify-content-between mb-3">
        <div>
            <h4 class="text-dark">Pengaturan Tugas Akhir</h4>
            <p class="text-muted">Atur tanggal mulai dan berakhir pengerjaan tugas akhir</p>
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
    <form method="POST" action="{{ route('dosen.assignment.update') }}" class="mt-3">
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
            <h4 class="text-dark">Tugas Akhir</h4>
            <p class="text-muted mb-0">Daftar file tugas akhir mahasiswa (TA1, TA2, TA3)</p>
        </div>
    </div>

    @if($groupedSubmissions->isEmpty())
        <p class="text-muted">Belum ada mahasiswa yang mengunggah tugas akhir.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>TA1</th>
                        <th>TA2</th>
                        <th>TA3</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($groupedSubmissions as $i => $group)
                        <tr>
                            <td>{{ $group['user']->num }}</td>
                            <td>{{ $group['user']->name }}</td>
                            
                            @foreach (['TA1', 'TA2', 'TA3'] as $taskCode)
                                @php
                                    $task = $group['tasks']->firstWhere('task_code', $taskCode);
                                @endphp

                                <td>
                                    @if ($task)
                                        <div class="d-flex flex-column">
                                            <small class="text-muted mb-2">
                                                {{ $task->submitted_at ? $task->submitted_at->format('d/m/Y H:i') : '-' }}
                                            </small>
                                            <a href="{{ asset('storage/' . $task->file_path) }}" 
                                               target="_blank" 
                                               class="btn btn-sm btn-outline-primary mb-1">
                                                Lihat File
                                            </a>
                                           
                                        </div>
                                    @else
                                        <span class="badge bg-secondary">Belum Upload</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection
