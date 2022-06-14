<?php

namespace App\Http\Controllers;

use App\Models\BaseMaterial;
use App\Models\Pelaksanaan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PelaksanaanController extends Controller
{
    public function index(Request $request) {
        $pelaksanaans = Pelaksanaan::with('kontrak')->get();
        return view('pelaksanaan.index', compact('pelaksanaans'));
    }

    public function show($pelaksanaan_id, Request $request) {
        $pelaksanaan = Pelaksanaan::with(['jasas', 'materials'])->find($pelaksanaan_id);

        if(!$pelaksanaan) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'pelaksanaan not found',
                'done_at' => Carbon::now()
            ]); 
        }

        $kontrak_materials = collect($pelaksanaan->kontrak->materials)->pluck('normalisasi');
        // hanya sediakan material yang ada di kontraknya pelaksanaan
        $base_materials = BaseMaterial::whereIn('normalisasi', $kontrak_materials)->get();

        return view('pelaksanaan.show', compact('pelaksanaan', 'base_materials'));
    }

    public function update($pelaksanaan_id, Request $request) {
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
            'spk' => $request->spk,
            'progress' => $request->progress
        ];

        try {
            $pelaksanaan->update($data);
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

    public function rabJasa($pelaksanaan_id) {
        $pelaksanaan = Pelaksanaan::find($pelaksanaan_id);
        if(!$pelaksanaan) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'pelaksanaan not found',
                'done_at' => Carbon::now()
            ]);
        }

        try {
            $rab_jasa = $pelaksanaan->kontrak->jasas;
            return response()->json([
                'success' => true,
                'data' => $rab_jasa,
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

    public function rabMaterial($pelaksanaan_id) {
        $pelaksanaan = Pelaksanaan::find($pelaksanaan_id);
        if(!$pelaksanaan) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'pelaksanaan not found',
                'done_at' => Carbon::now()
            ]);
        }

        try {
            $rab_material = $pelaksanaan->kontrak->materials;
            return response()->json([
                'success' => true,
                'data' => $rab_material,
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

    public function stokMaterial($pelaksanaan_id) {
        $pelaksanaan = Pelaksanaan::find($pelaksanaan_id);
        if(!$pelaksanaan) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'pelaksanaan not found',
                'done_at' => Carbon::now()
            ]);
        }

        try {
            $rab_materials = $pelaksanaan->kontrak->materials;
            
            $stok = [];
            foreach ($rab_materials as $rab_material) {
                if(isset($stok[$rab_material->normalisasi])) {
                    $stok[$rab_material->normalisasi]['jumlah'] += $rab_material->jumlah;
                } else {
                    $stok[$rab_material->normalisasi] = $rab_material->toArray();
                }
            }

            $transaksi_materials = $pelaksanaan->materials;
            foreach ($transaksi_materials as $transaksi_material) {
                if($transaksi_material->transaksi == 'keluar') {
                    $stok[$transaksi_material->normalisasi]['jumlah'] += $transaksi_material->jumlah;
                } else {
                    $stok[$transaksi_material->normalisasi]['jumlah'] -= $transaksi_material->jumlah;
                }
            }

            return response()->json([
                'success' => true,
                'data' => $stok,
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
