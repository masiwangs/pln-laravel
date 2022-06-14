<?php

namespace App\Http\Controllers;

use App\Models\{ BaseMaterial, Pengadaan, PengadaanWbsJasa, PengadaanJasa, PengadaanMaterial, PengadaanWbsMaterial, Skki, PengadaanFile, SkkiJasa, SkkiMaterial, Prk};
use Illuminate\Http\Request;
use Illuminate\Support\{ Carbon, Str };
use Illuminate\Support\Facades\Storage;

class PengadaanController extends Controller
{
    public function index() {
        $pengadaans = Pengadaan::get();
        $result = [
            'basket_1' => [],
            'basket_2' => [],
            'basket_3' => [],
        ];
        foreach($pengadaans as $pengadaan) {
            array_push($result['basket_'.$pengadaan->basket], $pengadaan);
        }
        return view('pengadaan.index', compact('result'));
    }

    public function create(Request $request) {
        $data = [
            'id' => Str::uuid(),
            'basket' => $request->basket
        ];
        Pengadaan::create($data);
        return redirect('/pengadaan/'.$data['id']);
    }

    public function show($pengadaan_id) {
        $pengadaan = Pengadaan::with(['jasas', 'materials', 'files'])->find($pengadaan_id);
        $skkis = Skki::where('basket', $pengadaan->basket)->get();
        $base_materials = BaseMaterial::get();
        return view('pengadaan.show', compact('pengadaan', 'skkis', 'base_materials'));
    }

    public function update($pengadaan_id, Request $request) {
        $pengadaan = Pengadaan::find($pengadaan_id);
        
        $data = [
            'id' => $pengadaan->id,
            'nodin' => $request->nodin,
            'tgl_nodin' => $request->tgl_nodin,
            'pr' => $request->pr,
            'nama' => $request->nama,
            'basket' => $pengadaan->basket
        ];
        if($request->status == 'PROSES') {
            $data['status'] = $request->status;
        }
        
        $pengadaan->update($data);

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'success',
            'done_at' => Carbon::now()
        ], 200);
    }

    public function jasaStore($pengadaan_id, Request $request) {
        $pengadaan = Pengadaan::find($pengadaan_id);
        if(!$pengadaan) {
            return response()->json([
                'success' => false,
                'message' => 'pengadaan not found',
                'done_at' => Carbon::now(),
            ]);
        }
        $data = [
            'id' => Str::orderedUuid(),
            'nama' => $request->jasa_nama,
            'harga' => $request->jasa_harga,
            'pengadaan_id' => $pengadaan->id
        ];
        PengadaanJasa::create($data);
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'success',
            'done_at' => Carbon::now()
        ]);
    }

    public function jasaUpdate($pengadaan_id, $jasa_id, Request $request) {
        $pengadaan = Pengadaan::find($pengadaan_id);
        if(!$pengadaan) {
            return response()->json([
                'success' => false,
                'message' => 'pengadaan not found',
                'done_at' => Carbon::now(),
            ]);
        }
        $jasa = PengadaanJasa::find($jasa_id);
        $data = [
            'id' => $jasa_id,
            'nama' => $request->jasa_nama,
            'harga' => $request->jasa_harga,
            'pengadaan_id' => $pengadaan->id
        ];
        
        $jasa->update($data);
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'success',
            'done_at' => Carbon::now()
        ]);
    }

    public function jasaDestroy($pengadaan_id, $jasa_id) {
        $jasa = PengadaanJasa::find($jasa_id);
        $jasa->delete();
        return response()->json([
            'success' => true,
            'data' => '',
            'message' => 'success',
            'done_at' => Carbon::now()
        ]);
    }

    public function jasaImportWbsJasa($pengadaan_id, Request $request) {
        $pengadaan = Pengadaan::find($pengadaan_id);

        if(!$pengadaan) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'pengadaan not found',
                'done_at' => Carbon::now()
            ]);
        }

        $skki = Skki::find($request->skki_id);

        if(!$skki) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'skki not found',
                'done_at' => Carbon::now()
            ]);
        }

        $result = [];
        foreach ($skki->jasas as $jasa) {
            $data = [
                'id' => Str::orderedUuid(),
                'nama' => $jasa->nama,
                'harga' => $jasa->harga,
                'pengadaan_id' => $pengadaan->id
            ];
            PengadaanJasa::create($data);
            array_push($result, $data);
        }

        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => 'success',
            'done_at' => Carbon::now()
        ]);
    }

    public function jasaSkkiShow($pengadaan_id, Request $request) {
        $skki = Skki::find($request->skki_id);

        if(!$skki) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'skki not foun',
                'done_at' => Carbon::now()
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $skki->jasas,
            'message' => 'success',
            'done_at' => Carbon::now()
        ]);
    }

    public function materialStore($pengadaan_id, Request $request) {
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
            'pengadaan_id' => $pengadaan_id,
            'base_material_id' => $material->id
        ];

        PengadaanMaterial::create($data);

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'success',
            'done_at' => Carbon::now()
        ]);
    }

    public function materialUpdate($pengadaan_id, $material_id, Request $request) {
        $base_material = BaseMaterial::find($request->base_material_id);
        
        if(!$base_material) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'material not found',
                'done_at' => Carbon::now()
            ]);
        }

        $material = PengadaanMaterial::find($material_id);

        $data = [
            'id' => $material->id,
            'normalisasi' => $material->normalisasi,
            'nama' => $material->nama,
            'deskripsi' => $material->deskripsi,
            'satuan' => $material->satuan,
            'harga' => $material->harga,
            'jumlah' => $request->material_jumlah,
            'pengadaan_id' => $pengadaan_id,
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

    public function materialDestroy($pengadaan_id, $material_id, Request $request) {
        $material = PengadaanMaterial::find($material_id);

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

    public function materialImportWbsMaterial($pengadaan_id, Request $request) {
        $pengadaan = Pengadaan::find($pengadaan_id);

        if(!$pengadaan) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'pengadaan not found',
                'done_at' => Carbon::now()
            ]);
        }

        $skki = Skki::find($request->skki_id);

        if(!$skki) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'skki not found',
                'done_at' => Carbon::now()
            ]);
        }

        $result = [];
        foreach ($skki->materials as $material) {
            $data = [
                'id' => Str::orderedUuid(),
                'normalisasi' => $material->normalisasi,
                'nama' => $material->nama,
                'deskripsi' => $material->deskripsi,
                'satuan' => $material->satuan,
                'harga' => $material->harga,
                'jumlah' => $material->jumlah,
                'pengadaan_id' => $pengadaan_id,
                'base_material_id' => $material->base_material_id
            ];
            PengadaanMaterial::create($data);
            array_push($result, $data);
        }

        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => 'success',
            'done_at' => Carbon::now()
        ]);
    }

    public function materialSkkiShow($pengadaan_id, Request $request) {
        $skki = Skki::find($request->skki_id);

        if(!$skki) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'skki not foun',
                'done_at' => Carbon::now()
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $skki->materials,
            'message' => 'success',
            'done_at' => Carbon::now()
        ]);
    }

    public function fileStore($pengadaan_id, Request $request) {
        $filename = $request->file->getClientOriginalName();
        $url = $request->file->storeAs('files', Carbon::now()->timestamp.'-'.$filename);
        $data = [
            'id' => Str::orderedUuid(),
            'nama' => $filename,
            'deskripsi' => $request->deskripsi,
            'url' => $url,
            'pengadaan_id' => $pengadaan_id
        ];

        PengadaanFile::create($data);

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'success',
            'done_at' => Carbon::now()
        ]);
    }

    public function fileDestroy($pengadaan_id, $file_id, Request $request) {
        $file = PengadaanFile::find($file_id);

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

    public function wbsJasaStore($pengadaan_id, Request $request) {
        $pengadaan = Pengadaan::find($pengadaan_id);
        if(!$pengadaan) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'error',
                'done_at' => Carbon::now()
            ], 200);
        }
        $skki = Skki::find($request->wbs_jasa);
        $data = [
            'id' => Str::orderedUuid(),
            'pengadaan_id' => $pengadaan->id,
            'wbs_jasa' => $skki->wbs_jasa,
            'skki_id' => $skki->id
        ];
        PengadaanWbsJasa::create($data);
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'success',
            'done_at' => Carbon::now()
        ], 200);
    }

    public function wbsJasaDestroy($pengadaan_id, $wbs_id, Request $request) {
        $wbs_jasa = PengadaanWbsJasa::find($wbs_id);
        $wbs_jasa->delete();
        return response()->json([
            'success' => true,
            'data' => '',
            'message' => 'success',
            'done_at' => Carbon::now()
        ], 200);
    }

    public function wbsMaterialStore($pengadaan_id, Request $request) {
        $pengadaan = Pengadaan::find($pengadaan_id);
        if(!$pengadaan) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'error',
                'done_at' => Carbon::now()
            ], 200);
        }
        $skki = Skki::find($request->wbs_material);
        $data = [
            'id' => Str::orderedUuid(),
            'pengadaan_id' => $pengadaan->id,
            'wbs_material' => $skki->wbs_material,
            'skki_id' => $skki->id
        ];
        PengadaanWbsMaterial::create($data);
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'success',
            'done_at' => Carbon::now()
        ], 200);
    }

    public function wbsMaterialDestroy($pengadaan_id, $wbs_id, Request $request) {
        $wbs = PengadaanWbsMaterial::find($wbs_id);
        $wbs->delete();
        return response()->json([
            'success' => true,
            'data' => '',
            'message' => 'success',
            'done_at' => Carbon::now()
        ], 200);
    }
}
