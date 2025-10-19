<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerceptionSetting extends Model
{
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
}
