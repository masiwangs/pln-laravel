<?php

use App\Http\Controllers\{
    AdminController,
    AuthController,
    BaseMaterialController,
    DashboardController,
    KontrakController, 
    KontrakFileController, 
    KontrakJasaController, 
    KontrakMaterialController,
    PelaksanaanController,
    PelaksanaanFileController,
    PelaksanaanJasaController,
    PelaksanaanMaterialController,
    PembayaranController,
    PembayaranFileController,
    PembayaranPertahapController,
    UserController,
};
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\PrkController;
use App\Http\Controllers\SkkiController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['auth', 'verified', 'verified-by-admin']], function() {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::group(['prefix' => 'prk'], function() {
        Route::get('/', [PrkController::class, 'index'])->name('prk');
        Route::get('/baru', [PrkController::class, 'create']);
        
        Route::get('/{prk_id}', [PrkController::class, 'show'])->name('prk-detail');
        Route::post('/{prk_id}', [PrkController::class, 'update']);
        
        Route::post('/{prk_id}/file', [PrkController::class, 'fileStore']);
        Route::delete('/{prk_id}/file/{file_id}', [PrkController::class, 'fileDestroy']);
        
        Route::post('/{prk_id}/jasa', [PrkController::class, 'jasaStore']);
        Route::post('/{prk_id}/jasa/{jasa_id}', [PrkController::class, 'jasaUpdate']);
        Route::delete('/{prk_id}/jasa/{jasa_id}', [PrkController::class, 'jasaDestroy']);
        
        Route::post('/{prk_id}/material', [PrkController::class, 'materialStore']);
        Route::post('/{prk_id}/material/{material_id}', [PrkController::class, 'materialUpdate']);
        Route::delete('/{prk_id}/material/{material_id}', [PrkController::class, 'materialDestroy']);
    });
    
    Route::group(['prefix' => 'skki'], function() {
        Route::get('/', [SkkiController::class, 'index'])->name('skki');
        Route::get('/baru', [SkkiController::class, 'create']);
    
        Route::get('/{skki_id}', [SkkiController::class, 'show'])->name('skki-detail');
        Route::post('/{skki_id}', [SkkiController::class, 'update']);
    
        Route::post('/{skki_id}/file', [SkkiController::class, 'fileStore']);
        Route::delete('/{skki_id}/file/{file_id}', [SkkiController::class, 'fileDestroy']);
    
        Route::post('/{skki_id}/jasa', [SkkiController::class, 'jasaStore']);
        Route::post('/{skki_id}/jasa/import/prk', [SkkiController::class, 'jasaImportPrk']);
        Route::post('/{skki_id}/jasa/{jasa_id}', [SkkiController::class, 'jasaUpdate']);
        Route::delete('/{skki_id}/jasa/{jasa_id}', [SkkiController::class, 'jasaDestroy']);
    
        Route::post('/{skki_id}/material', [SkkiController::class, 'materialStore']);
        Route::post('/{skki_id}/material/import/prk', [SkkiController::class, 'materialImportPrk']);
        Route::post('/{skki_id}/material/{material_id}', [SkkiController::class, 'materialUpdate']);
        Route::delete('/{skki_id}/material/{material_id}', [SkkiController::class, 'materialDestroy']);
    
    });
    
    Route::group(['prefix' => 'pengadaan'], function() {
        Route::get('/', [PengadaanController::class, 'index'])->name('pengadaan');
        Route::get('/baru', [PengadaanController::class, 'create']);
    
        Route::get('/{pengadaan_id}', [PengadaanController::class, 'show'])->name('pengadaan-detail');
        Route::post('/{pengadaan_id}', [PengadaanController::class, 'update']);
    
        Route::post('/{pengadaan_id}/file', [PengadaanController::class, 'fileStore']);
        Route::delete('/{pengadaan_id}/file/{file_id}', [PengadaanController::class, 'fileDestroy']);
    
        Route::post('/{pengadaan_id}/jasa', [PengadaanController::class, 'jasaStore']);
        Route::get('/{pengadaan_id}/jasa/skki', [PengadaanController::class, 'jasaSkkiShow']);
        Route::post('/{pengadaan_id}/jasa/{jasa_id}', [PengadaanController::class, 'jasaUpdate']);
        Route::post('/{pengadaan_id}/jasa/import/wbs-jasa', [PengadaanController::class, 'jasaImportWbsJasa']);
        Route::delete('/{pengadaan_id}/jasa/{jasa_id}', [PengadaanController::class, 'jasaDestroy']);
    
        Route::post('/{pengadaan_id}/wbs-jasa', [PengadaanController::class, 'wbsJasaStore']);
        Route::delete('/{pengadaan_id}/wbs-jasa/{wbs_id}', [PengadaanController::class, 'wbsJasaDestroy']);
    
        Route::post('/{pengadaan_id}/material', [PengadaanController::class, 'materialStore']);
        Route::post('/{pengadaan_id}/material/import/wbs-material', [PengadaanController::class, 'materialImportWbsMaterial']);
        Route::post('/{pengadaan_id}/wbs-material', [PengadaanController::class, 'wbsMaterialStore']);
        Route::delete('/{pengadaan_id}/wbs-material/{wbs_id}', [PengadaanController::class, 'wbsMaterialDestroy']);
        Route::get('/{pengadaan_id}/material/skki', [PengadaanController::class, 'materialSkkiShow']);
        Route::post('/{pengadaan_id}/material/{material_id}', [PengadaanController::class, 'materialUpdate']);
        Route::delete('/{pengadaan_id}/material/{material_id}', [PengadaanController::class, 'materialDestroy']);
    
    });
    
    Route::group(['prefix' => 'kontrak'], function() {
        Route::get('/', [KontrakController::class, 'index'])->name('kontrak');
        Route::post('/', [KontrakController::class, 'store']);
    
        Route::get('/{kontrak_id}', [KontrakController::class, 'show'])->name('kontrak-detail');
        Route::post('/{kontrak_id}', [KontrakController::class, 'update']);
    
        // amandemen
        Route::post('/{kontrak_id}/amandemen', [KontrakController::class, 'amandemenStore']);
    
        // file
        Route::post('/{kontrak_id}/file', [KontrakFileController::class, 'store']);
        Route::delete('/{kontrak_id}/file/{file_id}', [KontrakFileController::class, 'destroy']);
    
        // jasa
        Route::post('/{kontrak_id}/jasa', [KontrakJasaController::class, 'store']);
        Route::post('/{kontrak_id}/jasa/{jasa_id}', [KontrakJasaController::class, 'update']);
        Route::delete('/{kontrak_id}/jasa/{jasa_id}', [KontrakJasaController::class, 'destroy']);
    
        // material
        Route::post('/{kontrak_id}/material', [KontrakMaterialController::class, 'store']);
        Route::post('/{kontrak_id}/material/{material_id}', [KontrakMaterialController::class, 'update']);
        Route::delete('/{kontrak_id}/material/{material_id}', [KontrakMaterialController::class, 'destroy']);
    });
    
    Route::group(['prefix' => 'pelaksanaan'], function() {
        Route::get('/', [PelaksanaanController::class, 'index'])->name('pelaksanaan');
        
        Route::get('/{pelaksanaan_id}', [PelaksanaanController::class, 'show'])->name('pelaksanaan-detail');
        Route::post('/{pelaksanaan_id}', [PelaksanaanController::class, 'update']);
    
        //file
        Route::post('/{pelaksanaan_id}/file', [PelaksanaanFileController::class, 'store']);
        Route::delete('/{pelaksanaan_id}/file/{file_id}', [PelaksanaanFileController::class, 'destroy']);
    
        // jasa
        Route::post('/{pelaksanaan_id}/jasa', [PelaksanaanJasaController::class, 'store']);
        Route::post('/{pelaksanaan_id}/jasa/{jasa_id}', [PelaksanaanJasaController::class, 'update']);
        Route::delete('/{pelaksanaan_id}/jasa/{jasa_id}', [PelaksanaanJasaController::class, 'destroy']);
    
        // material
        Route::post('/{pelaksanaan_id}/material', [PelaksanaanMaterialController::class, 'store']);
        Route::post('/{pelaksanaan_id}/material/{material_id}', [PelaksanaanMaterialController::class, 'update']);
        Route::delete('/{pelaksanaan_id}/material/{material_id}', [PelaksanaanMaterialController::class, 'destroy']);
    
        // rab
        Route::get('/{pelaksanaan_id}/rab/jasa', [PelaksanaanController::class, 'rabJasa']);
        Route::get('/{pelaksanaan_id}/rab/material', [PelaksanaanController::class, 'rabMaterial']);
        Route::get('/{pelaksanaan_id}/stok/material', [PelaksanaanController::class, 'stokMaterial']);
    
    });
    
    Route::group(['prefix' => 'pembayaran'], function() {
        Route::get('/', [PembayaranController::class, 'index'])->name('pembayaran');
        
        Route::get('/{pembayaran_id}', [PembayaranController::class, 'show'])->name('pembayaran-detail');
        Route::post('/{pembayaran_id}', [PembayaranController::class, 'update']);
    
        Route::get('/{pembayaran_id}/transaksi/material', [PembayaranController::class, 'materialTransaction']);
    
        // pertahap
        Route::post('/{pembayaran_id}/pertahap', [PembayaranPertahapController::class, 'store']);
        Route::post('/{pembayaran_id}/pertahap/{pertahap_id}', [PembayaranPertahapController::class, 'update']);
        Route::delete('/{pembayaran_id}/pertahap/{pertahap_id}', [PembayaranPertahapController::class, 'destroy']);
    
        // file
        Route::post('/{pembayaran_id}/file', [PembayaranFileController::class, 'store']);
        Route::delete('/{pembayaran_id}/file/{file_id}', [PembayaranFileController::class, 'destroy']);
    
        // jasa
        // Route::post('/{pelaksanaan_id}/jasa', [PelaksanaanJasaController::class, 'store']);
        // Route::post('/{pelaksanaan_id}/jasa/{jasa_id}', [PelaksanaanJasaController::class, 'update']);
        // Route::delete('/{pelaksanaan_id}/jasa/{jasa_id}', [PelaksanaanJasaController::class, 'destroy']);
    
        // material
        // Route::post('/{pelaksanaan_id}/material', [PelaksanaanMaterialController::class, 'store']);
        // Route::post('/{pelaksanaan_id}/material', [PelaksanaanMaterialController::class, 'store']);
        // Route::post('/{pelaksanaan_id}/material/{material_id}', [PelaksanaanMaterialController::class, 'update']);
        // Route::delete('/{pelaksanaan_id}/material/{material_id}', [PelaksanaanMaterialController::class, 'destroy']);
    
        // rab
        // Route::get('/{pelaksanaan_id}/rab/jasa', [PelaksanaanController::class, 'rabJasa']);
        // Route::get('/{pelaksanaan_id}/rab/material', [PelaksanaanController::class, 'rabMaterial']);
        // Route::get('/{pelaksanaan_id}/stok/material', [PelaksanaanController::class, 'stokMaterial']);
    
    });
    
    Route::group(['prefix' => 'database'], function() {
        Route::group(['prefix' => 'material'], function() {
            Route::get('/', [BaseMaterialController::class, 'index'])->name('database.material');
            Route::post('/', [BaseMaterialController::class, 'store']);
            Route::post('/import', [BaseMaterialController::class, 'import']);
            Route::post('/{base_material_id}', [BaseMaterialController::class, 'update']);
        });
    });
    
    Route::group(['prefix' => 'administrasi'], function() {
        Route::group(['middleware' => ['role:super admin']], function() {
            Route::get('/admin', [AdminController::class, 'index'])->name('administrasi.admin');
            Route::post('/user/{user_id}/confirm', [AdminController::class, 'confirmUser']);
        });
        
        Route::get('/profile', [UserController::class, 'index'])->name('administrasi.user');
        Route::post('/profile', [UserController::class, 'update']);
        Route::post('/profile/password', [UserController::class, 'changePassword']);
    });
});

Route::group(['middleware' => ['auth', 'verified']], function() {
    Route::get('/waiting', function() {
        if(auth()->user()->verified == 1) {
            return redirect('/');
        }
        return view('auth.waiting-admin');
    });
});

// auth
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'doRegister']);
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'doLogin']);

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');