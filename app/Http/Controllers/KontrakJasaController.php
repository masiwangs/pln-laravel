<?php

namespace App\Http\Controllers;

use App\Models\{ Kontrak, KontrakJasa };
use Illuminate\Http\Request;
use Illuminate\Support\{ Carbon, Str };

class KontrakJasaController extends Controller
{
    public function store($kontrak_id, Request $request) {
        $kontrak = Kontrak::find($kontrak_id);
        if(!$kontrak) {
            return response()->json([
                'success' => false,
                'message' => 'kontrak not found',
                'done_at' => Carbon::now(),
            ]);
        }
        $data = [
            'id' => Str::orderedUuid(),
            'nama' => $request->jasa_nama,
            'harga' => $request->jasa_harga,
            'kontrak_id' => $kontrak->id
        ];
        KontrakJasa::create($data);
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'success',
            'done_at' => Carbon::now()
        ]);
    }

    public function update($kontrak_id, $jasa_id, Request $request) {
        $kontrak = Kontrak::find($kontrak_id);
        if(!$kontrak) {
            return response()->json([
                'success' => false,
                'message' => 'kontrak not found',
                'done_at' => Carbon::now(),
            ]);
        }
        $jasa = KontrakJasa::find($jasa_id);
        $data = [
            'id' => $jasa_id,
            'nama' => $request->jasa_nama,
            'harga' => $request->jasa_harga,
            'kontrak_id' => $kontrak->id
        ];
        
        $jasa->update($data);
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'success',
            'done_at' => Carbon::now()
        ]);
    }

    public function destroy($kontrak_id, $jasa_id) {
        $jasa = KontrakJasa::find($jasa_id);
        $jasa->delete();
        return response()->json([
            'success' => true,
            'data' => '',
            'message' => 'success',
            'done_at' => Carbon::now()
        ]);
    }
}
