<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Kerjakan Pretest</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="{{ asset('assets/images/favicon.png') }}">
  <style>
    /* floating countdown */
    #countdown {
      position: fixed;
      right: 20px;
      bottom: 20px;
      z-index: 2000;
      background: rgba(33,37,41,0.95);
      color: #fff;
      padding: .6rem .9rem;
      border-radius: .6rem;
      box-shadow: 0 6px 18px rgba(0,0,0,0.2);
      font-weight: 700;
      font-size: 1rem;
      min-width: 86px;
      text-align: center;
    }
  </style>
</head>
<body>

<div class="container mt-4 mb-5">
  <h3 class="text-center mb-4">Pretest</h3>

  <form id="pretestForm" method="POST" action="{{ route('mahasiswa.pretest.submit') }}">
    @csrf

    {{-- include attempt id supaya server tahu attempt mana --}}
    <input type="hidden" name="attempt_id" value="{{ $attempt->id }}">

    @foreach($questions as $index => $q)
      <div class="card mb-3">
        <div class="card-body">
            <input type="hidden" name="question_numbers[{{ $index }}]" value="{{ $index + 1 }}">
            <p class="fw-semibold mb-2">{{ $index + 1 }}. {{ $q['question'] }}</p>
            @foreach($q['options'] as $optKey => $optText)
                <div class="form-check">
                <input class="form-check-input" type="radio"
                        name="answers[{{ $index }}]"
                        id="q{{ $index }}_{{ $optKey }}"
                        value="{{ $optKey }}">
                <label class="form-check-label" for="q{{ $index }}_{{ $optKey }}">
                    {{ strtoupper($optKey) }}. {{ $optText }}
                </label>
                </div>
            @endforeach
        </div>
      </div>
    @endforeach

    <div class="d-flex justify-content-between align-items-center mt-3">
      <div class="text-muted">Mulai: <strong>{{ \Carbon\Carbon::parse($attempt->start_time)->format('d M Y H:i') }}</strong></div>
      <button type="submit" class="btn btn-success">Kumpulkan Jawaban</button>
    </div>
  </form>
</div>

<!-- Floating countdown -->
<div id="countdown">--:--</div>

<script>
  (function () {
    // endTimestampMs dikirim dari server (epoch milliseconds)
    const endTs = Number({{ $endTimestampMs }}); // e.g. 1696156800000
    const countdownEl = document.getElementById('countdown');
    const form = document.getElementById('pretestForm');

    // Flag untuk menghindari multiple submit
    let submitted = false;

    function formatTime(sec) {
      const m = Math.floor(sec / 60);
      const s = sec % 60;
      return String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
    }

    function tick() {
      const now = Date.now();
      let remainingMs = endTs - now;
      let remainingSec = Math.ceil(remainingMs / 1000);

      if (remainingSec <= 0) {
        countdownEl.textContent = '00:00';
        if (!submitted) {
          submitted = true;
          // optional: disable submit button to show feedback
          const btn = form.querySelector('button[type="submit"]');
          if (btn) { btn.disabled = true; btn.textContent = 'Mengumpulkan...'; }

          // submit form (POST)
          form.submit();
        }
        return;
      }

      countdownEl.textContent = formatTime(remainingSec);
    }

    // panggil segera supaya tidak delay 1 detik
    tick();
    // interval setiap 1 detik
    const timer = setInterval(tick, 1000);

    // Optional: jika user menutup tab / leave, kita tetap biarkan (server sudah punya start_time)
    // Jika perlu, bisa mendengarkan beforeunload untuk konfirmasi.
  })();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const html = document.documentElement;

        // cek localStorage theme
        if (localStorage.getItem("theme")) {
            html.setAttribute("data-bs-theme", localStorage.getItem("theme"));
        }
    });
</script>
</body>
</html>
