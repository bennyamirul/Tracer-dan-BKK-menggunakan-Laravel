@extends('layouts.app')

@section('title', 'Data DU/DI')

@section('content')
<div id="kt_content_container" class="container-xxl">
    <!--begin::Alert untuk success message-->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <div class="alert-text font-weight-bold">{{ session('success') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <!--end::Alert-->

    <div class="card mb-5 mb-xl-8">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Data DU/DI</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Total {{ $perusahaans->count() }} DU/DI</span>
            </h3>




            <!-- Modal Tambah Jurusan -->
            <div class="modal fade"
                id="addPerusahaanModal"
                tabindex="-1"
                aria-labelledby="addPerusahaanModalLabel"
                aria-hidden="true"
                data-modal-form
                data-error-text="Maaf, sepertinya ada beberapa kesalahan yang terdeteksi, silakan coba lagi."
                data-cancel-text="Apakah Anda yakin ingin membatalkan penambahan DU/DI?">
                <div class="modal-dialog modal-dialog-centered mw-650px">
                    <div class="modal-content rounded">
                        <!--begin::Modal header-->
                        <div class="modal-header pb-0 border-0 justify-content-end">
                            <!--begin::Close-->
                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                <span class="svg-icon svg-icon-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                        <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </div>
                            <!--end::Close-->
                        </div>
                        <!--end::Modal header-->
                        <!--begin::Modal body-->
                        <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                            <!--begin:Form-->
                            <form id="kt_modal_add_perusahaan_form" action="{{ route('admin.perusahaan.store') }}" method="POST" class="form" enctype="multipart/form-data">
                                @csrf
                                <!--begin::Heading-->
                                <div class="mb-13 text-center">
                                    <!--begin::Title-->
                                    <h1 class="mb-3">Tambah DU/DI Baru</h1>
                                    <!--end::Title-->
                                    <!--begin::Description-->
                                    <div class="text-muted fw-semibold fs-5">Silakan masukkan informasi DU/DI yang akan ditambahkan</div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Heading-->
                                <!--begin::Alert for errors-->
                                @if($errors->any() && old('_method') != 'PUT')
                                <div class="alert alert-danger d-flex align-items-center p-5 mb-8">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                                    <span class="svg-icon svg-icon-2hx svg-icon-danger me-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                                            <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor" />
                                            <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <div class="d-flex flex-column">
                                        <h4 class="mb-1 text-danger">Terdapat kesalahan!</h4>
                                        @foreach($errors->all() as $error)
                                        <span>• {{ $error }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                <!--end::Alert-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Nama DU/DI</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan nama lengkap DU/DI"></i>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text"
                                        class="form-control form-control-solid @error('nama_perusahaan') is-invalid @enderror"
                                        placeholder="Contoh: PT. ABC"
                                        name="nama_perusahaan"
                                        id="perusahaanName"
                                        value="{{ old('nama_perusahaan') }}"
                                        data-validate='{"notEmpty":{"message":"Nama DU/DI harus diisi"},"stringLength":{"min":2,"max":150,"message":"Nama DU/DI harus antara 2-150 karakter"}}' />
                                    @error('nama_perusahaan')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div>{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Email DU/DI</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Email DU/DI"></i>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text"
                                        class="form-control form-control-solid @error('email') is-invalid @enderror"
                                        placeholder="Contoh: example@gmail.com"
                                        name="email"
                                        id="email"
                                        value="{{ old('email') }}"
                                        data-validate='{"notEmpty":{"message":"Email DU/DI harus diisi"},"email":{"message":"Email DU/DI tidak valid"}}' />
                                    @error('email')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div>{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Kontak DU/DI</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Kontak DU/DI"></i>
                                    </label>
                                    <input type="text"
                                        class="form-control form-control-solid @error('kontak') is-invalid @enderror"
                                        placeholder="Contoh: 081234567890"
                                        name="kontak"
                                        id="kontak"
                                        value="{{ old('kontak') }}"
                                        data-validate='' />

                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Alamat DU/DI</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Alamat DU/DI"></i>
                                    </label>
                                    <input type="text"
                                        class="form-control form-control-solid @error('alamat') is-invalid @enderror"
                                        placeholder="Contoh: Jl. Raya No. 123, Jakarta"
                                        name="alamat"
                                        id="alamat"
                                        value="{{ old('alamat') }}"
                                        data-validate='{"notEmpty":{"message":"Alamat DU/DI harus diisi"},"stringLength":{"min":10,"max":255,"message":"Alamat DU/DI harus antara 10-255 karakter"}}' />
                                    @error('alamat')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div>{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Deskripsi DU/DI</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Deskripsi DU/DI"></i>
                                    </label>
                                    <textarea
                                        class="form-control form-control-solid @error('deskripsi') is-invalid @enderror"
                                        placeholder="Contoh: Deskripsi DU/DI"
                                        name="deskripsi"
                                        id="deskripsi"
                                        data-validate=''>{{ old('deskripsi') }}</textarea>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Logo DU/DI</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Logo DU/DI"></i>
                                    </label>
                                    <input type="file"
                                        class="form-control form-control-solid @error('logo') is-invalid @enderror"
                                        name="logo"
                                        id="logo"
                                        value="{{ old('logo') }}"
                                        data-validate=''
                                        enctype="multipart/form-data" />
                                </div>
                                <!--end::Input group-->
                                <!--begin::Actions-->
                                <div class="text-center">
                                    <button type="reset" class="btn btn-light me-3" data-modal-action="cancel">Batal</button>
                                    <button type="submit" class="btn btn-primary" data-modal-action="submit">
                                        <span class="indicator-label">Simpan</span>
                                        <span class="indicator-progress">Mohon tunggu...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                                <!--end::Actions-->
                            </form>
                            <!--end:Form-->
                        </div>
                        <!--end::Modal body-->
                    </div>
                </div>
            </div>

            <!-- Modal Edit Jurusan -->
            <div class="modal fade"
                id="editPerusahaanModal"
                tabindex="-1"
                aria-labelledby="editPerusahaanModalLabel"
                aria-hidden="true"
                data-modal-form
                data-modal-edit
                data-error-text="Maaf, sepertinya ada beberapa kesalahan yang terdeteksi, silakan coba lagi."
                data-cancel-text="Apakah Anda yakin ingin membatalkan perubahan DU/DI?">
                <div class="modal-dialog modal-dialog-centered mw-650px">
                    <div class="modal-content rounded">
                        <!--begin::Modal header-->
                        <div class="modal-header pb-0 border-0 justify-content-end">
                            <!--begin::Close-->
                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                <span class="svg-icon svg-icon-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                        <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </div>
                            <!--end::Close-->
                        </div>
                        <!--end::Modal header-->
                        <!--begin::Modal body-->
                        <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                            <!--begin:Form-->
                            <form id="kt_modal_edit_perusahaan_form"
                                action=""
                                method="POST"
                                class="form"
                                data-action-template="{{ route('admin.perusahaan.update', ':id') }}">
                                @csrf
                                @method('PUT')
                                <!--begin::Heading-->
                                <div class="mb-13 text-center">
                                    <!--begin::Title-->
                                    <h1 class="mb-3">Edit DU/DI</h1>
                                    <!--end::Title-->
                                    <!--begin::Description-->
                                    <div class="text-muted fw-semibold fs-5">Perbarui informasi DU/DI</div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Heading-->
                                <!--begin::Alert for errors-->
                                @if($errors->any() && old('_method') == 'PUT')
                                <div class="alert alert-danger d-flex align-items-center p-5 mb-8">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                                    <span class="svg-icon svg-icon-2hx svg-icon-danger me-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                                            <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor" />
                                            <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <div class="d-flex flex-column">
                                        <h4 class="mb-1 text-danger">Terdapat kesalahan!</h4>
                                        @foreach($errors->all() as $error)
                                        <span>• {{ $error }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                <!--end::Alert-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Nama DU/DI</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Nama DU/DI"></i>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text"
                                        class="form-control form-control-solid @error('nama_perusahaan') is-invalid @enderror"
                                        placeholder="Contoh: PT. ABC"
                                        name="nama_perusahaan"
                                        id="editPerusahaanName"
                                        value="{{ old('nama_perusahaan') }}"
                                        data-validate='{"notEmpty":{"message":"Nama DU/DI harus diisi"},"stringLength":{"min":2,"max":150,"message":"Nama DU/DI harus antara 2-150 karakter"}}' />
                                    @error('nama_perusahaan')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div>{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Email DU/DI</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan nama lengkap jurusan"></i>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text"
                                        class="form-control form-control-solid @error('email') is-invalid @enderror"
                                        placeholder="Contoh: Teknik Informatika"
                                        name="email"
                                        id="editPerusahaanEmail"
                                        value="{{ old('email') }}"
                                        data-validate='{"notEmpty":{"message":"Email DU/DI harus diisi"},"email":{"message":"Email DU/DI tidak valid"}}' />
                                    @error('email')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div>{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Kontak DU/DI</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Kontak DU/DI"></i>
                                    </label>
                                    <input type="text"
                                        class="form-control form-control-solid @error('kontak') is-invalid @enderror"
                                        placeholder="Contoh: 081234567890"
                                        name="kontak"
                                        id="editPerusahaanKontak"
                                        value="{{ old('kontak') }}"
                                        data-validate='' />
                                    @error('kontak')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div>{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Alamat DU/DI</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Alamat DU/DI"></i>
                                    </label>
                                    <input type="text"
                                        class="form-control form-control-solid @error('alamat') is-invalid @enderror"
                                        placeholder="Contoh: Jl. Raya No. 123, Jakarta"
                                        name="alamat"
                                        id="editPerusahaanAlamat"
                                        value="{{ old('alamat') }}"
                                        data-validate='{"notEmpty":{"message":"Alamat DU/DI harus diisi"},"stringLength":{"min":10,"max":255,"message":"Alamat DU/DI harus antara 10-255 karakter"}}' />
                                    @error('alamat')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div>{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Deskripsi DU/DI</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Deskripsi DU/DI"></i>
                                    </label>
                                    <textarea
                                        class="form-control form-control-solid @error('deskripsi') is-invalid @enderror"
                                        placeholder="Contoh: Deskripsi DU/DI"
                                        name="deskripsi"
                                        id="editPerusahaanDeskripsi"
                                        data-validate=''>{{ old('deskripsi') }}</textarea>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Logo DU/DI</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Logo DU/DI"></i>
                                    </label>
                                    <input type="file"
                                        class="form-control form-control-solid @error('logo') is-invalid @enderror"
                                        name="logo"
                                        id="editPerusahaanLogo"
                                        value="{{ old('logo') }}"
                                        data-validate=''
                                        enctype="multipart/form-data" />
                                </div>
                                <!--end::Input group-->
                                <!--begin::Actions-->
                                <div class="text-center">
                                    <button type="reset" class="btn btn-light me-3" data-modal-action="cancel">Batal</button>
                                    <button type="submit" class="btn btn-primary" data-modal-action="submit">
                                        <span class="indicator-label">Perbarui</span>
                                        <span class="indicator-progress">Mohon tunggu...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                                <!--end::Actions-->
                            </form>
                            <!--end:Form-->
                        </div>
                        <!--end::Modal body-->
                    </div>
                </div>
            </div>

        </div>
        <!--end::Header-->

        <!-- Search Box -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mt-3 px-5 px-md-8">
            <div class="position-relative w-100 w-md-auto">
                <span class="svg-icon svg-icon-1 position-absolute translate-middle-y top-50 ms-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                    </svg>
                </span>
                <input type="text" id="searchInput" class="form-control form-control-solid w-100 w-md-250px ps-14" placeholder="Cari DU/DI...">
            </div>

            <div class="card-toolbar w-100 w-md-auto">
                <!-- Tombol untuk membuka Modal -->
                <button type="button" class="btn btn-sm btn-primary w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#addPerusahaanModal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                    <span class="svg-icon svg-icon-muted svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M3 13V11C3 10.4 3.4 10 4 10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14H4C3.4 14 3 13.6 3 13Z" fill="black" />
                            <path d="M13 21H11C10.4 21 10 20.6 10 20V4C10 3.4 10.4 3 11 3H13C13.6 3 14 3.4 14 4V20C14 20.6 13.6 21 13 21Z" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->Tambah DU/DI
                </button>
            </div>
        </div>

        <!--begin::Body-->
        <div class="card-body py-3">
            <!--begin::Table container-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table id="kt_datatable_example_1" class="table table-hover align-middle gs-0 gy-4">
                    <!--begin::Table head-->
                    <thead>
                        <tr class="fw-bolder text-muted bg-light">
                            <th class="w-10px ps-4">No</th>
                            <th class="min-w-200px">Nama DU/DI</th>
                            <th class="min-w-200px">Email</th>
                            <th class="min-w-130px">Kontak</th>
                            <th class="min-w-200px">Alamat</th>
                            <th class="min-w-150px text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                        @forelse ($perusahaans as $index => $item)
                        <tr>
                            <td class="text-muted fw-bold fs-6 ps-5">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($item->logo_path)
                                    <div class="symbol symbol-35px me-3">
                                        <img src="{{ asset('storage/' . $item->logo_path) }}" alt="{{ $item->nama_perusahaan }}">
                                    </div>
                                    @else
                                    <div class="symbol symbol-50px me-3">
                                        <div class="symbol-label bg-light-primary text-primary fs-6 fw-bold">
                                            {{ substr($item->nama_perusahaan, 0, 2) }}
                                        </div>
                                    </div>
                                    @endif
                                    <div class="d-flex flex-column">
                                        <span class="text-dark fw-bold text-hover-primary text-capitalize">{{ $item->nama_perusahaan }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $item->email ?? '-' }}</td>
                            <td>{{ $item->kontak ?? '-' }}</td>
                            <td>{{ $item->alamat ?? '-' }}</td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.perusahaan.show', $item->id) }}"
                                    class="btn btn-icon btn-bg-light btn-active-color-info btn-sm me-1"
                                    title="Detail">
                                    <span class="fs-6">
                                        <i class="fa-regular fa-eye"></i>
                                    </span>
                                </a>
                                <button type="button"
                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 "
                                    data-bs-toggle="modal"
                                    data-bs-target="#editPerusahaanModal"
                                    data-id="{{ $item->id }}"
                                    data-nama_perusahaan="{{ $item->nama_perusahaan }}"
                                    data-email="{{ $item->email }}"
                                    data-kontak="{{ $item->kontak }}"
                                    data-alamat="{{ $item->alamat }}"
                                    data-deskripsi="{{ $item->deskripsi }}"
                                    title="Edit">
                                    <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                    <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor" />
                                            <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </button>
                                <form action="{{ route('admin.perusahaan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus DU/DI ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm " title="Hapus">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                        <span class="svg-icon svg-icon-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
                                                <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
                                                <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-10">
                                <div class="text-gray-600 fs-5 fw-semibold">
                                    Belum ada data DU/DI
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table container-->
        </div>
        <!--end::Body-->
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        const $dataTable = $('#kt_datatable_example_1').DataTable();
        const $search = $('#searchInput');
        if ($search.length) {
            $search.on('keyup', function() {
                $dataTable.search(this.value).draw();
            });
        }
    });
</script>
@endpush