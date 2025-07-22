<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ config('app.name') }}">
    <meta name="author" content="{{ config('app.author') }}">

    {{-- Title --}}
    <title>Login - {{ config('app.name') }}</title>

    {{-- Favicon icon --}}
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- tabler icons CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    {{-- Page CSS --}}
    <link rel="stylesheet" href="{{ asset('css/page-auth.css') }}">

    <style>
        .toggle-password-btn {
            display: none;
        }

        .login-background {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
        }

        .login-background::before {
            content: "";
            background-image: url('{{ asset("images/lldikti-building.jpg") }}');
            background-size: cover;
            background-position: center;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.4;
            /* Atur tingkat transparansi */
            z-index: 0;
        }

        .container-fluid {
            position: relative;
            z-index: 1;
            /* Pastikan kontennya tetap di atas background */
        }
    </style>
</head>

<body class="login-background">
    <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center">
        <div class="row w-100 bg-white rounded-4 shadow overflow-hidden" style="max-width: 960px;">

            <!-- Kolom Kiri -->
            <div class="col-12 col-md-7 d-flex flex-column justify-content-center align-items-center text-center p-5">
                <div style="max-width: 200px; margin-bottom: 20px;">
                    <img src="{{ asset('storage/logo/' . $profil->logo_instansi) }}" alt="Logo Instansi" class="img-fluid" style="width: 100%; height: auto;">
                </div>
                <h4 class="fw-bold mb-2">
                    Selamat Datang di
                    <span class="text-primary">{{ $profil->nama_aplikasi }}</span>
                </h4>
                <p class="text-muted fs-6">{{ $profil->kepanjangan_aplikasi }}</p>
            </div>


            <!-- Kolom Kanan - Form Login -->
            <div class="col-12 col-md-5 d-flex align-items-center justify-content-center bg-light h-100 p-4">
                <div class="card shadow w-100 border-0" style="max-width: 400px; border-radius: 1rem;">
                    <div class="card-body px-4 py-4">
                        <!-- Judul -->
                        <h5 class="text-center mb-1 fw-semibold text-primary">{{ $profil->nama_aplikasi }}</h5>
                        <p class="text-center text-muted mb-4">Silahkan Login untuk masuk ke Dashboard</p>

                        <!-- Alert -->
                        <x-alert></x-alert>

                        <!-- Form -->
                        <form action="{{ route('login.authenticate') }}" method="POST">
                            @csrf

                            <!-- Username -->
                            <div class="form-floating mb-3">
                                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" placeholder="Username" value="{{ old('username') }}">
                                <label><i class="ti ti-user"></i> <span class="ps-2">Username</span></label>
                                @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-floating mb-3 position-relative">
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control toggle-password @error('password') is-invalid @enderror"
                                    placeholder="Password"
                                    id="loginPassword">
                                <label for="loginPassword"><i class="ti ti-lock"></i> <span class="ps-2">Password</span></label>

                                {{-- Icon mata --}}
                                <span
                                    class="position-absolute top-50 end-0 translate-middle-y pe-3 toggle-password-btn"
                                    style="cursor: pointer; z-index: 10;">
                                    <i class="ti ti-eye" style="font-size: 1.3rem; color:rgb(142, 138, 138);"></i>
                                </span>


                                @error('password')
                                <div class=" invalid-feedback d-block">{{ $message }}
                                </div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                {!! htmlFormSnippet() !!}
                            </div>

                            @error('g-recaptcha-response')
                            <div class="text-danger mb-3" style="font-size: 0.9rem;">
                                {{ $message }}
                            </div>
                            @enderror

                            <!-- Tombol -->
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold mb-3" style="border-radius: 0.5rem;">LOGIN</button>

                            <!-- Footer -->
                            <div class="text-center small text-muted">
                                <a class="fw-semibold text-decoration-none text-primary">{{ $profil->nama_copyright }}</a>
                                <span class="fw-bold mx-1">By</span>
                                <img src="{{ asset('storage/logo/' . $profil->logo_kerjasama) }}" alt="Logo Kerjasama" style="height: 20px; vertical-align: middle;">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('loginPassword');
            const toggleIcon = document.querySelector('.toggle-password-btn');

            // Fungsi untuk toggle visibilitas icon
            function toggleIconVisibility() {
                if (passwordInput.value.trim() !== '') {
                    toggleIcon.style.display = 'block';
                } else {
                    toggleIcon.style.display = 'none';
                }
            }

            // Inisialisasi awal
            toggleIconVisibility();

            // Perbarui setiap kali input berubah
            passwordInput.addEventListener('input', toggleIconVisibility);

            // Toggle visibility password
            toggleIcon.addEventListener('click', function() {
                const icon = this.querySelector('i');
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                icon.classList.toggle('ti-eye');
                icon.classList.toggle('ti-eye-off');
            });
        });
    </script>



    {!! htmlScriptTagJsApi() !!}

</body>

</html>