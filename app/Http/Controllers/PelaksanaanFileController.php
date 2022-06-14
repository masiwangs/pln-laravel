<?php

namespace App\Http\Controllers;

use App\Models\PelaksanaanFile;
use Illuminate\Http\Request;
use Illuminate\Support\{ Carbon, Str };
use Illuminate\Support\Facades\Storage;

class PelaksanaanFileController extends Controller
{
    public function store($pelaksanaan_id, Request $request) {
        $filename = $request->file->getClientOriginalName();
        $url = $request->file->storeAs('files', Carbon::now()->timestamp.'-'.$filename);
        $data = [
            'id' => Str::orderedUuid(),
            'nama' => $filename,
            'deskripsi' => $request->deskripsi,
            'url' => $url,
            'pelaksanaan_id' => $pelaksanaan_id
        ];

        PelaksanaanFile::create($data);

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'success',
            'done_at' => Carbon::now()
        ]);
    }

    public function destroy($pelaksanaan_id, $file_id, Request $request) {
        $file = PelaksanaanFile::find($file_id);

        if(!$file) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'file not found',
                'done_at' => Carbon::now()
            ]);
        }

        Storage::delete($file->url);
        $file->delete();

        return response()->json([
            'success' => true,
            'data' => '',
            'message' => 'success',
            'done_at' => Carbon::now()
        ]); 
    }
}
