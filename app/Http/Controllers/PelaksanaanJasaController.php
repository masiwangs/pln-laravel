<?php

namespace App\Http\Controllers;

use App\Models\Pelaksanaan;
use App\Models\PelaksanaanJasa;
use Illuminate\Http\Request;
use Illuminate\Support\{ Carbon, Str };

class PelaksanaanJasaController extends Controller
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
            'nama' => $request->nama,
            'harga' => $request->harga,
            'pelaksanaan_id' => $pelaksanaan_id
        ];

        if($request->has('tanggal')) {
            $data = array_merge($data, ['tanggal' => $request->tanggal]);
        }

        try{
            PelaksanaanJasa::create($data);
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

    public function update($pelaksanaan_id, $jasa_id, Request $request) {
        $pelaksanaan = Pelaksanaan::find($pelaksanaan_id);
        if(!$pelaksanaan) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'pelaksanaan not found',
                'done_at' => Carbon::now()
            ]);
        }

        $jasa = PelaksanaanJasa::find($jasa_id);
        if(!$pelaksanaan) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'jasa not found',
                'done_at' => Carbon::now()
            ]);
        }

        $last = $jasa->toArray();

        $data = [
            'id' => $jasa_id,
            'nama' => $request->nama,
            'harga' => $request->harga,
            'pelaksanaan_id' => $pelaksanaan_id
        ];

        if($request->has('tanggal')) {
            $data = array_merge($data, ['tanggal' => $request->tanggal]);
        }

        try{
            $jasa->update($data);
            return response()->json([
                'success' => true,
                'data' => [
                    'last' => $last,
                    'new' => $data
                ],
                'message' => 'success',
                'done_at' => Carbon::now()
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'data' => '??',
                'message' => $th,
                'done_at' => Carbon::now()
            ]);
        }
    }

    public function destroy($pelaksanaan_id, $jasa_id, Request $request) {
        $pelaksanaan = Pelaksanaan::find($pelaksanaan_id);
        if(!$pelaksanaan) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'pelaksanaan not found',
                'done_at' => Carbon::now()
            ]);
        }

        $jasa = PelaksanaanJasa::find($jasa_id);
        if(!$pelaksanaan) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'jasa not found',
                'done_at' => Carbon::now()
            ]);
        }

        $data = $jasa->toArray();

        try{
            $jasa->delete();
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
}
