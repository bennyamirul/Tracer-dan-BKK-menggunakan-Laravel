@extends('layouts.app')

@section('title', 'Data Admin')

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
                <span class="card-label fw-bolder fs-3 mb-1">Data Admin</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Total {{ $users->where('role', 'admin_sekolah')->count() }} Admin Sekolah dan {{ $users->where('role', 'admin_dudi')->count() }} Admin DU/DI</span>
            </h3>




            <!-- Modal Tambah Jurusan -->
            <div class="modal fade"
                id="addAdminModal"
                tabindex="-1"
                aria-labelledby="addAdminModalLabel"
                aria-hidden="true"
                data-modal-form
                data-error-text="Maaf, sepertinya ada beberapa kesalahan yang terdeteksi, silakan coba lagi."
                data-cancel-text="Apakah Anda yakin ingin membatalkan penambahan Admin?">
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
                            <form id="kt_modal_add_admin_form" action="{{ route('admin.user.store') }}" method="POST" class="form" enctype="multipart/form-data">
                                @csrf
                                <!--begin::Heading-->
                                <div class="mb-13 text-center">
                                    <!--begin::Title-->
                                    <h1 class="mb-3">Tambah Admin Baru</h1>
                                    <!--end::Title-->
                                    <!--begin::Description-->
                                    <div class="text-muted fw-semibold fs-5">Silakan masukkan informasi Admin yang akan ditambahkan</div>
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
                                        <span class="required">Nama Admin</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan nama lengkap Admin"></i>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text"
                                        class="form-control form-control-solid @error('nama') is-invalid @enderror"
                                        placeholder="Contoh: John Doe"
                                        name="nama"
                                        id="adminName"
                                        value="{{ old('nama') }}"
                                        data-validate='{"notEmpty":{"message":"Nama Admin harus diisi"},"stringLength":{"min":2,"max":150,"message":"Nama Admin harus antara 2-150 karakter"}}' />
                                    @error('nama')
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
                                        <span class="required">Jenis Admin</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Jenis Admin"></i>
                                    </label>
                                    <!--end::Label-->
                                    <select class="form-control form-control-solid @error('role') is-invalid @enderror" name="role" id="role">
                                        <option value="admin_sekolah">Admin Sekolah</option>
                                        <option value="admin_dudi">Admin DU/DI</option>
                                    </select>
                                    @error('role')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div>{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row d-none" id="dudi_group">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">DU/DI</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan DU/DI"></i>
                                    </label>
                                    <select class="form-control form-control-solid @error('dudi') is-invalid @enderror" name="dudi" id="dudi" disabled>
                                        <option value="dudi">- Pilih DU/DI -</option>
                                        @foreach($perusahaans as $dudi)
                                        <option value="{{ $dudi->id }}">{{ $dudi->nama_perusahaan }}</option>
                                        @endforeach
                                    </select>
                                    @error('dudi')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div>{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">No Telp Admin</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan No Telp Admin"></i>
                                    </label>
                                    <input type="text"
                                        class="form-control form-control-solid @error('no_telp') is-invalid @enderror"
                                        placeholder="Contoh: 081234567890"
                                        name="no_telp"
                                        id="no_telp"
                                        value="{{ old('no_telp') }}"
                                        data-validate='' />

                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Alamat Admin</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Alamat Admin"></i>
                                    </label>
                                    <input type="text"
                                        class="form-control form-control-solid @error('alamat') is-invalid @enderror"
                                        placeholder="Contoh: Jl. Raya No. 123, Jakarta"
                                        name="alamat"
                                        id="alamat"
                                        value="{{ old('alamat') }}"
                                        data-validate='' />
                                    <!--end::Input group-->
                                </div>
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Tanggal Lahir Admin</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Tanggal Lahir Admin"></i>
                                    </label>
                                    <input type="date"
                                        class="form-control form-control-solid @error('tanggal_lahir') is-invalid @enderror"
                                        placeholder="Contoh: 1990-01-01"
                                        name="tanggal_lahir"
                                        id="tanggal_lahir"
                                        value="{{ old('tanggal_lahir') }}"
                                        data-validate='' />
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Jenis Kelamin Admin</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Jenis Kelamin Admin"></i>
                                    </label>
                                    <select
                                        class="form-control form-control-solid @error('jenis_kelamin') is-invalid @enderror"
                                        name="jenis_kelamin"
                                        id="jenis_kelamin"
                                        value="{{ old('jenis_kelamin') }}">
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
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
                                        <span class="required">Email Admin</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Email Admin"></i>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text"
                                        class="form-control form-control-solid @error('email') is-invalid @enderror"
                                        placeholder="Contoh: example@gmail.com"
                                        name="email"
                                        id="email"
                                        value="{{ old('email') }}"
                                        data-validate='{"notEmpty":{"message":"Email Admin harus diisi"},"email":{"message":"Email Admin tidak valid"}}' />
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
                                        <span class="required">Password Admin</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Password Admin"></i>
                                    </label>
                                    <input type="password"
                                        class="form-control form-control-solid @error('password') is-invalid @enderror"
                                        placeholder="Contoh: Password Admin"
                                        name="password"
                                        id="password"
                                        value="{{ old('password') }}"
                                        data-validate='{"notEmpty":{"message":"Password Admin harus diisi"},"stringLength":{"min":8,"max":150,"message":"Password Admin minimal 8 karakter"}}' />
                                    @error('password')
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
                                        <span class="required">Konfirmasi Password Admin</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Konfirmasi Password Admin"></i>
                                    </label>
                                    <input type="password"
                                        class="form-control form-control-solid @error('password_confirmation') is-invalid @enderror"
                                        placeholder="Contoh: Password Admin"
                                        name="password_confirmation"
                                        id="password_confirmation"
                                        value="{{ old('password_confirmation') }}"
                                        data-validate='{"notEmpty":{"message":"Konfirmasi Password Admin harus diisi"},"stringLength":{"min":8,"max":150,"message":"Konfirmasi Password Admin"}}' />
                                    @error('password_confirmation')
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
                                        <span class="required">Foto Admin</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Foto Admin"></i>
                                    </label>
                                    <input type="file"
                                        class="form-control form-control-solid @error('avatar') is-invalid @enderror"
                                        name="avatar"
                                        id="avatar"
                                        value="{{ old('avatar') }}"
                                        data-validate='' />
                                    @error('avatar')
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
                                        <span class="required">Status Admin</span>
                                    </label>
                                    <select
                                        class="form-control form-control-solid @error('status') is-invalid @enderror"
                                        name="status"
                                        id="status"
                                        value="{{ old('status') }}">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                                @error('status')
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div>{{ $message }}</div>
                                </div>
                                @enderror
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
                id="editAdminModal"
                tabindex="-1"
                aria-labelledby="editAdminModalLabel"
                aria-hidden="true"
                data-modal-form
                data-modal-edit
                data-error-text="Maaf, sepertinya ada beberapa kesalahan yang terdeteksi, silakan coba lagi."
                data-cancel-text="Apakah Anda yakin ingin membatalkan perubahan Admin?">
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
                            <form id="kt_modal_edit_admin_form"
                                action=""
                                method="POST"
                                class="form"
                                data-action-template="{{ route('admin.user.update', ':id') }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <!--begin::Heading-->
                                <div class="mb-13 text-center">
                                    <!--begin::Title-->
                                    <h1 class="mb-3">Edit Admin</h1>
                                    <!--end::Title-->
                                    <!--begin::Description-->
                                    <div class="text-muted fw-semibold fs-5">Perbarui informasi Admin</div>
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
                                        <span class="required">Nama Admin</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Nama Admin"></i>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text"
                                        class="form-control form-control-solid @error('nama') is-invalid @enderror"
                                        placeholder="Contoh: John Doe"
                                        name="nama"
                                        id="editAdminName"
                                        value="{{ old('nama') }}"
                                        data-validate='{"notEmpty":{"message":"Nama Admin harus diisi"},"stringLength":{"min":2,"max":150,"message":"Nama Admin harus antara 2-150 karakter"}}' />
                                    @error('nama')
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
                                        <span class="required">Jenis Admin</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Jenis Admin"></i>
                                    </label>
                                    <!--end::Label-->
                                    <select class="form-control form-control-solid @error('role') is-invalid @enderror" name="role" id="role">
                                        <option value="admin_sekolah">Admin Sekolah</option>
                                        <option value="admin_dudi">Admin DU/DI</option>
                                    </select>
                                    @error('role')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div>{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row d-none" id="dudi_group">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">DU/DI</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan DU/DI"></i>
                                    </label>
                                    <select class="form-control form-control-solid @error('dudi') is-invalid @enderror" name="dudi" id="dudi" disabled>
                                        <option value="dudi">- Pilih DU/DI -</option>
                                        @foreach($perusahaans as $dudi)
                                        <option value="{{ $dudi->id }}">{{ $dudi->nama_perusahaan }}</option>
                                        @endforeach
                                    </select>
                                    @error('dudi')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div>{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">No Telp Admin</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan No Telp Admin"></i>
                                    </label>
                                    <input type="text"
                                        class="form-control form-control-solid @error('no_telp') is-invalid @enderror"
                                        placeholder="Contoh: 081234567890"
                                        name="no_telp"
                                        id="editAdminNoTelp"
                                        value="{{ old('no_telp') }}"
                                        data-validate='' />
                                    @error('no_telp')
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
                                        <span class="required">Alamat Admin</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Alamat DU/DI"></i>
                                    </label>
                                    <input type="text"
                                        class="form-control form-control-solid @error('alamat') is-invalid @enderror"
                                        placeholder="Contoh: Jl. Raya No. 123, Jakarta"
                                        name="alamat"
                                        id="editAdminAlamat"
                                        value="{{ old('alamat') }}"
                                        data-validate='' />
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Tanggal Lahir Admin</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Deskripsi DU/DI"></i>
                                    </label>
                                    <input type="date"
                                        class="form-control form-control-solid @error('tanggal_lahir') is-invalid @enderror"
                                        placeholder="Contoh: 01-01-1990"
                                        name="tanggal_lahir"
                                        id="editAdminTanggalLahir"
                                        data-validate=''>{{ old('tanggal_lahir') }}</input>
                                    @error('tanggal_lahir')
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
                                        <span class="required">Jenis Kelamin Admin</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Jenis Kelamin Admin"></i>
                                    </label>
                                    <select
                                        class="form-control form-control-solid @error('jenis_kelamin') is-invalid @enderror"
                                        name="jenis_kelamin"
                                        id="editAdminJenisKelamin"
                                        value="{{ old('jenis_kelamin') }}">
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
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
                                        <span class="required">Email Admin</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan nama lengkap jurusan"></i>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text"
                                        class="form-control form-control-solid @error('email') is-invalid @enderror"
                                        placeholder="Contoh: Teknik Informatika"
                                        name="email"
                                        id="editAdminEmail"
                                        value="{{ old('email') }}"
                                        data-validate='{"notEmpty":{"message":"Email Admin harus diisi"},"email":{"message":"Email Admin tidak valid"}}' />
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
                                        <span class="required">Password Admin</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Password Admin"></i>
                                    </label>
                                    <input type="password"
                                        class="form-control form-control-solid @error('password') is-invalid @enderror"
                                        placeholder="Password baru"
                                        name="password"
                                        id="editAdminPassword"
                                        value="{{ old('password') }}"
                                        data-validate='{"notEmpty":{"message":"Password Admin harus diisi"},"stringLength":{"min":8,"max":150,"message":"Password Admin harus antara 8-150 karakter"}}' />
                                    @error('password')
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
                                        <span class="required">Konfirmasi Password Admin</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Konfirmasi Password Admin"></i>
                                    </label>
                                    <input type="password"
                                        class="form-control form-control-solid @error('password_confirmation') is-invalid @enderror"
                                        placeholder="Konfirmasi Password Baru"
                                        name="password_confirmation"
                                        id="editAdminPasswordConfirmation"
                                        value="{{ old('password_confirmation') }}"
                                        data-validate='{"notEmpty":{"message":"Konfirmasi Password Admin harus diisi"},"stringLength":{"min":8,"max":150,"message":"Konfirmasi Password Admin harus antara 8-150 karakter"}}' />
                                    @error('password_confirmation')
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
                                        <span class="required">Foto Admin</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Foto Admin"></i>
                                    </label>
                                    <input type="file"
                                        class="form-control form-control-solid @error('avatar') is-invalid @enderror"
                                        name="avatar"
                                        id="editAdminAvatar"
                                        value="{{ old('avatar') }}"
                                        data-validate='' />
                                    @error('avatar')
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
                                        <span class="required">Status Admin</span>
                                    </label>
                                </div>
                                <select
                                    class="form-control form-control-solid @error('status') is-invalid @enderror"
                                    name="status"
                                    id="status"
                                    value="{{ old('status') }}">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
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
                <input type="text" id="searchInput" class="form-control form-control-solid w-100 w-md-250px ps-14" placeholder="Cari Admin...">
            </div>

            <div class="card-toolbar w-100 w-md-auto">
                <!-- Tombol untuk membuka Modal -->
                <button type="button" class="btn btn-sm btn-primary w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#addAdminModal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                    <span class="svg-icon svg-icon-muted svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M3 13V11C3 10.4 3.4 10 4 10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14H4C3.4 14 3 13.6 3 13Z" fill="black" />
                            <path d="M13 21H11C10.4 21 10 20.6 10 20V4C10 3.4 10.4 3 11 3H13C13.6 3 14 3.4 14 4V20C14 20.6 13.6 21 13 21Z" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->Tambah Admin
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
                            <th class="min-w-200px">Nama Admin</th>
                            <th class="min-w-150px">Email</th>
                            <th class="min-w-150px">DU/DI</th>
                            <th class="min-w-50px">Status</th>
                            <th class="min-w-150px text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                        @forelse ($users as $index => $item)
                        <tr>
                            <td class="text-muted fw-bold fs-6 ps-5">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-45px me-3">
                                        <img src="{{ $item->avatar ? asset('storage/' . $item->avatar) : asset('assets/media/avatars/blank.png') }}" alt="{{ $item->nama }}" />
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="text-dark fw-bold text-hover-primary text-capitalize">{{ $item->nama }}</span>
                                        <span class="text-muted fs-7">{{ $item->role ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $item->email ?? '-' }}</td>
                            <td>{{ $item->dudi->nama_perusahaan ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $item->status == 'active' ? 'badge-success' : 'badge-danger' }}">{{ $item->status ?? '-' }}</span>
                            </td>
                            <td class="text-end pe-3">
                                <button type="button"
                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 "
                                    data-bs-toggle="modal"
                                    data-bs-target="#editAdminModal"
                                    data-id="{{ $item->id }}"
                                    data-nama="{{ $item->nama }}"
                                    data-role="{{ $item->role }}"
                                    data-dudi="{{ $item->dudi }}"
                                    data-no_telp="{{ $item->no_telp }}"
                                    data-alamat="{{ $item->alamat }}"
                                    data-jenis_kelamin="{{ $item->jenis_kelamin }}"
                                    data-tanggal_lahir="{{ $item->tanggal_lahir }}"
                                    data-email="{{ $item->email }}"
                                    data-logo="{{ $item->avatar }}"
                                    data-status="{{ $item->status }}"
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
                                <form action="{{ route('admin.user.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Admin ini?');">
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
                                    Belum ada data Admin
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

        // Toggle field DU/DI berdasarkan jenis admin
        const $role = $('#role');
        const $dudiGroup = $('#dudi_group');
        const $dudi = $('#dudi');

        function toggleDudi() {
            const isAdminDudi = $role.val() === 'admin_dudi';
            if (isAdminDudi) {
                $dudiGroup.removeClass('d-none');
                $dudi.prop('disabled', false);
            } else {
                $dudiGroup.addClass('d-none');
                $dudi.prop('disabled', true).val('dudi');
            }
        }

        toggleDudi();
        $role.on('change', toggleDudi);
    });
</script>
@endpush