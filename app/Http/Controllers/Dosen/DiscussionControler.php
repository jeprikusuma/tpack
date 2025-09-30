<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Discussion;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscussionControler extends Controller
{
    public function index($topic_id)
    {
        $topic = Topic::findOrFail($topic_id);
        $discussions = Discussion::where('topic_id', $topic_id)
            ->whereNull('parent_id')
            ->with(['user', 'replies.user'])
            ->latest()
            ->get();

        return view('dosen.discussion', compact('topic', 'discussions'));
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
            ->route('dosen.discussion', $topic_id)
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
                ->route('dosen.discussion', $topic_id)
                ->with('error', 'Anda tidak memiliki izin untuk menghapus diskusi ini.');
        }

        $discussion->delete();

        return redirect()
            ->route('dosen.discussion', $topic_id)
            ->with('success', 'Diskusi berhasil dihapus.');
    }
}
