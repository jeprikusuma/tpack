<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class FinalTaskSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'task_code',
        'file_path',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    /**
     * Relasi ke user (mahasiswa)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Dapatkan URL file di storage (kalau pakai storage:link)
     */
    public function getFileUrlAttribute(): ?string
    {
        return $this->file_path ? Storage::url($this->file_path) : null;
    }

    /**
     * Update atau ganti file upload
     */
    public static function uploadOrReplace(int $userId, string $taskCode, $uploadedFile)
    {
        $submission = self::firstOrNew([
            'user_id'   => $userId,
            'task_code' => $taskCode,
        ]);

        // hapus file lama kalau ada
        if ($submission->file_path && Storage::exists($submission->file_path)) {
            Storage::delete($submission->file_path);
        }

        // simpan file baru
        $path = $uploadedFile->store('uploads/final_tasks');

        $submission->file_path = $path;
        $submission->submitted_at = now();
        $submission->save();

        return $submission;
    }
}
