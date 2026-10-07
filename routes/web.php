<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ScratchCardController;
use App\Models\ScratchcardBatch;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/',[AdminLoginController::class,'index'])->name('login');

Route::post('/login', [AdminLoginController::class, 'login'])->name('login_submit');
Route::get('/admin/logout', [AdminLoginController::class, 'logout'])->name('logout');


Route::middleware(['adminauth'])->group(function () {
Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');
Route::get('create-card',[ScratchCardController::class,'index'])->name('create_scratch_card');
Route::post('/admin/scratchcards/store', [ScratchCardController::class, 'store'])->name('scratchcards_store');
Route::get('/admin/scratchcards/list', [ScratchCardController::class, 'list'])->name('scratchcards_index');
Route::get('/admin/scratchcards/export-pdf/{batch}', [ScratchCardController::class, 'exportPdf'])->name('scratchcards_pdf');
Route::post('/admin/scratchcards/{id}/toggle-prize', [ScratchCardController::class, 'togglePrize'])->name('scratchcards_togglePrize');

Route::get('/scratchcards/batches', [ScratchCardController::class, 'batchList'])->name('scratchcards_batchlist');
Route::get('/scratchcards/export-all', [ScratchcardController::class, 'exportAll'])->name('scratchcards_export_all');

Route::get('/admin/pricehascards/list', [ScratchCardController::class, 'pricehaslist'])->name('pricehas_card');

Route::get('/download-scratchcards-zip', function() {
    $file = storage_path('app/scratchcards_batches.zip');
    if(file_exists($file)){
        return response()->download($file)->deleteFileAfterSend(true);
    }
    abort(404);
});


Route::get('disbursed-card',[ScratchCardController::class,'disbursedindex'])->name('scratch_card_disbursed');
Route::post('/admin/disbursedscratchcards/store', [ScratchCardController::class, 'storedisbursed'])->name('disbursedscratchcards_store');


Route::get('/show-card/{encryptedCode}', [ScratchcardController::class, 'show'])->name('scratchcard_show');

Route::get('customer-list',[ScratchCardController::class,'customerlist'])->name('customer_list');



});



