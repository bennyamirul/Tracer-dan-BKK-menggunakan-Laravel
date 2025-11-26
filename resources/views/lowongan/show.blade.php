@extends('layouts.landing')

@section('title', 'Detail Lowongan')
@section('content')
<!--begin::Header Section (Simple)-->
<div class="mb-0 bg-light py-5">
    <div class="container-xxl">
        <div class="d-flex align-items-center">
            <a href="{{ route('lowongan') }}" class="btn btn-sm btn-light me-3">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h1 class="fs-2x fw-bold text-dark mb-0">Detail Lowongan</h1>
            </div>
        </div>
    </div>
</div>
<!--end::Header Section-->

<!--begin::Content-->
<div class="container-xxl py-10">
    <!--begin::Success/Error Alert-->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-5" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-5" role="alert">
        <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @auth
    @if(!$hasApplied && !$isComplete)
    <div class="alert alert-warning d-flex align-items-center mb-5" role="alert">
        <i class="bi bi-exclamation-triangle fs-2x me-4"></i>
        <div class="flex-grow-1">
            <h4 class="alert-heading fw-bold mb-1">Data Belum Lengkap</h4>
            <p class="mb-2">Anda harus mengisi data diri, data tracer alumni, dan mengupload berkas terlebih dahulu sebelum melamar lowongan.</p>
            <ul class="mb-2">
                @foreach($missingData as $data)
                <li>{{ $data }} belum lengkap</li>
                @endforeach
            </ul>
            <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-warning fw-bold">
                <i class="bi bi-pencil me-1"></i>Isi Data Sekarang
            </a>
        </div>
    </div>
    @endif
    @endauth
    <!--end::Success/Error Alert-->

    <div class="row g-5">
        <!--begin::Main Card-->
        <div class="col-lg-8">
            <div class="card shadow-sm" style="border-radius: 0.625rem;">
                <div class="card-body p-10" style="border-radius: 0.625rem;">
                    <!--begin::Header with Update Button-->
                    <div class="d-flex justify-content-between align-items-start mb-8">
                        <div>
                            <h2 class="fs-1 fw-bolder text-dark mb-0">{{ $lowongan->judul }}</h2>
                        </div>
                        @auth
                        @if($hasApplied)
                        <button type="button" class="btn btn-success" disabled>
                            <i class="bi bi-check-circle me-2"></i>Sudah Melamar
                        </button>
                        @elseif(!$isComplete)
                        <a href="{{ route('profile.edit') }}" class="btn btn-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>Isi Data Dulu
                        </a>
                        @else
                        <form action="{{ route('lowongan.apply', $lowongan->id) }}" method="POST" id="applyForm" class="d-inline">
                            @csrf
                            <button type="button" class="btn btn-primary" id="btnApply" data-kt-indicator-label="Lamar Sekarang">
                                <span class="indicator-label">
                                    <i class="bi bi-send me-2"></i>Lamar Sekarang
                                </span>
                                <span class="indicator-progress">
                                    Mohon tunggu... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </form>
                        @endif
                        @else
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            Login untuk Melamar
                        </a>
                        @endauth
                    </div>
                    <!--end::Header-->

                    <div class="separator mb-8"></div>

                    <!--begin::Billing Address Section-->
                    <div class="row g-5">
                        <!--begin::Left Column-->
                        <div class="col-md-6">
                            <!--begin::Info Item-->
                            <div class="mb-7">
                                <label class="text-muted fs-6 fw-normal mb-2">Posisi:</label>
                                <div class="text-dark fs-5">{{ $lowongan->posisi ?? '-' }}</div>
                            </div>
                            <!--end::Info Item-->

                            <!--begin::Info Item-->
                            <div class="mb-7">
                                <label class="text-muted fs-6 fw-normal mb-2">Pendidikan Minimal:</label>
                                <div class="text-dark fs-5">{{ $lowongan->pendidikan_min ?? '-' }}</div>
                            </div>
                            <!--end::Info Item-->

                            <!--begin::Info Item-->
                            <div class="mb-7">
                                <label class="text-muted fs-6 fw-normal mb-2">Jurusan:</label>
                                <div class="text-dark fs-5">{{ $lowongan->pendidikan_jurusan ?? '-' }}</div>
                            </div>
                            <!--end::Info Item-->
                        </div>
                        <!--end::Left Column-->

                        <!--begin::Right Column-->
                        <div class="col-md-6">
                            <!--begin::Info Item-->
                            <div class="mb-7">
                                <label class="text-muted fs-6 fw-normal mb-2">Tanggal Dibuat:</label>
                                <div class="text-dark fs-5">{{ $lowongan->tanggal_dibuat ? \Carbon\Carbon::parse($lowongan->tanggal_dibuat)->format('d M Y') : '-' }}</div>
                            </div>
                            <!--end::Info Item-->

                            <!--begin::Info Item-->
                            <div class="mb-7">
                                <label class="text-muted fs-6 fw-normal mb-2">Batas Lamaran:</label>
                                <div class="text-dark fs-5">{{ $lowongan->batas_lamaran ? \Carbon\Carbon::parse($lowongan->batas_lamaran)->format('d M Y') : '-' }}</div>
                            </div>
                            <!--end::Info Item-->

                            <!--begin::Info Item-->
                            <div class="mb-7">
                                <label class="text-muted fs-6 fw-normal mb-2">Status:</label>
                                <div>
                                    @if($lowongan->status === 'aktif')
                                    <span class="badge badge-light-success fs-7 fw-bold px-4 py-2">Aktif</span>
                                    @else
                                    <span class="badge badge-light-danger fs-7 fw-bold px-4 py-2">Nonaktif</span>
                                    @endif
                                </div>
                            </div>
                            <!--end::Info Item-->
                        </div>
                        <!--end::Right Column-->
                    </div>
                    <!--end::Billing Address Section-->

                    <div class="separator my-8"></div>

                    <!--begin::Description Section-->
                    <div class="mb-7">
                        <label class="text-muted fs-6 fw-normal mb-3">Deskripsi Lowongan:</label>
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
            <div class="card shadow-sm" style="border-radius: 0.625rem;">
                <div class="card-body p-9" style="border-radius: 0.625rem;">
                    <h3 class="fs-3 fw-bolder text-dark mb-5">Informasi Perusahaan</h3>

                    <!--begin::Company Info-->
                    @if($lowongan->perusahaan)
                    <div class="text-center mb-7">
                        <div class="symbol symbol-100px mb-5">
                            @if($lowongan->perusahaan->logo)
                            <img src="{{ asset('storage/' . $lowongan->perusahaan->logo) }}" alt="{{ $lowongan->perusahaan->nama_perusahaan }}" style="object-fit: contain; border-radius: 0.625rem;" />
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
                        <i class="bi bi-geo-alt-fill text-primary fs-4 me-3 mt-1"></i>
                        <div>
                            <div class="text-muted fs-7 fw-semibold mb-1">Alamat</div>
                            <div class="text-gray-800 fs-6">{{ $lowongan->perusahaan->alamat }}</div>
                        </div>
                    </div>
                    @endif

                    @if($lowongan->perusahaan->email)
                    <div class="d-flex align-items-start mb-5">
                        <i class="bi bi-envelope-fill text-success fs-4 me-3 mt-1"></i>
                        <div>
                            <div class="text-muted fs-7 fw-semibold mb-1">Email</div>
                            <div class="text-gray-800 fs-6">{{ $lowongan->perusahaan->email }}</div>
                        </div>
                    </div>
                    @endif

                    @if($lowongan->perusahaan->kontak)
                    <div class="d-flex align-items-start mb-5">
                        <i class="bi bi-telephone-fill text-info fs-4 me-3 mt-1"></i>
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

                    <a href="{{ route('perusahaan.show', $lowongan->perusahaan->id) }}" class="btn btn-light-primary w-100">
                        Lihat Detail Perusahaan
                    </a>
                    @else
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-building fs-3x mb-3"></i>
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
<!--end::Content-->
@endsection

@push('scripts')
<script>
    // Handle apply button with SweetAlert2 confirmation
    const btnApply = document.getElementById('btnApply');
    if (btnApply) {
        btnApply.addEventListener('click', function(e) {
            e.preventDefault();

            Swal.fire({
                text: "Apakah Anda yakin ingin melamar lowongan ini?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Ya, Lamar Sekarang!",
                cancelButtonText: "Batal",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function(result) {
                if (result.value) {
                    // Show loading indicator
                    btnApply.setAttribute('data-kt-indicator', 'on');
                    btnApply.disabled = true;

                    // Submit the form
                    document.getElementById('applyForm').submit();
                }
            });
        });
    }
</script>
@endpush