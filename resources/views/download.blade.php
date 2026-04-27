@extends('layouts.frontend')

@section('content')

<style>
    .download-hero {
        background: linear-gradient(135deg, #0f0f0f 0%, #1a1a2e 40%, #16213e 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        padding: 100px 0 60px;
    }
    .download-hero::before {
        content: '';
        position: absolute;
        width: 600px; height: 600px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(220,38,38,0.15), transparent 70%);
        top: -150px; right: -150px;
        pointer-events: none;
    }
    .download-hero::after {
        content: '';
        position: absolute;
        width: 400px; height: 400px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(220,38,38,0.08), transparent 70%);
        bottom: -100px; left: -100px;
        pointer-events: none;
    }
    .app-card {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 28px;
        padding: 40px 32px;
        backdrop-filter: blur(20px);
        transition: all 0.35s cubic-bezier(.4,0,.2,1);
        position: relative;
        overflow: hidden;
    }
    .app-card::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 28px;
        background: linear-gradient(135deg, rgba(220,38,38,0.08), transparent);
        opacity: 0;
        transition: opacity 0.35s;
        pointer-events: none; /* Tambahkan ini agar tidak menghalangi klik */
    }
    .app-card:hover {
        transform: translateY(-8px);
        border-color: rgba(220,38,38,0.4);
        box-shadow: 0 30px 60px rgba(220,38,38,0.15), 0 0 0 1px rgba(220,38,38,0.2);
    }
    .app-card:hover::before { opacity: 1; }
    .app-icon-wrapper {
        width: 100px; height: 100px;
        border-radius: 22px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 24px;
        position: relative;
    }
    .app-icon-wrapper img {
        width: 100%; height: 100%;
        object-fit: cover;
        border-radius: 22px;
    }
    .app-icon-wrapper .badge-role {
        position: absolute;
        bottom: -8px; right: -8px;
        width: 32px; height: 32px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px;
        border: 2px solid #0f0f0f;
    }
    .btn-download {
        display: inline-flex; align-items: center; justify-content: center; gap: 10px;
        padding: 14px 32px;
        border-radius: 999px;
        font-weight: 700; font-size: 15px;
        text-decoration: none;
        transition: all 0.2s;
        width: 100%;
        position: relative; /* Tambahkan ini */
        z-index: 10; /* Tambahkan ini */
    }
    .btn-download-primary {
        background: linear-gradient(135deg, #dc2626, #ef4444);
        color: white;
        box-shadow: 0 8px 24px rgba(220,38,38,0.4);
    }
    .btn-download-primary:hover {
        background: linear-gradient(135deg, #b91c1c, #dc2626);
        color: white;
        box-shadow: 0 12px 32px rgba(220,38,38,0.5);
        transform: scale(1.02);
    }
    .btn-download-secondary {
        background: rgba(255,255,255,0.08);
        color: white;
        border: 1.5px solid rgba(255,255,255,0.15);
    }
    .btn-download-secondary:hover {
        background: rgba(255,255,255,0.15);
        color: white;
        border-color: rgba(255,255,255,0.3);
        transform: scale(1.02);
    }
    .feature-chip {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 999px;
        padding: 5px 14px;
        font-size: 12px;
        color: rgba(255,255,255,0.7);
        font-weight: 500;
    }
    .divider-line {
        width: 1px;
        background: linear-gradient(to bottom, transparent, rgba(255,255,255,0.12), transparent);
    }
    .steps-wrap {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 20px;
        padding: 32px;
    }
    .step-num {
        width: 36px; height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #dc2626, #ef4444);
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 14px; color: white;
        flex-shrink: 0;
    }
</style>

<section class="download-hero">
    <div class="container position-relative" style="z-index:2;">

        {{-- TOP BADGE --}}
        <div class="text-center mb-5">
            <span class="feature-chip mb-4 d-inline-flex">
                <i class="bi bi-android2 text-success"></i> Tersedia untuk Android
            </span>
            <h1 class="display-4 fw-black text-white mb-3" style="font-weight:900; letter-spacing:-0.5px;">
                Download <span style="background: linear-gradient(135deg,#dc2626,#f97316); -webkit-background-clip:text; -webkit-text-fill-color:transparent;">Happy Gym</span><br>App
            </h1>
            <p class="text-white-50 fs-5" style="max-width:520px; margin:0 auto;">
                Pilih aplikasi sesuai peran Anda dan mulai perjalanan kebugaran bersama Happy Gym.
            </p>
        </div>

        {{-- APP CARDS --}}
        <div class="row g-4 justify-content-center mb-5">

            {{-- MEMBER APP --}}
            <div class="col-md-5">
                <div class="app-card">
                    <div class="app-icon-wrapper">
                        <img src="{{ asset('storage/images/logoapk.png') }}" alt="Happy Gym Member Icon">
                        <span class="badge-role" style="background: linear-gradient(135deg,#2563eb,#3b82f6);">
                            <i class="bi bi-person-fill text-white" style="font-size:13px;"></i>
                        </span>
                    </div>
                    <div class="text-center mb-4">
                        <h3 class="text-white fw-bold mb-1">Happy Gym Member</h3>
                        <p class="text-white-50 small mb-3">Untuk anggota gym & member aktif</p>
                        <div class="d-flex flex-wrap gap-2 justify-content-center">
                            <span class="feature-chip"><i class="bi bi-calendar-check"></i> Booking Kelas</span>
                            <span class="feature-chip"><i class="bi bi-graph-up"></i> Metrik Fisik</span>
                            <span class="feature-chip"><i class="bi bi-credit-card"></i> Transaksi</span>
                        </div>
                    </div>
                    <a href="{{ asset('HappyGym Member.apk') }}" download class="btn-download btn-download-primary">
                        <i class="bi bi-android2" style="font-size:18px;"></i>
                        <span>Download APK Member</span>
                    </a>
                    <p class="text-white-50 text-center mt-3 mb-0" style="font-size:12px;">
                        <i class="bi bi-shield-check text-success me-1"></i>Aman · Gratis · Untuk member terdaftar
                    </p>
                </div>
            </div>

            {{-- DIVIDER (hanya tampil di desktop) --}}
            <div class="d-none d-md-flex col-md-1 justify-content-center">
                <div class="divider-line my-5"></div>
            </div>

            {{-- INSTRUKTUR APP --}}
            <div class="col-md-5">
                <div class="app-card">
                    <div class="app-icon-wrapper">
                        <img src="{{ asset('storage/images/logoapk.png') }}" alt="Happy Gym Instruktur Icon">
                        <span class="badge-role" style="background: linear-gradient(135deg,#d97706,#f59e0b);">
                            <i class="bi bi-person-badge-fill text-white" style="font-size:13px;"></i>
                        </span>
                    </div>
                    <div class="text-center mb-4">
                        <h3 class="text-white fw-bold mb-1">Happy Gym Instruktur</h3>
                        <p class="text-white-50 small mb-3">Untuk instruktur & personal trainer</p>
                        <div class="d-flex flex-wrap gap-2 justify-content-center">
                            <span class="feature-chip"><i class="bi bi-people"></i> Kelola Klien</span>
                            <span class="feature-chip"><i class="bi bi-qr-code-scan"></i> Scan Absensi</span>
                            <span class="feature-chip"><i class="bi bi-megaphone"></i> Pengumuman</span>
                        </div>
                    </div>
                    <a href="{{ asset('HappyGym Instruktur.apk') }}" download class="btn-download btn-download-secondary">
                        <i class="bi bi-android2" style="font-size:18px;"></i>
                        <span>Download APK Instruktur</span>
                    </a>
                    <p class="text-white-50 text-center mt-3 mb-0" style="font-size:12px;">
                        <i class="bi bi-shield-check text-success me-1"></i>Khusus instruktur terdaftar
                    </p>
                </div>
            </div>
        </div>

        {{-- CARA INSTALL --}}
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="steps-wrap">
                    <h5 class="text-white fw-bold text-center mb-4">
                        <i class="bi bi-info-circle text-danger me-2"></i>Cara Install Aplikasi Android
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-3 col-6">
                            <div class="d-flex flex-column align-items-center text-center gap-2">
                                <div class="step-num">1</div>
                                <p class="text-white-50 small mb-0">Download file APK di atas</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex flex-column align-items-center text-center gap-2">
                                <div class="step-num">2</div>
                                <p class="text-white-50 small mb-0">Buka <strong class="text-white">Pengaturan</strong> → Keamanan</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex flex-column align-items-center text-center gap-2">
                                <div class="step-num">3</div>
                                <p class="text-white-50 small mb-0">Aktifkan <strong class="text-white">Sumber Tidak Dikenal</strong></p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex flex-column align-items-center text-center gap-2">
                                <div class="step-num">4</div>
                                <p class="text-white-50 small mb-0">Buka file APK & tap <strong class="text-white">Install</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
