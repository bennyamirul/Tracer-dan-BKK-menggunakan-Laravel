@extends('layouts.dudi')

@section('title', 'Data Lamaran')

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
                <span class="card-label fw-bolder fs-3 mb-1">Data Lamaran</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Total {{ $lamarans->count() }} lamaran</span>
            </h3>
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
                <input type="text" id="searchInput" class="form-control form-control-solid w-250px ps-14" placeholder="Cari lamaran...">
            </div>
        </div>
        <!--end::Search Box-->
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
                            <th class="min-w-200px">Nama Pelamar</th>
                            <th class="min-w-200px">Perusahaan</th>
                            <th class="min-w-150px">Posisi</th>
                            <th class="min-w-150px">Tanggal Lamaran</th>
                            <th class="min-w-200px">Tanggal Wawancara</th>
                            <th class="min-w-150px">Status</th>
                            <th class="min-w-150px text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                        @forelse ($lamarans as $index => $item)
                        <tr>
                            <td class="text-muted fw-bold ps-4">{{ $index + 1 }}</td>
                            <td class="text-dark fw-bold text-capitalize">{{ $item->user->nama }}</td>
                            <td class="text-dark fw-bold text-capitalize">{{ $item->lowongan->perusahaan->nama_perusahaan }}</td>
                            <td class="text-dark fw-bold text-capitalize">{{ $item->lowongan->posisi }}</td>
                            <td>{{ $item->tanggal_lamaran ? \Carbon\Carbon::parse($item->tanggal_lamaran)->format('d M Y') : '-' }}</td>
                            <td>{{ $item->tanggal_wawancara ? \Carbon\Carbon::parse($item->tanggal_wawancara)->format('d M Y') : '-' }}</td>
                            <td>
                                @if($item->status === 'diajukan')
                                <span class="badge badge-light-primary">Diajukan</span>
                                @elseif($item->status === 'diproses')
                                <span class="badge badge-light-warning">Diproses</span>
                                @elseif($item->status === 'wawancara')
                                <span class="badge badge-light-info">Wawancara</span>
                                @elseif($item->status === 'diterima')
                                <span class="badge badge-light-success">Diterima</span>
                                @elseif($item->status === 'ditolak')
                                <span class="badge badge-light-danger">Ditolak</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin_dudi.profile-user.index', $item->user_id) }}"
                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                    data-bs-toggle="tooltip"
                                    title="Detail Pelamar">
                                    <i class="fas fa-user fs-5"></i>
                                </a>

                                <a href="{{ route('admin_dudi.lamaran.show-lowongan', $item->id) }}"
                                    class="btn btn-icon btn-bg-light btn-active-color-info btn-sm me-1"
                                    data-bs-toggle="tooltip"
                                    title="Detail Lowongan">
                                    <i class="fas fa-briefcase fs-5"></i>
                                </a>

                                <a href="{{ route('admin_dudi.lamaran.edit', $item->id) }}"
                                    class="btn btn-icon btn-bg-light btn-active-color-warning btn-sm"
                                    data-bs-toggle="tooltip"
                                    title="Edit Status">
                                    <i class="fas fa-edit fs-5"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data lamaran</td>
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

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
@endsection