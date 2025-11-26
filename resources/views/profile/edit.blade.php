@extends('layouts.landing')

@section('content')
<div class="container py-10">
    <!--begin::Toolbar atas-->
    <div class="d-flex justify-content-end mb-5">
        <a href="{{ route('profile.show') }}" class="btn btn-light">Kembali</a>
    </div>
    <!--begin::Nav Tabs ala Metronic-->
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-0">
            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-5 fw-bolder" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#tab-edit-data-diri" aria-selected="true" role="tab">Data Diri</a>
                </li>
                @if(auth()->user()->role === 'pelamar_alumni')
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#tab-edit-tracer" aria-selected="false" role="tab">Tracer Alumni</a>
                </li>
                @endif
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#tab-edit-berkas" aria-selected="false" role="tab">Berkas</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="tab-edit-data-diri" role="tabpanel">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="section" value="user">
                <div class="row g-5">
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column align-items-center">
                                @php
                                $avatarPath = $user->avatar ? asset('storage/' . $user->avatar) : asset('assets/media/avatars/300-1.jpg');
                                @endphp
                                <div class="symbol symbol-160px symbol-lg-200px symbol-fixed position-relative">
                                    <img src="{{ $avatarPath }}" alt="avatar" style="width:200px;height:200px;object-fit:cover;border-radius:0.625rem;" />
                                </div>
                                <div class="mt-4 w-100">
                                    <label class="form-label fw-bolder">Foto Profil</label>
                                    <div class="d-flex">
                                        <input type="file" name="avatar" class="form-control" accept="image/*">
                                    </div>
                                    <div class="form-text">Format: JPG/PNG, maks 2MB.</div>
                                    @error('avatar')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card h-100">
                            <div class="card-header">
                                <h3 class="card-title fw-bolder">Data Diri</h3>
                            </div>
                            <div class="card-body">
                                @if(session('status') && session('activeTab') === 'data')
                                <div class="alert alert-success alert-dismissible fade show mb-5" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-6 mb-5">
                                        <label class="form-label fw-bold">Nama</label>
                                        <input type="text" class="form-control form-control-solid" name="nama" value="{{ old('nama', $user->nama) }}" required>
                                        @error('nama')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-5">
                                        <label class="form-label fw-bold">Email</label>
                                        <input type="email" class="form-control form-control-solid" name="email" value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-5">
                                        <label class="form-label fw-bold">No. Telepon</label>
                                        <input type="text" class="form-control form-control-solid" name="no_telp" value="{{ old('no_telp', $user->no_telp) }}">
                                        @error('no_telp')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-5">
                                        <label class="form-label fw-bold">Tanggal Lahir</label>
                                        <input type="date" class="form-control form-control-solid" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}">
                                        @error('tanggal_lahir')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-5">
                                        <label class="form-label fw-bold">Jenis Kelamin</label>
                                        <select class="form-select form-select-solid" name="jenis_kelamin">
                                            <option value="">Pilih</option>
                                            <option value="L" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="P" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('jenis_kelamin')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-5">
                                        <label class="form-label fw-bold">Password (opsional)</label>
                                        <input type="password" class="form-control form-control-solid" name="password" placeholder="Kosongkan jika tidak mengubah">
                                        @error('password')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-5">
                                    <label class="form-label fw-bold">Alamat</label>
                                    <textarea class="form-control form-control-solid" name="alamat" rows="3">{{ old('alamat', $user->alamat) }}</textarea>
                                    @error('alamat')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <span class="indicator-label">Simpan</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @if(auth()->user()->role === 'pelamar_alumni')
        <div class="tab-pane fade" id="tab-edit-tracer" role="tabpanel">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                <input type="hidden" name="section" value="tracer">
                <div class="card h-100">
                    <div class="card-header">
                        <h3 class="card-title fw-bolder">Tracer Alumni</h3>
                        <div class="card-toolbar">
                            <a href="{{ route('profile.show') }}" class="btn btn-light btn-sm">Kembali</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-5">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Jurusan</label>
                                <select name="tracer[jurusan_id]" class="form-select form-select-solid">
                                    <option value="">Pilih</option>
                                    @foreach($jurusans as $j)
                                    <option value="{{ $j->id }}" {{ optional($tracer)->jurusan_id == $j->id ? 'selected' : '' }}>{{ $j->nama }}</option>
                                    @endforeach
                                </select>
                                @error('tracer.jurusan_id')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Angkatan</label>
                                <select name="tracer[angkatan_id]" class="form-select form-select-solid">
                                    <option value="">Pilih</option>
                                    @foreach($angkatans as $a)
                                    <option value="{{ $a->id }}" {{ optional($tracer)->angkatan_id == $a->id ? 'selected' : '' }}>{{ $a->tahun }}</option>
                                    @endforeach
                                </select>
                                @error('tracer.angkatan_id')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kegiatan</label>
                                <select name="tracer[kegiatan_id]" class="form-select form-select-solid">
                                    <option value="">Pilih</option>
                                    @foreach($kegiatans as $k)
                                    <option value="{{ $k->id }}" {{ optional($tracer)->kegiatan_id == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                    @endforeach
                                </select>
                                @error('tracer.kegiatan_id')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Posisi/Peran</label>
                                <input type="text" class="form-control form-control-solid" name="tracer[posisi_peran]" value="{{ old('tracer.posisi_peran', optional($tracer)->posisi_peran) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Relevansi Jurusan</label>
                                <select name="tracer[relevansi_jurusan]" class="form-select form-select-solid">
                                    <option value="">Pilih</option>
                                    <option value="ya" {{ optional($tracer)->relevansi_jurusan == 'ya' ? 'selected' : '' }}>Ya</option>
                                    <option value="tidak" {{ optional($tracer)->relevansi_jurusan == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tahun Mulai</label>
                                <input type="number" class="form-control form-control-solid" name="tracer[tahun_mulai]" value="{{ old('tracer.tahun_mulai', optional($tracer)->tahun_mulai) }}" placeholder="YYYY">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Institusi</label>
                                <input type="text" class="form-control form-control-solid" name="tracer[institusi_nama]" value="{{ old('tracer.institusi_nama', optional($tracer)->institusi_nama) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Bidang Institusi</label>
                                <input type="text" class="form-control form-control-solid" name="tracer[institusi_bidang]" value="{{ old('tracer.institusi_bidang', optional($tracer)->institusi_bidang) }}">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Alamat Institusi</label>
                                <textarea class="form-control form-control-solid" rows="3" name="tracer[institusi_alamat]">{{ old('tracer.institusi_alamat', optional($tracer)->institusi_alamat) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Range Pendapatan</label>
                                <input type="text" class="form-control form-control-solid" name="tracer[pendapatan_range]" value="{{ old('tracer.pendapatan_range', optional($tracer)->pendapatan_range) }}" placeholder="Rp ...">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Catatan</label>
                                <textarea class="form-control form-control-solid" rows="3" name="tracer[catatan]">{{ old('tracer.catatan', optional($tracer)->catatan) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('profile.show') }}" class="btn btn-light">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
        @endif

        <div class="tab-pane fade" id="tab-edit-berkas" role="tabpanel">
            @if(session('status') && session('activeTab') === 'berkas')
            <div class="alert alert-success alert-dismissible fade show mb-5" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="row g-5">
                <!--begin::Upload CV Card-->
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder fs-3 mb-1">Upload CV</span>
                                <span class="text-muted mt-1 fw-semibold fs-7">Curriculum Vitae</span>
                            </h3>
                        </div>
                        <div class="card-body pt-5">
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="section" value="berkas">
                                <input type="hidden" name="jenis" value="CV">

                                <div class="mb-5">
                                    <label class="form-label fw-bold required">File CV</label>
                                    <input type="file" name="file" class="form-control form-control-lg" accept=".pdf,.doc,.docx">
                                    <div class="form-text">Format: PDF, DOC, DOCX. Maksimal 5MB</div>
                                    @error('file')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-grid mt-5">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-upload me-2"></i>Upload CV
                                    </button>
                                </div>
                            </form>

                            <div class="separator my-5"></div>

                            <!-- Daftar CV yang sudah diupload -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">CV Tersimpan</label>
                            </div>
                            @php
                            $cvList = $berkas->where('jenis', 'CV');
                            @endphp
                            @forelse($cvList as $item)
                            <div class="d-flex align-items-center justify-content-between bg-light-primary rounded p-3 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-file-earmark-pdf text-primary fs-2x me-3"></i>
                                    <div>
                                        <span class="text-dark fw-bold d-block">{{ basename($item->file_path) }}</span>
                                        <span class="text-muted fs-7">{{ $item->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-icon btn-sm btn-light-primary" title="Lihat">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ asset('storage/' . $item->file_path) }}" download class="btn btn-icon btn-sm btn-light-success" title="Download">
                                        <i class="bi bi-download"></i>
                                    </a>
                                    <form action="{{ route('profile.berkas.delete', $item->id) }}" method="POST" class="d-inline delete-berkas-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-icon btn-sm btn-light-danger btn-delete-berkas" data-berkas-id="{{ $item->id }}" data-berkas-type="CV" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-5 bg-light rounded">
                                <i class="bi bi-file-earmark-text fs-2x text-muted mb-2"></i>
                                <p class="text-muted mb-0">Belum ada CV yang diunggah</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <!--end::Upload CV Card-->

                <!--begin::Upload Surat Lamaran Card-->
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder fs-3 mb-1">Upload Surat Lamaran</span>
                                <span class="text-muted mt-1 fw-semibold fs-7">Cover Letter</span>
                            </h3>
                        </div>
                        <div class="card-body pt-5">
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="section" value="berkas">
                                <input type="hidden" name="jenis" value="Surat Lamaran">

                                <div class="mb-5">
                                    <label class="form-label fw-bold required">File Surat Lamaran</label>
                                    <input type="file" name="file" class="form-control form-control-lg" accept=".pdf,.doc,.docx">
                                    <div class="form-text">Format: PDF, DOC, DOCX. Maksimal 5MB</div>
                                    @error('file')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-grid mt-5">
                                    <button type="submit" class="btn btn-info">
                                        <i class="bi bi-upload me-2"></i>Upload Surat Lamaran
                                    </button>
                                </div>
                            </form>

                            <div class="separator my-5"></div>

                            <!-- Daftar Surat Lamaran yang sudah diupload -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Surat Lamaran Tersimpan</label>
                            </div>
                            @php
                            $suratList = $berkas->where('jenis', 'Surat Lamaran');
                            @endphp
                            @forelse($suratList as $item)
                            <div class="d-flex align-items-center justify-content-between bg-light-info rounded p-3 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-file-earmark-pdf text-info fs-2x me-3"></i>
                                    <div>
                                        <span class="text-dark fw-bold d-block">{{ basename($item->file_path) }}</span>
                                        <span class="text-muted fs-7">{{ $item->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-icon btn-sm btn-light-info" title="Lihat">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ asset('storage/' . $item->file_path) }}" download class="btn btn-icon btn-sm btn-light-success" title="Download">
                                        <i class="bi bi-download"></i>
                                    </a>
                                    <form action="{{ route('profile.berkas.delete', $item->id) }}" method="POST" class="d-inline delete-berkas-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-icon btn-sm btn-light-danger btn-delete-berkas" data-berkas-id="{{ $item->id }}" data-berkas-type="Surat Lamaran" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-5 bg-light rounded">
                                <i class="bi bi-file-earmark-text fs-2x text-muted mb-2"></i>
                                <p class="text-muted mb-0">Belum ada Surat Lamaran yang diunggah</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <!--end::Upload Surat Lamaran Card-->
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle active tab from session
            @if(session('activeTab'))
            var activeTab = '{{ session("activeTab") }}';
            if (activeTab === 'berkas') {
                var berkasTab = document.querySelector('a[href="#tab-edit-berkas"]');
                if (berkasTab) {
                    var tab = new bootstrap.Tab(berkasTab);
                    tab.show();
                }
            } else if (activeTab === 'tracer') {
                var tracerTab = document.querySelector('a[href="#tab-edit-tracer"]');
                if (tracerTab) {
                    var tab = new bootstrap.Tab(tracerTab);
                    tab.show();
                }
            }
            @endif

            // Handle delete berkas with SweetAlert2
            document.querySelectorAll('.btn-delete-berkas').forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    var berkasType = this.getAttribute('data-berkas-type');
                    var form = this.closest('form');

                    Swal.fire({
                        title: 'Hapus ' + berkasType + '?',
                        text: "Anda yakin ingin menghapus berkas ini? Tindakan ini tidak dapat dibatalkan.",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Ya, Hapus!",
                        cancelButtonText: "Batal",
                        customClass: {
                            confirmButton: "btn btn-danger",
                            cancelButton: "btn btn-active-light"
                        }
                    }).then(function(result) {
                        if (result.value) {
                            // Submit the form
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
    @endpush
    @endsection