<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Reflection;
use App\Models\Topic;
use Illuminate\Http\Request;

class ReflectionController extends Controller
{
    public function index($topic_id)
    {
        $topic = Topic::findOrFail($topic_id);

        $reflections = Reflection::with('user')
            ->where('topic_id', $topic_id)
            ->orderBy('created_at', 'desc')
            ->get();

        $questions = [
            "Bagaimana perasaanmu mempelajari materi tersebut?",
            "Apa yang telah anda pahami dari materi yang telah di pelajari?",
            "Apa hal baru/bermakna yang anda dapatkan dari materi yang dipelajari?",
            "Apa materi yang yang belum anda pahami?",
            "Kesulitan apakah yang anda hadapi selama mempelajari materi?",
            "Bagaimanakah anda akan menyelesaikan kesulitan tersebut?"
        ];

        return view('dosen.reflection', compact('topic', 'reflections', 'questions'));
    }
}
