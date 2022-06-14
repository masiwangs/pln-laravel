<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PembayaranController extends Controller
{
    public function index() {
        $pembayarans = Pembayaran::get();
        return view('pembayaran.index', compact('pembayarans'));
    }

    public function show($pembayaran_id) {
        try {
            $pembayaran = Pembayaran::find($pembayaran_id);
            return view('pembayaran.show', compact('pembayaran'));
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'data' => $th,
                'message' => 'success',
                'done_at' => Carbon::now()
            ]);
        }
    }

    public function update($pembayaran_id, Request $request) {
        try {
            $pembayaran = Pembayaran::find($pembayaran_id);
            $data = [
                'id' => $pembayaran_id,
                'status' => $request->status
            ];
            $pembayaran->update($data);
            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'success',
                'done_at' => Carbon::now()
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'data' => $th,
                'message' => 'success',
                'done_at' => Carbon::now()
            ]);
        }
    }

    public function materialTransaction($pembayaran_id) {
        try {
            $pembayaran = Pembayaran::find($pembayaran_id);
            $material_transactions = $pembayaran->pelaksanaan->materials;
            return response()->json([
                'success' => true,
                'data' => $material_transactions,
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
