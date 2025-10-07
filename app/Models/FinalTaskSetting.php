<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalTaskSetting extends Model
{
    use HasFactory;

    protected $table = 'final_task_settings';

    protected $fillable = [
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
    ];

    /**
     * Cek apakah periode tugas akhir sedang aktif.
     */
    public function isActive(): bool
    {
        $now = now();
        return ($this->start_date && $this->end_date)
            ? $now->between($this->start_date, $this->end_date)
            : false;
    }

    /**
     * Ambil setting aktif saat ini (jika ada)
     */
    public static function current(): ?self
    {
        $now = now();
        return self::where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->first();
    }
}
