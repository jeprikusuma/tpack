<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\ContentProgress;
use App\Models\Discussion;
use App\Models\FinalTaskSetting;
use App\Models\FinalTaskSubmission;
use App\Models\Reflection;
use App\Models\Topic;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    private $tasks = [
        'TA1' => 'Guru akan mengajarkan IPA topik <em>Tata Surya</em> di kelas VI. Di kelas tersebut teridentifikasi ada dua siswa <em>slow learners</em>. Susunlah rencana pembelajaran inklusif untuk mengakomodasi kebutuhan siswa yang berbeda! Terapkanlah pengetahuan Anda mengenai TPACK ketika menyusun rancangan pembelajaran!',
        'TA2' => 'Pak Eka merupakan guru kelas III di sebuah SD di Pedesaan. Di sekitar sekolah terdapat persawahan, sungai, dan ladang. Pak Eka akan mengajarkan IPA topik <em>Hewan Vertebrata dan Invertebrata</em>. Di kelas tersebut terdapat seorang siswa dengan gangguan pendengaran. Susunlah rencana pembelajaran inklusif yang sesuai dengan situasi tersebut! Terapkanlah pengetahuan Anda mengenai TPACK ketika menyusun rancangan pembelajaran!',
        'TA3' => 'Bu Ari adalah wali baru kelas IV SD. Ia mengetahui bahwa di kelas tersebut ada seorang anak laki-laki dengan gejala ADHD. Pada suatu hari, Bu Ari akan mengajarkan IPA topik <em>Ekosistem</em>. Ia ingin menciptakan pembelajaran yang inklusif untuk siswa kelas tersebut. Rancangan pembelajaran seperti apakah yang dapat disusun Bu Ari? Terapkanlah pengetahuan Anda mengenai TPACK ketika menyusun rancangan pembelajaran!'
    ];

    public function index()
    {

        $user = auth()->user();

        // Cek prasyarat untuk mengakses tugas akhir
        $check = $this->canAccessFinalAssignment($user);
        if (!$check['allowed']) {
            return view('mahasiswa.assignment', [
                'canAccess' => false,
                'reasons' => is_array($check['reason']) ? $check['reason'] : [$check['reason']],
                'setting' => FinalTaskSetting::first(),
                'submissions' => collect(),
                'tasks' => $this->tasks,
            ]);
        }

        $setting = FinalTaskSetting::first();
        $submissions = FinalTaskSubmission::where('user_id', $user->id)
            ->get()
            ->keyBy('task_code');

        return view('mahasiswa.assignment', [
            'canAccess' => true,
            'reasons' => [],
            'setting' => $setting,
            'submissions' => $submissions,
            'tasks' => $this->tasks,
        ]);
    }

    public function upload(Request $request)
    {
        // Cek prasyarat untuk mengakses tugas akhir
        $check = $this->canAccessFinalAssignment(auth()->user());
        if (!$check['allowed']) {
            return redirect()->back()->with('error', 'Persyaratan tidak terpenuhi!');
        }
        
        $request->validate([
            'task_code' => 'required|in:TA1,TA2,TA3',
            'file' => 'required|mimes:pdf,doc,docx|max:3048',
        ]);

        $user = auth()->user();
        $file = $request->file('file');
        $path = $file->store("final_tasks/{$user->id}", 'public');

        FinalTaskSubmission::updateOrCreate(
            [
                'user_id' => $user->id,
                'task_code' => $request->task_code,
            ],
            [
                'file_path' => $path,
                'submitted_at' => now(),
            ]
        );

        return redirect()->back()->with('success', 'File berhasil diunggah.');
    }

    private function canAccessFinalAssignment($user)
    {
        $userId = $user->id;
        // Test user
        if($user->email == 'jepri@test.com'){
            return ['allowed' => true];
        }

        // cek setting tugas akhir
        $setting = FinalTaskSetting::first();
        if(!$setting){
            return [
                'allowed' => false,
                'reason' => 'Tugas akhir belum tersedia!'
            ];
            
        }
        
        if(!$setting->isActive()){
            return [
                'allowed' => false,
                'reason' => "Tugas akhir tersedia pada ".Carbon::parse($setting->start_date)->format('d M Y H:i')." - ".Carbon::parse($setting->end_date)->format('d M Y H:i')
            ];
            
        }

        // Ambil topik terakhir (urutan paling akhir)
        $lastTopic = Topic::orderBy('id', 'desc')->first();

        if (!$lastTopic) {
            return [
                'allowed' => false,
                'reason' => 'Belum ada topik yang tersedia.'
            ];
        }

        // Ambil semua subtopik terakhir
        $subTopicIds = $lastTopic->subtopics()->pluck('id');

        // Hitung total konten
        $totalContents = Content::whereIn('sub_topic_id', $subTopicIds)->count();

        // Hitung jumlah konten yang sudah dibaca user
        $readContents = ContentProgress::where('user_id', $userId)
            ->whereIn('content_id', function($q) use ($subTopicIds) {
                $q->select('id')->from('contents')->whereIn('sub_topic_id', $subTopicIds);
            })
            ->where('is_read', true)
            ->count();

        // 1️⃣ Cek apakah semua konten di topik terakhir sudah dibaca
        if ($totalContents === 0 || $readContents < $totalContents) {
            return [
                'allowed' => false,
                'reason' => 'Selesaikan semua topik terlebih dahulu.'
            ];
        }

        // 2️⃣ Cek apakah sudah ikut diskusi
        $hasDiscussion = Discussion::where('user_id', $userId)
            ->where('topic_id', $lastTopic->id)
            ->exists();

        if (!$hasDiscussion) {
            return [
                'allowed' => false,
                'reason' => 'Ikuti diskusi di topik terakhir terlebih dahulu.'
            ];
        }

        // 3️⃣ Cek refleksi (6 pertanyaan)
        $hasReflection = Reflection::where('user_id', $userId)
            ->where('topic_id', $lastTopic->id)
            ->exists();

        if (!$hasReflection) {
            return [
                'allowed' => false,
                'reason' => 'Isi refleksi di topik terakhir terlebih dahulu.'
            ];
        }

        // Semua syarat terpenuhi ✅
        return ['allowed' => true];
    }

}
