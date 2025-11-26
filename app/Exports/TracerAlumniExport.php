<?php

namespace App\Exports;

use App\Models\TracerAlumni;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class TracerAlumniExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $data;
    protected $rowNumber = 0;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama Alumni',
            'Email',
            'No. HP',
            'Jurusan',
            'Angkatan',
            'Kegiatan',
            'Posisi/Peran',
            'Relevansi Jurusan',
            'Tahun Mulai',
            'Nama Institusi',
            'Bidang Institusi',
            'Alamat Institusi',
            'Pendapatan',
            'Tanggal Dibuat'
        ];
    }

    /**
     * @param mixed $tracer
     * @return array
     */
    public function map($tracer): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $tracer->user->nama ?? '-',
            $tracer->user->email ?? '-',
            $tracer->user->no_hp ?? '-',
            $tracer->jurusan->nama ?? '-',
            $tracer->angkatan->tahun ?? '-',
            $tracer->kegiatan->nama ?? '-',
            $tracer->posisi_peran ?? '-',
            $tracer->relevansi_jurusan ?? '-',
            $tracer->tahun_mulai ?? '-',
            $tracer->institusi_nama ?? '-',
            $tracer->institusi_bidang ?? '-',
            $tracer->institusi_alamat ?? '-',
            $tracer->pendapatan_range ?? '-',
            $tracer->created_at->format('d-m-Y H:i:s')
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold header with background color
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 5,  // No
            'B' => 20, // Nama Alumni
            'C' => 25, // Email
            'D' => 15, // No. HP
            'E' => 20, // Jurusan
            'F' => 10, // Angkatan
            'G' => 20, // Kegiatan
            'H' => 20, // Posisi/Peran
            'I' => 20, // Relevansi Jurusan
            'J' => 12, // Tahun Mulai
            'K' => 25, // Nama Institusi
            'L' => 20, // Bidang Institusi
            'M' => 30, // Alamat Institusi
            'N' => 20, // Pendapatan
            'O' => 18, // Tanggal Dibuat
        ];
    }
}
