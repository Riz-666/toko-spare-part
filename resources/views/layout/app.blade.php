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

        <!-- Live Chat Button -->
        @auth
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    // Buat tombol chat
                    const button = document.createElement("a");

                    const chatUrl = @json(auth()->user()->hasRole('admin') ? route('admin.chat.list') : route('customer.chat.index', 1));

                    button.href = chatUrl;
                    button.title = "Live Chat";
                    button.innerHTML = `<i class="fas fa-comments fa-lg"></i>`;

                    Object.assign(button.style, {
                        position: 'fixed',
                        right: '20px',
                        bottom: '20px',
                        width: '60px',
                        height: '60px',
                        backgroundColor: '#28a745',
                        color: '#fff',
                        borderRadius: '50%',
                        display: 'flex',
                        alignItems: 'center',
                        justifyContent: 'center',
                        fontSize: '22px',
                        zIndex: '999999',
                        boxShadow: '0 5px 15px rgba(0,0,0,0.3)',
                        textDecoration: 'none',
                        cursor: 'pointer'
                    });

                    document.body.appendChild(button);

                    // ===== Bubble Alert bergaya chat =====
                    const bubbleWrapper = document.createElement("div");
                    bubbleWrapper.style.position = 'fixed';
                    bubbleWrapper.style.right = '20px';
                    bubbleWrapper.style.bottom = '95px'; // Di atas tombol chat
                    bubbleWrapper.style.zIndex = '1000000';
                    bubbleWrapper.style.opacity = '0';
                    bubbleWrapper.style.transition = 'opacity 0.4s ease';

                    const reminder = document.createElement("div");
                    reminder.textContent = "Butuh bantuan? Chat admin sekarang!";

                    Object.assign(reminder.style, {
                        backgroundColor: '#ffc107',
                        color: '#000',
                        padding: '10px 14px',
                        borderRadius: '16px',
                        maxWidth: '220px',
                        boxShadow: '0 4px 10px rgba(0,0,0,0.2)',
                        fontSize: '14px',
                        position: 'relative',
                    });

                    // Tambahkan panah di bawah bubble
                    const arrow = document.createElement("div");
                    Object.assign(arrow.style, {
                        position: 'absolute',
                        bottom: '-10px',
                        right: '20px',
                        width: '0',
                        height: '0',
                        borderLeft: '10px solid transparent',
                        borderRight: '10px solid transparent',
                        borderTop: '10px solid #ffc107',
                    });

                    reminder.appendChild(arrow);
                    bubbleWrapper.appendChild(reminder);
                    document.body.appendChild(bubbleWrapper);

                    // Fungsi tampil dan sembunyikan alert
                    function showReminder() {
                        bubbleWrapper.style.opacity = '1';
                        setTimeout(() => {
                            bubbleWrapper.style.opacity = '0';
                        }, 5000); // tampil 10 detik
                    }

                    // Muncul pertama kali setelah 3 detik
                    setTimeout(showReminder, 3000);
                    // Lalu setiap 10 detik
                    setInterval(showReminder, 5000);
                });
            </script>
        @endauth

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

<script>
    const chatAudio = new Audio("{{ asset('notif/notif_live_chat.wav') }}");
    function checkNewChat() {
        fetch("{{ route('customer.chat.check') }}")
            .then(res => res.json())
            .then(data => {
                if (data.has_new) {
                    const notif = document.createElement("div");
                    notif.textContent = "💬 Pesan baru masuk!";
                    Object.assign(notif.style, {
                        position: 'fixed',
                        top: '90px',
                        left: '20px',
                        backgroundColor: '#007bff',
                        color: '#fff',
                        padding: '10px 15px',
                        borderRadius: '8px',
                        fontWeight: 'bold',
                        zIndex: 10000,
                        boxShadow: '0 0 10px rgba(0,0,0,0.3)'
                    });
                    document.body.appendChild(notif);

                    chatAudio.play().catch(() => {});

                    setTimeout(() => notif.remove(), 6000);
                }
            })
            .catch(console.error);
    }

    setInterval(checkNewChat, 10000); // setiap 10 detik
</script>


<script>
    const verifAudio = new Audio("{{ asset('notif/notif.wav') }}");

    function checkPesananVerifikasi() {
        fetch("{{ route('customer.pesanan.checkNew') }}")
            .then(res => res.json())
            .then(data => {
                if (data.verified) {
                    const notif = document.createElement("div");
                    notif.textContent = "✅ Pesanan kamu telah diverifikasi oleh admin!";
                    Object.assign(notif.style, {
                        position: 'fixed',
                        bottom: '130px',
                        right: '20px',
                        backgroundColor: '#28a745',
                        color: '#fff',
                        padding: '10px 15px',
                        borderRadius: '8px',
                        fontWeight: 'bold',
                        zIndex: 10000,
                        boxShadow: '0 0 10px rgba(0,0,0,0.3)'
                    });
                    document.body.appendChild(notif);
                    verifAudio.play();

                    setTimeout(() => notif.remove(), 6000);
                }
            });
    }

    setInterval(checkPesananVerifikasi, 10000); // setiap 10 detik
</script>


</html>
