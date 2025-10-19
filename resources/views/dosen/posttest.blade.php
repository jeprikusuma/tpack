@extends('master.panel.layout')

@section('title', 'Post-Test')

@section('content')
<div class=" bg-white rounded-4 mt-3 p-4">
    <h4>Pengaturan Post-Test</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Form pengaturan posttest --}}
    <form action="{{ route('dosen.posttest.update') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="start_date" class="form-label">Tanggal Mulai</label>
            <input type="datetime-local" name="start_date" id="start_date"
                   value="{{ old('start_date', $posttest?->start_date?->format('Y-m-d\TH:i')) }}"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">Tanggal Selesai</label>
            <input type="datetime-local" name="end_date" id="end_date"
                   value="{{ old('end_date', $posttest?->end_date?->format('Y-m-d\TH:i')) }}"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label for="duration_minutes" class="form-label">Durasi (menit)</label>
            <input type="number" name="duration_minutes" id="duration_minutes"
                   value="{{ old('duration_minutes', $posttest->duration_minutes ?? 30) }}"
                   class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
    {{-- Info tambahan --}}
    <div class="mt-4">
        <h6 class="fw-semibold">Status Saat Ini:</h6>
        @if ($posttest && $posttest->isActive())
            <span class="badge bg-success">Sedang Aktif</span>
            <small class="text-muted ms-2">
                ({{ $posttest->start_date->format('d M Y H:i') }} - {{ $posttest->end_date->format('d M Y H:i') }})
            </small>
        @elseif($posttest)
            <span class="badge bg-secondary">Tidak Aktif</span>
            <small class="text-muted ms-2">
                ({{ $posttest->start_date->format('d M Y H:i') }} - {{ $posttest->end_date->format('d M Y H:i') }})
            </small>
        @else
            <span class="text-muted">Belum ada pengaturan tanggal.</span>
        @endif
    </div>
</div>
<div class=" bg-white rounded-4 mt-3 p-4">
    {{-- Tabel hasil posttest mahasiswa --}}
    <h4>Hasil Post-Test Mahasiswa</h4>

    @if($attempts->isEmpty())
        <p class="text-muted">Belum ada mahasiswa yang mengerjakan posttest.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
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
