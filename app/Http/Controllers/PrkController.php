<?php

namespace App\Http\Controllers;

use App\Models\{ BaseMaterial, Prk, PrkFile, PrkJasa, PrkMaterial};
use Illuminate\Http\Request;
use Illuminate\Support\{ Carbon, Str };
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PrkController extends Controller
{
    public function index() {
        $prks = Prk::with('jasas')->get();
        $result = [
            'basket_1' => [],
            'basket_2' => [],
            'basket_3' => [],
        ];
        foreach($prks as $prk) {
            array_push($result['basket_'.$prk->basket], $prk);
        }
        return view('prk.index', compact('result'));
    }

    public function create(Request $request) {
        $id = Str::uuid();
        $prk = Prk::create([
            'id' => $id,
            'basket' => $request->basket
        ]);

        return redirect('/prk/'.$id);
    }

    public function import(Request $request) {
        $request->validate([
            'file' => 'required'
        ]);

        $temp_id = Str::orderedUuid();

        $input = $request->file->storeAs('temp', $temp_id.'.xlsx');
        $file = public_path('storage/'.$input);
        $source = IOFactory::load(str_replace('\\', '/', $file));
        $worksheet = $source->getActiveSheet();
        $total_row = $worksheet->getHighestRow();
        for ($i=2; $i <= $total_row; $i++) { 
            $nama_project = $worksheet->getCell('A'.$i)->getValue();
            $prk = $worksheet->getCell('B'.$i)->getValue();
            $lot = $worksheet->getCell('C'.$i)->getValue();
            $prioritas = $worksheet->getCell('D'.$i)->getValue();
            $basket = $worksheet->getCell('E'.$i)->getValue();

            // cek apakah udah ada nomor prk sama
            $exist = Prk::select('id')->where('prk', $prk)->first();

            if($prk && !$exist) {
                $data = [
                    'id' => Str::orderedUuid(),
                    'nama' => $nama_project,
                    'prk' => $prk,
                    'lot' => $lot,
                    'prioritas' => $prioritas,
                    'basket' => in_array($basket, [1, 2, 3]) ? $basket : 1
                ];

                Prk::create($data);
            }
        }

        return redirect()->back();
    }

    public function show($id) {
        $prk = Prk::with('jasas')->find($id);
        $materials = BaseMaterial::get();
        return view('prk.show', compact('prk', 'materials'));
    }

    public function update($id, Request $request) {
        $prk = Prk::find($id);
        $prk->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'success',
            'done_at' => Carbon::now()
        ], 200);
    }

    public function destroy(Prk $prk) {
        // check skki
        $skki = $prk->skki;
        if($skki) {
            return response()->json([
                'success' => false,
                'message' => 'Terdapat SKKI yang memakai PRK ini.',
                'done_at' => Carbon::now(),
            ]);
        }
        // delete material & jasa & files
        foreach ($prk->jasas as $jasa) {
            $jasa->delete();
        }
        foreach ($prk->materials as $material) {
            $material->delete();
        }
        foreach ($prk->files as $file) {
            Storage::delete($file->url);
            $file->delete();
        }
        // delete project
        $prk->delete();
        return response()->json([
            'success' => true,
            'message' => 'deleted',
            'done_at' => Carbon::now(),
        ]);
    }

    public function jasaStore($prk_id, Request $request) {
        $prk = Prk::find($prk_id);
        if(!$prk) {
            return response()->json([
                'success' => false,
                'message' => 'prk not found',
                'done_at' => Carbon::now(),
            ]);
        }
        $jasa_id = Str::orderedUuid();
        $jasa = PrkJasa::create([
            'id' => $jasa_id,
            'nama' => $request->jasa_nama,
            'harga' => $request->jasa_harga,
            'prk_id' => $prk->id
        ]);
        $jasa['id'] = $jasa_id;

        return response()->json([
            'success' => true,
            'data' => $jasa,
            'message' => 'success',
            'done_at' => Carbon::now()
        ]);
    }

    public function jasaUpdate($prk_id, $jasa_id, Request $request) {
        $prk = Prk::find($prk_id);
        if(!$prk) {
            return response()->json([
                'success' => false,
                'message' => 'prk not found',
                'done_at' => Carbon::now(),
            ]);
        }
        $jasa = PrkJasa::find($jasa_id);
        $data = [
            'id' => $jasa_id,
            'nama' => $request->jasa_nama,
            'harga' => $request->jasa_harga,
            'prk_id' => $prk->id
        ];
        
        $jasa->update($data);
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'success',
            'done_at' => Carbon::now()
        ]);
    }

    public function jasaDestroy($prk_id, $jasa_id) {
        $jasa = PrkJasa::find($jasa_id);
        $jasa->delete();
        return response()->json([
            'success' => true,
            'data' => '',
            'message' => 'success',
            'done_at' => Carbon::now()
        ]);
    }

    public function materialStore($prk_id, Request $request) {
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
            'prk_id' => $prk_id,
            'base_material_id' => $material->id
        ];

        PrkMaterial::create($data);

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'success',
            'done_at' => Carbon::now()
        ]);
    }

    public function materialUpdate($prk_id, $material_id, Request $request) {
        $base_material = BaseMaterial::find($request->base_material_id);

        if(!$base_material) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'material not found',
                'done_at' => Carbon::now()
            ]);
        }

        $material = PrkMaterial::find($material_id);

        $data = [
            'id' => $material_id,
            'normalisasi' => $base_material->normalisasi,
            'nama' => $request->material_nama,
            'deskripsi' => $request->material_deskripsi,
            'satuan' => $request->material_satuan,
            'harga' => $request->material_harga,
            'jumlah' => $request->material_jumlah,
            'prk_id' => $prk_id,
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

    public function materialDestroy($prk_id, $material_id, Request $request) {
        $material = PrkMaterial::find($material_id);

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

    public function fileStore($prk_id, Request $request) {
        $filename = $request->file->getClientOriginalName();
        $url = $request->file->storeAs('files', Carbon::now()->timestamp.'-'.$filename);
        $data = [
            'id' => Str::orderedUuid(),
            'nama' => $filename,
            'deskripsi' => $request->deskripsi,
            'url' => $url,
            'prk_id' => $prk_id
        ];

        PrkFile::create($data);

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'success',
            'done_at' => Carbon::now()
        ]);
    }

    public function fileDestroy($prk_id, $file_id, Request $request) {
        $file = PrkFile::find($file_id);

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
