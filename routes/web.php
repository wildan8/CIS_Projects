<?php
// use \App\Http\Controllers\Admin\SupplierGudangController;
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

// Route::get('/', 'LoginController@index')->middleware('guest');

// FIX ROUTE START //

// Route::get('/login-page', function () {return view('Login.auth-login');});

Route::POST('/Logout', 'LoginController@logout');

Route::get('/Login', 'LoginController@index')->name('login')->middleware('guest');
Route::POST('/Login', 'LoginController@store');

// Gudang Route Start//
Route::middleware(['auth', 'role:Gudang'])->group(function () {
    Route::get('/Gudang', 'BahanBakuController@Gudang')->name('Gudang');
    Route::get('/GudangPer', 'BahanBakuController@filter')->name('filter');
    // Route::get('/GudangPerPesanan', 'BahanBakuController@GudangPer')->name('GudangPer');
    Route::get('/Gudang/proses/{ID_MRP}', 'BahanBakuController@proses')->name('proses');
    Route::get('/Gudang/kebutuhanPDF/{daterange}', 'BahanBakuController@kebutuhanPDF')->name('kebutuhanPDF');
    Route::get('/Gudang/showPesanan/{ID_MPS}', 'BahanBakuController@showPesanan')->name('showPesanan');
    Route::get('/Gudang/export/{ID_MPS}', 'BahanBakuController@exportFirst')->name('exportFirst');
    Route::get('/Gudang/exportAll/{daterange}', 'BahanBakuController@exportAll')->name('exportAll');
    // Supplier Route Start

    Route::get('/Laporan', function () {
        return view('Laporan.BahanBaku');
        // Supplier Route Start
    });
    Route::prefix('Supplier')->group(function () {
        Route::get('/', 'SupplierController@index')->name('index');
        Route::get('/createSUP', 'SupplierController@create')->name('create');
        Route::POST('/storeSUP', 'SupplierController@store')->name('store');
        Route::get('/editSUP/{ID_Supplier}', 'SupplierController@edit')->name('edit');
        Route::get('/exportSUP', 'SupplierController@PDF')->name('export');
        Route::get('/cari', 'SupplierController@cari')->name('cari');
        Route::POST('/updateSUP', 'SupplierController@update')->name('update');
        Route::get('/deleteSUP/{ID_Supplier}', 'SupplierController@destroy')->name('destroy');
    });
    //Supplier Route End
    //Bahan Baku Route Start
    Route::prefix('Bahanbaku')->group(function () {
        Route::get('/', 'BahanBakuController@index')->name('index');
        Route::get('/createBB', 'BahanBakuController@create')->name('create');
        Route::POST('/storeBB', 'BahanBakuController@store')->name('store');
        Route::get('/editBB/{ID_BahanBaku}', 'BahanBakuController@test')->name('test');

        Route::get('/export', 'BahanBakuController@PDF')->name('export');
        Route::POST('/perbaru', 'BahanBakuController@update')->name('update');
        Route::get('/deleteBB/{ID_BahanBaku}', 'BahanBakuController@destroy')->name('destroy');
    });
    //Bahan Baku Route End
    //LOG Barang Route Start
    Route::prefix('LOG')->group(function () {
        Route::get('/', 'PenerimaanController@index')->name('index');
        Route::get('/createLOG', 'PenerimaanController@create')->name('create');
        Route::POST('/storeLOG', 'PenerimaanController@store')->name('store');
        Route::get('/editLOG/{ID_LOG}', 'PenerimaanController@edit')->name('edit');
        Route::get('/export/{daterange}', 'PenerimaanController@PDF')->name('export');
        Route::POST('/updateLOG', 'PenerimaanController@update')->name('update');
        Route::get('/deleteLOG/{ID_LOG}', 'PenerimaanController@destroy')->name('destroy');
    });
    //LOG Barang Route End

});
// Gudang Route End//

// Produksi Route Start//
Route::middleware(['auth', 'role:Produksi'])->group(function () {
    Route::get('/Produksi', 'ProdukController@Home')->name('Home');
    Route::get('/ProduksiDone', 'ProdukController@ProduksiDone')->name('ProduksiDone');
    Route::get('/Produksi/exportAll/{daterange}', 'ProdukController@exportAll')->name('exportAll');
    Route::get('/Produksi/exportAllDone/{daterange}', 'ProdukController@exportAllDone')->name('exportAllDone');
    Route::get('/Produksi/exportFirst/{ ID_MPS }', 'ProdukController@exportFirst')->name('exportFirst');
    Route::get('/PROD/showPROD/{ID_MPS}', 'ProdukController@show')->name('show');
    Route::get('/PROD/accPROD/{ID_MPS}', 'ProdukController@accept')->name('accept');
    // Route::get('/exportPDF/{daterange}', 'ProdukController@exportPDF')->name('exportPDF');

    //Produk Route Start
    Route::prefix('produk')->group(function () {
        Route::get('/', 'ProdukController@index')->name('index');
        Route::get('/createPROD', 'ProdukController@create')->name('create');
        Route::POST('/storePROD', 'ProdukController@store')->name('store');
        Route::get('/editPROD/{ID_Produk}', 'ProdukController@edit')->name('edit');
        Route::get('/export', 'ProdukController@PDF')->name('export');
        Route::POST('/updatePROD', 'ProdukController@update')->name('update');
        Route::get('/deletePROD/{ID_Produk}', 'ProdukController@destroy')->name('destroy');
    });
    //Produk Route End
    //BOM Route Start
    Route::prefix('BOM')->group(function () {
        Route::get('/', 'BOMController@index')->name('index');
        Route::get('/createBOM', 'BOMController@create')->name('create');
        Route::POST('/storeBOM', 'BOMController@store')->name('store');
        Route::get('/showBOM/{ID_Produk}', 'BOMController@show')->name('show');
        Route::get('/export/{ID_Produk}', 'BOMController@PDF')->name('export');
        Route::POST('/updateBOM', 'BOMController@update')->name('update');
        Route::get('/deleteBBBOM/{ID_BOM}', 'BOMController@destroyBB')->name('destroy.BB');
        Route::get('/deletePartsBOM/{ID_BOM}', 'BOMController@destroyParts')->name('destroy.Parts');
    });
    //BOM Route End
});
//produksi route end

// Admin route start

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/Admin', 'MRPController@filter')->name('filter');

    //MPS Route Start
    Route::prefix('MPS')->group(function () {
        Route::get('/', 'MPSController@index')->name('index');
        Route::get('/createMPS', 'MPSController@create')->name('create');
        Route::POST('/createMPS/fetchProduk', 'MPSController@fetchProduk')->name('fetchProduk');
        Route::POST('/storeMPS', 'MPSController@store')->name('store');
        Route::get('/export/{daterange}', 'MPSController@export')->name('export');
        Route::get('/editMPS/{ID_MPS}', 'MPSController@edit')->name('edit');
        Route::POST('/updateMPS', 'MPSController@update')->name('update');
        Route::get('/deleteMPS/{ID_MPS}', 'MPSController@destroy')->name('destroy');
    });
    //MPS Route End
    //MPS Route Start
    Route::prefix('MRP')->group(function () {
        Route::get('/', 'MRPController@index')->name('index');
        Route::get('/storeMRP/{ID_MPS}', 'MRPController@store')->name('store');
        Route::get('/showMRP/{ID_MPS}', 'MRPController@show')->name('show');
        Route::get('/deleteMRP/{ID_MPS}', 'MRPController@destroy')->name('destroy');
        Route::get('/export/{ID_MPS}', 'MRPController@exportFirst')->name('exportFirst');
        Route::get('/exportAll/{daterange}', 'MRPController@exportAll')->name('exportAll');
    });
    //MPS Route End
    // Register start
    Route::prefix('Register')->group(function () {
        Route::get('/', 'RegisterController@index');
        Route::POST('/', 'RegisterController@store');
    });
    // Register End
});
// Admin Route End
// Admin route start

Route::middleware(['auth', 'role:Payment'])->group(function () {

    //MPS Route Start
    Route::prefix('Payment')->group(function () {
        Route::get('/', 'PaymentsController@index')->name('index');
        Route::get('/PaymentProcess', 'PaymentsController@edit')->name('edit');

        Route::get('/createPAY/{ID_MRP}', 'PaymentsController@store')->name('store');
        Route::get('/deletePAY/{ID_Payment}', 'PaymentsController@destroy')->name('destroy');
        Route::get('/exportPDF/{daterange}', 'PaymentsController@exportPDF')->name('exportPDF');
        Route::get('/search', 'PaymentsController@search')->name('search');

    });
    //MPS Route End

});
// Admin Route End
