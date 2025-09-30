<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\SubTopic;
use App\Models\Topic;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index($topic_id, $subtopic_id){
        $topic = Topic::findOrFail($topic_id);
        $subtopic = SubTopic::findOrFail($subtopic_id);
        $contents = Content::select('title', 'id')
                        ->where('sub_topic_id', $subtopic_id)  
                        ->orderBy('created_at', 'asc')
                        ->get();
                          
        return view('dosen.content', compact('subtopic', 'topic', 'contents'));
    }

    public function form($topic_id, $subtopic_id, $id = null){
        $topic = Topic::findOrFail($topic_id);
        $subtopic = SubTopic::findOrFail($subtopic_id);
        $content = null;
        if($id){
            $content = Content::find($id);
        }
        return view('dosen.content_form', compact('subtopic', 'topic', 'content'));
    }

    public function store(Request $request, $topic_id, $subtopic_id, $id = null){
        try{ 
            $topic = Topic::findOrFail($topic_id);
            $subtopic = SubTopic::findOrFail($subtopic_id);

            $data = $request->validate([
                'title' => ['required', 'max:255'],
                'description' => ['required'],
            ]);
            
            $data['sub_topic_id'] = $subtopic->id;

            if($id != null){
                $content = Content::find($id);
                if($content == null){
                    return back()->with('error', 'Data tidak valid!');
                } 

            }

            $id != null ? $content->update($data) : Content::create($data);

            return redirect()->route('dosen.content', ['topic_id' => $topic->id, 'subtopic_id' => $subtopic->id])->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($topic_id, $subtopic_id, $id = null){
        try{ 
           $topic = Topic::findOrFail($topic_id);
           $subtopic = SubTopic::findOrFail($subtopic_id);
           $content = Content::findOrFail($id);
           $content->delete();

            return redirect()->route('dosen.content', ['topic_id' => $topic->id, 'subtopic_id' => $subtopic->id])->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    
}
