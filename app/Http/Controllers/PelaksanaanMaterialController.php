<?php

namespace App\Http\Controllers;

use App\Models\Pelaksanaan;
use App\Models\PelaksanaanMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\{ Carbon, Str };

class PelaksanaanMaterialController extends Controller
{
    public function store($pelaksanaan_id, Request $request) {
        $pelaksanaan = Pelaksanaan::find($pelaksanaan_id);

        if(!$pelaksanaan) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'pelaksanaan not found',
                'done_at' => Carbon::now()
            ]); 
        }

        $data = [
            'id' => Str::orderedUuid(),
            'tug9' => $request->material_tug9,
            'normalisasi' => $request->material_normalisasi,
            'nama' => $request->material_nama,
            'deskripsi' => $request->material_deskripsi,
            'satuan' => $request->material_satuan,
            'harga' => $request->material_harga,
            'jumlah' => $request->material_jumlah,
            'transaksi' => $request->material_transaksi,
            'tanggal' => $request->material_tanggal,
            'pelaksanaan_id' => $pelaksanaan_id,
            'base_material_id' => $request->base_material_id
        ];

        try {
            PelaksanaanMaterial::create($data);
            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'success',
                'done_at' => Carbon::now()
            ]); 
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => $th,
                'done_at' => Carbon::now()
            ]); 
        }
    }

    public function update($pelaksanaan_id, $material_id, Request $request) {
        $pelaksanaan = Pelaksanaan::find($pelaksanaan_id);

        if(!$pelaksanaan) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'pelaksanaan not found',
                'done_at' => Carbon::now()
            ]); 
        }

        $pelaksanaan_material = PelaksanaanMaterial::find($material_id);
        if(!$pelaksanaan_material) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'material not found',
                'done_at' => Carbon::now()
            ]); 
        }

        $data = [
            'id' => $material_id,
            'tug9' => $request->material_tug9,
            'normalisasi' => $request->material_normalisasi,
            'nama' => $request->material_nama,
            'deskripsi' => $request->material_deskripsi,
            'satuan' => $request->material_satuan,
            'harga' => $request->material_harga,
            'jumlah' => $request->material_jumlah,
            'transaksi' => $request->material_transaksi,
            'tanggal' => $request->material_tanggal,
            'pelaksanaan_id' => $pelaksanaan_id,
            'base_material_id' => $request->base_material_id
        ];

        try {
            $pelaksanaan_material->update($data);
            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'success',
                'done_at' => Carbon::now()
            ]); 
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => $th,
                'done_at' => Carbon::now()
            ]); 
        }
    }

    public function destroy($pelaksanaan_id, $material_id, Request $request) {
        $pelaksanaan = Pelaksanaan::find($pelaksanaan_id);
        if(!$pelaksanaan) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'pelaksanaan not found',
                'done_at' => Carbon::now()
            ]);
        }

        $pelaksanaan_material = PelaksanaanMaterial::find($material_id);
        if(!$pelaksanaan_material) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'material not found',
                'done_at' => Carbon::now()
            ]); 
        }

        try{
            $pelaksanaan_material->delete();
            return response()->json([
                'success' => true,
                'data' => '',
                'message' => 'success',
                'done_at' => Carbon::now()
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => $th,
                'done_at' => Carbon::now()
            ]);
        }
    }
}
