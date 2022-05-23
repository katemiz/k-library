<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\PdfController;

use App\Http\Livewire\AssetsTable;
use App\Http\Livewire\AssetsView;

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

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

Route::get('/', function () {
    return view('welcome');
});

/* Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard'); */

Route::get('/dashboard', [AssetController::class, 'stats'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('lang/{lang}', [
    'as' => 'lang.switch',
    'uses' => 'App\Http\Controllers\LanguageController@switchLang',
]);

require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('resim/', [AssetController::class, 'resimCheck'])
        ->name('resimCheck')
        ->middleware('auth');

    // LIBRARY ASSET
    Route::get('/assets-list', AssetsTable::class)->name('myassets');
    Route::get('/assets-view/{id}', AssetsView::class)->name('view');

    Route::get('assets-form', [AssetController::class, 'forms']);
    Route::get('assets-addfiles', [AssetController::class, 'addfilesform']);

    Route::get('assets-form/{id}', [AssetController::class, 'forms']);
    Route::post('assets-add', [AssetController::class, 'store']);
    Route::post('assets-update/{id}', [AssetController::class, 'update']);

    Route::get('delconfirm/{id}', [AssetController::class, 'delconfirm']);
    Route::get('delete/{id}', [AssetController::class, 'destroy']);

    Route::get('view-pdf/{id}', [PdfController::class, 'securePdf']);
});
