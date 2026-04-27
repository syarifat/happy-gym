<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Happy Gym | Pusat Kebugaran Modern</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/images/logo2.png') }}">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        /* Efek smooth scroll saat menu di-klik */
        html {
            scroll-behavior: smooth;
        }
        
        /* Memberikan jarak agar konten tidak tertutup navbar saat di-scroll */
        section {
            scroll-margin-top: 70px; 
        }

        /* Efek hover pada card paket */
        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2) !important;
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#hero">
                <img src="{{ asset('storage/images/logo.png') }}" alt="Happy Gym Logo" style="height: 40px; object-fit: contain;">
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto fw-semibold">
                    <li class="nav-item">
                        <a class="nav-link px-3" href="#hero">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="#tentang">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="#paket">Paket Membership</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="#lokasi">Cabang & Instruktur</a>
                    </li>
                </ul>
                
                <div class="ms-lg-3 mt-3 mt-lg-0">
                    <a href="{{ asset('HappyGym Member.apk') }}" download class="btn btn-danger px-4 rounded-pill fw-semibold shadow-sm"><i class="bi bi-android2 me-1"></i>Daftar Member</a>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container text-center">
            <div class="mb-3">
                <h4 class="text-danger fw-bold mb-0">HAPPY GYM</h4>
                <small class="text-secondary">Transform Your Body, Transform Your Life.</small>
            </div>
            
            <div class="mb-3">
                <a href="#" class="text-white me-3 fs-5"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-white me-3 fs-5"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-white fs-5"><i class="bi bi-youtube"></i></a>
            </div>
            
            <hr class="border-secondary">
            <p class="mb-0 text-secondary small">&copy; {{ date('Y') }} Happy Gym. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>