<?php

namespace App\Http\Controllers;

use App\Models\{ BaseMaterial, Prk, PrkFile, PrkJasa, PrkMaterial};
use Illuminate\Http\Request;
use Illuminate\Support\{ Carbon, Str };
use Illuminate\Support\Facades\Storage;

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
            'normalisasi' => $material->normalisasi,
            'nama' => $material->nama,
            'deskripsi' => $material->deskripsi,
            'satuan' => $material->satuan,
            'harga' => $material->harga,
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

        if($material->jumlah !== $material->stok) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'Material sudah digunakan di SKKI.',
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
