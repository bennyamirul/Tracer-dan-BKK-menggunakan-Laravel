@extends('layouts.app')

@section('content')
@php
$avatarPath = $user->avatar ? asset('storage/' . $user->avatar) : asset('assets/media/avatars/300-1.jpg');
@endphp
<div class="container-xxl py-5">
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
                                <span class="text-gray-900 fs-2 fw-bolder me-3">{{ $user->nama }}</span>
                            </div>
                            <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                                <span class="d-flex align-items-center text-gray-600 me-5 mb-2"><i class="fa-regular fa-envelope me-2"></i>{{ $user->email }}</span>
                                @if($user->no_telp)
                                <span class="d-flex align-items-center text-gray-600 me-5 mb-2"><i class="fa-solid fa-phone me-2"></i>{{ $user->no_telp }}</span>
                                @endif
                                @if($user->alamat)
                                <span class="d-flex align-items-center text-gray-600 mb-2"><i class="fa-solid fa-location-dot me-2"></i>{{ $user->alamat }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="d-flex my-4">
                            <a href="{{ route('admin.profile-user.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit Profil</a>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap flex-stack">
                        <div class="d-flex flex-column flex-grow-1 pe-8">
                            <div class="d-flex flex-wrap">
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <div class="fw-bold fs-6 text-gray-600">Role</div>
                                    <div class="fs-6 fw-bolder">{{ $user->role }}</div>
                                </div>
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <div class="fw-bold fs-6 text-gray-600">Bergabung</div>
                                    <div class="fs-6 fw-bolder">{{ $user->created_at?->format('d M Y') }}</div>
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
            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-5 fw-bolder" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#tab-data-diri" aria-selected="true" role="tab">Data Diri</a>
                </li>
                @if($user->role === 'pelamar_alumni')
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#tab-tracer" aria-selected="false" role="tab">Tracer Alumni</a>
                </li>
                @endif
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#tab-berkas" aria-selected="false" role="tab">Berkas</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#tab-lamaran" aria-selected="false" role="tab">Riwayat Lamaran</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab-data-diri" role="tabpanel">
                    <h3 class="fw-bolder mb-6">Data Diri</h3>
                    <div class="p-0">
                        <div class="row g-6 g-xl-9">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-light-primary me-4 p-4"><i class="fa-regular fa-id-card"></i></span>
                                    <div>
                                        <div class="text-gray-600">Nama</div>
                                        <div class="fs-6 fw-bolder text-gray-800">{{ $user->nama }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-light-success me-4 p-4"><i class="fa-regular fa-envelope"></i></span>
                                    <div>
                                        <div class="text-gray-600">Email</div>
                                        <div class="fs-6 fw-bolder text-gray-800">{{ $user->email }}</div>
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

                @if($user->role === 'pelamar_alumni')
                <div class="tab-pane fade" id="tab-tracer" role="tabpanel">
                    <h3 class="fw-bolder mb-6">Tracer Alumni</h3>
                    <div class="p-0">
                        @if($tracer)
                        <div class="row g-6 g-xl-9">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <div class="text-gray-600">Jurusan</div>
                                    <div class="fs-6 fw-bolder text-gray-800">{{ optional($tracer->jurusan)->nama ?? '-' }}</div>
                                </div>
                                <div class="mb-4">
                                    <div class="text-gray-600">Angkatan</div>
                                    <div class="fs-6 fw-bolder text-gray-800">{{ optional($tracer->angkatan)->tahun ?? '-' }}</div>
                                </div>
                                <div class="mb-4">
                                    <div class="text-gray-600">Kegiatan</div>
                                    <div class="fs-6 fw-bolder text-gray-800">{{ optional($tracer->kegiatan)->nama ?? '-' }}</div>
                                </div>
                                <div class="mb-4">
                                    <div class="text-gray-600">Posisi/Peran</div>
                                    <div class="fs-6 fw-bolder text-gray-800">{{ $tracer->posisi_peran ?? '-' }}</div>
                                </div>
                                <div class="mb-4">
                                    <div class="text-gray-600">Relevansi Jurusan</div>
                                    <div class="fs-6 fw-bolder text-gray-800 text-capitalize">{{ $tracer->relevansi_jurusan ?? '-' }}</div>
                                </div>
                                <div class="mb-4">
                                    <div class="text-gray-600">Tahun Mulai</div>
                                    <div class="fs-6 fw-bolder text-gray-800">{{ $tracer->tahun_mulai ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <div class="text-gray-600">Institusi</div>
                                    <div class="fs-6 fw-bolder text-gray-800">{{ $tracer->institusi_nama ?? '-' }}</div>
                                </div>
                                <div class="mb-4">
                                    <div class="text-gray-600">Bidang</div>
                                    <div class="fs-6 fw-bolder text-gray-800">{{ $tracer->institusi_bidang ?? '-' }}</div>
                                </div>
                                <div class="mb-4">
                                    <div class="text-gray-600">Alamat</div>
                                    <div class="fs-6 fw-bolder text-gray-800">{{ $tracer->institusi_alamat ?? '-' }}</div>
                                </div>
                                <div class="mb-4">
                                    <div class="text-gray-600">Pendapatan</div>
                                    <div class="fs-6 fw-bolder text-gray-800">{{ $tracer->pendapatan_range ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="text-muted">Belum mengisi tracer alumni.</div>
                        @endif
                    </div>
                </div>
                @endif

                <div class="tab-pane fade" id="tab-berkas" role="tabpanel">
                    <h3 class="fw-bolder mb-6">Berkas</h3>

                    <div class="row g-5">
                        <!--begin::CV Section-->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header border-0 pt-5">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bolder fs-3 mb-1">CV (Curriculum Vitae)</span>
                                        <span class="text-muted mt-1 fw-semibold fs-7">Dokumen CV yang diunggah</span>
                                    </h3>
                                </div>
                                <div class="card-body pt-5">
                                    @php
                                    $cvList = $berkas->where('jenis', 'CV');
                                    @endphp
                                    @forelse($cvList as $item)
                                    <div class="d-flex align-items-center justify-content-between bg-light-primary rounded p-3 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-file-earmark-pdf text-primary fs-2x me-3"></i>
                                            <div>
                                                <span class="text-dark fw-bold d-block">{{ basename($item->file_path) }}</span>
                                                <span class="text-muted fs-7">{{ $item->created_at->format('d M Y H:i') }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-icon btn-sm btn-light-primary" title="Lihat">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ asset('storage/' . $item->file_path) }}" download class="btn btn-icon btn-sm btn-light-success" title="Download">
                                                <i class="bi bi-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center py-8 bg-light rounded">
                                        <i class="bi bi-file-earmark-text fs-2x text-muted mb-3 d-block"></i>
                                        <p class="text-muted mb-0">Belum ada CV yang diunggah</p>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <!--end::CV Section-->

                        <!--begin::Surat Lamaran Section-->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header border-0 pt-5">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bolder fs-3 mb-1">Surat Lamaran</span>
                                        <span class="text-muted mt-1 fw-semibold fs-7">Cover Letter yang diunggah</span>
                                    </h3>
                                </div>
                                <div class="card-body pt-5">
                                    @php
                                    $suratList = $berkas->where('jenis', 'Surat Lamaran');
                                    @endphp
                                    @forelse($suratList as $item)
                                    <div class="d-flex align-items-center justify-content-between bg-light-info rounded p-3 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-file-earmark-pdf text-info fs-2x me-3"></i>
                                            <div>
                                                <span class="text-dark fw-bold d-block">{{ basename($item->file_path) }}</span>
                                                <span class="text-muted fs-7">{{ $item->created_at->format('d M Y H:i') }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-icon btn-sm btn-light-info" title="Lihat">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ asset('storage/' . $item->file_path) }}" download class="btn btn-icon btn-sm btn-light-success" title="Download">
                                                <i class="bi bi-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center py-8 bg-light rounded">
                                        <i class="bi bi-file-earmark-text fs-2x text-muted mb-3 d-block"></i>
                                        <p class="text-muted mb-0">Belum ada Surat Lamaran yang diunggah</p>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <!--end::Surat Lamaran Section-->
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-lamaran" role="tabpanel">
                    <h3 class="fw-bolder mb-6">Riwayat Lamaran</h3>
                    <div class="p-0">
                        @forelse($lamarans as $l)
                        <div class="d-flex align-items-center justify-content-between border rounded p-4 mb-3">
                            <div>
                                <div class="fw-bolder">{{ optional($l->lowongan)->judul ?? 'Lowongan' }}</div>
                                @php
                                $statusColor = [
                                'diajukan' => 'secondary',
                                'diproses' => 'info',
                                'wawancara' => 'warning',
                                'diterima' => 'success',
                                'ditolak' => 'danger',
                                ][$l->status] ?? 'secondary';
                                @endphp
                                <div class="text-muted small mt-1">Status: <span class="badge badge-light-{{ $statusColor }} text-capitalize">{{ $l->status }}</span> • {{ $l->created_at->format('d M Y') }}</div>
                            </div>
                        </div>
                        @empty
                        <div class="text-muted">Belum ada riwayat lamaran.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection