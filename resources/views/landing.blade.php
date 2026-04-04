@extends('layouts.frontend')

@section('content')

<section id="hero" class="text-center d-flex align-items-center justify-content-center"
    style="height:100vh; background:url('https://images.unsplash.com/photo-1599058917212-d750089bc07e') center/cover no-repeat; margin-top: -80px;">
    <div style="background:rgba(255,255,255,0.85); padding:50px; border-radius:15px; max-width: 800px;" class="shadow-lg mx-3">
        <h1 class="display-4 fw-bold text-dark mb-3">Transform Your Body at Happy Gym</h1>
        <p class="lead text-dark mb-4">Tempat terbaik untuk membentuk tubuh ideal Anda dengan fasilitas premium dan instruktur berpengalaman.</p>
        <a href="#paket" class="btn btn-danger btn-lg px-5 py-3 fw-bold rounded-pill shadow">
            Lihat Paket Membership
        </a>
    </div>
</section>

<section id="tentang" class="py-5 bg-white">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h2 class="text-danger fw-bold mb-4">Tentang Happy Gym</h2>
                <p class="text-muted fs-5">Happy Gym berdiri untuk membantu masyarakat hidup lebih sehat, bugar, dan kuat melalui pendekatan yang terstruktur dan fasilitas berstandar tinggi.</p>
                
                <h5 class="fw-bold mt-4"><i class="bi bi-eye text-danger"></i> Visi</h5>
                <p class="text-muted">Menjadi pusat kebugaran modern terpercaya yang mencetak gaya hidup sehat berkelanjutan.</p>

                <h5 class="fw-bold mt-4"><i class="bi bi-bullseye text-danger"></i> Misi</h5>
                <ul class="text-muted">
                    <li>Memberikan fasilitas dan alat kebugaran terbaik.</li>
                    <li>Meningkatkan kualitas hidup member secara fisik dan mental.</li>
                    <li>Menyediakan pelatihan profesional dari ahlinya.</li>
                </ul>
            </div>
            
            <div class="col-lg-6">
                <div class="row g-4 text-center">
                    <div class="col-6">
                        <div class="p-4 border rounded-4 shadow-sm h-100 bg-light">
                            <h1 class="text-danger display-5"><i class="bi bi-bicycle"></i></h1>
                            <h5 class="fw-bold mt-3">Alat Modern</h5>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-4 border rounded-4 shadow-sm h-100 bg-light">
                            <h1 class="text-danger display-5"><i class="bi bi-person-video3"></i></h1>
                            <h5 class="fw-bold mt-3">Instruktur Pro</h5>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-4 border rounded-4 shadow-sm h-100 bg-light">
                            <h1 class="text-danger display-5"><i class="bi bi-clipboard2-pulse"></i></h1>
                            <h5 class="fw-bold mt-3">Program Terarah</h5>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-4 border rounded-4 shadow-sm h-100 bg-light">
                            <h1 class="text-danger display-5"><i class="bi bi-tags"></i></h1>
                            <h5 class="fw-bold mt-3">Harga Terjangkau</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="paket" class="py-5 bg-dark text-white">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-white">Paket <span class="text-danger">Membership</span></h2>
            <p class="text-secondary">Pilih paket yang paling sesuai dengan kebutuhan kebugaran Anda.</p>
        </div>

        <div class="row g-4 text-center justify-content-center">
            @foreach($pakets as $index => $paket)
                <div class="col-md-4">
                    {{-- Logika agar paket di tengah (index ke-1) tampil beda/menonjol --}}
                    @if($index == 1)
                        <div class="card border-0 bg-white text-dark p-5 rounded-4 h-100 shadow-lg" style="transform: scale(1.05); z-index: 1;">
                            <div class="badge bg-danger position-absolute top-0 start-50 translate-middle px-3 py-2 rounded-pill">PALING POPULER</div>
                            <h4 class="fw-bold mt-2">{{ $paket->nama_paket }}</h4>
                            <h2 class="text-danger fw-bold my-3">Rp {{ number_format($paket->harga, 0, ',', '.') }}</h2>
                            <p class="small text-muted mb-0">Durasi: {{ $paket->durasi }} hari. Akses penuh kelas reguler.</p>
                        </div>
                    @else
                        <div class="card border-0 bg-secondary text-white p-5 rounded-4 h-100 hover-shadow">
                            <h4 class="fw-bold">{{ $paket->nama_paket }}</h4>
                            <h2 class="text-danger fw-bold my-3">Rp {{ number_format($paket->harga, 0, ',', '.') }}</h2>
                            <p class="small text-light mb-0">Durasi: {{ $paket->durasi }} hari. {{ $paket->jenis }} eksklusif.</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="lokasi" class="py-5 bg-light">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark">Cabang & <span class="text-danger">Instruktur</span></h2>
            <p class="text-muted">Temukan lokasi terdekat dan berlatih bersama para ahli kami.</p>
        </div>

        @foreach($lokasis as $lokasi)
        <div class="card shadow-sm border-0 mb-5 rounded-4 overflow-hidden">
            <div class="row g-0">
                <div class="col-lg-5 position-relative">
                    <img src="{{ asset('storage/'.$lokasi->foto) }}" class="img-fluid w-100" style="height: 300px; object-fit:cover;">
                    <div class="p-0">
                        <iframe src="{{ $lokasi->link_google_maps }}" width="100%" height="250" style="border:0;" allowfullscreen loading="lazy"></iframe>
                    </div>
                </div>

                <div class="col-lg-7 p-4 p-md-5 bg-white">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h3 class="fw-bold text-dark">{{ $lokasi->nama }}</h3>
                        <span class="badge bg-danger fs-6">{{ $lokasi->kota }}</span>
                    </div>
                    <p class="text-muted"><i class="bi bi-geo-alt-fill text-danger me-2"></i>{{ $lokasi->alamat }}</p>
                    
                    @if($lokasi->deskripsi)
                        <p class="text-dark small">{{ $lokasi->deskripsi }}</p>
                    @endif

                    <hr>

                    <div class="row mt-4">
                        <div class="col-md-6 mb-4">
                            <h6 class="fw-bold"><i class="bi bi-clock-fill text-danger me-2"></i>Jam Operasional</h6>
                            <div class="small">
                                @php
                                    $jadwal = preg_split("/\r\n|\n|\r/", trim($lokasi->jam_buka));
                                @endphp
                                @foreach($jadwal as $item)
                                    @php
                                        $parts = explode('|', $item);
                                        $hari = trim($parts[0] ?? '');
                                        $jam  = trim($parts[1] ?? '');
                                    @endphp
                                    @if($hari && $jam)
                                    <div class="d-flex justify-content-between border-bottom py-1">
                                        <span class="text-muted">{{ $hari }}</span>
                                        <span class="fw-semibold">{{ $jam }}</span>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <h6 class="fw-bold"><i class="bi bi-star-fill text-danger me-2"></i>Fasilitas Unggulan</h6>
                            <ul class="list-unstyled small text-muted">
                                @foreach(array_slice(explode("\n", $lokasi->fasilitas_klub), 0, 4) as $fasilitas)
                                    @if(trim($fasilitas) != '')
                                    <li class="mb-1"><i class="bi bi-check2-circle text-success me-1"></i> {{ $fasilitas }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="mt-2 p-3 bg-light rounded-4">
                        <h6 class="fw-bold mb-3"><i class="bi bi-person-badge-fill text-danger me-2"></i>Instruktur di Cabang Ini:</h6>
                        <div class="row g-2">
                            @forelse($lokasi->instrukturs as $instruktur)
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center p-2 bg-white border rounded shadow-sm">
                                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="bi bi-person-fill fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold" style="font-size: 0.9rem;">{{ $instruktur->nama }}</h6>
                                            <small class="text-muted" style="font-size: 0.8rem;">{{ $instruktur->spesialisasi ?? 'General Trainer' }}</small>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p class="text-muted small mb-0"><em>Belum ada instruktur yang ditugaskan di cabang ini.</em></p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @endforeach

    </div>
</section>

@endsection