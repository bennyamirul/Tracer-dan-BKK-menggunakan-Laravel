@extends('layouts.landing')

@section('content')
<div class="container py-10">
    <!--begin::Page Header-->
    <div class="d-flex flex-wrap flex-stack mb-6">
        <h1 class="fs-2x fw-bold my-2">Tracer Alumni</h1>
        <div class="d-flex align-items-center my-2">
            <span class="text-muted">Lacak dan pantau perkembangan karir alumni</span>
        </div>
    </div>
    <!--end::Page Header-->

    <!--begin::Card-->
    <div class="card shadow-sm">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Data Tracer Alumni</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Total {{ $tracers->count() }} alumni</span>
            </h3>
        </div>
        <!--end::Header-->
        <div class="d-flex flex-row justify-content-between mt-3 ms-8 pe-8">
            <div class="position-relative my-1">
                <span class="svg-icon svg-icon-1 position-absolute translate-middle-y top-50 ms-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                    </svg>
                </span>
                <input type="text" id="searchInput" class="form-control form-control-solid w-250px ps-14" placeholder="Cari tracer alumni...">
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
                            <th class="ps-4">No</th>
                            <th class="min-w-200px">Nama Alumni</th>
                            <th class="min-w-150px">Jurusan</th>
                            <th class="min-w-100px">Angkatan</th>
                            <th class="min-w-100px">Kegiatan</th>
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                        @forelse($tracers as $index => $tracer)
                        <tr>
                            <td class="ps-4">
                                <div class="text-gray-800 fw-bold fs-6">{{ $index + 1 }}</div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-45px me-3">
                                        @if($tracer->user && $tracer->user->avatar)
                                        <img src="{{ asset('storage/' . $tracer->user->avatar) }}" alt="{{ $tracer->user->nama }}" style="object-fit: cover; border-radius: 0.475rem;" />
                                        @else
                                        <div class="symbol-label bg-light-primary">
                                            <span class="text-primary fw-bold">{{ $tracer->user ? strtoupper(substr($tracer->user->nama, 0, 2)) : 'NA' }}</span>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="text-gray-800 fw-bold text-hover-primary">{{ $tracer->user ? $tracer->user->nama : '-' }}</span>
                                        <span class="text-muted fs-7">{{ $tracer->user ? $tracer->user->email : '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-gray-800 fs-6">{{ $tracer->jurusan ? $tracer->jurusan->nama : '-' }}</span>
                            </td>
                            <td>
                                <span class="text-gray-800 fs-6">{{ $tracer->angkatan ? $tracer->angkatan->tahun : '-' }}</span>
                            </td>
                            <td>
                                <span class="badge badge-light-info">{{ $tracer->kegiatan ? $tracer->kegiatan->nama : '-' }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-10">
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
    <!--end::Card-->

    <!--begin::Charts Widget-->
    <div class="card shadow-sm mt-6">
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
                    <!--begin::Svg Icon-->
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
                <!--begin::Menu-->
                <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true">
                    <!--begin::Header-->
                    <div class="px-7 py-5">
                        <div class="fs-5 text-dark fw-bolder">Filter Angkatan</div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Separator-->
                    <div class="separator border-gray-200"></div>
                    <!--end::Separator-->
                    <!--begin::Form-->
                    <form action="{{ route('tracer-alumni') }}" method="GET">
                        <div class="px-7 py-5">
                            <!--begin::Input group-->
                            <div class="mb-10">
                                <label class="form-label fw-bold">Pilih Angkatan:</label>
                                <div>
                                    <select name="angkatan_id" class="form-select form-select-solid">
                                        <option value="">Semua Angkatan</option>
                                        @foreach($angkatans as $angkatan)
                                        <option value="{{ $angkatan->id }}" {{ ($angkatanId ?? '') == $angkatan->id ? 'selected' : '' }}>
                                            {{ $angkatan->tahun }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Actions-->
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('tracer-alumni') }}" class="btn btn-sm btn-light btn-active-light-primary me-2">Reset</a>
                                <button type="submit" class="btn btn-sm btn-primary">Terapkan</button>
                            </div>
                            <!--end::Actions-->
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Menu-->
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body">
            <!--begin::Chart-->
            <canvas id="kt_charts_tracer_public"
                data-chart='@json($statistikKegiatan)'
                style="height: 350px"></canvas>
            <!--end::Chart-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Charts Widget-->
</div>

@endsection
@push('scripts')
<script>
    "use strict";

    var KTChartsTracerPublic = function() {
        var chart = {
            self: null,
            rendered: false
        };

        var initChart = function() {
            var element = document.getElementById("kt_charts_tracer_public");

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
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            borderColor: 'rgba(255, 255, 255, 0.1)',
                            borderWidth: 1,
                            padding: 12,
                            displayColors: false,
                            cornerRadius: 8
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                callback: function(value) {
                                    return Number.isInteger(value) ? value : '';
                                },
                                color: labelColor,
                                font: {
                                    size: 12
                                }
                            },
                            grid: {
                                color: borderColor,
                                drawBorder: false
                            }
                        },
                        x: {
                            ticks: {
                                color: labelColor,
                                font: {
                                    size: 12
                                }
                            },
                            grid: {
                                display: false,
                                drawBorder: false
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });
        };

        return {
            init: function() {
                initChart();
            }
        };
    }();

    KTUtil.onDOMContentLoaded(function() {
        KTChartsTracerPublic.init();
    });

    $(document).ready(function() {
        $dataTable = $('#kt_datatable_example_1').DataTable();
        $('#searchInput').on('keyup', function() {
            $dataTable.search(this.value).draw();
        });
    });
</script>
@endpush