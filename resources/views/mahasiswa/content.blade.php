<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- GLightbox -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/styles/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/layout.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

    <link href="https://iconsax.gitlab.io/i/icons.css" rel="stylesheet">

    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}">

    <title>{{ $content->title }}</title>

    <style>
        /* Tabel CKEditor rapi */
         .content-description {
            overflow-x: auto;
         }
        .content-description table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            margin-bottom: 1rem;
        }
        .content-description th, .content-description td {
            border: 1px solid #dee2e6;
            padding: 0.5rem;
        }
        .content-description th {
            background-color: #f8f9fa;
        }

        /* Gambar clickable untuk lightbox */
        .content-description img {
            max-width: 100%;
            height: auto;
            cursor: pointer;
            border-radius: 0.25rem;
            transition: transform 0.2s;
        }
        .content-description img:hover {
            transform: scale(1.02);
        }
    </style>
</head>
<body class="position-relative bg-white px-3 px-md-0">
    <div class="container mt-3 mt-md-5">
        <div class="d-flex flex-column flex-lg-row align-items-start justify-content-between">
            <div class="me-2">
                <h1 class="text-dark fw-bold mt-5">{{ $content->title }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('mahasiswa.topic') }}">Topik</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('mahasiswa.subtopic', ['topic_id' => $topic->id]) }}">{{$topic->title}}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('mahasiswa.contents', ['topic_id' => $topic->id, 'subtopic_id' => $subtopic->id]) }}">{{$subtopic->title}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$content->title}}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="mt-3 content-description">
            {!! $content->description !!}
        </div>
    </div>

    <!-- Back to topic -->
    <div class="position-fixed" style="bottom: 50px; right: 50px; z-index: 1050;">
        <a href="{{ route('mahasiswa.contents', ['topic_id' => $topic->id, 'subtopic_id' => $subtopic->id]) }}" 
           class="btn btn-primary px-3 rounded-pill shadow-lg" role="button">
            Kembali ke Topik
        </a>
    </div>

    <!-- Footer -->
    <div class="mt-5 mb-4 px-4">
        <p class="text-center text-muted" style="font-size: 14px;">All Rights Reserved by <strong class="text-primary">TPACK-IPA Inklusif</strong></p>
    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Theme
            if (localStorage.getItem("theme")) {
                document.documentElement.setAttribute("data-bs-theme", localStorage.getItem("theme"));
            }

            // Tambahkan lightbox ke semua gambar
            document.querySelectorAll('.content-description img').forEach(img => {
                img.setAttribute('data-glightbox', 'title:' + (img.alt || ''));
            });

            // Inisialisasi GLightbox
            GLightbox({
                selector: '[data-glightbox]',
                touchNavigation: true,
                loop: false,
                zoomable: true,
                autoplayVideos: false,
            });
        });
    </script>
</body>
</html>
