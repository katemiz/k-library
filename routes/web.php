<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AssetController;

use App\Http\Livewire\AssetsTable;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})
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
    Route::get('assets-view/{id}', [AssetController::class, 'show'])->name(
        'view'
    );

    //Route::get('assets-select-type', [AssetController::class, 'typeselect']);
    Route::get('assets-form', [AssetController::class, 'forms']);
    Route::get('assets-form/{id}', [AssetController::class, 'forms']);
    Route::post('assets-add', [AssetController::class, 'store']);
    Route::post('assets-update/{id}', [AssetController::class, 'update']);

    // Route::delete('assets/{type}', [AssetController::class, 'destroy']);

    /*     Route::post('fetch', [AssetController::class, 'fetch']);

    Route::get('dosya', [AssetController::class, 'dosyayap']);
    Route::post('dosya', [AssetController::class, 'dosyayukle']); */
});
