<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\PembayaranPertahap;
use Illuminate\Http\Request;
use Illuminate\Support\{ Carbon, Str };

class PembayaranPertahapController extends Controller
{
    public function store($pembayaran_id, Request $request) {
        try {
            $pembayaran = Pembayaran::find($pembayaran_id);
            $data = [
                'id' => Str::orderedUuid(),
                'tanggal' => $request->tanggal,
                'nominal' => $request->nominal,
                'keterangan' => $request->keterangan,
                'pembayaran_id' => $pembayaran_id
            ];
            PembayaranPertahap::create($data);
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

    public function update($pembayaran_id, $pertahap_id, Request $request) {
        try {
            $pertahap = PembayaranPertahap::find($pertahap_id);
            $data = [
                'id' => $pertahap_id,
                'tanggal' => $request->tanggal,
                'nominal' => $request->nominal,
                'keterangan' => $request->keterangan,
            ];
            $pertahap->update($data);
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

    public function destroy($pembayaran_id, $pertahap_id, Request $request) {
        try {
            $pertahap = PembayaranPertahap::find($pertahap_id);
            $last_data = $pertahap;
            $pertahap->delete();
            return response()->json([
                'success' => true,
                'data' => $last_data,
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
}
