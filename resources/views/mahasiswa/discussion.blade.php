@extends('master.panel.layout')

@section('title')
   Diskusi
@endsection

@section('content')
<div class="bg-white rounded-4 shadow-sm mt-3 p-4">
    <div class="d-flex flex-column flex-lg-row align-items-start justify-content-between mb-3">
        <div class="me-2">
            <h4 class="text-dark mb-2">Diskusi</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('mahasiswa.topic') }}">Topik</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('mahasiswa.subtopic', ['topic_id' => $topic->id]) }}">{{$topic->title}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Diskusi</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Form Tambah Diskusi Utama --}}
    <div class="mb-3 pt-3">
        <form action="{{ route('mahasiswa.discussion.store', $topic->id) }}" method="POST">
            @csrf
            <div class="d-flex align-items-start">
                <div class="me-3 d-none d-md-block">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=977CFF&color=fff" 
                         alt="avatar" class="rounded-circle" width="40" height="40">
                </div>
                <div class="flex-grow-1">
                    <textarea name="message" id="message" rows="3" 
                              class="form-control rounded-3 border-1 @error('message') is-invalid @enderror" 
                              placeholder="Tulis sesuatu...">{{ old('message') }}</textarea>
                    @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="text-end mt-3">
                        <button class="btn btn-primary px-4 rounded-pill shadow-sm" type="submit">Kirim</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Daftar Diskusi Utama --}}
    <div>
        <h5 class="fw-bold mb-3">Diskusi Terbaru</h5>
        @forelse($discussions as $discussion)
            <div class="d-flex mb-4 p-3 rounded-4 border bg-white hover-shadow-sm">
                {{-- Avatar User --}}
                <div class="me-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($discussion->user->name) }}&background=8AADCA&color=fff" 
                        alt="avatar" class="rounded-circle border shadow-sm" width="40" height="40">
                </div>

                {{-- Isi Diskusi --}}
                <div class="flex-grow-1">
                    <div>
                        <p class="fw-semibold text-dark mb-0">{{ $discussion->user->name }}</p>
                        <small class="text-muted">{{ $discussion->created_at->diffForHumans() }}</small>
                    </div>

                    {{-- bubble utama --}}
                    <div class="mt-3">
                        <p class="mb-0">{!! nl2br(e($discussion->message)) !!}</p>
                    </div>

                    {{-- Action --}}
                    <div class="mt-3 d-flex gap-4">
                        <button type="button" 
                                class="btn btn-sm btn-link text-decoration-none text-primary p-0 toggle-reply" 
                                data-target="reply-form-{{ $discussion->id }}">
                            <i class="iconsax" icon-name="retweet"></i> Balas
                        </button>

                        @if(auth()->id() === $discussion->user_id)
                            <button class="btn btn-sm btn-link text-danger text-decoration-none p-0" onclick="deleteAction({
                                        url: '{{ route('mahasiswa.discussion.delete', ['topic_id' => $topic->id, 'discussion_id' => $discussion->id]) }}',
                                        text: 'Apakah Anda yakin ingin menghapus diskusi ini?',
                                    })">
                            <i class="iconsax" icon-name="trash"></i>  Hapus</button>
                        @endif
                    </div>

                    {{-- Form balasan (hidden by default) --}}
                    <div id="reply-form-{{ $discussion->id }}" class="d-none my-3">
                        <form action="{{ route('mahasiswa.discussion.reply', [$topic->id, $discussion->id]) }}" method="POST">
                            @csrf
                            <div class="d-flex align-items-start">
                                <div class="me-2 d-none d-md-block">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=977CFF&color=fff"
                                        alt="avatar" class="rounded-circle" width="32" height="32">
                                </div>
                                <div class="flex-grow-1">
                                    <textarea name="message" rows="2" class="form-control border-1 rounded-3 mb-2" placeholder="Tulis balasan ke {{ $discussion->user->name }}..."></textarea>
                                    <div class="text-start mt-3">
                                        <button class="btn btn-sm btn-primary rounded-pill px-3" type="submit">Kirim</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- List balasan --}}
                    @if($discussion->replies->count())
                        <div class="mt-4 ps-4 border-start border-2">
                            @foreach($discussion->replies as $reply)
                                <div class="d-flex mb-4 mt-1">
                                    <div class="me-2">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($reply->user->name) }}&background=8AADCA&color=fff" 
                                            alt="avatar" class="rounded-circle border shadow-sm" width="30" height="30">
                                    </div>
                                    <div class="flex-grow-1">
                                        <div>
                                            <p class="fw-semibold text-dark mb-0">{{ $reply->user->name }}</p>
                                            <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div class="my-2">
                                            <p class="mb-0">{{ $reply->message }}</p>
                                        </div>
                                        <div class="mt-1">
                                            @if(auth()->id() === $reply->user_id)
                                                <button class="btn btn-sm btn-link text-danger text-decoration-none p-0" onclick="deleteAction({
                                                    url: '{{ route('mahasiswa.discussion.delete', [$topic->id, $reply->id]) }}',
                                                    text: 'Apakah Anda yakin ingin menghapus diskusi ini?',
                                                })">
                                                <i class="iconsax" icon-name="trash"></i> Hapus</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-muted fst-italic">Belum ada diskusi. Yuk mulai percakapan pertama!</p>
        @endforelse
    </div>
</div>
@endsection

@section('customjs')
<script>
    document.querySelectorAll('.toggle-reply').forEach(btn => {
        btn.addEventListener('click', function () {
            const target = document.getElementById(this.dataset.target);
            target.classList.toggle('d-none');
        });
    });
</script>
@endsection
