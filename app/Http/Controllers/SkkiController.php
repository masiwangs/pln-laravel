<?php

namespace App\Http\Controllers;

use App\Models\{ BaseMaterial, PengadaanWbsJasa, PengadaanWbsMaterial, Skki, SkkiFile, SkkiJasa, SkkiMaterial, Prk};
use Illuminate\Http\Request;
use Illuminate\Support\{ Carbon, Str };
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SkkiController extends Controller
{
    public function index() {
        $skkis = Skki::get();
        $result = [
            'basket_1' => [],
            'basket_2' => [],
            'basket_3' => [],
        ];
        foreach($skkis as $skki) {
            array_push($result['basket_'.$skki->basket], $skki);
        }
        return view('skki.index', compact('result'));
    }

    public function create(Request $request) {
        $data = [
            'id' => Str::uuid(),
            'basket' => $request->basket
        ];
        Skki::create($data);
        return redirect('/skki/'.$data['id']);
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
            $skki = $worksheet->getCell('A'.$i)->getValue();
            $prk = $worksheet->getCell('B'.$i)->getValue();
            $prk_skki = $worksheet->getCell('C'.$i)->getValue();
            $wbs_jasa = $worksheet->getCell('D'.$i)->getValue();
            $wbs_material = $worksheet->getCell('E'.$i)->getValue();
            $basket = $worksheet->getCell('F'.$i)->getValue();

            // cek apakah udah ada nomor prk sama
            $exist = Skki::select('id')->where('prk_skki', $prk_skki)->first();
            $prk_exist = Prk::select('id')->where('prk', $prk)->first();


            $test_arr = [];
            if($skki && $prk && !$exist && $prk_exist) {
                $data = [
                    'id' => Str::orderedUuid(),
                    'skki' => $skki,
                    'prk_skki' => $prk_skki,
                    'wbs_jasa' => $wbs_jasa,
                    'wbs_material' => $wbs_material,
                    'prk_id' => $prk_exist->id,
                    'basket' => in_array($basket, [1, 2, 3]) ? $basket : 1
                ];

                array_push($test_arr, $data);

                Skki::create($data);
            }
        }

        return redirect()->back();
    }

    public function show($id) {
        $skki = Skki::with(['jasas', 'materials', 'files'])->find($id);
        $prks = Prk::where('basket', $skki->basket)->get();
        $base_materials = BaseMaterial::get();
        return view('skki.show', compact('skki', 'prks', 'base_materials'));
    }

    public function update($skki_id, Request $request) {
        $skki = Skki::find($skki_id);
        $skki->update($request->all());
        $skki = Skki::with('prk')->find($skki_id);
        return response()->json([
            'success' => true,
            'data' => $skki,
            'message' => 'success',
            'done_at' => Carbon::now()
        ], 200);
    }

    public function destroy(Skki $skki) {
        // check wbs
        $wbs_jasas = PengadaanWbsJasa::where('skki_id', $skki->id)->first();
        $wbs_materials = PengadaanWbsMaterial::where('skki_id', $skki->id)->first();
        if($wbs_jasas or $wbs_materials) {
            return response()->json([
                'success' => false,
                'message' => 'Terdapat Pengadaan yang memakai WBS Jasa atau Material SKKI ini.',
                'done_at' => Carbon::now(),
            ]);
        }
        // delete material & jasa & files
        foreach ($skki->jasas as $jasa) {
            $jasa->delete();
        }
        foreach ($skki->materials as $material) {
            $material->delete();
        }
        foreach ($skki->files as $file) {
            Storage::delete($file->url);
            $file->delete();
        }
        // delete project
        $skki->delete();
        return response()->json([
            'success' => true,
            'message' => 'deleted',
            'done_at' => Carbon::now(),
        ]);
    }

    public function jasaStore($skki_id, Request $request) {
        $skki = Skki::find($skki_id);
        if(!$skki) {
            return response()->json([
                'success' => false,
                'message' => 'skki not found',
                'done_at' => Carbon::now(),
            ]);
        }
        $jasa_id = Str::orderedUuid();
        $jasa = SkkiJasa::create([
            'id' => $jasa_id,
            'nama' => $request->jasa_nama,
            'harga' => $request->jasa_harga,
            'skki_id' => $skki->id
        ]);
        $jasa['id'] = $jasa_id;

        return response()->json([
            'success' => true,
            'data' => $jasa,
            'message' => 'success',
            'done_at' => Carbon::now()
        ]);
    }

    public function jasaUpdate($skki_id, $jasa_id, Request $request) {
        $skki = Skki::find($skki_id);
        if(!$skki) {
            return response()->json([
                'success' => false,
                'message' => 'skki not found',
                'done_at' => Carbon::now(),
            ]);
        }
        $jasa = SkkiJasa::find($jasa_id);
        $data = [
            'id' => $jasa_id,
            'nama' => $request->jasa_nama,
            'harga' => $request->jasa_harga,
            'skki_id' => $skki->id
        ];
        
        $jasa->update($data);
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'success',
            'done_at' => Carbon::now()
        ]);
    }

    public function jasaDestroy($skki_id, $jasa_id) {
        $jasa = SkkiJasa::find($jasa_id);
        $jasa->delete();
        return response()->json([
            'success' => true,
            'data' => '',
            'message' => 'success',
            'done_at' => Carbon::now()
        ]);
    }

    public function jasaImportPrk($skki_id, Request $request) {
        $skki = Skki::find($skki_id);

        if(!$skki) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'skki not found',
                'done_at' => Carbon::now()
            ]);
        }

        $prk = Prk::find($skki->prk_id);

        if(!$prk) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'prk not found',
                'done_at' => Carbon::now()
            ]);
        }

        $result = [];
        foreach ($prk->jasas as $jasa) {
            $data = [
                'id' => Str::orderedUuid(),
                'nama' => $jasa->nama,
                'harga' => $jasa->harga,
                'skki_id' => $skki->id
            ];
            SkkiJasa::create($data);
            array_push($result, $data);
        }

        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => 'success',
            'done_at' => Carbon::now()
        ]);
    }

    public function materialStore($skki_id, Request $request) {
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
            'nama' => $request->material_nama,
            'deskripsi' => $request->material_deskripsi,
            'satuan' => $request->material_satuan,
            'harga' => $request->material_harga,
            'jumlah' => $request->material_jumlah,
            'skki_id' => $skki_id,
            'base_material_id' => $material->id
        ];

        SkkiMaterial::create($data);

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'success',
            'done_at' => Carbon::now()
        ]);
    }

    public function materialUpdate($skki_id, $material_id, Request $request) {
        $base_material = BaseMaterial::find($request->base_material_id);
        
        if(!$base_material) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'material not found',
                'done_at' => Carbon::now()
            ]);
        }

        $material = SkkiMaterial::find($material_id);

        $data = [
            'id' => $material_id,
            'normalisasi' => $base_material->normalisasi,
            'nama' => $request->material_nama,
            'deskripsi' => $request->material_deskripsi,
            'satuan' => $request->material_satuan,
            'harga' => $request->material_harga,
            'jumlah' => $request->material_jumlah,
            'skki_id' => $skki_id,
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

    public function materialDestroy($skki_id, $material_id, Request $request) {
        $material = SkkiMaterial::find($material_id);

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

    public function materialImportPrk($skki_id, Request $request) {
        $skki = Skki::find($skki_id);

        if(!$skki) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'skki not found',
                'done_at' => Carbon::now()
            ]); 
        }

        $prk = Prk::find($skki->prk_id);

        if(!$prk) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'prk not found',
                'done_at' => Carbon::now()
            ]); 
        }

        $result = [];
        foreach ($prk->materials as $material) {
            $data = [
                'id' => Str::orderedUuid(),
                'normalisasi' => $material->normalisasi,
                'nama' => $material->nama,
                'deskripsi' => $material->deskripsi,
                'satuan' => $material->satuan,
                'harga' => $material->harga,
                'jumlah' => $material->jumlah,
                'skki_id' => $skki->id,
                'base_material_id' => $material->base_material_id
            ];
            SkkiMaterial::create($data);
            array_push($result, $data);
        }

        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => 'success',
            'done_at' => Carbon::now()
        ]);
    }

    public function fileStore($skki_id, Request $request) {
        $filename = $request->file->getClientOriginalName();
        $url = $request->file->storeAs('files', Carbon::now()->timestamp.'-'.$filename);
        $data = [
            'id' => Str::orderedUuid(),
            'nama' => $filename,
            'deskripsi' => $request->deskripsi,
            'url' => $url,
            'skki_id' => $skki_id
        ];

        SkkiFile::create($data);

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'success',
            'done_at' => Carbon::now()
        ]);
    }

    public function fileDestroy($skki_id, $file_id, Request $request) {
        $file = SkkiFile::find($file_id);

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
