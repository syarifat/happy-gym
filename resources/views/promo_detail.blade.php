@extends('layouts.frontend')

@section('content')
<div class="container py-5" style="margin-top: 80px; min-height: 80vh;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                @if($pengumuman->foto)
                    <img src="{{ asset('storage/' . $pengumuman->foto) }}" class="card-img-top w-100" style="max-height: 400px; object-fit: cover;" alt="Promo Banner">
                @endif
                <div class="card-body p-5">
                    <span class="badge bg-danger mb-3 px-3 py-2 fs-6">{{ \Carbon\Carbon::parse($pengumuman->tanggal_post)->format('d M Y') }}</span>
                    <h1 class="fw-bold text-dark mb-4">{{ $pengumuman->judul }}</h1>
                    
                    <div class="text-secondary fs-5" style="line-height: 1.8;">
                        {!! nl2br(e($pengumuman->deskripsi)) !!}
                    </div>

                    <div class="mt-5 pt-4 border-top">
                        <a href="{{ route('landing.index') }}#pengumuman" class="btn btn-outline-danger px-4 py-2 mt-2">
                            <i class="bi bi-arrow-left"></i> Kembali ke Halaman Utama
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
