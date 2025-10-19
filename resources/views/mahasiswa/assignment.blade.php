@extends('master.panel.layout')

@section('title', 'Tugas Akhir')

@section('content')
<div class="bg-white rounded-4 mt-3 p-4">

    <h4 class="text-dark mb-2">Tugas Akhir</h4>
    <p class="text-muted mb-4">Silakan unggah file rencana pembelajaran Anda untuk setiap studi kasus berikut.</p>

    {{-- Jika belum memenuhi syarat --}}
    @if(!$canAccess)
        <div class="alert alert-warning rounded-4 p-4">
            <p class="fw-bold mb-2">Anda belum dapat mengerjakan tugas akhir.</p>
            <ul class="mb-0">
                @foreach($reasons as $reason)
                    <li>{{ $reason }}</li>
                @endforeach
            </ul>
        </div>
    @else
        {{-- Informasi waktu pengerjaan --}}
        @if(isset($setting))
            <div class="alert alert-secondary rounded-4 p-3 mb-4">
                <strong>Waktu pengerjaan:</strong><br>
                Mulai: {{ \Carbon\Carbon::parse($setting->start_date)->format('d M Y H:i') }} <br>
                Selesai: {{ \Carbon\Carbon::parse($setting->end_date)->format('d M Y H:i') }}
                <hr class="my-3">
                <ul class="mb-0">
                    <li>Gunakan template yang sudah disediakan (<a target="__blank" href="{{ asset('template/tugas_akhir_template.docx') }}" class="fw-semibold">Download Template</a>).</li>
                    <li>File yang diupload harus dalam format <strong>PDF</strong> dengan ukuran maksimal <strong>3 MB</strong>.</li>
                    <li>Tugas hanya dapat dikumpulkan pada rentang waktu di atas.</li>
                </ul>
            </div>
        @else
            <div class="alert alert-warning rounded-4 p-3">
                Tugas akhir belum disiapkan oleh dosen.
            </div>
        @endif

        @foreach($tasks as $code => $description)
            <div class="border rounded-4 p-4 mb-3">
                <h6 class="fw-bold text-primary mb-2">{{ str_replace('TA', 'Tugas Akhir ', $code) }}</h6>
                <p class="mb-3">{!! $description !!}</p>

                <div class="mb-2 d-flex flex-column flex-md-row justify-content-md-between align-items-md-center">
                        @if($submissions->has($code))
                            <div class="d-flex flex-column">
                                <small class="badge bg-success d-block">
                                    Dikirim: {{ \Carbon\Carbon::parse($submissions[$code]->submitted_at)->format('d/m/Y H:i') }}
                                </small>
                                <a href="{{ asset('storage/'.$submissions[$code]->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary my-2">
                                    <i class="bi bi-file-earmark-text"></i> Lihat File
                                </a>
                            </div>
                        @else
                            <span class="badge bg-warning text-dark mb-2">Belum Dikirim</span>
                        @endif
        
                        <button 
                            class="btn btn-primary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#uploadModal"
                            data-task="{{ $code }}"
                        >
                            <i class="bi bi-upload"></i> @if(!$submissions->has($code)) Upload @else Ganti @endif File
                        </button>
                </div>
            </div>
        @endforeach
    @endif

    @if (now() > $setting->end_date && !$canAccess)
        @foreach($tasks as $code => $description)
            <div class="border rounded-4 p-4 mb-3 bg-light">
                <h6 class="fw-bold text-primary mb-2">{{ str_replace('TA', 'Tugas Akhir ', $code) }}</h6>
                <p class="mb-3">{!! $description !!}</p>

                <div class="mb-2 d-flex flex-column flex-md-row justify-content-md-between align-items-md-center">
                        @if($submissions->has($code))
                            <div class="d-flex flex-column">
                                <small class="badge bg-success d-block">
                                    Dikirim: {{ \Carbon\Carbon::parse($submissions[$code]->submitted_at)->format('d/m/Y H:i') }}
                                </small>
                                <a href="{{ asset('storage/'.$submissions[$code]->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary my-2">
                                    <i class="bi bi-file-earmark-text"></i> Lihat File
                                </a>
                            </div>
                        @else
                            <span class="badge bg-danger text-white mb-2">Tidak Dikirim</span>
                        @endif
                </div>
            </div>
        @endforeach
    @endif
</div>

{{-- Modal Upload --}}
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4">
      <form action="{{ route('mahasiswa.assignment.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="uploadModalLabel">Upload File Tugas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="task_code" id="taskCodeInput">
          <div class="mb-3">
            <label for="file" class="form-label">Pilih File (.pdf)</label>
            <input type="file" name="file" id="file" accept=".pdf" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Upload</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Script untuk isi modal --}}
<script>
    const uploadModal = document.getElementById('uploadModal');
    uploadModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const taskCode = button.getAttribute('data-task');
        document.getElementById('taskCodeInput').value = taskCode;
        document.getElementById('uploadModalLabel').textContent = 'Upload File ' + taskCode;
    });
</script>
@endsection
