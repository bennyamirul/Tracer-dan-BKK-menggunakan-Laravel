@extends('layouts.dudi')

@section('title', 'Dashboard Admin DU/DI')
@section('content')
<!--begin::Post-->
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Layout-->
        <div class="d-flex flex-column flex-xl-row">
            <!--begin::Sidebar-->
            <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                <!--begin::Card-->
                <div class="card mb-5 mb-xl-8">
                    <!--begin::Card body-->
                    <div class="card-body pt-15">
                        <!--begin::Summary (Logo dan Nama Perusahaan)-->
                        <div class="d-flex flex-center flex-column mb-5">
                            <div class="symbol symbol-100px symbol-circle mb-7">
                                <img src="{{ $perusahaan && $perusahaan->logo_path ? asset('storage/' . $perusahaan->logo_path) : asset('assets/media/avatars/blank.png') }}" alt="logo" />
                            </div>
                            <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bolder mb-1">{{ $perusahaan->nama_perusahaan ?? 'Perusahaan belum diatur' }}</a>
                        </div>
                        <!--end::Summary-->

                        <div class="separator separator-dashed my-3"></div>

                        <!--begin::Details toggle-->
                        <div class="d-flex flex-stack fs-4 py-3">
                            <div class="fw-bolder rotate collapsible" data-bs-toggle="collapse" href="#kt_customer_view_details" role="button" aria-expanded="false" aria-controls="kt_customer_view_details">Detail Perusahaan
                                <span class="ms-2 rotate-180">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                    <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </span>
                            </div>
                            <div class="modal fade"
                                id="editPerusahaanModal"
                                tabindex="-1"
                                aria-labelledby="editPerusahaanModalLabel"
                                aria-hidden="true"
                                data-modal-form
                                data-modal-edit
                                data-error-text="Maaf, sepertinya ada beberapa kesalahan yang terdeteksi, silakan coba lagi."
                                data-cancel-text="Apakah Anda yakin ingin membatalkan perubahan Perusahaan?">
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
                                            <form id="kt_modal_edit_perusahaan_form"
                                                action=""
                                                method="POST"
                                                class="form"
                                                data-action-template="{{ route('admin_dudi.dashboard.update', ':id') }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <!--begin::Heading-->
                                                <div class="mb-13 text-center">
                                                    <!--begin::Title-->
                                                    <h1 class="mb-3">Edit Perusahaan</h1>
                                                    <!--end::Title-->
                                                    <!--begin::Description-->
                                                    <div class="text-muted fw-semibold fs-5">Perbarui informasi Perusahaan</div>
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
                                                        <span class="required">Nama Perusahaan</span>
                                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Judul Lowongan"></i>
                                                    </label>
                                                    <!--end::Label-->
                                                    <input type="text"
                                                        class="form-control form-control-solid @error('nama_perusahaan') is-invalid @enderror"
                                                        placeholder="Nama Perusahaan"
                                                        name="nama_perusahaan"
                                                        id="editPerusahaanNamaPerusahaan"
                                                        value="{{ old('nama_perusahaan') }}"
                                                        data-validate='{"notEmpty":{"message":"Nama Perusahaan harus diisi"},"stringLength":{"min":2,"max":150,"message":"Nama Perusahaan harus antara 2-150 karakter"}}' />
                                                    @error('nama_perusahaan')
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
                                                        <span class="required">Email</span>
                                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Email"></i>
                                                    </label>
                                                    <!--end::Label-->
                                                    <input type="text"
                                                        class="form-control form-control-solid @error('email') is-invalid @enderror"
                                                        placeholder="Contoh: example@gmail.com"
                                                        name="email"
                                                        id="editPerusahaanEmail"
                                                        value="{{ old('email') }}"
                                                        data-validate='{"notEmpty":{"message":"Email harus diisi"},"email":{"message":"Email tidak valid"}}' />
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
                                                        <span class="required">No. Telepon</span>
                                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan No. Telepon"></i>
                                                    </label>
                                                    <input type="text"
                                                        class="form-control form-control-solid @error('no_telp') is-invalid @enderror"
                                                        placeholder="Contoh: 081234567890"
                                                        name="no_telp"
                                                        id="editPerusahaanNoTelp"
                                                        value="{{ old('no_telp') }}"
                                                        data-validate='{"notEmpty":{"message":"No. Telepon harus diisi"},"numeric":{"message":"No. Telepon harus berupa angka"}}' />
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
                                                        <span class="required">Alamat</span>
                                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Alamat"></i>
                                                    </label>
                                                    <input type="text"
                                                        class="form-control form-control-solid @error('alamat') is-invalid @enderror"
                                                        placeholder="Contoh: Jl. Raya No. 123, Jakarta"
                                                        name="alamat"
                                                        id="editPerusahaanAlamat"
                                                        value="{{ old('alamat') }}"
                                                        data-validate=''>
                                                    @error('alamat')
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
                                                        <span class="required">Deskripsi</span>
                                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Masukkan Deskripsi Perusahaan"></i>
                                                    </label>
                                                    <textarea
                                                        class="form-control form-control-solid @error('deskripsi') is-invalid @enderror"
                                                        placeholder="Contoh: Deskripsi Perusahaan"
                                                        name="deskripsi"
                                                        id="editPerusahaanDeskripsi"
                                                        rows="4"
                                                        data-validate=''>{{ old('deskripsi') }}</textarea>
                                                    @error('deskripsi')
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
                                                        <span>Logo Perusahaan</span>
                                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Upload logo baru jika ingin mengubah"></i>
                                                    </label>
                                                    <input type="file"
                                                        class="form-control form-control-solid @error('logo') is-invalid @enderror"
                                                        name="logo"
                                                        id="editPerusahaanLogo"
                                                        accept="image/*"
                                                        data-validate='' />
                                                    <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah logo.</div>
                                                    @error('logo')
                                                    <div class="fv-plugins-message-container invalid-feedback">
                                                        <div>{{ $message }}</div>
                                                    </div>
                                                    @enderror
                                                </div>
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
                            <span data-bs-toggle="tooltip" data-bs-trigger="hover" title="Edit detail perusahaan">
                                <a class="btn btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#editPerusahaanModal"
                                    data-id="{{ $perusahaan->id }}"
                                    data-nama_perusahaan="{{ $perusahaan->nama_perusahaan }}"
                                    data-email="{{ $perusahaan->email }}"
                                    data-no_telp="{{ $perusahaan->kontak }}"
                                    data-alamat="{{ $perusahaan->alamat }}"
                                    data-deskripsi="{{ $perusahaan->deskripsi }}"
                                    title="Edit">Edit</a>
                            </span>
                        </div>
                        <!--end::Details toggle-->

                        <!--begin::Details content-->
                        <div id="kt_customer_view_details" class="collapse">
                            <div class="py-5 fs-6">
                                <!--begin::Details item-->
                                <div class="fw-bolder mt-5">Email</div>
                                <div class="text-gray-600">
                                    <a href="mailto:{{ $perusahaan->email ?? '' }}" class="text-gray-600 text-hover-primary">{{ $perusahaan->email ?? '-' }}</a>
                                </div>
                                <!--end::Details item-->

                                <!--begin::Details item-->
                                <div class="fw-bolder mt-5">Alamat</div>
                                <div class="text-gray-600">{{ $perusahaan->alamat ?? '-' }}</div>
                                <!--end::Details item-->

                                <!--begin::Details item-->
                                <div class="fw-bolder mt-5">No. Telepon</div>
                                <div class="text-gray-600">{{ $perusahaan->kontak ?? '-' }}</div>
                                <!--end::Details item-->

                                <!--begin::Details item-->
                                <div class="fw-bolder mt-5">Deskripsi</div>
                                <div class="text-gray-600">{{ $perusahaan->deskripsi ?? '-' }}</div>
                                <!--end::Details item-->
                            </div>
                        </div>
                        <!--end::Details content-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Sidebar-->
            <!--begin::Content-->
            <div class="flex-lg-row-fluid ms-lg-15">
                <!--begin::Charts Widget 1-->
                <div class="card card-xl-stretch mb-xl-8">
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-5">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1">Lowongan Per Bulan</span>
                            <span class="text-muted fw-bold fs-7" id="lowongan_year_label">
                                Tahun {{ $currentYear }}
                                @php
                                $totalLowongan = array_sum($seriesLowonganBulanan);
                                @endphp
                                @if($totalLowongan > 0)
                                <span class="badge badge-light-primary ms-2">{{ $totalLowongan }} lowongan</span>
                                @endif
                            </span>
                        </h3>
                        <!--end::Title-->
                        <!--begin::Toolbar-->
                        <div class="card-toolbar">
                            <select class="form-select form-select-sm form-select-solid w-125px" id="lowongan_year_filter">
                                @foreach($availableYears as $year)
                                <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body">
                        @php
                        $hasLowonganData = !empty($lowonganPerTahun) && !empty($seriesLowonganBulanan) && array_sum($seriesLowonganBulanan) > 0;
                        @endphp

                        @if(!$hasLowonganData)
                        <!--begin::Notice-->
                        <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed p-6">
                            <span class="svg-icon svg-icon-2tx svg-icon-primary me-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                                    <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor" />
                                    <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor" />
                                </svg>
                            </span>
                            <div class="d-flex flex-stack flex-grow-1">
                                <div class="fw-bold">
                                    <h4 class="text-gray-900 fw-bolder">Belum Ada Data Lowongan</h4>
                                    <div class="fs-6 text-gray-700">Silakan buat lowongan kerja terlebih dahulu untuk melihat statistik.</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Notice-->
                        @else
                        <!--begin::Chart-->
                        <div id="kt_charts_widget_1_chart" style="height: 350px"></div>
                        <!--end::Chart-->

                        @push('scripts')
                        <script>
                            (function() {
                                var el = document.getElementById('kt_charts_widget_1_chart');
                                if (!el) return;

                                // Data per tahun dari server (DATA REAL DARI DATABASE LOWONGAN_KERJA)
                                var lowonganPerTahun = <?php echo json_encode($lowonganPerTahun, JSON_NUMERIC_CHECK); ?>;
                                var labels = <?php echo json_encode($labelsBulan); ?>;
                                var currentYear = <?php echo $currentYear; ?>;

                                // Debug: tampilkan data di console
                                console.log('=== DATA LOWONGAN DARI DATABASE ===');
                                console.log('Lowongan Per Tahun:', lowonganPerTahun);
                                console.log('Tahun Sekarang:', currentYear);
                                console.log('Labels Bulan:', labels);

                                var chart1 = null;

                                // Function untuk render chart dengan data REAL dari database
                                function renderChart(year) {
                                    var series = lowonganPerTahun[year] || Array(12).fill(0);

                                    // Debug: tampilkan series untuk tahun yang dipilih
                                    console.log('Rendering chart untuk tahun ' + year);
                                    console.log('Data series:', series);
                                    console.log('Total lowongan:', series.reduce((a, b) => a + b, 0));

                                    var options = {
                                        series: [{
                                            name: 'Lowongan',
                                            data: series
                                        }],
                                        chart: {
                                            type: 'bar',
                                            height: 350,
                                            toolbar: {
                                                show: false
                                            }
                                        },
                                        plotOptions: {
                                            bar: {
                                                borderRadius: 4,
                                                horizontal: false,
                                                columnWidth: '55%',
                                                dataLabels: {
                                                    position: 'top'
                                                }
                                            }
                                        },
                                        dataLabels: {
                                            enabled: true,
                                            offsetY: -20,
                                            style: {
                                                fontSize: '12px',
                                                colors: ["#304758"]
                                            }
                                        },
                                        colors: ['#009ef7'],
                                        xaxis: {
                                            categories: labels,
                                            labels: {
                                                style: {
                                                    fontSize: '12px'
                                                }
                                            }
                                        },
                                        yaxis: {
                                            title: {
                                                text: 'Jumlah Lowongan'
                                            },
                                            min: 0,
                                            forceNiceScale: true,
                                            labels: {
                                                formatter: function(val) {
                                                    return Math.floor(val);
                                                }
                                            }
                                        },
                                        tooltip: {
                                            y: {
                                                formatter: function(val) {
                                                    return val + " lowongan"
                                                }
                                            }
                                        },
                                        noData: {
                                            text: 'Tidak ada data lowongan',
                                            align: 'center',
                                            verticalAlign: 'middle',
                                            style: {
                                                fontSize: '16px'
                                            }
                                        }
                                    };

                                    if (chart1) {
                                        chart1.destroy();
                                    }
                                    chart1 = new ApexCharts(el, options);
                                    chart1.render();
                                }

                                // Render chart pertama kali dengan data REAL
                                renderChart(currentYear);

                                // Handle filter tahun
                                var yearFilter = document.getElementById('lowongan_year_filter');
                                if (yearFilter) {
                                    yearFilter.addEventListener('change', function() {
                                        var selectedYear = parseInt(this.value);
                                        renderChart(selectedYear);

                                        // Update label tahun dan badge
                                        var yearLabel = document.getElementById('lowongan_year_label');
                                        if (yearLabel) {
                                            var totalLowongan = lowonganPerTahun[selectedYear] ?
                                                lowonganPerTahun[selectedYear].reduce((a, b) => a + b, 0) : 0;

                                            var badgeHtml = totalLowongan > 0 ?
                                                ' <span class="badge badge-light-primary ms-2">' + totalLowongan + ' lowongan</span>' : '';

                                            yearLabel.innerHTML = 'Tahun ' + selectedYear + badgeHtml;
                                        }
                                    });
                                }
                            })();
                        </script>
                        @endpush
                        @endif
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Charts Widget 1-->
                <!--begin::Charts Widget 3-->
                <div class="card card-xl-stretch mb-xl-8">
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1">Lamaran Per Bulan</span>
                            <span class="text-muted fw-bold fs-7" id="lamaran_year_label">
                                Tahun {{ $currentYear }}
                                @php
                                $totalLamaran = array_sum($seriesLamaranBulanan);
                                @endphp
                                @if($totalLamaran > 0)
                                <span class="badge badge-light-success ms-2">{{ $totalLamaran }} lamaran</span>
                                @endif
                            </span>
                        </h3>
                        <!--begin::Toolbar-->
                        <div class="card-toolbar">
                            <select class="form-select form-select-sm form-select-solid w-125px" id="lamaran_year_filter">
                                @foreach($availableYearsLamaran as $year)
                                <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body">
                        @php
                        $hasLamaranData = !empty($lamaranPerTahun) && !empty($seriesLamaranBulanan) && array_sum($seriesLamaranBulanan) > 0;
                        @endphp

                        @if(!$hasLamaranData)
                        <!--begin::Notice-->
                        <div class="notice d-flex bg-light-success rounded border-success border border-dashed p-6">
                            <span class="svg-icon svg-icon-2tx svg-icon-success me-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                                    <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor" />
                                    <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor" />
                                </svg>
                            </span>
                            <div class="d-flex flex-stack flex-grow-1">
                                <div class="fw-bold">
                                    <h4 class="text-gray-900 fw-bolder">Belum Ada Data Lamaran</h4>
                                    <div class="fs-6 text-gray-700">Belum ada lamaran yang masuk untuk lowongan Anda.</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Notice-->
                        @else
                        <!--begin::Chart-->
                        <div id="kt_charts_widget_3_chart" style="height: 350px"></div>
                        <!--end::Chart-->

                        @push('scripts')
                        <script>
                            (function() {
                                var el = document.getElementById('kt_charts_widget_3_chart');
                                if (!el) return;

                                // Data per tahun dari server (DATA REAL DARI DATABASE LAMARAN)
                                var lamaranPerTahun = <?php echo json_encode($lamaranPerTahun, JSON_NUMERIC_CHECK); ?>;
                                var labels = <?php echo json_encode($labelsBulan); ?>;
                                var currentYear = <?php echo $currentYear; ?>;

                                var chart3 = null;

                                // Function untuk render chart dengan data REAL dari database
                                function renderChart(year) {
                                    var series = lamaranPerTahun[year] || Array(12).fill(0);

                                    var options = {
                                        series: [{
                                            name: 'Lamaran',
                                            data: series
                                        }],
                                        chart: {
                                            height: 350,
                                            type: 'area',
                                            toolbar: {
                                                show: false
                                            }
                                        },
                                        colors: ['#50cd89'],
                                        fill: {
                                            type: 'gradient',
                                            gradient: {
                                                shade: 'light',
                                                type: 'vertical',
                                                shadeIntensity: 0.3,
                                                gradientToColors: undefined,
                                                inverseColors: true,
                                                opacityFrom: 0.7,
                                                opacityTo: 0.3,
                                                stops: [0, 100]
                                            }
                                        },
                                        dataLabels: {
                                            enabled: false
                                        },
                                        stroke: {
                                            curve: 'smooth',
                                            width: 3
                                        },
                                        xaxis: {
                                            categories: labels,
                                            labels: {
                                                style: {
                                                    fontSize: '12px'
                                                }
                                            }
                                        },
                                        yaxis: {
                                            title: {
                                                text: 'Jumlah Lamaran'
                                            },
                                            min: 0,
                                            forceNiceScale: true,
                                            labels: {
                                                formatter: function(val) {
                                                    return Math.floor(val);
                                                }
                                            }
                                        },
                                        tooltip: {
                                            y: {
                                                formatter: function(val) {
                                                    return val + " lamaran"
                                                }
                                            }
                                        }
                                    };

                                    if (chart3) {
                                        chart3.destroy();
                                    }
                                    chart3 = new ApexCharts(el, options);
                                    chart3.render();
                                }

                                // Render chart pertama kali dengan data REAL
                                renderChart(currentYear);

                                // Handle filter tahun
                                var yearFilter = document.getElementById('lamaran_year_filter');
                                if (yearFilter) {
                                    yearFilter.addEventListener('change', function() {
                                        var selectedYear = parseInt(this.value);
                                        renderChart(selectedYear);

                                        // Update label tahun dan badge
                                        var yearLabel = document.getElementById('lamaran_year_label');
                                        if (yearLabel) {
                                            var totalLamaran = lamaranPerTahun[selectedYear] ?
                                                lamaranPerTahun[selectedYear].reduce((a, b) => a + b, 0) : 0;

                                            var badgeHtml = totalLamaran > 0 ?
                                                ' <span class="badge badge-light-success ms-2">' + totalLamaran + ' lamaran</span>' : '';

                                            yearLabel.innerHTML = 'Tahun ' + selectedYear + badgeHtml;
                                        }
                                    });
                                }
                            })();
                        </script>
                        @endpush
                        @endif
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Charts Widget 3-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Layout-->
    </div>
    <!--end::Container-->
</div>
<!--end::Post-->

@if(session('success'))
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
    <div class="toast show align-items-center text-white bg-success border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
    <div class="toast show align-items-center text-white bg-danger border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
@endif
@endsection