<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
<form id="action-form" action="" method="POST" class="d-none">
    @csrf
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/scripts/layout.js') }}"> </script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/scripts/action.js') }}"> </script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const btnToggle = document.getElementById("toggleTheme");
    const html = document.documentElement;

    // cek localStorage theme
    if (localStorage.getItem("theme")) {
        html.setAttribute("data-bs-theme", localStorage.getItem("theme"));
        updateIcon(localStorage.getItem("theme"));
    }

    btnToggle.addEventListener("click", function () {
        let currentTheme = html.getAttribute("data-bs-theme") === "dark" ? "light" : "dark";
        html.setAttribute("data-bs-theme", currentTheme);
        localStorage.setItem("theme", currentTheme);
        updateIcon(currentTheme);
    });

    function updateIcon(theme) {
        if (theme === "dark") {
            btnToggle.innerHTML = `<i class="iconsax" icon-name="sun"></i>`;
        } else {
            btnToggle.innerHTML = `<i class="iconsax" icon-name="moon"></i>`;
        }
    }
});
</script>


<!-- Custom JS -->
@yield('customjs')

<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    const logout = () => {
        Swal.fire({
            title: "Keluar",
            text: "Apakah anda yakin keluar?",
            icon: "question",
            showCancelButton: !0,
            confirmButtonColor: "#d75350",
            cancelButtonColor: "#74788d",
            confirmButtonText: "Keluar",
            cancelButtonText: "Batal",
        }).then(function (e) {
            if(e.value){
                document.getElementById('logout-form').submit();
            }
        })
    }
</script>

@if (session('error'))
    <script>
        Toast.fire({
            icon: 'error',
            title: 'Gagal',
            text: "{{ session('error') }}",
        })
    </script>
@endif

@if ($errors->any())
    <script>
        Toast.fire({
            icon: 'error',
            title: 'Gagal',
            html: "{!! implode('<br>', $errors->all()) !!}",
        })
    </script>
@endif

@if (session('success'))
    <script>
        Toast.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('success') }}",
        })
    </script>
@endif



</body>
</html>
