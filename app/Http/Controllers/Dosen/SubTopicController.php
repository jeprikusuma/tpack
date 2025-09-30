<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\SubTopic;
use App\Models\Topic;
use Illuminate\Http\Request;

class SubTopicController extends Controller
{
    public function index($topic_id){
        $topic = Topic::findOrFail($topic_id);
        $subtopics = SubTopic::withCount('contents')
                        ->where('topic_id', $topic_id)  
                        ->orderBy('created_at', 'asc')
                        ->get();
                          
        return view('dosen.subtopic', compact('subtopics', 'topic'));
    }
    
    public function form($topic_id, $id = null){
        $topic = Topic::findOrFail($topic_id);
        $subtopic = null;
        if($id){
            $subtopic = SubTopic::find($id);
        }
        return view('dosen.subtopic_form', compact('subtopic', 'topic'));
    }

    public function store(Request $request, $topic_id, $id = null){
        try{ 
            $topic = Topic::findOrFail($topic_id);

            $data = $request->validate([
                'title' => ['required', 'max:255'],
            ]);
            
            $data['topic_id'] = $topic->id;

            if($id != null){
                $subtopic = SubTopic::find($id);
                if($subtopic == null){
                    return back()->with('error', 'Data tidak valid!');
                } 

            }

            $id != null ? $subtopic->update($data) : SubTopic::create($data);

            return redirect()->route('dosen.subtopic', ['topic_id' => $topic->id])->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($topic_id, $id = null){
        try{ 
           $topic = Topic::findOrFail($topic_id);
           $subtopic = SubTopic::findOrFail($id);
           $subtopic->delete();

            return redirect()->route('dosen.subtopic', ['topic_id' => $topic->id])->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
