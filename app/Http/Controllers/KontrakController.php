<?php

namespace App\Http\Controllers;

use App\Models\{ BaseMaterial, Kontrak, KontrakJasa, KontrakMaterial, Pengadaan, Pelaksanaan, Pembayaran};
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class KontrakController extends Controller
{
    public function index() {
        $pengadaans = Kontrak::get();
        $result = [
            'basket_1' => [],
            'basket_2' => [],
            'basket_3' => [],
        ];
        foreach($pengadaans as $pengadaan) {
            array_push($result['basket_'.$pengadaan->basket], $pengadaan);
        }
        return view('kontrak.index', compact('result'));
    }

    public function store(Request $request) {
        $pengadaan = Pengadaan::find($request->pengadaan_id);
        if(!$pengadaan) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'pengadaan not found',
                'done_at' => Carbon::now()
            ]); 
        }

        $data = [
            'id' => Str::orderedUuid(),
            'nomor_kontrak' => $request->kontrak_nomor_kontrak,
            'tgl_kontrak' => $request->kontrak_tgl_kontrak,
            'tgl_awal' => $request->kontrak_tgl_awal,
            'tgl_akhir' => $request->kontrak_tgl_akhir,
            'pelaksana' => $request->kontrak_pelaksana,
            'direksi' => $request->kontrak_direksi,
            'pengadaan_id' => $request->pengadaan_id,
            'basket' => $pengadaan->basket
        ];

        $pengadaan->update([
            'status' => 'TERKONTRAK'
        ]);

        // create kontrak
        $kontrak = Kontrak::create($data);
        // create pelaksanaan
        $pelaksanaan_id = Str::orderedUuid();
        $pelaksanaan = Pelaksanaan::create([
            'id' => $pelaksanaan_id,
            'spk' => '',
            'progress' => 0,
            'kontrak_id' => $data['id'],
            'basket' => $kontrak->basket
        ]);
        // create pembayaran
        $pembayaran = Pembayaran::create([
            'id' => Str::orderedUuid(),
            'basket' => $kontrak->basket,
            'kontrak_id' => $data['id'],
            'pelaksanaan_id' => $pelaksanaan_id,
        ]);
        // copy jasa
        foreach ($pengadaan->jasas as $jasa) {
            KontrakJasa::create([
                'id' => Str::orderedUuid(),
                'nama' => $jasa->nama,
                'harga' => $jasa->harga,
                'kontrak_id' => $data['id']
            ]);
        }
        // copy material
        foreach ($pengadaan->materials as $material) {
            KontrakMaterial::create([
                'id' => Str::orderedUuid(),
                'normalisasi' => $material->normalisasi,
                'nama' => $material->nama,
                'deskripsi' => $material->deskripsi,
                'satuan' => $material->satuan,
                'harga' => $material->harga,
                'jumlah' => $material->jumlah,
                'kontrak_id' => $data['id'],
                'base_material_id' => $material->base_material_id
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'success',
            'done_at' => Carbon::now()
        ]); 
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
            $nomor_kontrak = $worksheet->getCell('A'.$i)->getValue();
            $nodin = $worksheet->getCell('B'.$i)->getValue();
            $tgl_kontrak = $worksheet->getCell('C'.$i)->getValue();
            $tgl_awal = $worksheet->getCell('D'.$i)->getValue();
            $tgl_akhir = $worksheet->getCell('E'.$i)->getValue();
            $pelaksana = $worksheet->getCell('F'.$i)->getValue();
            $direksi = $worksheet->getCell('G'.$i)->getValue();
            $versi_amandemen = $worksheet->getCell('H'.$i)->getValue();
            $basket = $worksheet->getCell('I'.$i)->getValue();

            // cek apakah udah ada nomor prk sama
            $exist = Kontrak::select('id')->where('nomor_kontrak', $nomor_kontrak)->first();
            $pengadaan_exist = Pengadaan::select('id')->where('nodin', $nodin)->first();
            // cek tanggal
            $parsedDateTglKontrak = Date::excelToDateTimeObject($tgl_kontrak);
            $parsedDateTglAwal = Date::excelToDateTimeObject($tgl_awal);
            $parsedDateTglAkhir = Date::excelToDateTimeObject($tgl_akhir);
            if($parsedDateTglKontrak) {
                $tgl_kontrak = $parsedDateTglKontrak;
            } else {
                $tgl_kontrak = NULL;
            }
            if($parsedDateTglAwal) {
                $tgl_awal = $parsedDateTglAwal;
            } else {
                $tgl_awal = NULL;
            }
            if($parsedDateTglAkhir) {
                $tgl_akhir = $parsedDateTglAkhir;
            } else {
                $tgl_akhir = NULL;
            }

            if($nomor_kontrak && !$exist && $pengadaan_exist) {
                $data = [
                    'id' => Str::orderedUuid(),
                    'nomor_kontrak' => $nomor_kontrak,
                    'tgl_kontrak' => $tgl_kontrak,
                    'tgl_awal' => $tgl_awal,
                    'tgl_akhir' => $tgl_akhir,
                    'pelaksana' => $pelaksana,
                    'direksi' => strtoupper($direksi),
                    'versi_amandemen' => $versi_amandemen,
                    'basket' => in_array($basket, [1, 2, 3]) ? $basket : 1,
                    'pengadaan_id' => $pengadaan_exist->id
                ];

                Kontrak::create($data);
            }
        }

        return redirect()->back();
    }

    public function show($kontrak_id) {
        $kontrak = Kontrak::with(['files', 'jasas', 'materials'])->firstOrFail();
        $base_materials = BaseMaterial::get();
        return view('kontrak.show', compact('kontrak', 'base_materials'));
    }

    public function update($kontrak_id, Request $request) {
        $kontrak = Kontrak::find($kontrak_id);
        
        $data = [
            'id' => $kontrak->id,
            'nomor_kontrak' => $request->nomor_kontrak,
            'tgl_kontrak' => $request->tgl_kontrak,
            'tgl_awal' => $request->tgl_awal,
            'tgl_akhir' => $request->tgl_akhir,
            'pelaksana' => $request->pelaksana,
            'direksi' => $request->direksi
        ];

        try {
            $kontrak->update($data);
            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'success',
                'done_at' => Carbon::now()
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'data' => $th,
                'message' => 'error',
                'done_at' => Carbon::now()
            ], 500);
        }

        
    }

    public function amandemenStore($kontrak_id, Request $request) {
        $kontrak = Kontrak::find($kontrak_id);

        if(!$kontrak) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'kontrak not found',
                'done_at' => Carbon::now()
            ], 404);
        }

        $data = [];

        if($request->has('is_amandemen')) {
            $data['is_amandemen'] = $request->is_amandemen;
        } else {
            $data['is_amandemen'] = 1;
        }

        if($request->has('versi_amandemen')) {
            $data['versi_amandemen'] = $request->versi_amandemen;
        }

        try {
            $kontrak->update($data);
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
            ], 500);
        }
    }
}
