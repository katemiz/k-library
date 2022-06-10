<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\FileAccessController;

use App\Http\Livewire\AssetView;
use App\Http\Livewire\ListRecords;

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

/* Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
}); */

Route::get('/', function () {
    return view('welcome');
});

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
    // Route::get('/assets-list/{type}', AssetsTable::class);
    Route::get('/asset-view/{id}', AssetView::class)->name('view');

    Route::get('assets-form', [AssetController::class, 'forms']);
    Route::get('assets-addfiles', [AssetController::class, 'addfilesform']);
    Route::post('assets-storefiles', [AssetController::class, 'storefiles']);

    Route::get('assets-form/{id}', [AssetController::class, 'forms']);
    Route::post('assets-add', [AssetController::class, 'store']);
    Route::post('assets-update/{id}', [AssetController::class, 'update']);

    Route::get('delconfirm/{id}', [AssetController::class, 'delconfirm']);
    Route::get('delete/{id}', [AssetController::class, 'destroy']);
    Route::get('/delete-attach/{type}/{asset_id}/{id}', [
        AssetController::class,
        'deleteattach',
    ]);

    Route::get('/access-audio/{id}', [FileAccessController::class, 'audio']);
    Route::get('/access-document/{id}', [FileAccessController::class, 'docs']);
    Route::get('/access-dosya/{id}', [FileAccessController::class, 'dosya']);

    Route::get('/list-records/{type}', ListRecords::class);
});
