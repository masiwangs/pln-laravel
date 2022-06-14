<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\PembayaranFile;
use Illuminate\Http\Request;
use Illuminate\Support\{ Carbon, Str };
use Illuminate\Support\Facades\Storage;

class PembayaranFileController extends Controller
{
    public function store($pembayaran_id, Request $request) {
        $filename = $request->file->getClientOriginalName();
        $url = $request->file->storeAs('files', Carbon::now()->timestamp.'-'.$filename);
        $data = [
            'id' => Str::orderedUuid(),
            'nama' => $filename,
            'deskripsi' => $request->deskripsi,
            'url' => $url,
            'pembayaran_id' => $pembayaran_id
        ];

        PembayaranFile::create($data);

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'success',
            'done_at' => Carbon::now()
        ]);
    }

    public function destroy($pembayaran_id, $file_id, Request $request) {
        $file = PembayaranFile::find($file_id);

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
