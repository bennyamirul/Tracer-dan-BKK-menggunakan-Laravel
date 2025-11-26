@extends('layouts.app')

@section('title', 'Tracer Alumni')

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
                <span class="card-label fw-bolder fs-3 mb-1">Data Tracer Alumni</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Total {{ $items->count() }} tracer alumni</span>
            </h3>
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
                <input type="text" id="searchInput" class="form-control form-control-solid w-100 w-md-250px ps-14" placeholder="Cari tracer alumni...">
            </div>
            <!--begin::Export-->
            <button type="button" class="btn btn-light-primary w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#kt_subscriptions_export_modal">
                <!--begin::Svg Icon | path: icons/duotune/arrows/arr078.svg-->
                <span class="svg-icon svg-icon-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1" transform="rotate(90 12.75 4.25)" fill="black" />
                        <path d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z" fill="black" />
                        <path d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z" fill="#C4C4C4" />
                    </svg>
                </span>
                <!--end::Svg Icon-->Export</button>
            <!--end::Export-->
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
                            <th class="min-w-200px">Nama Alumni</th>
                            <th class="min-w-100px">Jurusan</th>
                            <th class="min-w-100px">Angkatan</th>
                            <th class="min-w-100px">Kegiatan</th>
                            <th class="min-w-100px text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                        @forelse($items as $index => $tracer)
                        <tr>
                            <td>
                                <div class="text-muted fw-bold fs-6 ps-5">{{ $index + 1 }}</div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-45px me-3">
                                        <img src="{{ $tracer->user->avatar ? asset('storage/' . $tracer->user->avatar) : asset('assets/media/avatars/blank.png') }}" alt="{{ $tracer->user->nama }}" />
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="text-dark fw-bold text-hover-primary text-capitalize">{{ $tracer->user->nama }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-dark fs-6 text-capitalize">{{ $tracer->jurusan->nama }}</span>
                            </td>
                            <td>
                                <span class="text-dark fs-6 text-capitalize">{{ $tracer->angkatan->tahun }}</span>
                            </td>
                            <td>
                                <span class="text-dark fs-6 text-capitalize">{{ $tracer->kegiatan->nama }}</span>
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.profile-user.show', $tracer->user->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" title="Show">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.profile-user.edit', $tracer->user->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" title="Edit">
                                    <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor" />
                                            <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                </a>
                                <form action="{{ route('admin.tracer.destroy', $tracer->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tracer alumni ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm" title="Hapus">
                                        <span class="svg-icon svg-icon-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
                                                <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
                                                <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-10">
                                <div class="text-gray-600 fs-5 fw-semibold">
                                    Belum ada data tracer alumni
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

<!--begin::Modal - Export-->
<div class="modal fade" id="kt_subscriptions_export_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bolder">Export Data Tracer Alumni</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <form id="export_form" action="{{ route('admin.tracer.export') }}" method="GET">
                    <div class="fv-row mb-10">
                        <label class="fs-5 fw-bold form-label mb-5">Pilih Range Tanggal (Opsional):</label>
                        <input id="date_range" class="form-control form-control-solid" placeholder="Pilih tanggal" name="date" />
                        <div class="form-text">Kosongkan jika ingin export semua data</div>
                    </div>
                    <div class="fv-row mb-10">
                        <label class="fs-5 fw-bold form-label mb-5">Format Export:</label>
                        <select name="format" class="form-select form-select-solid">
                            <option value="xlsx">Excel (.xlsx)</option>
                            <option value="pdf">PDF (.pdf)</option>
                        </select>
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Export</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<!--end::Modal - Export-->
<!--begin::Charts Widget 1-->
<div class="card card-xl-stretch mb-xl-8">
    <!--begin::Header-->
    <div class="card-header border-0 pt-5">
        <!--begin::Title-->
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bolder fs-3 mb-1">Statistik Alumni Berdasarkan Kegiatan</span>
            <span class="text-muted fw-bold fs-7">Total {{ $totalTracerAlumni }} alumni terdaftar</span>
        </h3>
        <!--end::Title-->
        <!--begin::Toolbar-->
        <div class="card-toolbar">
            <!--begin::Menu-->
            <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                <span class="svg-icon svg-icon-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="5" y="5" width="5" height="5" rx="1" fill="#000000" />
                            <rect x="14" y="5" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
                            <rect x="5" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
                            <rect x="14" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
                        </g>
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </button>
            <!--begin::Menu 1-->
            <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_dashboard_filter">
                <!--begin::Header-->
                <div class="px-7 py-5">
                    <div class="fs-5 text-dark fw-bolder">Filter Angkatan</div>
                </div>
                <!--end::Header-->
                <!--begin::Menu separator-->
                <div class="separator border-gray-200"></div>
                <!--end::Menu separator-->
                <!--begin::Form-->
                <form action="{{ route('admin.tracer.index') }}" method="GET" id="filterForm">
                    <div class="px-7 py-5">
                        <!--begin::Input group-->
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-bold">Pilih Angkatan:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div>
                                <select name="angkatan_id" class="form-select form-select-solid" id="angkatanSelect">
                                    <option value="">Semua Angkatan</option>
                                    @foreach($angkatans as $angkatan)
                                    <option value="{{ $angkatan->id }}" {{ $angkatanId == $angkatan->id ? 'selected' : '' }}>
                                        {{ $angkatan->display_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.tracer.index') }}" class="btn btn-sm btn-light btn-active-light-primary me-2">Reset</a>
                            <button type="submit" class="btn btn-sm btn-primary">Terapkan</button>
                        </div>
                        <!--end::Actions-->
                    </div>
                </form>
                <!--end::Form-->
            </div>
            <!--end::Menu 1-->
            <!--end::Menu-->
        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body">
        <!--begin::Chart-->
        <canvas id="kt_charts_widget_1_chart"
            data-chart='@json($statistikKegiatan)'
            style="height: 350px"></canvas>
        <!--end::Chart-->
    </div>
    <!--end::Body-->
</div>
<!--end::Charts Widget 1-->
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // DataTable
        $dataTable = $('#kt_datatable_example_1').DataTable();
        $('#searchInput').on('keyup', function() {
            $dataTable.search(this.value).draw();
        });

        // Flatpickr untuk date range picker
        $("#date_range").flatpickr({
            altInput: true,
            altFormat: "d M Y",
            dateFormat: "Y-m-d",
            mode: "range",
            locale: {
                rangeSeparator: ' to '
            }
        });

        // Handle form export submit
        $('#export_form').on('submit', function(e) {
            // Tutup modal setelah submit
            setTimeout(function() {
                $('#kt_subscriptions_export_modal').modal('hide');
            }, 500);

            // Tampilkan notifikasi
            Swal.fire({
                text: "File sedang didownload...",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn btn-primary"
                },
                timer: 2000
            });
        });
    });
    "use strict";

    var KTChartsWidget1 = function() {
        var chart = {
            self: null,
            rendered: false
        };

        var initChart = function() {
            var element = document.getElementById("kt_charts_widget_1_chart");

            if (!element) {
                return;
            }

            var dataAttr = element.getAttribute('data-chart');

            if (!dataAttr) {
                var parent = element.parentElement;
                parent.innerHTML = '<div class="text-center py-10"><p class="text-muted">Data tidak ditemukan</p></div>';
                return;
            }

            var chartData = JSON.parse(dataAttr);
            var categories = Object.keys(chartData);
            var seriesData = Object.values(chartData);

            if (categories.length === 0) {
                var parent = element.parentElement;
                parent.innerHTML = '<div class="text-center py-10"><div class="d-flex flex-column align-items-center"><i class="fas fa-chart-bar fs-3x text-muted mb-3"></i><p class="text-muted fs-5">Belum ada data statistik alumni</p></div></div>';
                return;
            }

            var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
            var borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
            var colors = ['#3E97FF', '#50CD89', '#F1416C', '#FFC700', '#7239EA', '#50CDCD', '#FF6B6B'];

            // Plugin untuk shadow effect
            const shadowPlugin = {
                id: 'shadowPlugin',
                beforeDatasetsDraw: function(chart) {
                    const ctx = chart.ctx;
                    ctx.save();
                    ctx.shadowColor = 'rgba(0, 0, 0, 0.15)';
                    ctx.shadowBlur = 10;
                    ctx.shadowOffsetX = 0;
                    ctx.shadowOffsetY = 4;
                },
                afterDatasetsDraw: function(chart) {
                    chart.ctx.restore();
                }
            };

            // Use Chart.js
            var ctx = element.getContext('2d');

            chart.self = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: categories,
                    datasets: [{
                        label: 'Jumlah Alumni',
                        data: seriesData,
                        backgroundColor: colors,
                        borderColor: colors,
                        borderWidth: 0,
                        borderRadius: 8,
                        barPercentage: 0.4,
                        categoryPercentage: 0.7
                    }]
                },
                plugins: [shadowPlugin],
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + ' alumni';
                                }
                            },
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            displayColors: false,
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#ddd',
                            borderWidth: 1
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                callback: function(value) {
                                    if (Number.isInteger(value)) {
                                        return value;
                                    }
                                },
                                font: {
                                    size: 12,
                                    family: 'Poppins'
                                },
                                color: labelColor
                            },
                            title: {
                                display: true,
                                text: 'Jumlah Alumni',
                                font: {
                                    size: 13,
                                    weight: 'bold',
                                    family: 'Poppins'
                                },
                                color: labelColor
                            },
                            grid: {
                                color: borderColor,
                                drawBorder: false
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 12,
                                    weight: '600',
                                    family: 'Poppins'
                                },
                                color: labelColor
                            },
                            grid: {
                                display: false,
                                drawBorder: false
                            }
                        }
                    }
                }
            });

            chart.rendered = true;
        }

        // Public methods
        return {
            init: function() {
                initChart();
            }
        }
    }();

    // On document ready
    KTUtil.onDOMContentLoaded(function() {
        KTChartsWidget1.init();
    });
</script>
@endpush