@extends('master.panel.layout')

@section('title', 'Hasil Instrumen Persepsi')

@section('content')
<div class="bg-white rounded-4 mt-3 p-4 shadow-sm">
    <div class="d-flex flex-column flex-lg-row align-items-start justify-content-between mb-3">
        <div>
            <h4 class="text-dark">Detail Jawaban Mahasiswa</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dosen.perception') }}">Instrumen Persepsi</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
          </div>
    </div>
    <p><strong>Nama:</strong> {{ $student->name }}</p>
    <p><strong>NIM:</strong> {{ $student->num }}</p>
    <p><strong>Total Skor:</strong> {{ $response->total_score }}</p>

    <div class="table-responsive">
      <table class="table table-bordered align-middle">
        <tr class="table-light">
          <th>No</th>
          <th>Pertanyaan</th>
          <th>Jawaban</th>
          <th>Skor</th>
        </tr>
        @foreach ($response->answers as $ans)
        <tr>
          <td>{{ $ans->question_number }}</td>
          <td>{{ $questions[$ans->question_number - 1] }}</td>
          <td>{{ $ans->answer }}</td>
          <td>{{ $ans->score }}</td>
        </tr>
        @endforeach
    </table>
  </div>
</div>
@endsection
