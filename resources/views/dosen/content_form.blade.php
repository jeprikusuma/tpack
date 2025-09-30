@extends('master.panel.layout')

@section('title')
   Form Pembahasan
@endsection

@section('content')
<div class="bg-white rounded-4 mt-3 p-4">
    <div class="d-flex flex-column flex-lg-row align-items-start justify-content-between">
        <div class="me-2">
            <h4 class="text-dark">Form Pembahasan</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dosen.topic') }}">Topik</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dosen.subtopic', ['topic_id' => $topic->id]) }}">{{$topic->title}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dosen.content', ['topic_id' => $topic->id, 'subtopic_id' => $subtopic->id]) }}">{{$subtopic->title}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$content != null ? 'Edit' : 'Tambah'}} Data</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="mt-3">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form class="row" method="POST">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Judul</label>
                <input type="title" class="form-control @error('title') is-invalid @enderror" 
                    id="title" name="title" placeholder="Masukkan judul..." value="{{ old('title', $content?->title) }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tambahan CKEditor5 untuk description --}}
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea id="description" name="description" 
                    class="form-control @error('description') is-invalid @enderror" 
                    rows="6">{{ old('description', $content?->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-2">
                <button type="submit" class="btn btn-primary rounded-pill py-2 col-12">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('customjs')
    {{-- Load CKEditor5 from CDN --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'), {
                ckfinder: {
                    uploadUrl: "{{ route('upload.image') }}"
                },
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'underline', 'strikethrough', 'link', 'fontColor', 'fontBackgroundColor', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        'alignment', 'outdent', 'indent', '|',
                        'blockQuote', 'code', 'insertTable', 'imageUpload', 'mediaEmbed', 'horizontalLine', '|',
                        'undo', 'redo'
                    ]
                },
                mediaEmbed: {
                    previewsInData: true
                },
                table: {
                    contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                }
            })
            .then(editor => {
                editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                    return {
                        upload: () => {
                            return loader.file.then(file => {
                                const data = new FormData();
                                data.append('upload', file);
                                data.append('_token', '{{ csrf_token() }}'); // penting!

                                return fetch("{{ route('upload.image') }}", {
                                    method: 'POST',
                                    body: data
                                })
                                .then(response => response.json())
                                .then(result => {
                                    return { default: result.url };
                                });
                            });
                        }
                    };
                };
    })
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
