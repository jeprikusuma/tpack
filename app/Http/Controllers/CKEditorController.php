<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CKEditorController extends Controller
{
    public function store(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $path = $file->store('uploads', 'public');
            $url = asset('storage/' . $path);

            return response()->json([
                'url' => $url 
            ]);
        }

        return response()->json(['error' => 'Tidak ada file diupload'], 400);
    }
}
