<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index(){
        $data = Topic::withCount('subtopics')
                        ->orderBy('created_at', 'asc')
                        ->get();
                          
        return view('dosen.topic', compact('data'));
    }
    
    public function form($id = null){
        $topic = null;
        if($id){
            $topic = Topic::find($id);
        }
        return view('dosen.topic_form', compact('topic'));
    }

    public function store(Request $request, $id = null){
        try{ 
            $data = $request->validate([
                'title'          => 'required|max:255',
                'start_date'     => 'required|date',
                'end_date'       => 'required|date|after_or_equal:start_date',
            ]);

            if($id != null){
                $topic = Topic::find($id);
                if($topic == null){
                    return back()->with('error', 'Data tidak valid!');
                } 

            }

            $id != null ? $topic->update($data) : Topic::create($data);

            return redirect()->route('dosen.topic')->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id = null){
        try{ 
           $topic = Topic::findOrFail($id);
           $topic->delete();

            return redirect()->route('dosen.topic')->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
