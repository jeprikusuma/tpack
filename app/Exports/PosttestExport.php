<?php

namespace App\Exports;

use App\Models\PosttestAttempt;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PosttestExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PosttestAttempt::with('user')->get()->map(function ($attempt) {
            return [
                'NIM' => $attempt->user->num,
                'Email' => $attempt->user->email,
                'Nama' => $attempt->user->name,
                'Status' => $attempt->status,
                'Nilai' => $attempt->score ?? '-',
                'Waktu Mulai' => $attempt->start_time,
                'Waktu Selesai' => $attempt->end_time ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'NIM',
            'Email',
            'Nama',
            'Status',
            'Nilai',
            'Waktu Mulai',
            'Waktu Selesai',
        ];
    }
}
