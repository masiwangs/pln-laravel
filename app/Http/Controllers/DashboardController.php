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
        $prks = Prk::get();
        $skkis = Skki::get();
        $pengadaans = Pengadaan::get();
        $kontraks = Kontrak::get();
        $pelaksanaans = Pelaksanaan::get();
        $pembayarans = Pembayaran::get();

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
