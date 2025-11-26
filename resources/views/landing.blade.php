@extends('layouts.landing')

@section('title', 'BKK & Tracer Study')

@section('hero-section')
<!--begin::Landing hero-->
<div class="d-flex flex-column flex-center w-100 min-h-400px min-h-lg-500px px-9">
    <!--begin::Heading-->
    <div class="text-center mb-3 mb-lg-5 py-6 py-lg-10">
        <!--begin::Title-->
        <h1 class="text-white lh-base fw-bolder fs-2hx mb-6">
            Selamat Datang di BKK & Tracer Study
            <br />SMK Teratai Putih Global 4
            <br />dengan
            <span style="background: linear-gradient(to right, #12CE5D 0%, #FFD80C 100%);background-clip: text;-webkit-background-clip: text;-webkit-text-fill-color: transparent;">
                <span id="kt_landing_hero_text">Tracer Alumni</span>
            </span>
        </h1>
        <!--end::Title-->
        <!--begin::Description-->
        <div class="fs-5 text-white mb-6">
        </div>
        <!--end::Description-->
    </div>
    <!--end::Heading-->
    <!--begin::Statistics-->
    <div class="d-flex flex-center flex-nowrap position-relative px-2 px-md-5 gap-3 gap-md-8 gap-lg-12 overflow-auto">
        <!--begin::Statistic-->
        <div class="d-flex flex-center flex-shrink-0 mx-1 mx-md-3">
            <div class="d-flex align-items-center">
                <!--begin::Icon-->
                <div class="symbol symbol-35px symbol-md-45px symbol-lg-50px me-2 me-md-3">
                    <div class="symbol-label" style="background-color:rgb(36, 54, 82);">
                        <span class="svg-icon svg-icon-white svg-icon-1 svg-icon-md-2x svg-icon-lg-2hx">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                                <path opacity="0.3" d="M8.9 21L7.19999 22.6999C6.79999 23.0999 6.2 23.0999 5.8 22.6999L4.1 21H8.9ZM4 16.0999L2.3 17.8C1.9 18.2 1.9 18.7999 2.3 19.1999L4 20.9V16.0999ZM19.3 9.1999L15.8 5.6999C15.4 5.2999 14.8 5.2999 14.4 5.6999L9 11.0999V21L19.3 10.6999C19.7 10.2999 19.7 9.5999 19.3 9.1999Z" fill="black" />
                                <path d="M21 15V20C21 20.6 20.6 21 20 21H11.8L18.8 14H20C20.6 14 21 14.4 21 15ZM10 21V4C10 3.4 9.6 3 9 3H4C3.4 3 3 3.4 3 4V21C3 21.6 3.4 22 4 22H9C9.6 22 10 21.6 10 21ZM7.5 18.5C7.5 19.1 7.1 19.5 6.5 19.5C5.9 19.5 5.5 19.1 5.5 18.5C5.5 17.9 5.9 17.5 6.5 17.5C7.1 17.5 7.5 17.9 7.5 18.5Z" fill="black" />
                            </svg>
                        </span>
                    </div>
                </div>
                <!--end::Icon-->
                <!--begin::Text-->
                <div class="d-flex flex-column flex-md-row align-items-baseline gap-1 gap-md-2">
                    <div class="fs-3 fs-md-2hx fw-bold text-white">{{ $lowongans->count() }}</div>
                    <div class="fs-8 fs-md-6 fw-bold text-gray-300 text-nowrap">Lowongan Tersedia</div>
                </div>
                <!--end::Text-->
            </div>
        </div>
        <!--end::Statistic-->
        <!--begin::Statistic-->
        <div class="d-flex flex-center flex-shrink-0 mx-1 mx-md-3">
            <div class="d-flex align-items-center">
                <!--begin::Icon-->
                <div class="symbol symbol-35px symbol-md-45px symbol-lg-50px me-2 me-md-3">
                    <div class="symbol-label" style="background-color:rgb(36, 54, 82);">
                        <i class="fa-solid fa-building text-white fs-3 fs-md-2x fs-lg-2hx"></i>
                    </div>
                </div>
                <!--end::Icon-->
                <!--begin::Text-->
                <div class="d-flex flex-column flex-md-row align-items-baseline gap-1 gap-md-2">
                    <div class="fs-3 fs-md-2hx fw-bold text-white">{{ $perusahaans->count() }}</div>
                    <div class="fs-8 fs-md-6 fw-bold text-gray-300 text-nowrap">Perusahaan</div>
                </div>
                <!--end::Text-->
            </div>
        </div>
        <!--end::Statistic-->
        <!--begin::Statistic-->
        <div class="d-flex flex-center flex-shrink-0 mx-1 mx-md-3">
            <div class="d-flex align-items-center">
                <!--begin::Icon-->
                <div class="symbol symbol-35px symbol-md-45px symbol-lg-50px me-2 me-md-3">
                    <div class="symbol-label" style="background-color:rgb(36, 54, 82);">
                        <span class="svg-icon svg-icon-white svg-icon-1 svg-icon-md-2x svg-icon-lg-2hx">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M16.0173 9H15.3945C14.2833 9 13.263 9.61425 12.7431 10.5963L12.154 11.7091C12.0645 11.8781 12.1072 12.0868 12.2559 12.2071L12.6402 12.5183C13.2631 13.0225 13.7556 13.6691 14.0764 14.4035L14.2321 14.7601C14.2957 14.9058 14.4396 15 14.5987 15H18.6747C19.7297 15 20.4057 13.8774 19.912 12.945L18.6686 10.5963C18.1487 9.61425 17.1285 9 16.0173 9Z" fill="black" />
                                <rect opacity="0.3" x="14" y="4" width="4" height="4" rx="2" fill="black" />
                                <path d="M4.65486 14.8559C5.40389 13.1224 7.11161 12 9 12C10.8884 12 12.5961 13.1224 13.3451 14.8559L14.793 18.2067C15.3636 19.5271 14.3955 21 12.9571 21H5.04292C3.60453 21 2.63644 19.5271 3.20698 18.2067L4.65486 14.8559Z" fill="black" />
                                <rect opacity="0.3" x="6" y="5" width="6" height="6" rx="3" fill="black" />
                            </svg>
                        </span>
                    </div>
                </div>
                <!--end::Icon-->
                <!--begin::Text-->
                <div class="d-flex flex-column flex-md-row align-items-baseline gap-1 gap-md-2">
                    <div class="fs-3 fs-md-2hx fw-bold text-white">{{ $users->count() }}+</div>
                    <div class="fs-8 fs-md-6 fw-bold text-gray-300 text-nowrap">Pencari Kerja</div>
                </div>
                <!--end::Text-->
            </div>
        </div>
        <!--end::Statistic-->
    </div>
    <!--end::Statistics-->
</div>
<!--end::Landing hero-->
@endsection

@section('content')

<!--begin::Lowongan Kerja Section-->
<div class="mb-n10 mb-lg-n20 z-index-2 pt-20">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Heading-->
        <div class="text-center mb-17">
            <!--begin::Badge-->
            <span class="badge badge-lg badge-light-primary mb-5">
                <i class="bi bi-briefcase-fill me-2"></i>Lowongan Terbaru
            </span>
            <!--end::Badge-->
            <!--begin::Title-->
            <h3 class="fs-2hx text-dark fw-bolder mb-5">
                Temukan Karir Impian Anda
            </h3>
            <!--end::Title-->
            <!--begin::Text-->
            <div class="fs-5 text-gray-600 fw-semibold">
                Ratusan peluang kerja menanti dari perusahaan terpercaya
            </div>
            <!--end::Text-->
        </div>
        <!--end::Heading-->
        <!--begin::Lowongan Cards-->
        <div class="row g-6 g-xl-9 mb-6 mb-xl-9">
            @forelse($lowongans as $lowongan)
            <!--begin::Col-->
            <div class="col-md-6 col-lg-4">
                <!--begin::Card-->
                <div class="card h-100 shadow-sm hover-elevate-up transition-all" style="border-radius: 0.75rem; border: 1px solid #e4e6ef;">
                    <!--begin::Card body-->
                    <div class="card-body d-flex flex-column p-8">
                        <!--begin::Header-->
                        <div class="d-flex align-items-center justify-content-between mb-5">
                            <!--begin::Logo-->
                            <div class="symbol symbol-60px">
                                @php($logo = optional($lowongan->perusahaan)->logo)
                                @if($logo)
                                <span class="symbol-label bg-light-primary">
                                    <img src="{{ asset('storage/' . $logo) }}" alt="logo" class="w-100 h-100" style="object-fit: contain; padding: 8px;" />
                                </span>
                                @else
                                <span class="symbol-label bg-light-primary text-primary fs-2 fw-bold">
                                    {{ Str::upper(substr(optional($lowongan->perusahaan)->nama_perusahaan ?? 'PR', 0, 2)) }}
                                </span>
                                @endif
                            </div>
                            <!--end::Logo-->
                            <!--begin::Badge-->
                            <span class="badge badge-light-success fw-bold">
                                {{ $lowongan->tanggal_dibuat ? \Carbon\Carbon::parse($lowongan->tanggal_dibuat)->diffForHumans() : 'Baru' }}
                            </span>
                            <!--end::Badge-->
                        </div>
                        <!--end::Header-->

                        <!--begin::Title-->
                        <a href="{{ route('lowongan.show', $lowongan->id) }}" class="text-gray-900 text-hover-primary fs-4 fw-bold mb-3 text-decoration-none">
                            {{ $lowongan->judul }}
                        </a>
                        <!--end::Title-->

                        <!--begin::Company-->
                        <div class="text-gray-600 fw-semibold fs-6 mb-5">
                            <i class="bi bi-building me-2 text-primary"></i>{{ optional($lowongan->perusahaan)->nama_perusahaan ?? 'Perusahaan' }}
                        </div>
                        <!--end::Company-->

                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-5"></div>
                        <!--end::Separator-->

                        <!--begin::Info-->
                        <div class="d-flex flex-column gap-3 mb-7">
                            <!--begin::Posisi-->
                            <div class="d-flex align-items-center">
                                <i class="bi bi-person-badge text-gray-500 fs-5 me-3"></i>
                                <span class="text-gray-700 fw-semibold fs-7">{{ $lowongan->posisi }}</span>
                            </div>
                            <!--end::Posisi-->
                            <!--begin::Lokasi-->
                            <div class="d-flex align-items-center">
                                <i class="bi bi-geo-alt text-gray-500 fs-5 me-3"></i>
                                <span class="text-gray-700 fw-semibold fs-7">{{ Str::limit(optional($lowongan->perusahaan)->alamat ?? 'Lokasi tidak tersedia', 30) }}</span>
                            </div>
                            <!--end::Lokasi-->
                            <!--begin::Deadline-->
                            @if($lowongan->batas_lamaran)
                            <div class="d-flex align-items-center">
                                <i class="bi bi-clock text-gray-500 fs-5 me-3"></i>
                                <span class="text-gray-700 fw-semibold fs-7">Batas: {{ \Carbon\Carbon::parse($lowongan->batas_lamaran)->format('d M Y') }}</span>
                            </div>
                            @endif
                            <!--end::Deadline-->
                        </div>
                        <!--end::Info-->

                        <!--begin::Action-->
                        <div class="mt-auto">
                            <a href="{{ route('lowongan.show', $lowongan->id) }}" class="btn btn-primary w-100">
                                <i class="bi bi-arrow-right-circle me-2"></i>Lihat Detail
                            </a>
                        </div>
                        <!--end::Action-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Col-->
            @empty
            <!--begin::Empty State-->
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body text-center py-20">
                        <i class="bi bi-inbox fs-5x text-gray-400 mb-5"></i>
                        <h3 class="fs-2 fw-bold text-gray-800 mb-3">Belum Ada Lowongan</h3>
                        <p class="fs-5 text-gray-600 mb-5">Saat ini belum ada lowongan kerja yang tersedia.<br />Pantau terus untuk update lowongan terbaru!</p>
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            <i class="bi bi-bell me-2"></i>Daftar untuk Notifikasi
                        </a>
                    </div>
                </div>
            </div>
            <!--end::Empty State-->
            @endforelse
        </div>
        <!--end::Lowongan Cards-->

        <!--begin::Action-->
        <div class="text-center">
            <a href="{{ route('lowongan') }}" class="btn btn-lg btn-primary">
                <i class="bi bi-grid-3x3-gap me-2"></i>Lihat Semua Lowongan
            </a>
        </div>
        <!--end::Action-->
    </div>
    <!--end::Container-->

</div>
<!--end::Lowongan Kerja Section-->

<!--begin::Perusahaan Terpercaya Section-->
<div class="pt-20 pt-lg-40">
    <!--begin::Wrapper-->
    <div class="pb-15 pt-18 bg-white">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Heading-->
            <div class="text-center mt-15 mb-18">
                <!--begin::Badge-->
                <span class="badge badge-lg badge-light-success mb-5">
                    <i class="bi bi-buildings-fill me-2"></i>Perusahaan Terpercaya
                </span>
                <!--end::Badge-->
                <!--begin::Title-->
                <h3 class="fs-2hx text-dark fw-bolder mb-5">Perusahaan Terpercaya</h3>
                <!--end::Title-->
                <!--begin::Description-->
                <div class="fs-5 text-gray-600 fw-semibold">
                    Bekerja sama dengan perusahaan-perusahaan terbaik di Indonesia
                </div>
                <!--end::Description-->
            </div>
            <!--end::Heading-->
            <!--begin::Perusahaan Grid-->
            <div class="row g-6 g-xl-9 mb-20">
                @forelse($perusahaans as $perusahaan)
                <!--begin::Col-->
                <div class="col-lg-4 col-md-6">
                    <!--begin::Card-->
                    <div class="card h-100 shadow-sm hover-elevate-up" style="border-radius: 0.75rem; border: 1px solid #e4e6ef;">
                        <!--begin::Card body-->
                        <div class="card-body d-flex flex-column p-8">
                            <!--begin::Logo-->
                            <div class="d-flex align-items-center mb-6">
                                @if($perusahaan->logo)
                                <div class="symbol symbol-70px me-4">
                                    <span class="symbol-label bg-light-primary">
                                        <img src="{{ asset('storage/' . $perusahaan->logo) }}" alt="{{ $perusahaan->nama_perusahaan }}" class="w-100 h-100" style="object-fit: contain; padding: 8px;" />
                                    </span>
                                </div>
                                @else
                                <div class="symbol symbol-70px me-4">
                                    <div class="symbol-label bg-light-primary">
                                        <span class="fs-2x fw-bold text-primary">{{ strtoupper(substr($perusahaan->nama_perusahaan, 0, 2)) }}</span>
                                    </div>
                                </div>
                                @endif
                                <!--begin::Company Name-->
                                <div class="flex-grow-1">
                                    <a href="{{ route('perusahaan.show', $perusahaan->id) }}" class="text-gray-900 text-hover-primary fs-4 fw-bold text-decoration-none d-block">
                                        {{ $perusahaan->nama_perusahaan }}
                                    </a>
                                    <span class="badge badge-light-primary mt-2">Partner</span>
                                </div>
                                <!--end::Company Name-->
                            </div>
                            <!--end::Logo-->

                            <!--begin::Separator-->
                            <div class="separator separator-dashed mb-6"></div>
                            <!--end::Separator-->

                            <!--begin::Address-->
                            <div class="d-flex align-items-start mb-5">
                                <i class="bi bi-geo-alt-fill text-primary me-3 fs-4"></i>
                                <span class="text-gray-700 fw-semibold fs-6 text-start">{{ $perusahaan->alamat ?? 'Alamat tidak tersedia' }}</span>
                            </div>
                            <!--end::Address-->

                            <!--begin::Action-->
                            <!-- <div class="mt-auto">
                                <a href="{{ route('perusahaan.show', $perusahaan->id) }}" class="btn btn-light-primary w-100">
                                    <i class="bi bi-eye me-2"></i>Lihat Profil
                                </a>
                            </div> -->
                            <!--end::Action-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Col-->
                @empty
                <!--begin::Empty State-->
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body text-center py-20">
                            <i class="bi bi-building fs-5x text-gray-400 mb-5"></i>
                            <h3 class="fs-2 fw-bold text-gray-800 mb-3">Belum Ada Perusahaan</h3>
                            <p class="fs-5 text-gray-600 mb-0">Saat ini belum ada perusahaan mitra terdaftar.<br />Hubungi kami untuk menjadi mitra perusahaan.</p>
                        </div>
                    </div>
                </div>
                <!--end::Empty State-->
                @endforelse
            </div>
            <!--end::Perusahaan Grid-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Perusahaan Terpercaya Section-->


<!--begin::Kontak Section-->
<div class="mt-sm-n10" id="kontak">
    <!--begin::Curve top-->
    <div class="landing-curve landing-dark-color">
        <svg viewBox="15 -1 1470 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1 48C4.93573 47.6644 8.85984 47.3311 12.7725 47H1489.16C1493.1 47.3311 1497.04 47.6644 1501 48V47H1489.16C914.668 -1.34764 587.282 -1.61174 12.7725 47H1V48Z" fill="currentColor"></path>
        </svg>
    </div>
    <!--end::Curve top-->
    <!--begin::Wrapper-->
    <div class="py-10 landing-dark-bg">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Heading-->
            <div class="text-center mb-12">
                <!--begin::Title-->
                <h3 class="fs-2hx text-white fw-bold mb-5">Hubungi Kami</h3>
                <!--end::Title-->
                <!--begin::Description-->
                <div class="fs-5 text-gray-400 fw-semibold">
                    Siap membantu mengoptimalkan sistem tracer alumni untuk sekolah dan perusahaan Anda
                </div>
                <!--end::Description-->
            </div>
            <!--end::Heading-->
            <!--begin::Contact Info-->
            <div class="row g-10">
                <!--begin::Left Column - Contact Details-->
                <div class="col-lg-6">
                    <!--begin::Alamat-->
                    <div class="d-flex align-items-start mb-8">

                        <div class="flex-grow-1">
                            <h4 class="text-white fw-bold mb-2">Alamat</h4>
                            <div class="text-gray-400 fw-semibold fs-6 lh-lg">
                                SMK Teratai Putih Global 4<br />
                                Jl. Pendidikan No. 123, Kelurahan XYZ<br />
                                Jakarta Selatan 12345, Indonesia
                            </div>
                        </div>
                    </div>
                    <!--end::Alamat-->

                    <!--begin::Email-->
                    <div class="d-flex align-items-start mb-8">

                        <div class="flex-grow-1">
                            <h4 class="text-white fw-bold mb-2">Email</h4>
                            <a href="mailto:bkk@smktp4.sch.id" class="text-gray-400 text-hover-primary fw-semibold fs-6">
                                bkk@smktp4.sch.id
                            </a>
                        </div>
                    </div>
                    <!--end::Email-->

                    <!--begin::Telepon-->
                    <div class="d-flex align-items-start">

                        <div class="flex-grow-1">
                            <h4 class="text-white fw-bold mb-2">Telepon</h4>
                            <a href="tel:+622112345678" class="text-gray-400 text-hover-primary fw-semibold fs-6 d-block mb-1">
                                (021) 1234-5678
                            </a>
                            <div class="text-gray-500 fs-7">Senin - Jumat: 08:00 - 16:00 WIB</div>
                        </div>
                    </div>
                    <!--end::Telepon-->
                </div>
                <!--end::Left Column-->

                <!--begin::Right Column - Social Media-->
                <div class="col-lg-6">
                    <div class="d-flex flex-column align-items-center align-items-lg-start h-100 justify-content-center">
                        <h4 class="text-white fw-bold mb-6">Ikuti Kami</h4>
                        <div class="d-flex flex-wrap gap-4">
                            <a href="#" class="btn btn-icon btn-transparent btn-active-color-primary" style="width: 55px; height: 55px;">
                                <i class="bi bi-facebook fs-2x"></i>
                            </a>
                            <a href="#" class="btn btn-icon btn-transparent btn-active-color-primary" style="width: 55px; height: 55px;">
                                <i class="bi bi-instagram fs-2x"></i>
                            </a>
                            <a href="#" class="btn btn-icon btn-transparent btn-active-color-primary" style="width: 55px; height: 55px;">
                                <i class="bi bi-twitter fs-2x"></i>
                            </a>
                            <a href="#" class="btn btn-icon btn-transparent btn-active-color-primary" style="width: 55px; height: 55px;">
                                <i class="bi bi-youtube fs-2x"></i>
                            </a>
                        </div>
                        <div class="text-gray-400 fs-6 fw-semibold mt-6 text-center text-lg-start">
                            Dapatkan update lowongan kerja terbaru dan<br />informasi kegiatan alumni kami
                        </div>
                    </div>
                </div>
                <!--end::Right Column-->
            </div>
            <!--end::Contact Info-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Kontak Section-->
@endsection

@push('scripts')
<script>
    // Typed.js untuk animasi teks hero
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Typed !== 'undefined') {
            new Typed('#kt_landing_hero_text', {
                strings: [
                    'BKK & Tracer Study',
                    'Perusahaan Terpercaya',
                    'Lowongan Kerja Terbaru',
                    'Tracer Alumni',
                ],
                typeSpeed: 50,
                backSpeed: 30,
                backDelay: 2000,
                loop: true
            });
        }
    });
</script>
@endpush