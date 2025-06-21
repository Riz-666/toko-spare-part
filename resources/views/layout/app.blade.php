<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
</head>

<body>

    @include('layout.navbar')

    @yield('content')

    @include('layout.footer')
</body>
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
</html>
