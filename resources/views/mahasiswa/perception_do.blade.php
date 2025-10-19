<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Instrumen Persepsi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="{{ asset('assets/images/favicon.png') }}">
</head>
<body>

<div class="container mt-4 mb-5">
  <h3 class="text-center mb-4">Instrumen Persepsi Mahasiswa</h3>

  {{-- tampilkan error --}}
  @if ($errors->any())
      <div class="alert alert-danger rounded-4 p-4">
          @foreach ($errors->all() as $error)
              <div>{{ $error }}</div>
          @endforeach
      </div>
  @endif

  {{-- tampilkan success --}}
  @if (session('success'))
      <div class="alert alert-success rounded-4 p-4">
          {{ session('success') }}
      </div>
  @endif

  <form id="perceptionForm" method="POST" action="{{ route('mahasiswa.perception.submit') }}">
    @csrf

    {{-- daftar pertanyaan --}}
    @foreach($questions as $index => $q)
      <div class="card mb-3">
        <div class="card-body">
          <p class="fw-semibold mb-2">{{ $index + 1 }}. {{ $q }}</p>

          @foreach($options as $opt)
            <div class="form-check">
              <input class="form-check-input" type="radio"
                     name="answers[{{ $index }}]"
                     id="q{{ $index }}_{{ $opt['value'] }}"
                     value="{{ $opt['value'] }}" required>
              <label class="form-check-label" for="q{{ $index }}_{{ $opt['value'] }}">
                {{ $opt['label'] }}
              </label>
            </div>
          @endforeach
        </div>
      </div>
    @endforeach

    {{-- tombol submit --}}
    <div class="d-flex justify-content-end mt-4">
      <button type="submit" class="btn btn-success px-4">Kumpulkan Jawaban</button>
    </div>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
      const html = document.documentElement;
      if (localStorage.getItem("theme")) {
          html.setAttribute("data-bs-theme", localStorage.getItem("theme"));
      }
  });
</script>

</body>
</html>
