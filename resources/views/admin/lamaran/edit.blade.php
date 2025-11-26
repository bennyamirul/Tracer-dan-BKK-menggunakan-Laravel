@extends('layouts.app')

@section('title', 'Edit Lamaran')

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="card mb-5">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Edit Status Lamaran</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Perbarui status lamaran</span>
            </h3>
        </div>
        <!--end::Header-->

        <!--begin::Body-->
        <div class="card-body py-4">
            <!--begin::Info Lamaran-->
            <div class="mb-10">
                <h4 class="mb-5">Informasi Lamaran</h4>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <span class="text-muted">Nama Pelamar</span>
                    </div>
                    <div class="col-md-9">
                        <span class="fw-bold text-capitalize">{{ $lamaran->user->nama }}</span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <span class="text-muted">Perusahaan</span>
                    </div>
                    <div class="col-md-9">
                        <span class="fw-bold text-capitalize">{{ $lamaran->lowongan->perusahaan->nama_perusahaan }}</span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <span class="text-muted">Posisi</span>
                    </div>
                    <div class="col-md-9">
                        <span class="fw-bold text-capitalize">{{ $lamaran->lowongan->posisi }}</span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <span class="text-muted">Tanggal Lamaran</span>
                    </div>
                    <div class="col-md-9">
                        <span class="fw-bold">{{ $lamaran->tanggal_lamaran ? \Carbon\Carbon::parse($lamaran->tanggal_lamaran)->format('d M Y') : '-' }}</span>
                    </div>
                </div>
            </div>
            <!--end::Info Lamaran-->

            <!--begin::Form-->
            <form action="{{ route('admin.lamaran.update', $lamaran->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!--begin::Status-->
                <div class="mb-10">
                    <label class="form-label required">Status Lamaran</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="">Pilih Status</option>
                        <option value="diajukan" {{ old('status', $lamaran->status) == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                        <option value="diproses" {{ old('status', $lamaran->status) == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="wawancara" {{ old('status', $lamaran->status) == 'wawancara' ? 'selected' : '' }}>Wawancara</option>
                        <option value="diterima" {{ old('status', $lamaran->status) == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ old('status', $lamaran->status) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <!--end::Status-->

                <!--begin::Tanggal Wawancara-->
                <div class="mb-10">
                    <label class="form-label">Tanggal Wawancara (opsional)</label>
                    <input type="date"
                        name="tanggal_wawancara"
                        class="form-control @error('tanggal_wawancara') is-invalid @enderror"
                        value="{{ old('tanggal_wawancara', $lamaran->tanggal_wawancara) }}">
                    <div class="form-text">Isi jika status sudah menuju wawancara</div>
                    @error('tanggal_wawancara')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <!--end::Tanggal Wawancara-->

                <!--begin::Actions-->
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.lamaran.index') }}" class="btn btn-light me-3">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">Simpan Perubahan</span>
                    </button>
                </div>
                <!--end::Actions-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Body-->
    </div>
</div>
@endsection