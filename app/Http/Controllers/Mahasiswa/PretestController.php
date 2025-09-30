<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Pretest;
use App\Models\PretestAttempt;
use App\Models\PretestAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class PretestController extends Controller
{
    // =========================
    // Halaman sebelum mengerjakan
    // =========================
    public function index()
    {
        $pretest = Pretest::first(); // hanya ada 1 pretest
        $attempt = PretestAttempt::where('user_id', Auth::id())->first();

        return view('mahasiswa.pretest', compact('pretest', 'attempt'));
    }

    // =========================
    // Halaman pengerjaan pretest
    // =========================
    public function do()
    {
        $pretest = Pretest::first();
        $user = Auth::user();

        // Pastikan pretest ada
        if (!$pretest) {
            return redirect()->route('mahasiswa.pretest')
                ->withErrors(['msg' => 'Pretest belum disetting oleh dosen.']);
        }

        // Cek kalau user sudah pernah submit atau timeout
        $finishedAttempt = PretestAttempt::where('user_id', $user->id)
            ->where('pretest_id', $pretest->id)
            ->whereIn('status', ['submitted', 'timeout'])
            ->first();

        if ($finishedAttempt) {
            return redirect()->route('mahasiswa.pretest')
                ->withErrors(['msg' => 'Anda sudah mengerjakan pretest, tidak bisa mengerjakan lagi.']);
        }

        // Ambil attempt in_progress kalau ada (penting untuk refresh)
        $attempt = PretestAttempt::where('user_id', $user->id)
            ->where('pretest_id', $pretest->id)
            ->where('status', 'in_progress')
            ->first();

        // Jika belum ada attempt in_progress, buat baru
        if (!$attempt) {
            $attempt = PretestAttempt::create([
                'pretest_id' => $pretest->id,
                'user_id' => $user->id,
                'start_time' => now(),
                'status' => 'in_progress',
            ]);
        }

        // Hitung waktu akhir berdasarkan attempt->start_time + duration_minutes
        $endTime = \Carbon\Carbon::parse($attempt->start_time)
                    ->addMinutes((int) $pretest->duration_minutes);

        // Jika waktu sudah lewat, tandai timeout lalu redirect
        if (now()->greaterThanOrEqualTo($endTime)) {
            $attempt->update([
                'end_time' => $endTime,
                'status' => 'timeout',
            ]);
            return redirect()->route('mahasiswa.pretest')
                ->withErrors(['msg' => 'Waktu pengerjaan sudah habis.']);
        }

        // Siapkan data untuk view
        $questions = $this->getQuestions();
        $endTimestampMs = $endTime->getTimestamp() * 1000;

        return view('mahasiswa.pretest_do', compact('questions', 'attempt', 'endTimestampMs', 'pretest'));
    }



    // =========================
    // Submit jawaban pretest
    // =========================
    public function submit(Request $request)
    {
        $pretest = Pretest::first();
        $attempt = PretestAttempt::where('user_id', Auth::id())
            ->where('status', 'in_progress')
            ->first();

        if (!$attempt) {
            return redirect()->route('mahasiswa.pretest')
                ->withErrors(['msg' => 'Tidak ada pretest yang sedang berlangsung.']);
        }

        $questions = $this->getQuestions();
        $answers = $request->input('answers', []);

        $score = 0;

        foreach ($questions as $index => $q) {
            $userAnswer = $answers[$index] ?? null;
            $correct = $q['answer'];

            PretestAnswer::create([
                'attempt_id' => $attempt->id,
                'question' => $q['question'],
                'question_number' => $request->question_numbers[$index], 
                'answer' => $userAnswer,
                'is_correct' => $userAnswer === $correct,
            ]);

            if ($userAnswer === $correct) {
                $score++;
            }
        }

        $attempt->update([
            'end_time' => now(),
            'status' => 'submitted',
            'score' => $score,
        ]);

        return redirect()->route('mahasiswa.pretest')
            ->with('success', 'Pretest berhasil disubmit. Nilai Anda: ' . $score);
    }

    // =========================
    // Soal pretest (array statis)
    // =========================
    private function getQuestions()
    {
        return [
            [
                'question' => 'Dalam pembelajaran IPA inklusif materi jenis hewan berdasarkan tulang punggung, dilakukan pengamatan beberapa jenis hewan avertebrata yang ditempatkan di sebuah baskom. Hewan avertebrata yang ada di baskom adalah udang, cumi-cumi, cacing tanah, dan karang. Berdasarkan pengamatan, ciri-ciri hewan cumi-cumi adalah...',
                'options' => [
                    'a' => 'Badan licin, panjang, bentuk gilig',
                    'b' => 'Badan licin, pipih, dan ada tentakel',
                    'c' => 'Badan beruas-ruas, memiliki antena dan ekor',
                    'd' => 'Badan bercangkang, ada bagian tubuh yang lunak dan licin',
                ],
                'answer' => 'b',
            ],
            [
                'question' => 'Bu Lisa mengajar topik ekosistem dalam kelas inklusif yang terdiri dari siswa reguler dan siswa dengan disabilitas intelektual ringan. Penilaian konten IPA yang melibatkan penggunaan teknologi yang paling tepat adalah...',
                'options' => [
                    'a' => 'Menilai video pendek siswa mengelompokkan komponen biotik dan abiotik di sekitar rumahnya',
                    'b' => 'Memberikan Google form berisi soal uraian level C1-C3 untuk siswa dengan disabilitas intelektual ringan',
                    'c' => 'Menggunakan aplikasi Quiziz berisi soal pilihan ganda level C1-C6 kepada semua siswa',
                    'd' => 'Menggunakan aplikasi Candy berisi soal menjodohkan kepada semua siswa',
                ],
                'answer' => 'a',
            ],
            [
                'question' => 'Untuk mendukung pembelajaran IPA di kelas inklusif, teknologi assistive yang paling tepat untuk siswa dengan gangguan penglihatan adalah...',
                'options' => [
                    'a' => 'Model 3D yang dapat diraba',
                    'b' => 'Hearing aid dan subtitle',
                    'c' => 'Tablet dengan aplikasi gambar',
                    'd' => 'Proyektor dengan layar besar',
                ],
                'answer' => 'a',
            ],
            [
                'question' => 'Seorang guru mengajar siswa dengan disabilitas intelektual ringan, yang mengalami kesulitan memahami urutan dan konsep abstrak. Pendekatan pembelajaran yang paling sesuai untuk membantu siswa tersebut adalah...',
                'options' => [
                    'a' => 'Pendekatan berbasis penemuan',
                    'b' => 'Pendekatan individual dan fungsional',
                    'c' => 'Pendekatan langsung',
                    'd' => 'Pendekatan ekspositori',
                ],
                'answer' => 'b',
            ],
            [
                'question' => 'Pak Budi mengajar di kelas inklusif yang terdiri dari siswa reguler dan siswa dengan disabilitas intelektual ringan. Ketika menjelaskan konsep gaya dorong dan gaya tarik, Pak Budi menggunakan kegiatan mendorong meja dan menarik kursi. Namun, siswa dengan disabilitas intelektual masih kesulitan memahami perbedaan keduanya. Strategi yang paling tepat untuk membantu pemahaman mereka adalah...',
                'options' => [
                    'a' => 'Guru mengulangi penjelasan dengan suara lebih keras dan berdiri di samping siswa',
                    'b' => 'Siswa mempraktikkan mendorong dan menarik meja belajarnya',
                    'c' => 'Siswa diberi tugas menemukan contoh gaya dorong dan tarik yang sering ditemukan dalam kehidupan sehari-hari',
                    'd' => 'Teman sebangku membantu menjelaskan kepada siswa berkebutuhan khusus sebagai upaya tutor sebaya',
                ],
                'answer' => 'b',
            ],
            [
                'question' => 'Teknologi yang paling tepat digunakan untuk mengajarkan IPA kepada siswa dengan hambatan intelektual ringan adalah...',
                'options' => [
                    'a' => 'Aplikasi e-book interaktif dengan teks panjang',
                    'b' => 'Aplikasi melakukan percobaan sederhana',
                    'c' => 'Presentasi PowerPoint dengan berbagai animasi',
                    'd' => 'Aplikasi Candy untuk berlatih soal pilihan ganda secara mandiri',
                ],
                'answer' => 'b',
            ],
            [
                'question' => 'Bu Rina akan menilai pemahaman siswa setelah pembelajaran IPA. Di kelasnya, selain siswa reguler terdapat siswa low vision dan siswa dengan disabilitas intelektual ringan. Bentuk penilaian yang paling sesuai adalah...',
                'options' => [
                    'a' => 'Tes tertulis pilihan ganda untuk semua siswa untuk menghemat waktu penilaian',
                    'b' => 'Penilaian lisan untuk semua siswa sehingga mengakomodasi semua kebutuhan anak',
                    'c' => 'Penilaian performa beserta rubrik terhadap penjelasan lisan siswa',
                    'd' => 'Penilaian tes menjodohkan khusus untuk siswa berkebutuhan khusus',
                ],
                'answer' => 'c',
            ],
            [
                'question' => 'Untuk mengajarkan konsep gelombang bunyi kepada siswa tunarungu, teknologi yang paling tepat adalah...',
                'options' => [
                    'a' => 'Audio podcast dengan penjelasan detail',
                    'b' => 'Video animasi visualisasi gelombang dilengkapi bahasa isyarat',
                    'c' => 'Teknologi sederhana untuk membuat telepon kaleng',
                    'd' => 'Speaker dengan volume yang telah dimodifikasi untuk suara tinggi',
                ],
                'answer' => 'b',
            ],
            [
                'question' => 'Pak Ahmad akan mengajarkan konsep magnet kepada siswa dengan gangguan penglihatan. Metode pembelajaran yang paling sesuai adalah...',
                'options' => [
                    'a' => 'Menjelaskan sifat magnet secara verbal dengan detail',
                    'b' => 'Memperdengarkan video tentang magnet dan memberikan volume tinggi pada suara video',
                    'c' => 'Memberikan kegiatan hands-on dengan berbagai benda magnetik dan non-magnetik',
                    'd' => 'Memberikan buku teks Braille tentang magnet dan meminta siswa membacanya',
                ],
                'answer' => 'c',
            ],
            [
                'question' => 'Platform pembelajaran online yang paling aksesible untuk kelas inklusif dengan jenis disabilitas tunarungu adalah...',
                'options' => [
                    'a' => 'Platform yang mendukung berbagai jenis teks',
                    'b' => 'Platform dengan tampilan gambar yang variatif',
                    'c' => 'Platform dengan screen magnifier dan screen reader',
                    'd' => 'Platform video edukasi dengan subtitle',
                ],
                'answer' => 'd',
            ],
            [
                'question' => 'Untuk membantu siswa memahami pembiasan cahaya di kelas inklusif, teknologi berikut yang paling mendukung untuk digunakan oleh guru adalah...',
                'options' => [
                    'a' => 'Gambar berseri IPA digital',
                    'b' => 'Simulasi interaktif yang bisa disesuaikan aksesibilitasnya',
                    'c' => 'Catatan teks secara detail dalam bentuk PDF',
                    'd' => 'Penjelasan konsep disertai gambar-gambar melalui grup WhatsApp kelas',
                ],
                'answer' => 'b',
            ],
            [
                'question' => 'Untuk membantu menjelaskan konsep gaya kepada siswa dengan hambatan intelektual ringan, teknologi yang paling tepat digunakan oleh guru adalah...',
                'options' => [
                    'a' => 'Lembar kerja digital dalam bentuk kuis-kuis disertai gambar',
                    'b' => 'Tayangan animasi interaktif yang memperlihatkan perbedaan dorong dan tarik',
                    'c' => 'Podcast penjelasan konsep gaya dalam durasi singkat',
                    'd' => 'Slide presentasi berisi materi gaya yang diuraikan secara detail',
                ],
                'answer' => 'b',
            ],
            [
                'question' => 'Untuk menilai pemahaman siswa dengan disabilitas intelektual ringan tentang materi tumbuhan, alat penilaian yang paling tepat adalah...',
                'options' => [
                    'a' => 'Tes essay dengan pertanyaan variatif dari yang paling sederhana hingga yang lebih kompleks',
                    'b' => 'Penilaian praktik mengelompokkan tumbuhan secara sederhana',
                    'c' => 'Tes pilihan ganda dengan 5 opsi jawaban dengan variasi level kognitif',
                    'd' => 'Presentasi individu di depan kelas',
                ],
                'answer' => 'b',
            ],
            [
                'question' => 'Saat merancang pembelajaran tentang bagian-bagian tumbuhan untuk kelas inklusif yang terdiri dari siswa reguler dan siswa low vision, Bu Nia ingin memastikan semua siswa dapat memahami konsep dengan benar. Pilihan rancangan pembelajaran yang menunjukkan integrasi TPACK secara tepat adalah...',
                'options' => [
                    'a' => 'Menampilkan tayangan powerpoint tentang bagian-bagian tumbuhan di layar proyektor dan mengatur intensitas cahayanya',
                    'b' => 'Menampilkan tayangan powerpoint dengan font 14 tentang bagian-bagian tumbuhan di layar proyektor',
                    'c' => 'Menggunakan beberapa mikro video pembelajaran tentang bagian-bagian tumbuhan yang diperbesar dan durasi singkat',
                    'd' => 'Menggunakan tumbuhan sebagai media pembelajaran dan disertai narasi audio',
                ],
                'answer' => 'd',
            ],
            [
                'question' => 'Seorang guru memperagakan proses pernafasan dada dan pernafasan perut. Pernyataan berikut yang benar adalah ....',
                'options' => [
                    'a' => 'Otot utama yang bekerja pada pernafasan dada adalah diafragma',
                    'b' => 'Perut mengembang dan mengempis saat terjadi menarik dan menghembuskan nafas saat pernafasan dada',
                    'c' => 'Volume udara pada pernafasan dada lebih sedikit dan nafas lebih pendek',
                    'd' => 'Pernafasan dada lebih banyak dilakukan saat tidur',
                ],
                'answer' => 'c',
            ],
        ];
    }

}
