@extends('layouts.auth')

@section('content')
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-column-fluid  bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(assets/media/illustrations/dozzy-1/14.png)">
        <!--begin::Content-->
        <div class=" d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
            <!--begin::Logo-->
            <a href="{{ url('/') }}" class="mb-12">
                <img alt="Logo" src="{{ asset('assets/media/logos/tp4.png') }}" class="logo h-80px" />
            </a>
            <!--end::Logo-->
            <!--begin::Wrapper-->
            <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                <!--begin::Form-->
                <form class="form w-100" method="POST" action="{{ route('login') }}" id="kt_sign_in_form">
                    @csrf
                    <!--begin::Heading-->
                    <div class="text-center mb-10">
                        <!--begin::Title-->
                        <h1 class="text-dark mb-3">Masuk ke BKK & Tracer Study</h1>
                        <!--end::Title-->
                        <!--begin::Link-->
                        <div class="text-gray-400 fw-bold fs-4">Belum punya akun?
                            <a href="{{ route('register') }}" class="link-primary fw-bolder">Daftar Sekarang</a>
                        </div>
                        <!--end::Link-->
                    </div>
                    <!--end::Heading-->
                    <!--begin::Separator-->
                    <div class="d-flex align-items-center mb-10">
                        <div class="border-bottom border-gray-300 mw-50 w-100"></div>
                        <span class="fw-bold text-gray-400 fs-7 mx-2"></span>
                        <div class="border-bottom border-gray-300 mw-50 w-100"></div>
                    </div>
                    <!--end::Separator-->

                    <!--begin::Alert-->
                    @if (session('success'))
                    <div class="alert alert-success d-flex align-items-center p-5 mb-10">
                        <i class="ki-duotone ki-shield-tick fs-2hx text-success me-4">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <div class="d-flex flex-column">
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
                        <i class="ki-duotone ki-shield-cross fs-2hx text-danger me-4">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <div class="d-flex flex-column">
                            @foreach ($errors->all() as $error)
                            <span>{{ $error }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    <!--end::Alert-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="form-label fs-6 fw-bolder text-dark">Email</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-lg form-control-solid @error('email') is-invalid @enderror"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            autofocus
                            required />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack mb-2">
                            <!--begin::Label-->
                            <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                            <!--end::Label-->
                            <!--begin::Link-->
                            <a href="#" class="link-primary fs-6 fw-bolder">Lupa Password?</a>
                            <!--end::Link-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Input-->
                        <input class="form-control form-control-lg form-control-solid @error('password') is-invalid @enderror"
                            type="password"
                            name="password"
                            autocomplete="current-password"
                            required />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Actions-->
                    <div class="text-center">
                        <!--begin::Submit button-->
                        <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                            <span class="indicator-label">Masuk</span>
                            <span class="indicator-progress">Mohon tunggu...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                        <!--end::Submit button-->
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->

                @if ($errors->any())
                <div class="d-none" id="flash" data-flash="error" data-message="{{ $errors->first() }}"></div>
                @endif
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Content-->

        <!--begin::Modal - Rate Limit Warning-->
        <div class="modal fade" id="kt_modal_rate_limit" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header pb-0 border-0 justify-content-end">
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <i class="ki-duotone ki-cross fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                        <!--begin::Icon-->
                        <div class="text-center mb-13">
                            <i class="ki-duotone ki-shield-cross fs-5qx text-danger mb-5">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <h1 class="mb-3 text-danger">Terlalu Banyak Percobaan!</h1>
                            <div class="text-gray-600 fw-semibold fs-5">
                                Akun Anda telah diblokir sementara untuk keamanan.
                            </div>
                        </div>
                        <!--end::Icon-->

                        <!--begin::Alert-->
                        <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6 mb-10">
                            <i class="ki-duotone ki-timer fs-2tx text-warning me-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                            <div class="d-flex flex-stack flex-grow-1">
                                <div class="fw-semibold">
                                    <h4 class="text-gray-900 fw-bold">Mohon Tunggu Sebentar</h4>
                                    <div class="fs-6 text-gray-700">
                                        Anda telah mencoba login terlalu banyak. Silakan tunggu
                                        <span class="fw-bold text-danger">60 detik</span> sebelum mencoba lagi.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Alert-->

                        <!--begin::Info-->
                        <div class="mb-10">
                            <h4 class="text-gray-900 fw-bold mb-5">ℹ️ Mengapa ini terjadi?</h4>
                            <div class="text-gray-700 fs-6 mb-5">
                                Sistem kami mendeteksi terlalu banyak percobaan login dalam waktu singkat.
                                Ini adalah langkah keamanan untuk melindungi akun Anda dari akses tidak sah.
                            </div>
                        </div>
                        <!--end::Info-->

                        <!--begin::Tips-->
                        <div class="mb-10">
                            <h4 class="text-gray-900 fw-bold mb-5">💡 Tips:</h4>
                            <div class="d-flex flex-column gap-3">
                                <div class="d-flex align-items-center">
                                    <i class="ki-duotone ki-check-circle fs-2 text-success me-3">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <span class="text-gray-700">Tunggu 1 menit sebelum mencoba lagi</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="ki-duotone ki-check-circle fs-2 text-success me-3">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <span class="text-gray-700">Pastikan email dan password Anda benar</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="ki-duotone ki-check-circle fs-2 text-success me-3">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <span class="text-gray-700">Gunakan fitur "Lupa Password" jika diperlukan</span>
                                </div>
                            </div>
                        </div>
                        <!--end::Tips-->

                        <!--begin::Actions-->
                        <div class="text-center">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                                <i class="ki-duotone ki-check fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Saya Mengerti
                            </button>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Modal body-->
                </div>
            </div>
        </div>
        <!--end::Modal - Rate Limit Warning-->

        <!--begin::Footer-->
        <div class="d-flex flex-center flex-column-auto p-10">
            <!--begin::Links-->
            <div class="d-flex align-items-center fw-bold fs-6">
                <span class="text-muted">© {{ date('Y') }} BKK & Tracer Study</span>
            </div>
            <!--end::Links-->
        </div>
        <!--end::Footer-->
    </div>
    <!--end::Authentication - Sign-in-->
</div>
<!--end::Main-->

@push('scripts')
<script>
    // Check if there's a rate limit error
    document.addEventListener('DOMContentLoaded', function() {
        var flashError = document.getElementById('flash');

        if (flashError && flashError.dataset.flash === 'error') {
            var errorMessage = flashError.dataset.message;

            // Check if error message contains rate limit keywords
            if (errorMessage && (
                    errorMessage.toLowerCase().includes('too many') ||
                    errorMessage.toLowerCase().includes('terlalu banyak') ||
                    errorMessage.toLowerCase().includes('throttle')
                )) {
                // Show rate limit modal
                var modal = new bootstrap.Modal(document.getElementById('kt_modal_rate_limit'));
                modal.show();
            }
        }
    });
</script>
@endpush

@endsection