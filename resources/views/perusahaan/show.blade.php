@extends('layouts.landing')

@section('title', 'Detail Perusahaan')
@section('content')
<div class="container py-10">
    <!--begin::Page Header-->
    <div class="d-flex flex-wrap flex-stack mb-6">
        <h1 class="fs-2x fw-bold my-2">{{ $perusahaan->nama_perusahaan }}</h1>
        <div class="d-flex align-items-center my-2">
            <a href="{{ route('perusahaan') }}" class="btn btn-sm btn-light">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    <!--end::Page Header-->

    <!--begin::Card-->
    <div class="card shadow-sm">
        <!--begin::Body-->
        <div class="card-body p-10">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10">
                <!--begin::Col - Info Perusahaan-->
                <div class="col-lg-4">
                    <!--begin::Card-->
                    <div class="card card-bordered">
                        <div class="card-body text-center p-10">
                            <!--begin::Logo-->
                            <div class="mb-7">
                                @if($perusahaan->logo)
                                <img src="{{ asset('storage/' . $perusahaan->logo) }}" alt="{{ $perusahaan->nama_perusahaan }}" class="mh-150px mw-100" style="object-fit: contain;" />
                                @else
                                <div class="d-flex align-items-center justify-content-center bg-light rounded" style="height: 150px;">
                                    <span class="fs-3x fw-bold text-gray-600">{{ strtoupper(substr($perusahaan->nama_perusahaan, 0, 2)) }}</span>
                                </div>
                                @endif
                            </div>
                            <!--end::Logo-->

                            <h2 class="fs-2 fw-bold text-dark mb-5">{{ $perusahaan->nama_perusahaan }}</h2>

                            <!--begin::Details-->
                            <div class="text-start">
                                @if($perusahaan->email)
                                <div class="d-flex align-items-center mb-5">
                                    <i class="bi bi-envelope-fill text-primary fs-3 me-3"></i>
                                    <div>
                                        <div class="text-muted fs-7">Email</div>
                                        <div class="fw-semibold fs-6">{{ $perusahaan->email }}</div>
                                    </div>
                                </div>
                                @endif

                                @if($perusahaan->kontak)
                                <div class="d-flex align-items-center mb-5">
                                    <i class="bi bi-telephone-fill text-primary fs-3 me-3"></i>
                                    <div>
                                        <div class="text-muted fs-7">Kontak</div>
                                        <div class="fw-semibold fs-6">{{ $perusahaan->kontak }}</div>
                                    </div>
                                </div>
                                @endif

                                @if($perusahaan->alamat)
                                <div class="d-flex align-items-start mb-5">
                                    <i class="bi bi-geo-alt-fill text-primary fs-3 me-3"></i>
                                    <div>
                                        <div class="text-muted fs-7">Alamat</div>
                                        <div class="fw-semibold fs-6">{{ $perusahaan->alamat }}</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <!--end::Details-->
                        </div>
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Col-->

                <!--begin::Col - Deskripsi & Lowongan-->
                <div class="col-lg-8">
                    <!--begin::Deskripsi-->
                    @if($perusahaan->deskripsi)
                    <div class="card card-bordered mb-5">
                        <div class="card-header">
                            <h3 class="card-title">Tentang Perusahaan</h3>
                        </div>
                        <div class="card-body">
                            <p class="text-gray-700 fs-6">{{ $perusahaan->deskripsi }}</p>
                        </div>
                    </div>
                    @endif
                    <!--end::Deskripsi-->

                    <!--begin::Lowongan-->
                    <div class="card card-bordered">
                        <div class="card-header">
                            <h3 class="card-title">Lowongan Kerja Tersedia</h3>
                        </div>
                        <div class="card-body">
                            @forelse($perusahaan->lowongan as $lowongan)
                            <!--begin::Lowongan Item-->
                            <div class="border border-gray-300 border-dashed rounded p-5 mb-5">
                                <div class="d-flex flex-stack flex-wrap">
                                    <div class="flex-grow-1 me-5">
                                        <h4 class="fs-5 fw-bold text-dark mb-2">{{ $lowongan->posisi }}</h4>
                                        <div class="text-muted fs-7 mb-2">
                                            <i class="bi bi-geo-alt me-1"></i>
                                            {{ $lowongan->lokasi ?? 'Lokasi tidak ditentukan' }}
                                        </div>
                                        @if($lowongan->gaji)
                                        <div class="text-muted fs-7 mb-2">
                                            <i class="bi bi-currency-dollar me-1"></i>
                                            {{ $lowongan->gaji }}
                                        </div>
                                        @endif
                                        <div class="text-muted fs-7">
                                            <i class="bi bi-calendar me-1"></i>
                                            Diposting: {{ $lowongan->created_at->format('d M Y') }}
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-light-success fs-7 fw-bold">{{ ucfirst($lowongan->status) }}</span>
                                    </div>
                                </div>
                                @if($lowongan->deskripsi)
                                <div class="mt-4">
                                    <p class="text-gray-700 fs-7">{{ Str::limit($lowongan->deskripsi, 200) }}</p>
                                </div>
                                @endif
                            </div>
                            <!--end::Lowongan Item-->
                            @empty
                            <div class="text-center py-10">
                                <div class="fs-5 fw-semibold text-muted mb-3">Belum ada lowongan tersedia</div>
                                <p class="text-muted fs-7">Perusahaan ini belum membuka lowongan kerja saat ini</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    <!--end::Lowongan-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Card-->
</div>
@endsection