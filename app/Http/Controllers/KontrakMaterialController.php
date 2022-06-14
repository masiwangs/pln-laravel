<?php

namespace App\Http\Controllers;

use App\Models\{ BaseMaterial, KontrakMaterial };
use Illuminate\Http\Request;
use Illuminate\Support\{ Carbon, Str };

class KontrakMaterialController extends Controller
{
    public function store($kontrak_id, Request $request) {
        $material = BaseMaterial::find($request->base_material_id);

        if(!$material) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'material not found',
                'done_at' => Carbon::now()
            ]);
        }

        $data = [
            'id' => Str::orderedUuid(),
            'normalisasi' => $material->normalisasi,
            'nama' => $material->nama,
            'deskripsi' => $material->deskripsi,
            'satuan' => $material->satuan,
            'harga' => $material->harga,
            'jumlah' => $request->material_jumlah,
            'kontrak_id' => $kontrak_id,
            'base_material_id' => $material->id
        ];

        KontrakMaterial::create($data);

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'success',
            'done_at' => Carbon::now()
        ]);
    }

    public function update($kontrak_id, $material_id, Request $request) {
        $base_material = BaseMaterial::find($request->base_material_id);
        
        if(!$base_material) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'material not found',
                'done_at' => Carbon::now()
            ]);
        }

        $material = KontrakMaterial::find($material_id);

        $data = [
            'id' => $material->id,
            'normalisasi' => $material->normalisasi,
            'nama' => $material->nama,
            'deskripsi' => $material->deskripsi,
            'satuan' => $material->satuan,
            'harga' => $material->harga,
            'jumlah' => $request->material_jumlah,
            'kontrak_id' => $kontrak_id,
            'base_material_id' => $base_material->id
        ];

        $material->update($data);

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'success',
            'done_at' => Carbon::now()
        ]);
    }

    public function destroy($kontrak_id, $material_id, Request $request) {
        $material = KontrakMaterial::find($material_id);

        if(!$material) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'material not found',
                'done_at' => Carbon::now()
            ]);
        }

        $material->delete();

        return response()->json([
            'success' => true,
            'data' => '',
            'message' => 'success',
            'done_at' => Carbon::now()
        ]);
    }
}
