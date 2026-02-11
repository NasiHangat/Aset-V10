<?php

use App\Http\Controllers\ChartController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AsetOutController;
use App\Http\Controllers\AjuanController;
use App\Http\Controllers\AsetKeluarController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\SessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('isLogin')->group(function () {
	Route::get('/', [ChartController::class, 'index']);
	Route::get('/', [ChartController::class, 'chart']);

	// Route::post('/checkCodeExists', [BarangController::class, 'checkCodeExists'])->name('checkCodeExists');
	Route::post('/checkNupExists', [BarangController::class, 'checkNupExists'])->name('checkNupExists');
	Route::post('/checkNoSeriExists', [BarangController::class, 'checkNoSeriExists'])->name('checkNoSeriExists');

	Route::prefix('asetTetap')->group(function () {
		Route::post('/filter', [BarangController::class, 'filter'])->name('asetTetap.filter');
		Route::post('/search', [BarangController::class, 'search'])->name('asetTetap.search');
		Route::post('/multiDelete', [BarangController::class, 'multiDelete'])->name('asetTetap.multiDelete');
		Route::get('/import', [BarangController::class, 'import'])->name('asetTetap.import');
		Route::post('/import', [BarangController::class, 'importStore'])->name('asetTetap.import');
		Route::post('/export', [BarangController::class, 'export'])->name('asetTetap.export');
	});
	//Route::resource('/asetTetap', BarangController::class);
	Route::prefix('asetTetap')->group(function () {
		Route::get('/', [BarangController::class, 'index'])->name('asetTetap.index');
		Route::get('/add', [BarangController::class, 'create'])->name('asetTetap.create');
		Route::post('/add/store', [BarangController::class, 'store'])->name('asetTetap.store');
		Route::get('/{id}/edit', [BarangController::class, 'edit'])->name('asetTetap.edit');
		Route::put('/{id}', [BarangController::class, 'update'])->name('asetTetap.update');
		Route::delete('/{id}', [BarangController::class, 'destroy'])->name('asetTetap.destroy');
	});

	Route::prefix('generate_qrcodes')->group(function () {
		Route::post('/', [QrCodeController::class, 'generateQRCodes'])->name('generate_qrcodes');
		Route::post('/scanning', [QrCodeController::class, 'scanning'])->name('scanning');
		Route::get('/scanningResult', [QrCodeController::class, 'scanningResult'])->name('generate_qrcodes.scanningResult');
	});

	Route::post('/checkCodeBExists', [ItemsController::class, 'checkCodeBExists'])->name('checkCodeBExists');
	Route::post('/items/import', [ItemsController::class, 'fileImport'])->name('items.import');
	Route::get('/items/export', [ItemsController::class, 'export'])->name('items.export');
	Route::post('/items/filter', [ItemsController::class, 'filter'])->name('items.filter');
	//Route::resource('/items', ItemsController::class);
	Route::prefix('items')->group(function () {
		Route::get('/', [ItemsController::class, 'index'])->name('items.index');
		Route::get('/add', [ItemsController::class, 'create'])->name('items.create');
		Route::post('/add/store', [ItemsController::class, 'store'])->name('items.store');
		Route::get('/{id}/edit', [ItemsController::class, 'edit']);
		Route::put('/{id}', [ItemsController::class, 'update']);
		Route::delete('/{id}', [ItemsController::class, 'destroy'])->name('items.destroy');
	});

	// pengajuan
	Route::prefix('pengajuan/ajuan')->group(function () {
		Route::get('/', [ItemsController::class, 'ajuan'])->name('getPengajuan');
		Route::get('/add', [ItemsController::class, 'pengajuan'])->name('addPengajuan');
		Route::post('/add/addPengajuan', [ItemsController::class, 'addPengajuan'])->name('pengajuan');
		//Route::put('/{id}', [ItemsController::class, 'update']);
		//Route::delete('/{id}', [ItemsController::class, 'destroy'])->name('location.destroy');
	});

	// location
	Route::prefix('location')->group(function () {
		Route::get('/', [LocationController::class, 'get_data']);
		Route::post('/add/store', [LocationController::class, 'dataStore'])->name('location.store');
		Route::put('/{id}', [LocationController::class, 'update'])->name('location.update');
		Route::delete('/{id}', [LocationController::class, 'destroy'])->name('location.destroy');
		Route::post('/search', [LocationController::class, 'search'])->name('location.search');
		Route::post('/filter', [LocationController::class, 'filter'])->name('location.filter');

	});

	// category
	Route::prefix('category')->group(function () {
		Route::get('/', [CategoryController::class, 'get_data']);
		Route::post('/add/store', [CategoryController::class, 'dataStore'])->name('category.store');
		Route::put('/{id}', [CategoryController::class, 'update'])->name('category.update');
		Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
        Route::post('/search', [CategoryController::class, 'search'])->name('category.search');
	});

	// pengguna
	Route::prefix('pengguna')->group(function () {
		Route::get('/', [UserController::class, 'get_data']);
		Route::get('/add', [UserController::class, 'addData'])->name('pengguna.add');
		Route::post('/add/store', [UserController::class, 'dataStore'])->name('pengguna.store');
		Route::get('/edit/{id}', [UserController::class, 'editData'])->name('pengguna.edit');
		Route::put('/edit/{id}', [UserController::class, 'update'])->name('pengguna.update');
		Route::delete('/{id}', [UserController::class, 'destroy'])->name('pengguna.destroy');
        Route::post('/search', [UserController::class, 'search'])->name('pengguna.search');
		Route::post('/filter', [UserController::class, 'filter'])->name('pengguna.filter');
	});

	// peminjaman
	Route::prefix('peminjaman')->group(function () {
		Route::get('/', [PeminjamanController::class, 'get_data']);
		Route::get('/add', [PeminjamanController::class, 'addData'])->name('peminjaman.add');
		Route::post('/add/store', [PeminjamanController::class, 'dataStore'])->name('peminjaman.store');
		Route::get('/kembali/{id}', [PeminjamanController::class, 'kembali'])->name('peminjaman.kembali');
		Route::put('/kembali/{id}', [PeminjamanController::class, 'pengembalian'])->name('peminjaman.pengembalian');
		Route::get('/edit/{id}', [PeminjamanController::class, 'editData'])->name('peminjaman.edit');
		Route::put('/edit/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
		Route::delete('/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
		Route::get('/report', [PeminjamanController::class, 'report'])->name('peminjaman.report-peminjaman');
		Route::get('/export', [PeminjamanController::class, 'export'])->name('peminjaman.report');
		Route::get('/exportall', [PeminjamanController::class, 'exportAll'])->name('peminjaman.reportAll');
		Route::post('/search', [PeminjamanController::class, 'search'])->name('peminjaman.search');
		Route::post('/filter', [PeminjamanController::class, 'filter'])->name('peminjaman.filter');
	});

	// asetout
	Route::prefix('asetout')->group(function () {
		Route::get('/', [AsetOutController::class, 'get_data']);
		Route::get('/list', [AsetOutController::class, 'getList']);
		Route::get('/add', [AsetOutController::class, 'addData'])->name('asetout.add');
		Route::post('/add/store', [AsetOutController::class, 'dataStore'])->name('asetout.store');
		Route::get('/edit/{id}', [AsetOutController::class, 'editData'])->name('asetout.edit');
		Route::put('/edit/{id}', [AsetOutController::class, 'update'])->name('asetout.update');
		Route::get('/editND/{id}', [AsetOutController::class, 'editDataND'])->name('asetout.editND');
		Route::put('/editND/{id}', [AsetOutController::class, 'updateND'])->name('asetout.updateND');

		// route pengajuan barang keluar
		Route::get('/ajuan/{id}', [AjuanController::class, 'getData'])->name('asetout.ajuan');
		Route::put('/ajuan/edit/{id}', [AjuanController::class, 'editData'])->name('ajuan.edit');
		Route::put('/ajuan/approve/{id}', [AjuanController::class, 'approve'])->name('ajuan.approve');
		Route::put('/ajuan/reject/{id}', [AjuanController::class, 'reject'])->name('ajuan.reject');
		Route::delete('/{id}', [AsetOutController::class, 'destroy'])->name('asetout.destroy');
		Route::get('/report', [AsetOutController::class, 'report'])->name('asetout.report-asetout');
		Route::post('/filter', [AsetOutController::class, 'filter'])->name('asetout.filter');
		Route::get('/export', [AsetOutController::class, 'exportAll'])->name('asetout.reportAll');
		Route::get('/cetak-faktur/{noFaktur}', [AsetOutController::class, 'cetakFaktur'])->name('cetak-faktur');
		//Route::get('/cetak-nota/{noFaktur}', [AsetOutController::class, 'cetakNota'])->name('cetak-nota');
		Route::get('/download/{noND}', [AsetOutController::class, 'download'])->name('cetak-nota');
		Route::get('/lampiran-pdf', [AsetOutController::class, 'lampiranPDF'])->name('lampiran.pdf');
		//Route::get('/download/{noFaktur}', [AsetOutController::class, 'download'])->name('ajuan.download');
	});

	// asetkeluar
	Route::prefix('asetkeluar')->group(function () {
		Route::get('/', [AsetKeluarController::class, 'index']);
		Route::get('/add', [AsetKeluarController::class, 'addData'])->name('asetkeluar.add');
		Route::post('/add/store', [AsetKeluarController::class, 'dataStore'])->name('asetkeluar.store');
		Route::get('/edit/{id}', [AsetKeluarController::class, 'editData'])->name('asetkeluar.edit');
		Route::put('/update/{id}', [AsetKeluarController::class, 'update'])->name('asetkeluar.update');
		Route::delete('/{id}', [AsetKeluarController::class, 'destroy'])->name('asetkeluar.destroy');
		Route::get('/download/{id}', [AsetKeluarController::class, 'download'])->name('asetkeluar.download');
		Route::get('/export', [AsetKeluarController::class, 'export'])->name('asetkeluar.export');
	    Route::post('/search', [AsetKeluarController::class, 'search'])->name('asetkeluar.search');
	});
});

// seesion
Route::prefix('session')->group(function () {
    Route::get('/', [SessionController::class, 'formLogin'])->middleware('isTamu');
    Route::post('/login', [SessionController::class, 'login'])->middleware('isTamu');
    Route::get('/logout', [SessionController::class, 'logout'])->name('session.logout');
});

Route::get('/autoLogin', [SessionController::class, 'autoLogin']);
