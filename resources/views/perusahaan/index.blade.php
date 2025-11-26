@extends('layouts.landing')

@section('title', 'Perusahaan Mitra')
@section('content')
<div class="container py-10">
    <!--begin::Page Header-->
    <div class="d-flex flex-wrap flex-stack mb-6">
        <h1 class="fs-2x text-gray-800 fw-bold my-2">Perusahaan Mitra</h1>
        <div class="d-flex align-items-center my-2">
            <span class="text-muted">Jelajahi perusahaan-perusahaan yang telah bermitra dengan kami</span>
        </div>
    </div>
    <!--end::Page Header-->

    <!--begin::Search Bar-->
    <div class="card shadow-sm mb-8">
        <div class="card-body p-5">
            <div class="position-relative" data-kt-search-element="wrapper">
                <i class="bi bi-search position-absolute top-50 translate-middle-y ms-4 fs-3 text-gray-500"></i>
                <input type="text"
                    class="form-control form-control-lg ps-14"
                    placeholder="Cari perusahaan berdasarkan nama atau lokasi..."
                    data-kt-search-element="input">
            </div>
        </div>
    </div>
    <!--end::Search Bar-->

    <!--begin::Result Info-->
    <div class="d-flex justify-content-between align-items-center mb-5 d-none" data-kt-search-element="info">
        <div class="text-gray-700 fw-semibold">
            Menampilkan <span data-kt-search-element="count">{{ $perusahaans->count() }}</span> perusahaan
        </div>
        <button type="button" class="btn btn-sm btn-light-primary" data-kt-search-element="clear">
            <i class="bi bi-x-circle me-2"></i>Reset Pencarian
        </button>
    </div>
    <!--end::Result Info-->

    <!--begin::Row-->
    <div class="row g-6 g-xl-8">
        @forelse($perusahaans as $perusahaan)
        <!--begin::Col-->
        <div class="col-md-6 col-xl-4" data-kt-search-element="item">
            <!--begin::Card-->
            <div class="card card-bordered h-100 hover-elevate-up">
                <!--begin::Body-->
                <div class="card-body shadow-sm p-8">
                    <!--begin::Logo-->
                    <div class="d-flex align-items-center mb-5">
                        <div class="symbol symbol-60px me-5">
                            @if($perusahaan->logo)
                            <img src="{{ asset('storage/' . $perusahaan->logo) }}" alt="{{ $perusahaan->nama_perusahaan }}" style="object-fit: contain;" />
                            @else
                            <div class="symbol-label bg-light-primary">
                                <span class="fs-3 fw-bold text-primary">{{ strtoupper(substr($perusahaan->nama_perusahaan, 0, 2)) }}</span>
                            </div>
                            @endif
                        </div>
                        <div>
                            <h3 class="fs-3 fw-bolder text-dark mb-1" data-kt-search-element="title">{{ $perusahaan->nama_perusahaan }}</h3>
                        </div>
                    </div>
                    <!--end::Logo-->

                    <!--begin::Info-->
                    <div class="mb-6">
                        @if($perusahaan->alamat)
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-geo-alt-fill text-primary fs-5 me-3 mt-1"></i>
                            <span class="text-gray-700 fs-6" data-kt-search-element="text">{{ $perusahaan->alamat }}</span>
                        </div>
                        @endif

                        <div class="separator separator-dashed my-4"></div>

                        <div class="fs-7 text-gray-600 fw-semibold mb-2">Kerjasama</div>
                        @if($perusahaan->email || $perusahaan->kontak)
                        @if($perusahaan->email)
                        <div class="badge badge-light-primary mb-2 me-2">
                            <i class="bi bi-envelope me-1"></i> {{ Str::limit($perusahaan->email, 25) }}
                        </div>
                        @endif
                        @if($perusahaan->kontak)
                        <div class="badge badge-light-info mb-2">
                            <i class="bi bi-telephone me-1"></i> {{ $perusahaan->kontak }}
                        </div>
                        @endif
                        @else
                        <div class="text-muted fs-7">-</div>
                        @endif
                    </div>
                    <!--end::Info-->

                    <!--begin::Action-->
                    <div class="d-grid">
                        <a href="{{ route('perusahaan.show', $perusahaan->id) }}" class="btn btn-light-primary btn-sm">
                            Lihat Detail
                        </a>
                    </div>
                    <!--end::Action-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Col-->
        @empty
        <!--begin::Empty State-->
        <div class="col-12">
            <div class="card card-bordered">
                <div class="card-body text-center py-20">
                    <div class="fs-2hx fw-bold text-dark mb-5">Belum ada perusahaan terdaftar</div>
                    <div class="fs-6 text-muted">Silakan kembali lagi nanti untuk melihat perusahaan mitra terbaru</div>
                </div>
            </div>
        </div>
        <!--end::Empty State-->
        @endforelse

        <!--begin::No Results-->
        <div class="col-12 d-none" data-kt-search-element="empty">
            <div class="card shadow-sm">
                <div class="card-body text-center py-20">
                    <i class="bi bi-search fs-5x text-gray-400 mb-5"></i>
                    <h3 class="fs-2 fw-bold text-gray-800 mb-3">Tidak Ada Hasil</h3>
                    <p class="fs-5 text-gray-600 mb-5">Perusahaan yang Anda cari tidak ditemukan.<br />Coba kata kunci lain.</p>
                </div>
            </div>
        </div>
        <!--end::No Results-->
    </div>
    <!--end::Row-->

    <!--begin::Pagination-->
    @if($perusahaans->hasPages())
    <div class="d-flex justify-content-center mt-10" data-kt-search-element="pagination">
        {{ $perusahaans->links() }}
    </div>
    @endif
    <!--end::Pagination-->
</div>

@push('scripts')
<script>
    // Metronic Search Handler
    "use strict";
    var PerusahaanSearch = function() {
        var input, countElement, clearBtn, items, emptyElement, paginationElement;

        var search = function() {
            var searchTerm = input.value.toLowerCase().trim();
            var visibleCount = 0;
            var infoElement = document.querySelector('[data-kt-search-element="info"]');

            items.forEach(function(item) {
                var title = item.querySelector('[data-kt-search-element="title"]');
                var texts = item.querySelectorAll('[data-kt-search-element="text"]');
                var searchableText = title ? title.innerText.toLowerCase() : '';

                texts.forEach(function(text) {
                    searchableText += ' ' + text.innerText.toLowerCase();
                });

                if (searchableText.includes(searchTerm)) {
                    item.classList.remove('d-none');
                    visibleCount++;
                } else {
                    item.classList.add('d-none');
                }
            });

            countElement.textContent = visibleCount;

            if (visibleCount === 0 && searchTerm !== '') {
                emptyElement.classList.remove('d-none');
            } else {
                emptyElement.classList.add('d-none');
            }

            if (searchTerm !== '') {
                if (infoElement) infoElement.classList.remove('d-none');
                if (paginationElement) paginationElement.style.display = 'none';
            } else {
                if (infoElement) infoElement.classList.add('d-none');
                if (paginationElement) paginationElement.style.display = 'flex';
            }
        };

        var clear = function() {
            input.value = '';
            search();
            input.focus();
        };

        return {
            init: function() {
                input = document.querySelector('[data-kt-search-element="input"]');
                countElement = document.querySelector('[data-kt-search-element="count"]');
                clearBtn = document.querySelector('[data-kt-search-element="clear"]');
                items = document.querySelectorAll('[data-kt-search-element="item"]');
                emptyElement = document.querySelector('[data-kt-search-element="empty"]');
                paginationElement = document.querySelector('[data-kt-search-element="pagination"]');

                if (input) {
                    input.addEventListener('input', search);
                }

                if (clearBtn) {
                    clearBtn.addEventListener('click', clear);
                }
            }
        };
    }();

    KTUtil.onDOMContentLoaded(function() {
        PerusahaanSearch.init();
    });
</script>
@endpush
@endsection