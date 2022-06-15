<?php

namespace App\Http\Controllers;

use App\Models\Kontrak;
use App\Models\Pelaksanaan;
use App\Models\Pembayaran;
use App\Models\Pengadaan;
use App\Models\Prk;
use App\Models\Skki;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected function _format($number) {
        return $number;
    }

    public function index(Request $request) {
        $prks = Prk::query();
        $skkis = Skki::query();
        $pengadaans = Pengadaan::query();
        $kontraks = Kontrak::query();
        $pelaksanaans = Pelaksanaan::query();
        $pembayarans = Pembayaran::query();

        if($request->basket) {
            if(in_array($request->basket, [1, 2, 3])) {
                $prks = $prks->where('basket', $request->basket);
                $skkis = $prks->where('basket', $request->basket);
                $pengadaans = $prks->where('basket', $request->basket);
                $kontraks = $prks->where('basket', $request->basket);
                $pelaksanaans = $prks->where('basket', $request->basket);
                $pembayarans = $prks->where('basket', $request->basket);
            }
        }

        $prks = $prks->get();
        $skkis = $skkis->get();
        $pengadaans = $pengadaans->get();
        $kontraks = $kontraks->get();
        $pelaksanaans = $pelaksanaans->get();
        $pembayarans = $pembayarans->get();

        $prks = collect($prks)->map(
            function ($prk) { 
                $jasas = collect($prk->jasas)->sum('harga');
                $materials = collect($prk->materials)->map(
                    function($material) {
                        return $material->jumlah * $material->harga;
                    }
                )->sum();
                return [$jasas, $materials];
            });

        $skkis = collect($skkis)->map(
            function ($skki) { 
                $jasas = collect($skki->jasas)->sum('harga');
                $materials = collect($skki->materials)->map(
                    function($material) {
                        return $material->jumlah * $material->harga;
                    }
                )->sum();
                return [$jasas, $materials];
            });

        $pengadaans = collect($pengadaans)->map(
            function ($pengadaan) { 
                $jasas = collect($pengadaan->jasas)->sum('harga');
                $materials = collect($pengadaan->materials)->map(
                    function($material) {
                        return $material->jumlah * $material->harga;
                    }
                )->sum();
                return [$jasas, $materials];
            });

        $kontraks = collect($kontraks)->map(
            function ($kontrak) { 
                $jasas = collect($kontrak->jasas)->sum('harga');
                $materials = collect($kontrak->materials)->map(
                    function($material) {
                        return $material->jumlah * $material->harga;
                    }
                )->sum();
                return [$jasas, $materials];
            });

        $pelaksanaans = collect($pelaksanaans)->map(
            function ($pelaksanaan) { 
                $jasas = collect($pelaksanaan->jasas)->sum('harga');
                $materials = collect($pelaksanaan->materials)->map(
                    function($material) {
                        return $material->jumlah * $material->harga;
                    }
                )->sum();
                return [$jasas, $materials];
            });

        $pembayarans = collect($pembayarans)->map(
            function ($pembayaran) { 
                $pertahaps = collect($pembayaran->tahapans)->sum('nominal');
                return [$pertahaps];
            });

        return view('dashboard.index', compact('prks', 'skkis', 'pengadaans', 'kontraks', 'pelaksanaans', 'pembayarans'));
    }
}
