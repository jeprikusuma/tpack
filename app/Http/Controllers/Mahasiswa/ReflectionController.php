<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Reflection;
use App\Models\SubTopic;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReflectionController extends Controller
{

    public function index($topic_id)
    {
        $userId = auth()->id();
        $topic = Topic::findOrFail($topic_id);

        // ===== 1️⃣ Hitung progress topik =====
        $subtopics = $topic->subtopics()->withCount('contents')->get();

        // ambil jumlah konten yang sudah dibaca user
        $readCounts = DB::table('content_progress as cp')
            ->join('contents as c', 'cp.content_id', '=', 'c.id')
            ->select('c.sub_topic_id', DB::raw('COUNT(cp.id) as read_count'))
            ->where('cp.user_id', $userId)
            ->where('cp.is_read', true)
            ->whereIn('c.sub_topic_id', $subtopics->pluck('id'))
            ->groupBy('c.sub_topic_id')
            ->pluck('read_count', 'sub_topic_id');

        $subtopics->map(function ($st) use ($readCounts) {
            $st->read_contents = $readCounts->get($st->id, 0);
            return $st;
        });

        $totalContents = $subtopics->sum('contents_count');
        $readContents = $subtopics->sum('read_contents');
        $progress = $totalContents > 0 ? round(($readContents / $totalContents) * 100, 2) : 0;

        if ($progress < 100) {
            return redirect()->route('mahasiswa.subtopic', ['topic_id' => $topic->id])
                            ->with('error', 'Anda harus menyelesaikan semua konten topik terlebih dahulu.');
        }

        // ===== 2️⃣ Cek sudah ikut diskusi =====
        $hasDiscussion = DB::table('discussions')
            ->where('topic_id', $topic_id)
            ->where('user_id', $userId)
            ->exists();

        if (!$hasDiscussion) {
            return redirect()->route('mahasiswa.subtopic', ['topic_id' => $topic->id])
                            ->with('error', 'Anda harus mengikuti diskusi topik ini sebelum mengisi refleksi.');
        }

        // ===== 3️⃣ Ambil refleksi jika sudah ada =====
        $reflection = Reflection::where('user_id', $userId)
                                ->where('topic_id', $topic_id)
                                ->first();

        $questions = [
            "Bagaimana perasaanmu mempelajari materi tersebut?",
            "Apa yang telah anda pahami dari materi yang telah di pelajari?",
            "Apa hal baru/bermakna yang anda dapatkan dari materi yang dipelajari?",
            "Apa materi yang yang belum anda pahami?",
            "Kesulitan apakah yang anda hadapi selama mempelajari materi?",
            "Bagaimanakah anda akan menyelesaikan kesulitan tersebut?"
        ];

        return view('mahasiswa.reflection', compact('topic', 'reflection', 'questions'));
    }



    public function store(Request $request, $topic_id){
        $user_id = auth()->id();
        $data = $request->validate([
            'answer1' => 'required|string',
            'answer2' => 'required|string',
            'answer3' => 'required|string',
            'answer4' => 'required|string',
            'answer5' => 'required|string',
            'answer6' => 'required|string',
        ]);

        Reflection::updateOrCreate(
            ['user_id' => $user_id, 'topic_id' => $topic_id],
            $data
        );
        return redirect()->route('mahasiswa.reflection', ['topic_id' => $topic_id])->with('success', 'Refleksi berhasil disimpan!');
    }
}
