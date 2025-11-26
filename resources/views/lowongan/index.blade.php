@extends('layouts.landing')

@section('title', 'Lowongan Kerja')
@section('content')
<div class="container py-10">
    <!--begin::Page Header-->
    <div class="d-flex flex-wrap flex-stack mb-6">
        <h1 class="fs-2x text-gray-800 fw-bold my-2">Lowongan Kerja</h1>
        <div class="d-flex align-items-center my-2">
            <span class="text-muted">Temukan peluang karir terbaik untuk Anda</span>
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
                    placeholder="Cari lowongan berdasarkan judul, posisi, atau perusahaan..."
                    data-kt-search-element="input">
            </div>
        </div>
    </div>
    <!--end::Search Bar-->

    <!--begin::Result Info-->
    <div class="d-flex justify-content-between align-items-center mb-5 d-none" data-kt-search-element="info">
        <div class="text-gray-700 fw-semibold">
            Menampilkan <span data-kt-search-element="count">{{ $lowongans->count() }}</span> lowongan
        </div>
        <button type="button" class="btn btn-sm btn-light-primary" data-kt-search-element="clear">
            <i class="bi bi-x-circle me-2"></i>Reset Pencarian
        </button>
    </div>
    <!--end::Result Info-->

    <!--begin::Lowongan Cards-->
    <div class="row g-6 g-xl-9">
        @forelse($lowongans as $lowongan)
        <!--begin::Col-->
        <div class="col-md-6 col-lg-4" data-kt-search-element="item">
            <!--begin::Card-->
            <div class="card h-100 shadow-sm hover-elevate-up transition-all" style="border-radius: 0.75rem; border: 1px solid #e4e6ef;">
                <!--begin::Card body-->
                <div class="card-body d-flex flex-column p-8">
                    <!--begin::Header-->
                    <div class="d-flex align-items-center justify-content-between mb-5">
                        <!--begin::Logo-->
                        <div class="symbol symbol-60px">
                            @php($logo = optional($lowongan->perusahaan)->logo)
                            @if($logo)
                            <span class="symbol-label bg-light-primary">
                                <img src="{{ asset('storage/' . $logo) }}" alt="logo" class="w-100 h-100" style="object-fit: contain; padding: 8px;" />
                            </span>
                            @else
                            <span class="symbol-label bg-light-primary text-primary fs-2 fw-bold">
                                {{ Str::upper(substr(optional($lowongan->perusahaan)->nama_perusahaan ?? 'PR', 0, 2)) }}
                            </span>
                            @endif
                        </div>
                        <!--end::Logo-->
                        <!--begin::Badge-->
                        <span class="badge badge-light-success fw-bold">
                            {{ $lowongan->tanggal_dibuat ? \Carbon\Carbon::parse($lowongan->tanggal_dibuat)->diffForHumans() : 'Baru' }}
                        </span>
                        <!--end::Badge-->
                    </div>
                    <!--end::Header-->

                    <!--begin::Title-->
                    <a href="{{ route('lowongan.show', $lowongan->id) }}" class="text-gray-900 text-hover-primary fs-4 fw-bold mb-3 text-decoration-none" data-kt-search-element="title">
                        {{ $lowongan->judul }}
                    </a>
                    <!--end::Title-->

                    <!--begin::Company-->
                    <div class="text-gray-600 fw-semibold fs-6 mb-5" data-kt-search-element="text">
                        <i class="bi bi-building me-2 text-primary"></i>{{ optional($lowongan->perusahaan)->nama_perusahaan ?? 'Perusahaan' }}
                    </div>
                    <!--end::Company-->

                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-5"></div>
                    <!--end::Separator-->

                    <!--begin::Info-->
                    <div class="d-flex flex-column gap-3 mb-7">
                        <!--begin::Posisi-->
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-badge text-gray-500 fs-5 me-3"></i>
                            <span class="text-gray-700 fw-semibold fs-7" data-kt-search-element="text">{{ $lowongan->posisi }}</span>
                        </div>
                        <!--end::Posisi-->
                        <!--begin::Lokasi-->
                        <div class="d-flex align-items-center">
                            <i class="bi bi-geo-alt text-gray-500 fs-5 me-3"></i>
                            <span class="text-gray-700 fw-semibold fs-7">{{ Str::limit(optional($lowongan->perusahaan)->alamat ?? 'Lokasi tidak tersedia', 30) }}</span>
                        </div>
                        <!--end::Lokasi-->
                        <!--begin::Deadline-->
                        @if($lowongan->batas_lamaran)
                        <div class="d-flex align-items-center">
                            <i class="bi bi-clock text-gray-500 fs-5 me-3"></i>
                            <span class="text-gray-700 fw-semibold fs-7">Batas: {{ \Carbon\Carbon::parse($lowongan->batas_lamaran)->format('d M Y') }}</span>
                        </div>
                        @endif
                        <!--end::Deadline-->
                    </div>
                    <!--end::Info-->

                    <!--begin::Action-->
                    <div class="mt-auto">
                        <a href="{{ route('lowongan.show', $lowongan->id) }}" class="btn btn-primary w-100">
                            <i class="bi bi-arrow-right-circle me-2"></i>Lihat Detail
                        </a>
                    </div>
                    <!--end::Action-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Col-->
        @empty
        <!--begin::Empty State-->
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body text-center py-20">
                    <i class="bi bi-inbox fs-5x text-gray-400 mb-5"></i>
                    <h3 class="fs-2 fw-bold text-gray-800 mb-3">Belum Ada Lowongan</h3>
                    <p class="fs-5 text-gray-600 mb-5">Saat ini belum ada lowongan kerja yang tersedia.<br />Pantau terus untuk update lowongan terbaru!</p>
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        <i class="bi bi-bell me-2"></i>Daftar untuk Notifikasi
                    </a>
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
                    <p class="fs-5 text-gray-600 mb-5">Lowongan yang Anda cari tidak ditemukan.<br />Coba kata kunci lain.</p>
                </div>
            </div>
        </div>
        <!--end::No Results-->
    </div>
    <!--end::Lowongan Cards-->

    <!--begin::Pagination-->
    @if($lowongans->hasPages())
    <div class="d-flex justify-content-center mt-10" data-kt-search-element="pagination">
        {{ $lowongans->links() }}
    </div>
    @endif
    <!--end::Pagination-->
</div>

@push('scripts')
<script>
    // Metronic Search Handler
    "use strict";
    var LowonganSearch = function() {
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
        LowonganSearch.init();
    });
</script>
@endpush
@endsection