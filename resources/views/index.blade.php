
@extends('master.guest.layout')

@section('content')
    <div class="container d-flex py-3">
      <div class="row align-items-center justify-content-between justify-self-center">
        <div class="col-md-6">
          <h3 class="mt-5 fw-bold fs-1 lh-md">TPACK-IPA Inklusif Bagi Kesetaraan Pendidikan IPA SD Untuk Penyandang Disabilitas</h3>
          <div class="mt-5 d-flex align-items-center gap-4">
            <a href="/login" class="btn btn-outline-primary px-5 rounded-pill fw-bold">Enroll me</a>
            <a href="/workflow" class="d-flex align-items-center gap-3 text-dark">
              <p class="mb-0">Learn more</p>
              <img src="{{ asset('assets/svg/arrow-right.svg') }}" height="18">
            </a>
          </div>
        </div>
        <div class="col-md-6">
          <img src="{{ asset('assets/images/banner.png') }}" alt="Hero Image" class="img-fluid mt-5">
        </div>
      </div>
    </div>
    <div class="container" style="min-height: 60vh;">
      <h3 class="mt-5 fw-bold fs-3 mb-5">INTRODUCTION</h3>
      <div class="row gap-4">
        <div class="col-12 col-md-4">
          <div class="d-flex align-items-center gap-2 mb-3">
            <h class="fs-4 fw-bold text-primary">Objective</h>
            <img src="{{ asset('assets/svg/send-2.svg') }}" height="33">
          </div>
          <p class="text-justify">Program ini bertujuan untuk menguatkan kompetensi calon guru SD, dalam hal pengetahuan teknologi-pedagogi-konten (TPACK) untuk IPA SD bagi kelas inklusif, termasuk siswa penyandang disabilitas, sehingga terwujud kesetaraan pendidikan IPA SD. Setelah mengikuti program, calon guru SD akan mampu menyusun pembelajaran berdasarkan konten dan melibatkan penggunaan teknologi yang sesuai bagi kelas inklusi, terutama siswa penyandang disabilitas.</p>
        </div>
        <div class="col-12 col-md-4">
          <div class="d-flex align-items-center gap-2 mb-3">
            <h class="fs-4 fw-bold text-primary">Format</h>
            <img src="{{ asset('assets/svg/note-2.svg') }}" height="33">
          </div>
          <p class="text-justify">Program ini adalah kursus Pelatihan Berbasis Web (Web-Based Training/WBT) yang interaktif dan sepenuhnya dapat dipelajari secara mandiri, disertai dengan Panduan Materi. Kursus WBT ini mengimplementasikan kegiatan sinkronous dan asinkronous, melalui fitur-fitur yang telah disediakan.</p>
        </div>
        <div class="col-12 col-md-3">
          <div class="d-flex align-items-center gap-2 mb-3">
            <h class="fs-4 fw-bold text-primary">Target Groups</h>
            <img src="{{ asset('assets/svg/teacher.svg') }}" height="33">
          </div>
          <p class="text-justify">Mahasiswa calon guru SD.</p>
        </div>
      </div>
    </div>
    <div class="container mt-5">
      <div class="mt-5 fw-bold fs-3 mb-5 text-center">CONTENT</div>
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
    <div class="container mt-5">
      <div class="mt-5 fw-bold fs-3 mb-5 text-center">INSTRUCTORS</div>
      <div class="owl-carousel">
        <div class="item d-flex flex-column flex-md-row gap-4">
          <div class="bg-body-tertiary flex-1 rounded-circle overflow-hidden" style="height: 80px !important; width: 80px !important;">
              <img src="{{ asset('assets/images/nancy.png') }}"/>
          </div>
          <div style="flex: 1;">
            <p class="fw-bold mb-0">Dr. Putu Nanci Riastini, S.Pd., M.Pd.</p>
            <p class="text-primary mb-2">putunanci.riastini@undiksha.ac.id</p>
            <p>Dr. Putu Nanci Riastini, S.Pd., M.Pd. lahir di Singaraja pada tanggal 27 April 1986. Ia beralamat di Jalan Pulau Menjangan, Kecamatan Buleleng, Kabupaten Buleleng, Bali. Riwayat pendidikannya dimulai dari jenjang Strata 1 (S1) di Universitas Pendidikan Ganesha (Undiksha) Program Studi Pendidikan Kimia, kemudian melanjutkan pendidikan Strata 2 (S2) di universitas yang sama pada Program Studi Pendidikan Dasar IPA. Setelah itu, Ia menempuh pendidikan Strata 3 (S3) di Universitas Negeri Yogyakarta pada Program Studi Ilmu Pendidikan-Pendidikan IPA. Ia pernah mengikuti Internship Dosen Muda di lingkungan Dikti di Universitas Negeri Surabaya; shortcourse STUNED NUFFIC NESO di Ede, Wageningen, Belanda; terlibat dalam kegiatan Workshop kegiatan ilmiah untuk Pendidikan calon guru SD yang diselenggarakan oleh Universitas Pendidikan Ganesha dan Chiba University Jepang, menjadi guest lecturer di Holy Cross of Davao College (HCDC), Filipina dan University of Melbourne, Australia. Bidang keilmuan yang ditekuni adalah pendidikan Sekolah Dasar bidang IPA, pengembangan ilmu pengetahuan dan pengajaran IPA SD yang inklusif, dan pengembangan profesional guru SD.</p>
          </div>
        </div>
        <div class="item d-flex flex-column flex-md-row gap-4">
          <div class="bg-body-tertiary flex-1 rounded-circle overflow-hidden" style="height: 80px !important; width: 80px !important;">
            <img src="{{ asset('assets/images/dessy.png') }}"/>
          </div>
          <div style="flex: 1;">
            <p class="fw-bold mb-0">Dr. phil. Dessy Seri Wahyuni, S.Kom., M.Eng.</p>
            <p class="text-primary mb-2">seri.wahyuni@undiksha.ac.id</p>
            <p>Dessy Seri Wahyuni mengajar di Program Studi Teknik Informatika, Fakultas Teknik dan Vokasi, Universitas Pendidikan Ganesha, Bali, Indonesia. Tugas utamanya adalah mengajar, meneliti, dan memberikan pengabdian kepada masyarakat. Dessy meraih gelar Doktor di Program Pendidikan Vokasi melalui Program Gelar Bersama di Universitas Negeri Yogyakarta dan Technische Universität Dresden, Jerman. Ia mengajar di program sarjana dan pascasarjana di universitas tersebut, yang beberapa mata kuliahnya berkaitan dengan Desain dan Strategi Instruksional Praxis di Sekolah Menengah Kejuruan, Desain Kurikulum Link and Match di Sekolah Menengah Kejuruan, dan Pengembangan Pembelajar melalui Keterampilan Kognitif dan Praktis. Mata kuliah tersebut mencerminkan keahliannya serta bidang penelitian yang diminatinya. Ia membimbing penelitian mahasiswa di TUD, Jerman, dan Universitas Pendidikan Ganesha.</p>
          </div>
        </div>
        <div class="item d-flex flex-column flex-md-row gap-4">
          <div class="bg-body-tertiary flex-1 rounded-circle overflow-hidden" style="height: 80px !important; width: 80px !important;">
            <img src="{{ asset('assets/images/widi.png') }}"/>
          </div>
          <div style="flex: 1;"> 
            <p class="fw-bold mb-0">Dr. Ni Ketut Widiartini, S.Pd., M.Pd.</p>
            <p class="text-primary mb-2">ketut.widiartini@undiksha.ac.id</p>
            <p>Dr. Ketut Widiartini, S.Pd., M.Pd. lahir di Singaraja pada tanggal 1 Agustus 1975. Ia beralamat di Perumahan Banyuning Lestari, Kecamatan Buleleng, Kabupaten Buleleng, Bali. Riwayat pendidikannya dimulai dari jenjang Strata 1 (S1) di STKIP Singaraja Program Studi Pendidikan Kesejahteraan Keluarga, kemudian melanjutkan pendidikan Strata 2 (S2) di Universitas Pendidikan Ganesha pada Program Studi Penelitian dan Evaluasi Pendidikan. Setelah itu, Ia menempuh pendidikan Strata 3 (S3) di Universitas Negeri Jakarta pada Program Studi Penelitian dan Evaluasi Pendidikan. Mata kuliah yang diajarkan adalah metodologi penelitian, Statistik dasar, dan Asesmen Pembelajaran.</p>
          </div>
        </div>
      </div>
    </div>
@endsection