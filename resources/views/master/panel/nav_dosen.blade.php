<div>
    <a class="siderbar-menu {{ Request::is('dosen') ? 'active' : '' }}"  href="{{ route('dosen.dashboard') }}">
        <div>
            <i class="iconsax me-2" icon-name="home-1"></i>
            Dashboard
        </div>
    </a>
     <a class="siderbar-menu {{ Request::is('dosen/pretest') || Request::is('dosen/pretest/*') ? 'active' : '' }}"  href="{{ route('dosen.pretest') }}">
        <div>
            <i class="iconsax me-2" icon-name="cue-cards"></i>
            Pre-test
        </div>
    </a>
    <a class="siderbar-menu {{ Request::is('dosen/topic') || Request::is('dosen/topic/*') ? 'active' : '' }}"  href="{{ route('dosen.topic') }}">
        <div>
            <i class="iconsax me-2" icon-name="note-text"></i>
            Topik
        </div>
    </a>
    <a class="siderbar-menu {{ Request::is('dosen/assignment') || Request::is('dosen/assignment/*') ? 'active' : '' }}"  href="{{ route('dosen.assignment') }}">
        <div>
            <i class="iconsax me-2" icon-name="task-list-square"></i>
            Tugas Akhir
        </div>
    </a>
    <a class="siderbar-menu {{ Request::is('dosen/perception') || Request::is('dosen/perception/*') ? 'active' : '' }}"  href="{{ route('dosen.perception') }}">
        <div>
            <i class="iconsax me-2" icon-name="document-text-1"></i>
            Instrumen Persepsi
        </div>
    </a>
    <a class="siderbar-menu {{ Request::is('dosen/posttest') || Request::is('dosen/posttest/*') ? 'active' : '' }}"  href="{{ route('dosen.posttest') }}">
        <div>
            <i class="iconsax me-2" icon-name="notepad"></i>
            Post-test
        </div>
    </a>
</div>