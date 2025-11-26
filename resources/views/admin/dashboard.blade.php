@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div id="kt_content_container" class="container-xxl">
    <!--begin::Header-->
    <div class="mb-8">
        <h1 class="fw-bolder text-dark mb-2">Dashboard</h1>
        <p class="text-muted fs-6 mb-0">Selamat datang di panel admin TracerBKK</p>
    </div>
    <!--end::Header-->

    <!--begin::Stats Row-->
    <div class="row g-6 g-xl-9 mb-6">
        <!--begin::Col - Tracer Alumni-->
        <div class="col-sm-6 col-xl-3">
            <a href="{{ route('admin.tracer.index') }}" class="card h-100 hoverable">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex align-items-center mb-5">
                        <div class="symbol symbol-50px me-3">
                            <span class="symbol-label bg-light-info">
                                <i class="fas fa-graduation-cap fs-2x text-info"></i>
                            </span>
                        </div>
                        <div>
                            <div class="fs-7 text-muted fw-semibold">Tracer Alumni</div>
                            <div class="fs-2hx fw-bold text-dark">{{ $totalTracerAlumni }}</div>
                        </div>
                    </div>
                    <div class="text-muted fs-7">
                        <i class="fas fa-chart-line text-info me-1"></i>
                        Total data tracer alumni
                    </div>
                </div>
            </a>
        </div>
        <!--end::Col-->

        <!--begin::Col - Data Perusahaan-->
        <div class="col-sm-6 col-xl-3">
            <a href="{{ route('admin.perusahaan.index') }}" class="card h-100 hoverable">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex align-items-center mb-5">
                        <div class="symbol symbol-50px me-3">
                            <span class="symbol-label bg-light-primary">
                                <i class="fas fa-building fs-2x text-primary"></i>
                            </span>
                        </div>
                        <div>
                            <div class="fs-7 text-muted fw-semibold">Data Perusahaan</div>
                            <div class="fs-2hx fw-bold text-dark">{{ $totalPerusahaan }}</div>
                        </div>
                    </div>
                    <div class="text-muted fs-7">
                        <i class="fas fa-briefcase text-primary me-1"></i>
                        Total perusahaan terdaftar
                    </div>
                </div>
            </a>
        </div>
        <!--end::Col-->

        <!--begin::Col - Data Pelamar-->
        <div class="col-sm-6 col-xl-3">
            <a href="{{ route('admin.pelamar.index') }}" class="card h-100 hoverable">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex align-items-center mb-5">
                        <div class="symbol symbol-50px me-3">
                            <span class="symbol-label bg-light-success">
                                <i class="fas fa-users fs-2x text-success"></i>
                            </span>
                        </div>
                        <div>
                            <div class="fs-7 text-muted fw-semibold">Data Pelamar</div>
                            <div class="fs-2hx fw-bold text-dark">{{ $totalPelamar }}</div>
                        </div>
                    </div>
                    <div class="text-muted fs-7">
                        <i class="fas fa-user-check text-success me-1"></i>
                        Total pelamar kerja
                    </div>
                </div>
            </a>
        </div>
        <!--end::Col-->

        <!--begin::Col - Data Lowongan-->
        <div class="col-sm-6 col-xl-3">
            <a href="{{ route('admin.lowongan.index') }}" class="card h-100 hoverable">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex align-items-center mb-5">
                        <div class="symbol symbol-50px me-3">
                            <span class="symbol-label bg-light-warning">
                                <i class="fas fa-clipboard-list fs-2x text-warning"></i>
                            </span>
                        </div>
                        <div>
                            <div class="fs-7 text-muted fw-semibold">Data Lowongan</div>
                            <div class="fs-2hx fw-bold text-dark">{{ $totalLowongan }}</div>
                        </div>
                    </div>
                    <div class="text-muted fs-7">
                        <i class="fas fa-file-alt text-warning me-1"></i>
                        Total lowongan kerja
                    </div>
                </div>
            </a>
        </div>
        <!--end::Col-->
    </div>
    <!--end::Stats Row-->
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
                    <form action="{{ route('admin.dashboard') }}" method="GET" id="filterForm">
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
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-light btn-active-light-primary me-2">Reset</a>
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
</div>

<style>
    .hoverable {
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .hoverable:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
</style>

@push('scripts')
<script>
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
@endsection