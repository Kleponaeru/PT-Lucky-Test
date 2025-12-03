<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\NumberFormat;

class MahasiswaExport implements FromCollection, WithHeadings, WithColumnFormatting
{
    public function collection()
    {
        return Mahasiswa::with('jenisKelamin')
            ->get()
            ->map(function ($m) {
                return [
                    'M#' => $m->m_id,
                    'NIM' => "'" . $m->nim,
                    'Nama' => $m->nama,
                    'Jenis Kelamin' => $m->jenisKelamin->description,
                    'Jurusan' => $m->jurusan,
                    'IPK' => $m->ipk,
                ];
            });
    }

    public function columnFormats(): array
    {
        return [
            'B' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT, // Column B = NIM
        ];
    }

    public function headings(): array
    {
        return ['M#', 'NIM', 'Nama', 'Jenis Kelamin', 'Jurusan', 'IPK'];
    }
}

