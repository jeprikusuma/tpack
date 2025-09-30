<?php

namespace App\Http\Middleware;

use App\Models\Pretest;
use App\Models\PretestAttempt;
use App\Models\Topic;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckTopicAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $topic_id = $request->route('topic_id');
        $topic = Topic::findOrFail($topic_id);

        $now = now();

        // 1️⃣ cek pretest aktif untuk topik ini
        $pretest = Pretest::where('is_active', true)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->first();

        if ($pretest) {
            // cek apakah user sudah submit pretest
            $attempt = PretestAttempt::where('pretest_id', $pretest->id)
                ->where('user_id', $user->id)
                ->where('status', 'submitted')
                ->first();

            if (!$attempt) {
                return redirect()->route('mahasiswa.pretest')->with('error', 'Silahkan selesaikan pretest terlebih dahulu.');
            }
        }

        // 2️⃣ cek rentang tanggal topik dibuka
        if ($topic->start_date && $now->lt($topic->start_date)) {
            return redirect()->route('mahasiswa.topic')->with('error', 'Topik ini belum dibuka.');
        }
        if ($topic->end_date && $now->gt($topic->end_date)) {
            return redirect()->route('mahasiswa.topic')->with('error', 'Topik ini sudah ditutup.');
        }

        // 3️⃣ cek topik sebelumnya
        $prevTopic = Topic::where('id', '<', $topic->id)->orderBy('id', 'desc')->first();
        if ($prevTopic) {
            // cek semua konten sebelumnya
            $totalPrevContents = $prevTopic->subtopics->sum(fn($st) => $st->contents->count());
            $readPrevContents = $user->contentProgress()
                ->whereIn('content_id', $prevTopic->subtopics->flatMap(fn($st) => $st->contents->pluck('id')))
                ->where('is_read', true)
                ->count();

            if ($readPrevContents < $totalPrevContents) {
                return redirect()->route('mahasiswa.topic')->with('error', 'Selesaikan semua konten di topik sebelumnya.');
            }

            // cek diskusi
            $participated = $user->discussions()->where('topic_id', $prevTopic->id)->exists();
            if (!$participated) {
                return redirect()->route('mahasiswa.topic')->with('error', 'Ikuti diskusi di topik sebelumnya.');
            }

            // cek refleksi
            $reflections = $user->reflections()->where('topic_id', $prevTopic->id)->exists();
            if (!$reflections) {
                return redirect()->route('mahasiswa.topic')->with('error', 'Isi refleksi di topik sebelumnya.');
            }
        }

        return $next($request);
    }
}
