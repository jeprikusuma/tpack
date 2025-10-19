<div>
    <a class="siderbar-menu {{ Request::is('mahasiswa') ? 'active' : '' }}"  href="{{ route('mahasiswa.dashboard') }}">
        <div>
            <i class="iconsax me-2" icon-name="home-1"></i>
            Dashboard
        </div>
    </a>
    <a class="siderbar-menu {{ Request::is('mahasiswa/pretest') || Request::is('mahasiswa/pretest/*') ? 'active' : '' }}"  href="{{ route('mahasiswa.pretest') }}">
        <div>
            <i class="iconsax me-2" icon-name="cue-cards"></i>
            Pre-test
        </div>
    </a>
    <a class="siderbar-menu {{ Request::is('mahasiswa/topic') || Request::is('mahasiswa/topic/*') ? 'active' : '' }}"  href="{{ route('mahasiswa.topic') }}">
        <div>
            <i class="iconsax me-2" icon-name="note-text"></i>
            Topik
        </div>
    </a>
    <a class="siderbar-menu {{ Request::is('mahasiswa/assignment') || Request::is('mahasiswa/assignment/*') ? 'active' : '' }}"  href="{{ route('mahasiswa.assignment') }}">
        <div>
            <i class="iconsax me-2" icon-name="task-list-square"></i>
            Tugas Akhir
        </div>
    </a>
    <a class="siderbar-menu {{ Request::is('mahasiswa/perception') || Request::is('mahasiswa/perception/*') ? 'active' : '' }}"  href="{{ route('mahasiswa.perception') }}">
        <div>
            <i class="iconsax me-2" icon-name="document-text-1"></i>
            Instrumen Persepsi
        </div>
    </a>
    <a class="siderbar-menu {{ Request::is('mahasiswa/posttest') || Request::is('mahasiswa/posttest/*') ? 'active' : '' }}"  href="{{ route('mahasiswa.posttest') }}">
        <div>
            <i class="iconsax me-2" icon-name="notepad"></i>
            Post-test
        </div>
    </a>
</div>