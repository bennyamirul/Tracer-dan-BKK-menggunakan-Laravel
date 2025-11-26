@extends('layouts.app')

@section('title','Profil Pengguna')

@section('content')
@php
$user = $user ?? auth()->user();
$avatarPath = ($user?->avatar ?? null) ? asset('storage/' . $user->avatar) : asset('assets/media/avatars/300-1.jpg');
@endphp
<div class="container-xxl py-5">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                <div class="me-7 mb-4">
                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                        <img src="{{ $avatarPath }}" alt="avatar" style="object-fit:cover;border-radius:0.625rem;" />
                        <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-white h-20px w-20px"></div>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center mb-2">
                                <span class="text-gray-900 fs-2 fw-bolder me-3">{{ $user?->nama ?? 'Pengguna' }}</span>
                            </div>
                            <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                                <span class="d-flex align-items-center text-gray-600 me-5 mb-2"><i class="fa-regular fa-envelope me-2"></i>{{ $user?->email ?? '-' }}</span>
                                @if(!empty($user?->no_telp))
                                <span class="d-flex align-items-center text-gray-600 me-5 mb-2"><i class="fa-solid fa-phone me-2"></i>{{ $user->no_telp }}</span>
                                @endif
                                @if(!empty($user?->alamat))
                                <span class="d-flex align-items-center text-gray-600 mb-2"><i class="fa-solid fa-location-dot me-2"></i>{{ $user->alamat }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="d-flex my-4">
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditProfile">
                                <i class="fa-solid fa-edit me-2"></i>Edit Profil
                            </button>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap flex-stack">
                        <div class="d-flex flex-column flex-grow-1 pe-8">
                            <div class="d-flex flex-wrap">
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <div class="fw-bold fs-6 text-gray-600">Role</div>
                                    <div class="fs-6 fw-bolder">{{ $user?->role ?? '-' }}</div>
                                </div>
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <div class="fw-bold fs-6 text-gray-600">Bergabung</div>
                                    <div class="fs-6 fw-bolder">{{ optional($user?->created_at)->format('d M Y') ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-5 mb-xl-10">
        <div class="card-header py-5">
            <h3 class="fw-bolder mb-0">Data Diri</h3>
        </div>
        <div class="card-body">
            <div>
                <div class="row g-6 g-xl-9">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-light-primary me-4 p-4"><i class="fa-regular fa-id-card"></i></span>
                            <div>
                                <div class="text-gray-600">Nama</div>
                                <div class="fs-6 fw-bolder text-gray-800">{{ $user?->nama ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-light-success me-4 p-4"><i class="fa-regular fa-envelope"></i></span>
                            <div>
                                <div class="text-gray-600">Email</div>
                                <div class="fs-6 fw-bolder text-gray-800">{{ $user?->email ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-light-warning me-4 p-4"><i class="fa-solid fa-phone"></i></span>
                            <div>
                                <div class="text-gray-600">No. Telepon</div>
                                <div class="fs-6 fw-bolder text-gray-800">{{ $user->no_telp ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-light-info me-4 p-4"><i class="fa-solid fa-location-dot"></i></span>
                            <div>
                                <div class="text-gray-600">Alamat</div>
                                <div class="fs-6 fw-bolder text-gray-800">{{ $user->alamat ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-light-danger me-4 p-4"><i class="fa-regular fa-calendar"></i></span>
                            <div>
                                <div class="text-gray-600">Tanggal Lahir</div>
                                <div class="fs-6 fw-bolder text-gray-800">{{ $user->tanggal_lahir ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-light-secondary me-4 p-4"><i class="fa-solid fa-venus-mars"></i></span>
                            <div>
                                <div class="text-gray-600">Jenis Kelamin</div>
                                <div class="fs-6 fw-bolder text-gray-800">{{ $user->jenis_kelamin ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Profile -->
<div class="modal fade" id="modalEditProfile" tabindex="-1" aria-labelledby="modalEditProfileLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
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
                <div class="modal-body">
                    <!--begin::Heading-->
                    <div class="mb-13 text-center">
                        <!--begin::Title-->
                        <h1 class="mb-3">Edit Profile</h1>
                        <!--end::Title-->
                        <!--begin::Description-->
                        <div class="text-muted fw-semibold fs-5">Silakan masukkan informasi profil yang akan diedit</div>
                        <!--end::Description-->
                    </div>
                    <!--end::Heading-->
                    <div class="row g-4">
                        <!-- Avatar Upload -->
                        <div class="col-12 text-center">
                            <div class="mb-3">
                                <img id="avatarPreview" src="{{ $avatarPath }}" alt="Avatar Preview" class="rounded" style="width: 120px; height: 120px; object-fit: cover;">
                            </div>
                            <div>
                                <label for="avatar" class="btn btn-sm btn-light-primary">
                                    <i class="fa-solid fa-upload me-2"></i>Upload Avatar
                                </label>
                                <input type="file" class="d-none" id="avatar" name="avatar" accept="image/*" onchange="previewAvatar(this)">
                                <div class="form-text">Format: JPG, PNG. Maks: 2MB</div>
                                @error('avatar')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Nama -->
                        <div class="col-md-6">
                            <label for="nama" class="form-label required">Nama</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $user->nama) }}" required>
                            @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label required">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- No. Telepon -->
                        <div class="col-md-6">
                            <label for="no_telp" class="form-label">No. Telepon</label>
                            <input type="text" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp" name="no_telp" value="{{ old('no_telp', $user->no_telp) }}">
                            @error('no_telp')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal Lahir -->
                        <div class="col-md-6">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}">
                            @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="col-md-6">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Alamat -->
                        <div class="col-12">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3">{{ old('alamat', $user->alamat) }}</textarea>
                            @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah">
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Kosongkan jika tidak ingin mengubah">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modalEditProfile = new bootstrap.Modal(document.getElementById('modalEditProfile'));
        modalEditProfile.show();
    });
</script>
@endif

<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarPreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection