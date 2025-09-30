<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\ContentProgress;
use App\Models\Pretest;
use App\Models\PretestAttempt;
use App\Models\SubTopic;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopicController extends Controller
{
    
    public function index()
    {
        $user = auth()->user();
        $userId = $user->id;
        $now = now();

        // ambil semua topik + jumlah subtopik
        $topics = Topic::withCount('subtopics')
            ->orderBy('created_at', 'asc')
            ->get();

        // ambil semua konten per topik sekaligus (hanya id)
        $allContentIds = Content::pluck('id', 'sub_topic_id'); // keyed by sub_topic_id

        $topics->map(function ($topic) use ($user, $userId, $now, $allContentIds) {

            // ===== 1️⃣ Hitung progress =====
            $subTopicIds = $topic->subtopics()->pluck('id');

            // total konten di topik
            $totalContents = Content::whereIn('sub_topic_id', $subTopicIds)->count();

            // jumlah konten yang sudah dibaca user
            $readContents = ContentProgress::where('user_id', $userId)
                ->whereIn('content_id', function($q) use ($subTopicIds) {
                    $q->select('id')->from('contents')->whereIn('sub_topic_id', $subTopicIds);
                })
                ->where('is_read', true)
                ->count();

            $topic->progress = $totalContents > 0
                ? round(($readContents / $totalContents) * 100, 2)
                : 0;
            
            // topik diskusi dan refleksi
            $topic->has_discussed = $user->discussions()->where('topic_id', $topic->id)->exists();
            $topic->has_reflected = $user->reflections()->where('topic_id', $topic->id)->exists();

            // ===== 2️⃣ Default topik tersedia =====
            $topic->is_available = true;
            $topic->blocked_reason = null;

            // ===== 3️⃣ Cek prerequest =====

            // 3a Pretest aktif
            $pretest = Pretest::where('is_active', true)
                ->where('start_date', '<=', $now)
                ->where('end_date', '>=', $now)
                ->first();

            if ($pretest) {
                $attempt = PretestAttempt::where('pretest_id', $pretest->id)
                    ->where('user_id', $user->id)
                    ->where('status', 'submitted')
                    ->exists();

                if (!$attempt) {
                    $topic->is_available = false;
                    $topic->blocked_reason = 'Silahkan selesaikan pretest terlebih dahulu';
                    return $topic;
                }
            }

            // 3b Cek tanggal topik
            if ($topic->start_date && $now->lt($topic->start_date)) {
                $topic->is_available = false;
                $topic->blocked_reason = 'Topik ini belum dibuka';
                return $topic;
            }

            if ($topic->end_date && $now->gt($topic->end_date)) {
                $topic->is_available = false;
                $topic->blocked_reason = 'Topik ini sudah ditutup';
                return $topic;
            }

            // 3c Cek topik sebelumnya
            $prevTopic = Topic::where('id', '<', $topic->id)->orderBy('id', 'desc')->first();
            if ($prevTopic) {

                // total konten topik sebelumnya
                $prevSubIds = $prevTopic->subtopics()->pluck('id');
                $totalPrevContents = Content::whereIn('sub_topic_id', $prevSubIds)->count();

                // jumlah konten yang sudah dibaca
                $readPrevContents = ContentProgress::where('user_id', $user->id)
                    ->whereIn('content_id', function($q) use ($prevSubIds) {
                        $q->select('id')->from('contents')->whereIn('sub_topic_id', $prevSubIds);
                    })
                    ->where('is_read', true)
                    ->count();

                if ($readPrevContents < $totalPrevContents) {
                    $topic->is_available = false;
                    $topic->blocked_reason = 'Selesaikan semua konten di topik sebelumnya';
                    return $topic;
                }

                // diskusi
                $participated = $user->discussions()->where('topic_id', $prevTopic->id)->exists();
                if (!$participated) {
                    $topic->is_available = false;
                    $topic->blocked_reason = 'Ikuti diskusi di topik sebelumnya';
                    return $topic;
                }

                // refleksi (6 pertanyaan)
                $reflections = $user->reflections()->where('topic_id', $prevTopic->id)->exists();
                if (!$reflections) {
                    $topic->is_available = false;
                    $topic->blocked_reason = 'Isi semua refleksi di topik sebelumnya';
                    return $topic;
                }
            }

            return $topic;
        });

        return view('mahasiswa.topic', compact('topics'));
    }


    
    public function subtopic($topic_id)
    {
        $userId = auth()->id();

        $topic = Topic::findOrFail($topic_id);

        // ambil subtopik + total konten
        $subtopics = SubTopic::withCount('contents')
            ->where('topic_id', $topic_id)
            ->orderBy('created_at', 'asc')
            ->get();

        // ambil jumlah konten yang sudah dibaca per subtopik dalam 1 query
        $readCounts = DB::table('content_progress as cp')
            ->join('contents as c', 'cp.content_id', '=', 'c.id')
            ->select('c.sub_topic_id', DB::raw('COUNT(cp.id) as read_count'))
            ->where('cp.user_id', $userId)
            ->where('cp.is_read', true)
            ->whereIn('c.sub_topic_id', $subtopics->pluck('id'))
            ->groupBy('c.sub_topic_id')
            ->pluck('read_count', 'sub_topic_id'); // sub_topic_id => read_count

        // tambahkan ke masing-masing subtopik
        $subtopics->map(function ($st) use ($readCounts) {
            $st->read_contents = $readCounts->get($st->id, 0);
            return $st;
        });

        return view('mahasiswa.subtopic', compact('subtopics', 'topic'));
    }


    public function contents($topic_id, $subtopic_id){
        $userId = auth()->id();

        $topic = Topic::findOrFail($topic_id);
        $subtopic = SubTopic::findOrFail($subtopic_id);

        $contents = Content::select('title', 'id')
                        ->with(['progress_by_user' => function($q) use ($userId) {
                            $q->where('user_id', $userId);
                            $q->where('is_read', 1);
                        }])
                        ->where('sub_topic_id', $subtopic_id)  
                        ->orderBy('created_at', 'asc')
                        ->get();
                          
        return view('mahasiswa.contents', compact('subtopic', 'topic', 'contents'));
    }
    
    public function content($topic_id, $subtopic_id, $content_id)
    {
        $topic = Topic::findOrFail($topic_id);
        $subtopic = SubTopic::findOrFail($subtopic_id);
        $content = Content::findOrFail($content_id);

        $userId = auth()->id();

        // cek apakah progress sudah ada
        $progress = ContentProgress::firstOrNew([
            'user_id'   => $userId,
            'content_id'=> $content->id,
        ]);

        // kalau belum pernah baca → tandai sebagai read
        if (!$progress->exists || !$progress->is_read) {
            $progress->is_read = true;
            $progress->read_at = now();
            $progress->save();
        }

        return view('mahasiswa.content', compact('subtopic', 'topic', 'content'));
    }
}
