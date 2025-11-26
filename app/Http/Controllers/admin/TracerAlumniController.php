<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TracerAlumni;
use App\Models\Jurusan;
use App\Models\Angkatan;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\TracerAlumniExport;
use Maatwebsite\Excel\Facades\Excel;

class TracerAlumniController extends Controller
{
    public function index(Request $request)
    {
        $items = TracerAlumni::with(['user', 'jurusan', 'angkatan', 'kegiatan'])->latest()->get();
        $jurusans = Jurusan::orderBy('nama')->get();
        $angkatans = Angkatan::orderBy('tahun', 'desc')->get();
        $kegiatans = Kegiatan::orderBy('nama')->get();
        $totalTracerAlumni = TracerAlumni::count();

        // Get filter angkatan dari request
        $angkatanId = $request->get('angkatan_id');

        // Ambil semua kegiatan yang ada
        $semuaKegiatan = \App\Models\Kegiatan::orderBy('nama', 'asc')->get();

        // Query tracer alumni berdasarkan kegiatan
        $query = TracerAlumni::query();

        if ($angkatanId) {
            $query->where('angkatan_id', $angkatanId);
        }

        // Hitung alumni per kegiatan
        $alumniPerKegiatan = $query->selectRaw('kegiatan_id, COUNT(*) as total')
            ->groupBy('kegiatan_id')
            ->pluck('total', 'kegiatan_id');

        // Buat statistik dengan semua kegiatan (termasuk yang 0)
        $statistikKegiatan = [];
        foreach ($semuaKegiatan as $kegiatan) {
            $jumlah = $alumniPerKegiatan->get($kegiatan->id, 0);
            $statistikKegiatan[$kegiatan->nama] = $jumlah;
        }

        // Tambahkan alumni yang belum memilih kegiatan (jika ada)
        $belumMemilih = $alumniPerKegiatan->get(null, 0);
        if ($belumMemilih > 0) {
            $statistikKegiatan['Belum Memilih'] = $belumMemilih;
        }

        // Get semua angkatan untuk filter
        $angkatans = \App\Models\Angkatan::orderBy('tahun', 'desc')->get();

        return view('admin.tracer.index', compact(
            'items',
            'jurusans',
            'angkatans',
            'kegiatans',
            'statistikKegiatan',
            'totalTracerAlumni',
            'angkatanId'
        ));
    }

    public function show(TracerAlumni $tracer)
    {
        $tracer->load(['user', 'jurusan', 'angkatan', 'kegiatan']);
        return response()->json($tracer);
    }

    public function update(Request $request, TracerAlumni $tracer)
    {
        $validated = $request->validate([
            'jurusan_id' => ['required', 'exists:jurusan,id'],
            'angkatan_id' => ['required', 'exists:tahun_angkatan,id'],
            'kegiatan_id' => ['required', 'exists:kegiatan,id'],
            'posisi_peran' => ['nullable', 'string', 'max:100'],
            'relevansi_jurusan' => ['nullable', 'in:ya,tidak'],
            'tahun_mulai' => ['nullable', 'digits:4'],
            'institusi_nama' => ['nullable', 'string', 'max:150'],
            'institusi_bidang' => ['nullable', 'string', 'max:100'],
            'institusi_alamat' => ['nullable', 'string', 'max:255'],
            'pendapatan_range' => ['nullable', 'string', 'max:50'],
            'catatan' => ['nullable', 'string'],
        ]);

        $tracer->update($validated);

        return redirect()->route('admin.tracer.index')->with('status', 'Data tracer alumni berhasil diperbarui');
    }

    public function export(Request $request)
    {
        $format = $request->get('format', 'xlsx');
        $dateRange = $request->get('date');

        $startDate = null;
        $endDate = null;

        // Parse date range jika ada
        if ($dateRange) {
            $dates = explode(' to ', $dateRange);
            $startDate = $dates[0] ?? null;
            $endDate = $dates[1] ?? $dates[0];
        }

        // Ambil data
        $query = TracerAlumni::with(['user', 'jurusan', 'angkatan', 'kegiatan']);

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $data = $query->latest()->get();

        $fileName = 'tracer_alumni_' . date('Y-m-d_His');

        // Export berdasarkan format
        switch ($format) {
            case 'pdf':
                return $this->exportPDF($data, $fileName);
            default:
                return $this->exportExcel($data, $fileName);
        }
    }

    private function exportExcel($data, $fileName)
    {
        // Gunakan library maatwebsite/excel untuk export
        return Excel::download(new TracerAlumniExport($data), $fileName . '.xlsx');
    }

    private function exportPDF($data, $fileName)
    {
        // Define headers
        $headers = [
            'No',
            'Nama Alumni',
            'Email',
            'Jurusan',
            'Angkatan',
            'Kegiatan',
            'Posisi/Peran',
            'Institusi',
            'Pendapatan',
            'Tanggal Dibuat'
        ];

        // Transform data to array of arrays
        $rows = [];
        foreach ($data as $index => $tracer) {
            $rows[] = [
                $index + 1,
                $tracer->user->nama ?? '-',
                $tracer->user->email ?? '-',
                $tracer->jurusan->nama ?? '-',
                $tracer->angkatan->tahun ?? '-',
                $tracer->kegiatan->nama ?? '-',
                $tracer->posisi_peran ?? '-',
                $tracer->institusi_nama ?? '-',
                $tracer->pendapatan_range ?? '-',
                $tracer->created_at->format('d-m-Y H:i')
            ];
        }

        // Generate PDF menggunakan Blade View
        try {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('exports.pdf-template', [
                'title' => 'Data Tracer Alumni',
                'documentTitle' => 'Data Tracer Alumni',
                'subtitle' => 'Laporan Data Alumni',
                'headers' => $headers,
                'data' => $rows,
                'headerColor' => '#4472C4',
                'exportDate' => date('d F Y, H:i:s'),
                'total' => count($data) . ' alumni',
                'printedBy' => Auth::check() ? Auth::user()->nama : 'Admin'
            ]);

            $pdf->setPaper('a4', 'landscape');

            return $pdf->download($fileName . '.pdf');
        } catch (\Throwable $e) {
            // Jika DomPDF error, fallback ke HTML download
            $html = view('exports.pdf-template', [
                'title' => 'Data Tracer Alumni',
                'documentTitle' => 'Data Tracer Alumni',
                'headers' => $headers,
                'data' => $rows,
                'headerColor' => '#4472C4',
                'total' => count($data) . ' alumni',
                'printedBy' => Auth::check() ? Auth::user()->nama : 'Admin'
            ])->render();

            $httpHeaders = [
                'Content-Type' => 'text/html; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '.html"',
            ];

            return response($html, 200, $httpHeaders);
        }
    }

    public function destroy(TracerAlumni $tracer)
    {
        $tracer->delete();
        return redirect()->route('admin.tracer.index')->with('status', 'Data tracer alumni berhasil dihapus');
    }
}
