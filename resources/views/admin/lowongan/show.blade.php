@extends('layouts.app')

@section('title', 'Detail Lowongan')

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="row g-5">
        <!--begin::Main Card-->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-5">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Detail Lowongan</span>
                    </h3>
                    <div class="card-toolbar">
                        <a href="{{ route('admin.lowongan.index') }}" class="btn btn-sm btn-light">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body py-4">
                    <!--begin::Header-->
                    <div class="mb-8">
                        <h2 class="fs-1 fw-bolder text-dark mb-0">{{ $lowongan->judul }}</h2>
                    </div>

                    <div class="separator mb-8"></div>

                    <!--begin::Info Section-->
                    <div class="row g-5 mb-8">
                        <!--begin::Left Column-->
                        <div class="col-md-6">
                            <!--begin::Info Item-->
                            <div class="mb-7">
                                <label class="text-muted fs-6 fw-semibold mb-2">Posisi:</label>
                                <div class="text-dark fs-5 fw-bold">{{ $lowongan->posisi ?? '-' }}</div>
                            </div>
                            <!--end::Info Item-->

                            <!--begin::Info Item-->
                            <div class="mb-7">
                                <label class="text-muted fs-6 fw-semibold mb-2">Pendidikan Minimal:</label>
                                <div class="text-dark fs-5">{{ $lowongan->pendidikan_min ?? '-' }}</div>
                            </div>
                            <!--end::Info Item-->

                            <!--begin::Info Item-->
                            <div class="mb-7">
                                <label class="text-muted fs-6 fw-semibold mb-2">Jurusan:</label>
                                <div class="text-dark fs-5">{{ $lowongan->pendidikan_jurusan ?? '-' }}</div>
                            </div>
                            <!--end::Info Item-->
                        </div>
                        <!--end::Left Column-->

                        <!--begin::Right Column-->
                        <div class="col-md-6">
                            <!--begin::Info Item-->
                            <div class="mb-7">
                                <label class="text-muted fs-6 fw-semibold mb-2">Tanggal Dibuat:</label>
                                <div class="text-dark fs-5">{{ $lowongan->tanggal_dibuat ? \Carbon\Carbon::parse($lowongan->tanggal_dibuat)->format('d M Y') : '-' }}</div>
                            </div>
                            <!--end::Info Item-->

                            <!--begin::Info Item-->
                            <div class="mb-7">
                                <label class="text-muted fs-6 fw-semibold mb-2">Batas Lamaran:</label>
                                <div class="text-dark fs-5">{{ $lowongan->batas_lamaran ? \Carbon\Carbon::parse($lowongan->batas_lamaran)->format('d M Y') : '-' }}</div>
                            </div>
                            <!--end::Info Item-->

                            <!--begin::Info Item-->
                            <div class="mb-7">
                                <label class="text-muted fs-6 fw-semibold mb-2">Status:</label>
                                <div>
                                    @if($lowongan->status === 'aktif')
                                    <span class="badge badge-light-success fs-7 fw-bold">Aktif</span>
                                    @else
                                    <span class="badge badge-light-danger fs-7 fw-bold">Nonaktif</span>
                                    @endif
                                </div>
                            </div>
                            <!--end::Info Item-->
                        </div>
                        <!--end::Right Column-->
                    </div>
                    <!--end::Info Section-->

                    <div class="separator mb-8"></div>

                    <!--begin::Description Section-->
                    <div class="mb-7">
                        <label class="text-muted fs-6 fw-semibold mb-3">Deskripsi Lowongan:</label>
                        <div class="text-dark fs-5 lh-lg">
                            {!! nl2br(e($lowongan->deskripsi ?? '-')) !!}
                        </div>
                    </div>
                    <!--end::Description Section-->
                </div>
            </div>
        </div>
        <!--end::Main Card-->

        <!--begin::Sidebar-->
        <div class="col-lg-4">
            <!--begin::Company Card-->
            <div class="card shadow-sm mb-5">
                <div class="card-body p-9">
                    <h3 class="fs-3 fw-bolder text-dark mb-5">Informasi Perusahaan</h3>

                    <!--begin::Company Info-->
                    @if($lowongan->perusahaan)
                    <div class="text-center mb-7">
                        <div class="symbol symbol-100px mb-5">
                            @if($lowongan->perusahaan->logo)
                            <img src="{{ asset('storage/' . $lowongan->perusahaan->logo) }}"
                                alt="{{ $lowongan->perusahaan->nama_perusahaan }}"
                                style="object-fit: contain;" />
                            @else
                            <div class="symbol-label bg-light-primary">
                                <span class="fs-2 fw-bold text-primary">{{ strtoupper(substr($lowongan->perusahaan->nama_perusahaan, 0, 2)) }}</span>
                            </div>
                            @endif
                        </div>
                        <h4 class="fs-4 fw-bold text-dark mb-1">{{ $lowongan->perusahaan->nama_perusahaan }}</h4>
                    </div>

                    <div class="separator mb-5"></div>

                    <!--begin::Contact Details-->
                    @if($lowongan->perusahaan->alamat)
                    <div class="d-flex align-items-start mb-5">
                        <i class="fas fa-map-marker-alt text-primary fs-4 me-3 mt-1"></i>
                        <div>
                            <div class="text-muted fs-7 fw-semibold mb-1">Alamat</div>
                            <div class="text-gray-800 fs-6">{{ $lowongan->perusahaan->alamat }}</div>
                        </div>
                    </div>
                    @endif

                    @if($lowongan->perusahaan->email)
                    <div class="d-flex align-items-start mb-5">
                        <i class="fas fa-envelope text-success fs-4 me-3 mt-1"></i>
                        <div>
                            <div class="text-muted fs-7 fw-semibold mb-1">Email</div>
                            <div class="text-gray-800 fs-6">{{ $lowongan->perusahaan->email }}</div>
                        </div>
                    </div>
                    @endif

                    @if($lowongan->perusahaan->kontak)
                    <div class="d-flex align-items-start mb-5">
                        <i class="fas fa-phone text-info fs-4 me-3 mt-1"></i>
                        <div>
                            <div class="text-muted fs-7 fw-semibold mb-1">Kontak</div>
                            <div class="text-gray-800 fs-6">{{ $lowongan->perusahaan->kontak }}</div>
                        </div>
                    </div>
                    @endif
                    <!--end::Contact Details-->

                    @if($lowongan->perusahaan->deskripsi)
                    <div class="separator my-5"></div>
                    <div>
                        <div class="text-muted fs-7 fw-semibold mb-2">Tentang Perusahaan</div>
                        <div class="text-gray-700 fs-7 lh-base">{{ Str::limit($lowongan->perusahaan->deskripsi, 200) }}</div>
                    </div>
                    @endif

                    <div class="separator my-5"></div>

                    <a href="{{ route('admin.perusahaan.show', $lowongan->perusahaan->id) }}" class="btn btn-light-primary w-100">
                        <i class="fas fa-building me-2"></i>Lihat Detail Perusahaan
                    </a>
                    @else
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-building fs-3x mb-3"></i>
                        <p>Informasi perusahaan tidak tersedia</p>
                    </div>
                    @endif
                    <!--end::Company Info-->
                </div>
            </div>
            <!--end::Company Card-->
        </div>
        <!--end::Sidebar-->
    </div>
</div>
@endsection