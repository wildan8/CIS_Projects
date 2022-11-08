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
Route::get('/Register', 'RegisterController@index');
Route::POST('/Register', 'RegisterController@store');

Route::POST('/Logout', 'LoginController@logout');

Route::get('/Login', 'LoginController@index')->name('login')->middleware('guest');
Route::POST('/Login', 'LoginController@store');

// Gudang Route Start//
Route::middleware(['auth', 'role:Gudang'])->group(function () {
    Route::get('/Gudang', function () {
        return view('gudang.home');
        // Supplier Route Start
    });
    Route::get('/Laporan', function () {
        return view('Laporan.BahanBaku');
        // Supplier Route Start
    });
    Route::prefix('Supplier')->group(function () {
        Route::get('/', 'SupplierController@index')->name('index');
        Route::get('/createSUP', 'SupplierController@create')->name('create');
        Route::POST('/storeSUP', 'SupplierController@store')->name('store');
        Route::get('/editSUP/{ID_Supplier}', 'SupplierController@edit')->name('edit');
        Route::get('/export', 'SupplierController@PDF')->name('export');
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
        Route::get('/export', 'PenerimaanController@PDF')->name('export');
        Route::POST('/updateLOG', 'PenerimaanController@update')->name('update');
        Route::get('/deleteLOG/{ID_LOG}', 'PenerimaanController@destroy')->name('destroy');
    });
    //LOG Barang Route End

});
// Gudang Route End//

// Produksi Route Start//
Route::middleware(['auth', 'role:Produksi'])->group(function () {
    Route::get('/Produksi', function () {
        return view('Produksi.home');
    });
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
        Route::get('/deleteBOM/{ID_BOM}', 'BOMController@destroy')->name('destroy');
    });
    //BOM Route End
});
//produksi route end

// Admin route start

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/Admin', function () {
        return view('Admin.home');
    });
    //BOM Route Start
    Route::prefix('MPS')->group(function () {
        Route::get('/', 'MPSController@index')->name('index');
        Route::get('/createMPS', 'MPSController@create')->name('create');
        Route::get('/createMPS/fetch', 'MPSController@fetch')->name('fetch');
        Route::POST('/storeMPS', 'MPSController@store')->name('store');
        Route::get('/editMPS/{ID_MPS}', 'MPSController@edit')->name('edit');
        Route::POST('/updateMPS', 'MPSController@update')->name('update');
        Route::get('/deleteMPS/{ID_MPS}', 'MPSController@destroy')->name('destroy');
    });
    //BOM Route End
});
// Admin Route End

// Produksi Route End//
Route::get('/ReturnProduk', 'ReturnProdukController@index');

Route::get('/Payment', 'PaymentsController@index');

// FIX ROUTE END //
Route::get('/Return/createRET', function () {return view('gudang.forms.return');});
Route::get('/Penerimaan/editTRM', function () {return view('gudang.edits.penerimaan');});
Route::get('/Return/editRET', function () {return view('gudang.edits.return');});
