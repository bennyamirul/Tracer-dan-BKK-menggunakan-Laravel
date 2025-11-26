@extends('layouts.app')

@section('title', 'Detail DU/DI')

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="card">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Detail DU/DI</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('admin.perusahaan.index') }}" class="btn btn-sm btn-light">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row g-5">
                <div class="col-md-3">
                    @php
                    $logoPath = $perusahaan->logo ? (\Illuminate\Support\Str::startsWith($perusahaan->logo, ['http://','https://']) ? $perusahaan->logo : asset('storage/'.$perusahaan->logo)) : null;
                    @endphp
                    @if($logoPath)
                    <img src="{{ $logoPath }}" alt="logo" class="img-fluid rounded" />
                    @else
                    <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height:140px">Tidak ada logo</div>
                    @endif
                </div>
                <div class="col-md-9">
                    <div class="mb-4">
                        <div class="text-muted">Nama Perusahaan</div>
                        <div class="fw-bold fs-5">{{ $perusahaan->nama_perusahaan }}</div>
                    </div>
                    <div class="mb-4">
                        <div class="text-muted">Email</div>
                        <div class="fw-bold">{{ $perusahaan->email ?: '-' }}</div>
                    </div>
                    <div class="mb-4">
                        <div class="text-muted">Kontak</div>
                        <div class="fw-bold">{{ $perusahaan->kontak ?: '-' }}</div>
                    </div>
                    <div class="mb-4">
                        <div class="text-muted">Alamat</div>
                        <div class="fw-bold">{{ $perusahaan->alamat ?: '-' }}</div>
                    </div>
                    <div class="mb-4">
                        <div class="text-muted">Deskripsi</div>
                        <div class="fw-bold">{!! nl2br(e($perusahaan->deskripsi)) !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection