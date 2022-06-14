<?php

namespace App\Http\Controllers;

use App\Models\BaseMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\{ Carbon, Str };
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BaseMaterialController extends Controller
{
    public function index() {
        $base_materials = BaseMaterial::get();
        return view('base-materials.index', compact('base_materials'));
    }

    public function store(Request $request) {
        $base_material = BaseMaterial::where('normalisasi', $request->normalisasi)->first();
        if($base_material) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'Kode normalisasi telah terdaftar',
                'done_at' => Carbon::now()
            ], 400); 
        }

        $data = [
            'id' => Str::orderedUuid(),
            'normalisasi' => $request->normalisasi,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'satuan' => $request->satuan,
            'harga' => $request->harga
        ];

        try {
            BaseMaterial::create($data);
            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'success',
                'done_at' => Carbon::now()
            ], 200); 
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => $th,
                'done_at' => Carbon::now()
            ], 400); 
        }
    }

    public function update($base_material_id, Request $request) {
        $base_material = BaseMaterial::find($base_material_id);
        if(!$base_material) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'Material tidak ditemukan',
                'done_at' => Carbon::now()
            ], 404); 
        }

        $data = [
            'id' => $base_material_id,
            'normalisasi' => $request->normalisasi,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'satuan' => $request->satuan,
            'harga' => $request->harga
        ];

        try {
            $base_material->update($data);
            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'success',
                'done_at' => Carbon::now()
            ], 200); 
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => $th,
                'done_at' => Carbon::now()
            ], 400); 
        }
    }

    public function import(Request $request) {
        $request->validate([
            'file' => 'required'
        ]);

        $input = $request->file->storeAs('temp', Str::orderedUuid().'.xlsx');

        $file = public_path('storage/'.$input);

        $source = IOFactory::load(str_replace('\\', '/', $file));
        $worksheet = $source->getActiveSheet();
        // $cell = $worksheet->getCell('A2')->getValue();
        $total_row = $worksheet->getHighestRow();
        for ($i=2; $i < $total_row; $i++) { 
            $normalisasi = $worksheet->getCell('A'.$i)->getValue();
            $nama = $worksheet->getCell('B'.$i)->getValue();
            $deskripsi = $worksheet->getCell('C'.$i)->getValue();
            $satuan = $worksheet->getCell('D'.$i)->getValue();
            $harga = $worksheet->getCell('E'.$i)->getValue();

            // cek apakah udah ada
            $exist = BaseMaterial::select('id')->where('normalisasi', $normalisasi)->first();

            if($normalisasi && $nama && $satuan && $harga && !$exist) {
                $data = [
                    'id' => Str::orderedUuid(),
                    'normalisasi' => $normalisasi,
                    'nama' => $nama,
                    'deskripsi' => $deskripsi,
                    'satuan' => $satuan,
                    'harga' => $harga
                ];

                BaseMaterial::create($data);
            }
        }

        Storage::delete($input);

        return redirect()->back();
    }
}
