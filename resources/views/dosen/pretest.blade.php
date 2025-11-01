@extends('master.panel.layout')

@section('title', 'Pretest')

@section('content')
<div class=" bg-white rounded-4 mt-3 p-4">
    <h4>Pengaturan Pretest</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Form pengaturan pretest --}}
    <form action="{{ route('dosen.pretest.update') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="start_date" class="form-label">Tanggal Mulai</label>
            <input type="datetime-local" name="start_date" id="start_date"
                   value="{{ old('start_date', $pretest?->start_date?->format('Y-m-d\TH:i')) }}"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">Tanggal Selesai</label>
            <input type="datetime-local" name="end_date" id="end_date"
                   value="{{ old('end_date', $pretest?->end_date?->format('Y-m-d\TH:i')) }}"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label for="duration_minutes" class="form-label">Durasi (menit)</label>
            <input type="number" name="duration_minutes" id="duration_minutes"
                   value="{{ old('duration_minutes', $pretest->duration_minutes ?? 30) }}"
                   class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
<div class=" bg-white rounded-4 mt-3 p-4">
    {{-- Tabel hasil pretest mahasiswa --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
        <h4>Hasil Pretest Mahasiswa</h4>
        <a href="{{ route('dosen.pretest.export') }}" class="btn btn-sm btn-success">
            <i class="bi bi-download"></i> Download Excel
        </a>
    </div>


    @if($attempts->isEmpty())
        <p class="text-muted">Belum ada mahasiswa yang mengerjakan pretest.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email / NIM</th>
                        <th>Status</th>
                        <th>Nilai</th>
                        <th>Waktu Mulai</th>
                        <th>Waktu Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attempts as $i => $attempt)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $attempt->user->name }}</td>
                            <td>{{ $attempt->user->email }}</td>
                            <td>
                                @if($attempt->status === 'submitted')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($attempt->status === 'timeout')
                                    <span class="badge bg-warning text-dark">Timeout</span>
                                @else
                                    <span class="badge bg-secondary">Proses</span>
                                @endif
                            </td>
                            <td>{{ $attempt->score ?? '-' }}</td>
                            <td>{{ $attempt->start_time }}</td>
                            <td>{{ $attempt->end_time ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
