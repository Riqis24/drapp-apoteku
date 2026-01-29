<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dr.App - Apoteku</title>
    <link rel="shortcut icon"
        href="data:image/svg+xml,%3csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%2033%2034'%20fill-rule='evenodd'%20stroke-linejoin='round'%20stroke-miterlimit='2'%20xmlns:v='https://vecta.io/nano'%3e%3cpath%20d='M3%2027.472c0%204.409%206.18%205.552%2013.5%205.552%207.281%200%2013.5-1.103%2013.5-5.513s-6.179-5.552-13.5-5.552c-7.281%200-13.5%201.103-13.5%205.513z'%20fill='%23435ebe'%20fill-rule='nonzero'/%3e%3ccircle%20cx='16.5'%20cy='8.8'%20r='8.8'%20fill='%2341bbdd'/%3e%3c/svg%3e"
        type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: radial-gradient(circle at top right, #1e70e9, #1557c0);
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            /* Center Vertikal */
            justify-content: center;
            /* Center Horizontal */
            font-family: 'Segoe UI', Roboto, sans-serif;
            position: relative;
            overflow-x: hidden;
            padding: 20px;
            /* Jarak aman untuk layar kecil */
        }

        /* Corak Dekoratif Background */
        body::before,
        body::after {
            content: "";
            position: fixed;
            width: 50vw;
            height: 50vw;
            border-radius: 50%;
            z-index: -2;
        }

        body::before {
            top: -150px;
            left: -150px;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        }

        body::after {
            bottom: -150px;
            right: -150px;
            clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
            /* Bentuk segitiga abstrak */
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
        }

        /* Overlay Pola Titik-titik (Dot Pattern) */
        .bg-pattern {
            position: fixed;
            /* Ubah ke fixed agar tidak bergeser saat scroll */
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px);
            background-size: 30px 30px;
            z-index: -1;
        }

        .btn-login {
            background: linear-gradient(to right, #1e70e9, #1557c0);
            border: none;
        }

        .login-card {
            border-radius: 2rem;
            overflow: hidden;
            border: 4px solid rgba(255, 204, 0, 0.3);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            background: white;
            width: 100%;
            max-width: 950px;
            /* Batas panjang maksimal agar tidak terlalu lebar */
        }

        .row-eq-height {
            display: flex;
            flex-wrap: wrap;
        }

        .login-left {
            background-color: #f8fbff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
        }

        .form-control {
            border-radius: 0.75rem;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            background-color: #f3f6f9;
            border: 1px solid #e1e5eb;
        }

        .form-control:focus {
            background-color: #fff;
            box-shadow: 0 0 0 0.25rem rgba(30, 112, 233, 0.1);
        }

        .input-group-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            color: #adb5bd;
        }

        /* Style khusus untuk tombol mata */
        .btn-show-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            border: none;
            background: none;
            color: #adb5bd;
            cursor: pointer;
        }

        .btn-show-password:hover {
            color: #1e70e9;
        }

        .btn-login {
            border-radius: 0.75rem;
            padding: 0.8rem;
            font-weight: bold;
            background-color: #1e70e9;
            border: none;
            transition: all 0.3s;
        }
    </style>
</head>

<body>
    <div class="bg-pattern"></div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">

                <div class="text-center text-white mb-4">
                    <h1 class="fw-bold">Halo, Rekan Apoteker!</h1>
                    <p class="opacity-75">Silahkan login untuk mengakses sistem POS Apoteku</p>
                </div>

                <div class="card login-card border-0 mx-auto">
                    <div class="row g-0 row-eq-height">

                        <div class="col-md-6 login-left d-none d-md-flex">
                            <img src="{{ url('assets/images/apoteku-image.png') }}" class="img-fluid mb-4"
                                style="max-height: 280px;">
                        </div>

                        <div class="col-md-6 bg-white p-4 p-lg-5">
                            <div class="mb-4">
                                <h2 class="fw-bold text-dark">Welcome!</h2>
                                <p class="text-muted small">Masukkan akun terdaftar anda</p>
                            </div>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Email</label>
                                    <div class="position-relative">
                                        <i class="fa-solid fa-envelope input-group-icon"></i>
                                        <input type="text" class="form-control" name="user_mstr_email"
                                            placeholder="nama@email.com">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold small">Password</label>
                                    <div class="position-relative">
                                        <i class="fa-solid fa-lock input-group-icon"></i>
                                        <input type="password" class="form-control" id="password"
                                            name="user_mstr_password" placeholder="••••••••">
                                        <button type="button" id="togglePassword" class="btn-show-password">
                                            <i class="fa-solid fa-eye" id="eyeIcon"></i>
                                        </button>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-login w-100 text-white">
                                    LOGIN SEKARANG <i class="fa-solid fa-arrow-right ms-2"></i>
                                </button>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function(e) {
            // Toggle tipe input
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Toggle icon (eye / eye-slash)
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>
