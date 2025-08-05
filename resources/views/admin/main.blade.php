<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin & Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords" content="adminkit, bootstrap, dashboard, template, responsive, admin panel, Laravel, UI Kit">

    <title>Dashboard - Stock App</title>
    <style>
        .btn-gradient-primary {
            background: linear-gradient(45deg, #1e90ff, #00bcd4);
            border: none;
            color: white;
        }

        .btn-gradient-primary:hover {
            background: linear-gradient(45deg, #00bcd4, #1e90ff);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
    </style>

    {{-- CSS includes --}}
    @include('admin.css')
</head>

<body>
    <div class="wrapper">
        {{-- Sidebar --}}
        @include('admin.sidebar')

        <div class="main">
            {{-- Navbar --}}
            @include('admin.navbar')

            <main class="content">
                @yield('content')
                @if(session('success'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: '{{ session('success') }}',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    </script>
                @endif

                @if($errors->any())
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: '{{ $errors->first() }}',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    </script>
                @endif



            </main>

            {{-- Footer --}}
            @include('admin.footer')
        </div>
    </div>

    {{-- JS includes --}}
    @include('admin.js')

    {{-- CDN SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Script Konfirmasi Hapus --}}
    <script>
        document.querySelectorAll('.show-confirm').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                let form = this.closest('form');

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

    @stack('scripts')
</body>

</html>