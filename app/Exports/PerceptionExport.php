<?php

namespace App\Exports;

use App\Models\PerceptionResponse;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PerceptionExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PerceptionResponse::with('student')->get()->map(function ($attempt) {
            return [
                'NIM' => $attempt->student->num,
                'Email' => $attempt->student->email,
                'Nama' => $attempt->student->name,
                'Total Skor' => $attempt->total_score ?? 0,
                'Dibuat Pada' => $attempt->created_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'NIM',
            'Email',
            'Nama',
            'Total Skor',
            'Dibuat Pada',
        ];
    }
}
