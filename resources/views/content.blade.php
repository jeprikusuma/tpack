@extends('master.guest.layout')

@section('content')
    <div class="container d-flex">
       <h3 class="mt-5 fw-bold fs-1 lh-md">Content</h3>
    </div>
    <div class="container mt-5">
      <!-- Item 1 -->
      <div class="item open">
        <div class="item-header">
          <div class="left">
            <div class="number">01</div>
            <div class="header-text">Pengetahuan konten IPA</div>
          </div>
          <div class="right">
            <span>Detail</span>
            <img src="{{ asset('assets/svg/arrow-down.svg') }}" class="arrow" height="20">
          </div>
        </div>
        <div class="content" style="display:block;">
          <ul >
            <li>Mahluk hidup</li>
            <li>Benda dan sifat</li>
            <li>Energi</li>
            <li>Gaya dan gerak</li>
            <li>Tata surya</li>
            <li>Lingkungan dan fenomena alam</li>
          </ul>
        </div>
      </div>
      <!-- Item 2 -->
      <div class="item">
        <div class="item-header">
          <div class="left">
            <div class="number">02</div>
            <div class="header-text">Pengetahuan Pedagogi</div>
          </div>
          <div class="right">
            <span>Detail</span>
            <img src="{{ asset('assets/svg/arrow-down.svg') }}" class="arrow" height="20">
          </div>
        </div>
        <div class="content">
          <ul >
            <li>Penguasaan karakteristik peserta didik</li>
            <li>Penguasaan teori belajar</li>
            <li>Pengembangan kurikulum berbasis inklusif</li>
            <li>Penerapan pembelajaran</li>
            <li>Pemanfaatan teknologi</li>
            <li>Fasilitasi pengembangan potensi</li>
            <li>Komunikasi efektif</li>
            <li>Penerapan penilaian dan evaluasi</li>
            <li>Pemanfaatan hasil penilaian</li>
            <li>Penerapan tindakan reflektif</li>
          </ul>
        </div>
      </div>
      <!-- Item 3 -->
      <div class="item">
        <div class="item-header">
          <div class="left">
            <div class="number">03</div>
            <div class="header-text">Pengetahuan Teknologi</div>
          </div>
          <div class="right">
            <span>Detail</span>
            <img src="{{ asset('assets/svg/arrow-down.svg') }}" class="arrow" height="20">
          </div>
        </div>
        <div class="content">
          <ul >
            <li>Teknologi pendukung konten</li>
            <li>Teknologi pendukung pembelajaran</li>
          </ul>
        </div>
      </div>
      <!-- Item 4 -->
      <div class="item">
        <div class="item-header">
          <div class="left">
            <div class="number">04</div>
            <div class="header-text">Pengetahuan Pedagogi Konten (PCK)</div>
          </div>
          <div class="right">
            <span>Detail</span>
            <img src="{{ asset('assets/svg/arrow-down.svg') }}" class="arrow" height="20">
          </div>
        </div>
        <div class="content">
          <ul >
            <li>Pengetahuan Pedagogi Konten (PCK)</li>
          </ul>
        </div>
      </div>
      <!-- Item 5 -->
      <div class="item">
        <div class="item-header">
          <div class="left">
            <div class="number">05</div>
            <div class="header-text">Pengetahuan Teknologi Pedagogi (PTK)</div>
          </div>
          <div class="right">
            <span>Detail</span>
            <img src="{{ asset('assets/svg/arrow-down.svg') }}" class="arrow" height="20">
          </div>
        </div>
        <div class="content">
          <ul >
            <li>Pengetahuan Teknologi Pedagogi (PTK)</li>
          </ul>
        </div>
      </div>
      <!-- Item 6 -->
      <div class="item">
        <div class="item-header">
          <div class="left">
            <div class="number">06</div>
            <div class="header-text">Pengetahuan Teknologi Konten (TCK)</div>
          </div>
          <div class="right">
            <span>Detail</span>
            <img src="{{ asset('assets/svg/arrow-down.svg') }}" class="arrow" height="20">
          </div>
        </div>
        <div class="content">
          <ul >
            <li>Pengetahuan Teknologi Konten (PCK)</li>
          </ul>
        </div>
      </div>
      <!-- Item 7 -->
      <div class="item">
        <div class="item-header">
          <div class="left">
            <div class="number">07</div>
            <div class="header-text">Pengetahuan Teknologi Pedagogi Konten (TPACK)</div>
          </div>
          <div class="right">
            <span>Detail</span>
            <img src="{{ asset('assets/svg/arrow-down.svg') }}" class="arrow" height="20">
          </div>
        </div>
        <div class="content">
          <ul >
            <li>Pengetahuan Teknologi Pedagogi Konten (TPACK)</li>
          </ul>
        </div>
      </div>
    </div>
@endsection