@extends('layouts.dudi')

@section('title', 'Data Lowongan Kerja')

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
                <span class="card-label fw-bolder fs-3 mb-1">Data Lowongan Kerja</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Total {{ $lowongans->count() }} Lowongan Kerja</span>
            </h3>




            <!-- Modal Tambah Jurusan -->
            <div class="modal fade"
                id="addLowonganModal"
                tabindex="-1"
                aria-labelledby="addLowonganModalLabel"
                aria-hidden="true"
                data-modal-form
                data-error-text="Maaf, sepertinya ada beberapa kesalahan yang terdeteksi, silakan coba lagi."
                data-cancel-text="Apakah Anda yakin ingin membatalkan penambahan Lowongan Kerja?">
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
                            <form id="kt_modal_add_lowongan_form" action="{{ route('admin_dudi.lowongan.store') }}" method="POST" class="form">
                                @csrf
                                <!--begin::Heading-->
                                <div class="mb-13 text-center">
                                    <!--begin::Title-->
                                    <h1 class="mb-3">Tambah Lowongan Kerja Baru</h1>
                                    <!--end::Title-->
                                    <!--begin::Description-->
                                    <div class="text-muted fw-semibold fs-5">Silakan masukkan informasi Lowongan Kerja yang akan ditambahkan</div>
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
                                        <span class="required">Perusahaan</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Perusahaan"></i>
                                    </label>
                                    <!--end::Label-->
                                    <select class="form-select form-select-solid @error('perusahaan_id') is-invalid @enderror"
                                        name="perusahaan_id"
                                        id="perusahaan_id">
                                        <option value="">Pilih Perusahaan</option>
                                        @foreach($perusahaans as $perusahaan)
                                        <option value="{{ $perusahaan->id }}">{{ $perusahaan->nama_perusahaan }}</option>
                                        @endforeach
                                    </select>
                                    @error('perusahaan_id')
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
                                        <span class="required">Judul Lowongan</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Judul Lowongan Kerja"></i>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text"
                                        class="form-control form-control-solid @error('judul') is-invalid @enderror"
                                        placeholder="Contoh: Software Engineer"
                                        name="judul"
                                        id="judul"
                                        value="{{ old('judul') }}"
                                        data-validate='{"notEmpty":{"message":"Judul Lowongan Kerja harus diisi"},"stringLength":{"min":2,"max":150,"message":"Judul Lowongan Kerja harus antara 2-150 karakter"}}' />
                                    @error('judul')
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
                                        <span class="required">Posisi Lowongan</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Posisi Lowongan Kerja"></i>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text"
                                        class="form-control form-control-solid @error('posisi') is-invalid @enderror"
                                        placeholder="Contoh: Software Engineer"
                                        name="posisi"
                                        id="posisi"
                                        value="{{ old('posisi') }}"
                                        data-validate='{"notEmpty":{"message":"Posisi Lowongan Kerja harus diisi"},"stringLength":{"min":2,"max":150,"message":"Posisi Lowongan Kerja harus antara 2-150 karakter"}}' />
                                    @error('posisi')
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
                                        <span class="required">Pendidikan Minimum</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Kontak DU/DI"></i>
                                    </label>
                                    <select class="form-select form-select-solid @error('pendidikan_min') is-invalid @enderror"
                                        placeholder="Contoh: SD, SMP, SMA/SMK, D3, S1, S2, S3"
                                        name="pendidikan_min"
                                        id="pendidikan_min"
                                        value="{{ old('pendidikan_min') }}"
                                        data-validate=''>
                                        <option value="">Pilih Pendidikan Minimum</option>
                                        <option value="SD">SD</option>
                                        <option value="SMP">SMP</option>
                                        <option value="SMA/SMK">SMA/SMK</option>
                                        <option value="D3">D3</option>
                                        <option value="S1">S1</option>
                                        <option value="S2">S2</option>
                                        <option value="S3">S3</option>
                                    </select>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Pendidikan Jurusan</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Pendidikan Jurusan"></i>
                                    </label>
                                    <input type="text"
                                        class="form-control form-control-solid @error('pendidikan_jurusan') is-invalid @enderror"
                                        placeholder="Contoh: Rekayasa Perangkat Lunak"
                                        name="pendidikan_jurusan"
                                        id="pendidikan_jurusan"
                                        value="{{ old('pendidikan_jurusan') }}"
                                        data-validate='' />
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Batas Lamaran</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Batas Lamaran"></i>
                                    </label>
                                    <input type="date"
                                        class="form-control form-control-solid @error('batas_lamaran') is-invalid @enderror"
                                        placeholder="Batas Lamaran"
                                        name="batas_lamaran"
                                        id="batas_lamaran"
                                        value="{{ old('batas_lamaran') }}"
                                        data-validate=''>

                                    </input>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Deskripsi Lowongan</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Deskripsi Lowongan"></i>
                                    </label>
                                    <textarea
                                        class="form-control form-control-solid @error('deskripsi') is-invalid @enderror"
                                        name="deskripsi"
                                        id="deskripsi"
                                        value="{{ old('deskripsi') }}"
                                        data-validate=''>
                                    </textarea>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Status</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Status"></i>
                                    </label>
                                    <select class="form-select form-select-solid @error('status') is-invalid @enderror"
                                        name="status"
                                        id="status"
                                        value="{{ old('status') }}"
                                        data-validate=''>
                                        <option value="aktif">Aktif</option>
                                        <option value="nonaktif">Nonaktif</option>
                                    </select>
                                    @error('status')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div>{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>
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
                id="editLowonganModal"
                tabindex="-1"
                aria-labelledby="editLowonganModalLabel"
                aria-hidden="true"
                data-modal-form
                data-modal-edit
                data-error-text="Maaf, sepertinya ada beberapa kesalahan yang terdeteksi, silakan coba lagi."
                data-cancel-text="Apakah Anda yakin ingin membatalkan perubahan Lowongan Kerja?">
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
                            <form id="kt_modal_edit_lowongan_form"
                                action=""
                                method="POST"
                                class="form"
                                data-action-template="{{ route('admin_dudi.lowongan.update', ':id') }}">
                                @csrf
                                @method('PUT')
                                <!--begin::Heading-->
                                <div class="mb-13 text-center">
                                    <!--begin::Title-->
                                    <h1 class="mb-3">Edit Lowongan Kerja</h1>
                                    <!--end::Title-->
                                    <!--begin::Description-->
                                    <div class="text-muted fw-semibold fs-5">Perbarui informasi Lowongan Kerja</div>
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
                                        <span class="required">Judul Lowongan</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Judul Lowongan"></i>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text"
                                        class="form-control form-control-solid @error('judul') is-invalid @enderror"
                                        placeholder="Lowongan Kerja"
                                        name="judul"
                                        id="editLowonganJudul"
                                        value="{{ old('judul') }}"
                                        data-validate='{"notEmpty":{"message":"Judul Lowongan harus diisi"},"stringLength":{"min":2,"max":150,"message":"Judul Lowongan harus antara 2-150 karakter"}}' />
                                    @error('judul')
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
                                        <span class="required">Posisi Lowongan</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Posisi Lowongan"></i>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text"
                                        class="form-control form-control-solid @error('posisi') is-invalid @enderror"
                                        placeholder="Contoh: Software Engineer"
                                        name="posisi"
                                        id="editLowonganPosisi"
                                        value="{{ old('posisi') }}"
                                        data-validate='{"notEmpty":{"message":"Posisi Lowongan harus diisi"},"stringLength":{"min":2,"max":150,"message":"Posisi Lowongan harus antara 2-150 karakter"}}' />
                                    @error('posisi')
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
                                        <span class="required">Pendidikan Minimum</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Pendidikan Minimum"></i>
                                    </label>
                                    <select class="form-select form-select-solid @error('pendidikan_min') is-invalid @enderror"
                                        placeholder="Contoh: SD, SMP, SMA/SMK, D3, S1, S2, S3"
                                        name="pendidikan_min"
                                        id="pendidikan_min"
                                        value="{{ old('pendidikan_min') }}"
                                        data-validate=''>
                                        <option value="SD">SD</option>
                                        <option value="SMP">SMP</option>
                                        <option value="SMA/SMK">SMA/SMK</option>
                                        <option value="D3">D3</option>
                                        <option value="S1">S1</option>
                                        <option value="S2">S2</option>
                                        <option value="S3">S3</option>
                                    </select>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Pendidikan Jurusan</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Pendidikan Jurusan"></i>
                                    </label>
                                    <input type="text"
                                        class="form-control form-control-solid @error('pendidikan_jurusan') is-invalid @enderror"
                                        placeholder="Contoh: Rekayasa Perangkat Lunak"
                                        name="pendidikan_jurusan"
                                        id="pendidikan_jurusan"
                                        value="{{ old('pendidikan_jurusan') }}"
                                        data-validate=''>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Deskripsi Lowongan</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Deskripsi Lowongan"></i>
                                    </label>
                                    <textarea
                                        class="form-control form-control-solid @error('deskripsi') is-invalid @enderror"
                                        placeholder="Contoh: Deskripsi Lowongan"
                                        name="deskripsi"
                                        id="editLowonganDeskripsi"
                                        value="{{ old('deskripsi') }}"
                                        data-validate=''>
                                    </textarea>


                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Batas Lamaran</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Logo DU/DI"></i>
                                    </label>
                                    <input type="date"
                                        class="form-control form-control-solid @error('batas_lamaran') is-invalid @enderror"
                                        name="batas_lamaran"
                                        id="editLowonganBatasLamaran"
                                        value="{{ old('batas_lamaran') }}"
                                        data-validate='' />
                                </div>
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Status</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Status"></i>
                                    </label>
                                    <select class="form-select form-select-solid @error('status') is-invalid @enderror"
                                        name="status"
                                        id="editLowonganStatus"
                                        value="{{ old('status') }}"
                                        data-validate=''>
                                        <option value="aktif">Aktif</option>
                                        <option value="nonaktif">Nonaktif</option>
                                    </select>
                                    @error('status')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div>{{ $message }}</div>
                                    </div>
                                    @enderror
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
        <div class="d-flex flex-row justify-content-between mt-3 ms-8 pe-8">
            <div class="position-relative my-1">
                <span class="svg-icon svg-icon-1 position-absolute translate-middle-y top-50 ms-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                    </svg>
                </span>
                <input type="text" id="searchInput" class="form-control form-control-solid w-250px ps-14" placeholder="Cari Lowongan Kerja...">
            </div>

            <div class="card-toolbar">
                <!-- Tombol untuk membuka Modal -->
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addLowonganModal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                    <span class="svg-icon svg-icon-muted svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M3 13V11C3 10.4 3.4 10 4 10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14H4C3.4 14 3 13.6 3 13Z" fill="black" />
                            <path d="M13 21H11C10.4 21 10 20.6 10 20V4C10 3.4 10.4 3 11 3H13C13.6 3 14 3.4 14 4V20C14 20.6 13.6 21 13 21Z" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->Tambah Lowongan Kerja
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
                            <th class="min-w-200px">Nama Perusahaan</th>
                            <th class="min-w-200px">Judul Lowongan</th>
                            <th class="min-w-150px">Pendidikan Min</th>
                            <th class="min-w-150px">Tanggal Dibuat</th>
                            <th class="min-w-100px">Batas Lamar</th>
                            <th class="min-w-50px">Status</th>
                            <th class="min-w-150px text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                        @forelse ($lowongan as $index => $item)
                        <tr>
                            <td class="text-muted fw-bold ps-4">{{ $index + 1 }}</td>
                            <td class="text-dark fw-bold text-capitalize">{{ $item->perusahaan ? $item->perusahaan->nama_perusahaan : '-' }}</td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="text-dark fw-bold text-capitalize">{{ $item->judul }}</span>
                                    <span class="text-muted fw-semibold text-muted d-block fs-7">Posisi : {{ $item->posisi }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-light-primary text-capitalize">{{ $item->pendidikan_min }}</span>
                            </td>
                            <td>{{ $item->tanggal_dibuat ? \Carbon\Carbon::parse($item->tanggal_dibuat)->format('d M Y') : '-' }}</td>
                            <td>{{ $item->batas_lamaran ? \Carbon\Carbon::parse($item->batas_lamaran)->format('d M Y') : '-' }}</td>
                            <td>
                                @if($item->status === 'aktif')
                                <span class="badge badge-light-success">Aktif</span>
                                @else
                                <span class="badge badge-light-danger">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin_dudi.lowongan.show', $item->id) }}" class="btn btn-icon btn-bg-light btn-active-color-info btn-sm me-1" title="Detail">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                                <button type="button"
                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 "
                                    data-bs-toggle="modal"
                                    data-bs-target="#editLowonganModal"
                                    data-id="{{ $item->id }}"
                                    data-judul="{{ $item->judul }}"
                                    data-posisi="{{ $item->posisi }}"
                                    data-pendidikan_min="{{ $item->pendidikan_min }}"
                                    data-pendidikan_jurusan="{{ $item->pendidikan_jurusan }}"
                                    data-deskripsi="{{ $item->deskripsi }}"
                                    data-batas_lamaran="{{ $item->batas_lamaran ? \Carbon\Carbon::parse($item->batas_lamaran)->format('Y-m-d') : '' }}"
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
                                <form action="{{ route('admin_dudi.lowongan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Lowongan Kerja ini?');">
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
                                    Belum ada data Lowongan Kerja
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