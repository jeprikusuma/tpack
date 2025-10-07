<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\FinalTaskSetting;
use App\Models\FinalTaskSubmission;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index()
    {
        $setting = FinalTaskSetting::latest()->first();
        
         // Ambil semua submission beserta user-nya
        $submissions = FinalTaskSubmission::with('user')
            ->orderBy('user_id')
            ->orderBy('task_code')
            ->get();

        // Kelompokkan berdasarkan user_id
        $groupedSubmissions = $submissions
            ->groupBy('user_id')
            ->map(function ($tasks) {
                return [
                    'user' => $tasks->first()->user,
                    'tasks' => $tasks,
                ];
            });

        return view('dosen.assignment', compact('setting', 'groupedSubmissions'));
    }

    /**
     * Simpan atau perbarui tanggal tugas akhir.
     */
    public function update(Request $request)
    {
        $request->validate([
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date', 'after:start_date'],
        ]);

        $setting = FinalTaskSetting::latest()->first();

        if (!$setting) {
            $setting = new FinalTaskSetting();
        }

        $setting->start_date = $request->start_date;
        $setting->end_date = $request->end_date;
        $setting->save();

        return redirect()
            ->back()
            ->with('success', 'Tanggal tugas akhir berhasil diperbarui.');
    }
}
