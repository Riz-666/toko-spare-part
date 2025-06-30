<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    {{-- sweetAlert --}}
    <link rel="stylesheet" href="{{ asset('sweetalert2/dist/sweetalert2.all.min.css') }}">
    <!-- fontawesome -->
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    {{-- CSS Home --}}
    <link rel="stylesheet" href="{{ asset('css_home/style.css') }}">
    <title>{{ $judul }}</title>
    <link rel="icon" type="image/png" href="{{ asset('/storage/default-img/logo-ct.png') }}">
</head>

<body style="display: flex; flex-direction: column; min-height: 100vh;">


    @include('layout.navbar')

    <main class="py-4" style="padding-bottom: 80px;">
        @yield('content')
        
    </main>



    @include('layout.footer')
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- bootstrap js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
{{-- sweetAlert --}}
<script src="{{ asset('sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
<!-- fontawesome js -->
<script src="{{ asset('fontawesome/js/all.min.js') }}"></script>

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil !!!',
            text: '{{ session('success') }}'
        });
    </script>
@endif

@if (session('status'))
    <script>
        Swal.fire({
            position: "top-end",
            title: 'Selamat Datang',
            text: '{{ session('status') }}',
            showConfirmButton: false,
            timer: 3000
        });
    </script>
@endif

<script type="text/javascript">
    $(document).on('click', '.show_confirm', function(event) {
        event.preventDefault();

        var form = $(this).closest("form");
        var name = $(this).data("konf-delete");

        Swal.fire({
            title: 'Konfirmasi Hapus Pesanan?',
            html: "Data <strong>" + name + "</strong> akan dihapus dan tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Terhapus!',
                    text: 'Data berhasil dihapus.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    form.submit();
                });
            }
        });
    });
</script>


<script type="text/javascript">
    $(document).on('click', '.show_confirm_batal', function(event) {
        event.preventDefault();

        var form = $(this).closest("form");
        var name = $(this).data("konf-delete");

        Swal.fire({
            title: 'Konfirmasi Batalkan Pesanan?',
            html: "Pesanan <strong>" + name +
                "</strong> akan Batalkan dan tidak dapat Di Ubah Kembali!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Batalkan Pesanan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Di Batalkan!',
                    text: 'Pesanan Berhasil DI batalkan!',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    form.submit();
                });
            }
        });
    });
</script>

@if (session('logout'))
    <script>
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: '{{ session('logout') === true ? 'Berhasil Logout' : session('logout') }}',
            showConfirmButton: false,
            timer: 3000
        });
    </script>
@endif

</html>
