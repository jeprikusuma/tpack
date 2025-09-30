@extends('master.guest.layout')

@section('content')
<div class="container">
    <h3 class="mt-5 fw-bold fs-1 lh-md">Partner</h3>
    <div class="row mt-3 flex-column-reverse flex-lg-row">
        <div class="col-12 col-lg-6">
            <p>
                Tim Peneliti sangat menghargai kinerja kolaborasi strategis dengan anggota mitra penelitian...
                <strong>“Disability-Friendly”</strong>.
            </p>

            <div class="d-flex flex-column flex-md-row gap-3 mt-5 mb-4 align-items-start">
                <div class="d-flex gap-3">
                    <img src="{{ asset('assets/images/logo-fip.png') }}" height="50" width="50" />
                    <img src="{{ asset('assets/images/logo-ftk.png') }}" height="50" width="50" />
                </div>
                <div>
                    <p class="mb-0">Fakultas Ilmu Pendidikan Universitas Pendidikan Ganesha </p>
                    <p>Fakultas Teknik dan Kejuruan Universitas Pendidikan Ganesha</p>
                </div>
            </div>

            <div class="border rounded-4 mb-3 p-3 d-flex gap-3 align-items-center">
                <img src="{{ asset('assets/images/nancy.png') }}" height="35" width="35" />
                <p class="mb-0 fw-bold">Peneliti dan Dosen Prodi PGSD FIP Undiksha</p>
            </div>
            <div class="border rounded-4 mb-3 p-3 d-flex gap-3 align-items-center">
                <img src="{{ asset('assets/images/dessy.png') }}" height="35" width="35" />
                <p class="mb-0 fw-bold">Peneliti dan Dosen Prodi PTI FTK Undiksha</p>
            </div>
            <div class="border rounded-4 mb-3 p-3 d-flex gap-3 align-items-center">
                <img src="{{ asset('assets/images/widi.png') }}" height="35" width="35" />
                <p class="mb-0 fw-bold">Peneliti dan Dosen Prodi S2 PEP FTK Undiksha</p>
            </div>
        </div>

        <!-- Gambar partner -->
        <div class="col-12 col-lg-6 mb-4 mb-lg-0">
            <img src="{{ asset('assets/images/partner.png') }}" class="img-fluid" />
        </div>
    </div>
</div>
@endsection
