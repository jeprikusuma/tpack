<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\PerceptionResponse;
use App\Models\PerceptionSetting;
use App\Models\User;
use Illuminate\Http\Request;

class PerceptionController extends Controller
{
    public function index()
    {
        $setting = PerceptionSetting::first();

        $responses = PerceptionResponse::with('student')->get();

        return view('dosen.perception', compact('setting', 'responses'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $setting = PerceptionSetting::firstOrCreate([]);

        $setting->update([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->back()->with('success', 'Periode pengisian instrumen berhasil diperbarui.');
    }

    public function show($studentId)
    {
        $student = User::findOrFail($studentId);

        $response = $student->perceptionResponse()
            ->with('answers')
            ->first();

        if (!$response) {
            return redirect()->back()->with('error', 'Mahasiswa belum mengisi instrumen.');
        }

        $questions = $this->getQuestions();

        return view('dosen.perception_show', compact('student', 'response', 'questions'));
    }

    private function getQuestions()
    {
        return [
            "Saya mempelajari teknologi pendukung belajar untuk anak disabilitas dengan mudah",
            "Saya sudah memiliki pengalaman menggunakan berbagai teknologi pendukung pembelajaran inklusif",
            "Saya memiliki pengetahuan yang cukup tentang konsep-konsep IPA SD",
            "Saya memahami kebutuhan khusus siswa disabilitas dalam mempelajari IPA",
            "Saya dapat menyesuaikan pembelajaran berdasarkan kemampuan individu siswa disabilitas",
            "Saya dapat menerapkan berbagai pendekatan pembelajaran inklusif",
            "Saya dapat memilih pendekatan pembelajaran IPA yang efektif untuk siswa penyandang disabilitas kategori sensorik",
            "Saya dapat memilih pendekatan pembelajaran IPA yang efektif untuk siswa penyandang disabilitas kategori intelektual",
            "Saya tahu teknologi yang dapat membantu siswa penyandang disabilitas kategori sensorik memahami konsep IPA",
            "Saya tahu teknologi yang dapat membantu siswa penyandang disabilitas kategori intelektual memahami konsep IPA",
            "Saya dapat memilih teknologi yang mendukung pembelajaran siswa disabilitas",
            "Saya dapat mengadaptasi teknologi untuk berbagai kebutuhan siswa disabilitas",
            "Saya dapat melaksanakan pembelajaran IPA yang mengintegrasikan teknologi dan pendekatan inklusif untuk siswa penyandang disabilitas kategori sensorik dan intelektual",
            "Saya dapat merancang pembelajaran IPA inklusif yang inovatif dengan dukungan teknologi",
            "Dosen mata kuliah IPA saya memodelkan integrasi teknologi dan pendekatan inklusif dengan baik",
            "Dosen saya mendorong penelitian tentang pembelajaran inklusif",
        ];
    }
}
