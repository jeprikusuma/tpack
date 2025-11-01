<?php

namespace App\Http\Controllers\Dosen;

use App\Exports\PretestExport;
use App\Http\Controllers\Controller;
use App\Models\Pretest;
use App\Models\PretestAttempt;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PretestController extends Controller
{
    public function index()
    {
        $pretest = Pretest::first();

        $attempts = PretestAttempt::with('user')
            ->when($pretest, fn($q) => $q->where('pretest_id', $pretest->id))
            ->orderBy('end_time', 'desc')
            ->get();

        return view('dosen.pretest', compact('pretest', 'attempts'));
    }

    /**
     * Update pengaturan pretest
     */
    public function update(Request $request)
    {
        $request->validate([
            'start_date'       => 'required|date',
            'end_date'         => 'required|date|after_or_equal:start_date',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        $pretest = Pretest::first() ?? new Pretest();

        $pretest->title            = 'Pretest IPA Inklusif';
        $pretest->start_date       = $request->start_date;
        $pretest->end_date         = $request->end_date;
        $pretest->duration_minutes = $request->duration_minutes;
        $pretest->is_active        = true;
        $pretest->save();

        return redirect()
            ->route('dosen.pretest')
            ->with('success', 'Pengaturan pretest berhasil disimpan.');
    }


    public function export()
    {
        return Excel::download(new PretestExport, 'hasil_pretest.xlsx');
    }
}
