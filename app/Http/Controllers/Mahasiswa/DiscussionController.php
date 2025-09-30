<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Discussion;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DiscussionController extends Controller
{
    public function index($topic_id)
    {
        $userId = auth()->id();
        $topic = Topic::findOrFail($topic_id);

        // Ambil semua subtopik + jumlah konten masing-masing
        $subtopics = $topic->subtopics()->withCount('contents')->get();

        // Ambil jumlah konten yang sudah dibaca user
        $readCounts = DB::table('content_progress as cp')
            ->join('contents as c', 'cp.content_id', '=', 'c.id')
            ->select('c.sub_topic_id', DB::raw('COUNT(cp.id) as read_count'))
            ->where('cp.user_id', $userId)
            ->where('cp.is_read', true)
            ->whereIn('c.sub_topic_id', $subtopics->pluck('id'))
            ->groupBy('c.sub_topic_id')
            ->pluck('read_count', 'sub_topic_id');

        // hitung progress per subtopik
        $subtopics->map(function ($st) use ($readCounts) {
            $st->read_contents = $readCounts->get($st->id, 0);
            return $st;
        });

        // Hitung progress topik
        $totalContents = $subtopics->sum('contents_count');
        $readContents = $subtopics->sum('read_contents');
        $progress = $totalContents > 0 ? round(($readContents / $totalContents) * 100, 2) : 0;

        // Cek jika progress < 100%, redirect atau abort
        if ($progress < 100) {
            return redirect()->route('mahasiswa.subtopic', ['topic_id' => $topic->id])
                            ->with('error', 'Anda harus menyelesaikan semua konten topik sebelum mengakses diskusi.');
        }

        // Ambil diskusi
        $discussions = Discussion::where('topic_id', $topic_id)
            ->whereNull('parent_id')
            ->with(['user', 'replies.user'])
            ->latest()
            ->get();

        return view('mahasiswa.discussion', compact('topic', 'discussions'));
    }

    public function store(Request $request, $topic_id)
    {
        $request->validate([
            'message'   => 'required|string',
            'parent_id' => 'nullable|exists:discussions,id',
        ]);

        Discussion::create([
            'topic_id'  => $topic_id,
            'user_id'   => Auth::id(),
            'parent_id' => $request->parent_id,
            'message'   => $request->message,
        ]);

        return redirect()
            ->route('mahasiswa.discussion', $topic_id)
            ->with('success', 'Diskusi berhasil ditambahkan.');
    }

    public function reply(Request $request, $topic_id, $discussion_id)
    {
        // Validasi input
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        // Buat balasan baru
        Discussion::create([
            'topic_id'  => $topic_id,
            'parent_id' => $discussion_id,
            'user_id'   => auth()->id(),
            'message'   => $request->message,
        ]);

        return back()->with('success', 'Balasan berhasil ditambahkan!');
    }

    public function destroy($topic_id, $discussion_id)
    {
        $discussion = Discussion::findOrFail($discussion_id);

        // Cek apakah user berhak menghapus
        if ($discussion->user_id !== Auth::id()) {
            return redirect()
                ->route('mahasiswa.discussion', $topic_id)
                ->with('error', 'Anda tidak memiliki izin untuk menghapus diskusi ini.');
        }

        $discussion->delete();

        return redirect()
            ->route('mahasiswa.discussion', $topic_id)
            ->with('success', 'Diskusi berhasil dihapus.');
    }
}
