<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Posttest;
use App\Models\PosttestAttempt;
use Illuminate\Http\Request;

class PosttestController extends Controller
{
    public function index()
    {
        $posttest = Posttest::first();

        $attempts = PosttestAttempt::with('user')
            ->when($posttest, fn($q) => $q->where('posttest_id', $posttest->id))
            ->orderBy('end_time', 'desc')
            ->get();

        return view('dosen.posttest', compact('posttest', 'attempts'));
    }

    /**
     * Update pengaturan posttest
     */
    public function update(Request $request)
    {
        $request->validate([
            'start_date'       => 'required|date',
            'end_date'         => 'required|date|after_or_equal:start_date',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        $posttest = Posttest::first() ?? new Posttest();

        $posttest->title            = 'Posttest IPA Inklusif';
        $posttest->start_date       = $request->start_date;
        $posttest->end_date         = $request->end_date;
        $posttest->duration_minutes = $request->duration_minutes;
        $posttest->is_active        = true;
        $posttest->save();

        return redirect()
            ->route('dosen.posttest')
            ->with('success', 'Pengaturan posttest berhasil disimpan.');
    }
}
