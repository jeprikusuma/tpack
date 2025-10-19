<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\PerceptionSetting;
use App\Models\PerceptionResponse;
use App\Models\PerceptionAnswer;
use App\Models\FinalTaskSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PerceptionController extends Controller
{
    /**
     * Halaman utama persepsi (cek status & akses)
     */
    public function index()
    {
        $setting = PerceptionSetting::first();
        $user = Auth::user();
        $response = PerceptionResponse::where('student_id', $user->id)->first();

        $check = $this->canAccessPerception($user);

        return view('mahasiswa.perception', [
            'setting' => $setting,
            'response' => $response,
            'canAccess' => $check['allowed'],
            'reasons' => is_array($check['reason']) ? $check['reason'] : [$check['reason']],
        ]);
    }

    /**
     * Halaman pengerjaan persepsi (tanpa timer)
     */
    public function do()
    {
        $user = Auth::user();
        $check = $this->canAccessPerception($user);

        if (!$check['allowed']) {
            return redirect()->route('mahasiswa.perception')
                ->with('error', 'Anda belum memenuhi syarat untuk mengisi instrumen persepsi.');
        }

        $setting = PerceptionSetting::first();
        $questions = $this->getQuestions();
        $options = [
            ['label' => 'Sangat Tidak Setuju', 'value' => 1],
            ['label' => 'Tidak Setuju', 'value' => 2],
            ['label' => 'Netral', 'value' => 3],
            ['label' => 'Setuju', 'value' => 4],
            ['label' => 'Sangat Setuju', 'value' => 5],
        ];

        return view('mahasiswa.perception_do', compact('questions', 'options', 'setting'));
    }

    /**
     * Submit jawaban persepsi
     */
    public function submit(Request $request)
    {
        $user = Auth::user();
        $check = $this->canAccessPerception($user);

        if (!$check['allowed']) {
            return redirect()->route('mahasiswa.perception')
                ->with('error', 'Anda belum memenuhi syarat untuk mengisi instrumen persepsi.');
        }

        $setting = PerceptionSetting::first();
        if (!$setting) {
            return redirect()->route('mahasiswa.perception')
                ->withErrors(['msg' => 'Instrumen belum disetting oleh dosen.']);
        }

        // Cegah submit ulang
        $existing = PerceptionResponse::where('student_id', $user->id)->exists();
        if ($existing) {
            return redirect()->route('mahasiswa.perception')
                ->withErrors(['msg' => 'Anda sudah mengisi instrumen persepsi.']);
        }

        // Validasi input
        $validated = $request->validate([
            'answers' => 'required|array|size:16',
            'answers.*' => 'integer|min:1|max:5',
        ]);

        // Simpan ke perception_responses
        $response = PerceptionResponse::create([
            'student_id' => $user->id,
            'total_score' => array_sum($validated['answers']),
        ]);

        // Simpan ke perception_answers
        foreach ($validated['answers'] as $index => $value) {
            PerceptionAnswer::create([
                'response_id' => $response->id,
                'question_number' => $index + 1,
                'answer' => $value,
                'score' => $value,
            ]);
        }

        return redirect()->route('mahasiswa.perception')
            ->with('success', 'Instrumen persepsi berhasil dikirim.');
    }

    /**
     * Pertanyaan (16 tetap)
     */
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

    /**
     * Cek apakah mahasiswa boleh akses persepsi
     */
    private function canAccessPerception($user)
    {
        $setting = PerceptionSetting::first();

        if (!$setting) {
            return [
                'allowed' => false,
                'reason' => 'Instrumen persepsi belum disetting oleh dosen.',
            ];
        }

        $now = Carbon::now();
        if ($setting->start_date && $now->lt($setting->start_date)) {
            return [
                'allowed' => false,
                'reason' => 'Instrumen persepsi belum dapat diakses. Mulai pada ' .
                    $setting->start_date->format('d M Y H:i'),
            ];
        }

        if ($setting->end_date && $now->gt($setting->end_date)) {
            return [
                'allowed' => false,
                'reason' => 'Periode pengisian instrumen persepsi telah berakhir pada ' .
                    $setting->end_date->format('d M Y H:i'),
            ];
        }

        // Sudah isi
        $exists = PerceptionResponse::where('student_id', $user->id)->exists();
        if ($exists) {
            return [
                'allowed' => false,
                'reason' => 'Anda sudah mengisi instrumen persepsi.',
            ];
        }

        // Cek tugas akhir
        $requiredTasks = ['TA1', 'TA2', 'TA3'];
        $uploadedTasks = FinalTaskSubmission::where('user_id', $user->id)
            ->pluck('task_code')
            ->toArray();

        $missing = array_diff($requiredTasks, $uploadedTasks);
        if (!empty($missing)) {
            return [
                'allowed' => false,
                'reason' => 'Anda harus mengumpulkan semua tugas akhir (TA1, TA2, TA3) terlebih dahulu.',
            ];
        }

        return ['allowed' => true, 'reason' => null];
    }
}
