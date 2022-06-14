<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\FileAccessController;
use App\Http\Livewire\AssetView;
use App\Http\Livewire\ListRecords;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('lang/{lang}', [
    'as' => 'lang.switch',
    'uses' => 'App\Http\Controllers\LanguageController@switchLang',
]);

Route::get('/dashboard', [AssetController::class, 'stats'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/asset-view/{id}', AssetView::class)->name('view');

    Route::get('assets-form', [AssetController::class, 'forms']);
    Route::get('assets-form/{id}', [AssetController::class, 'forms']);

    Route::post('assets-add', [AssetController::class, 'store']);
    Route::post('assets-update/{id}', [AssetController::class, 'update']);

    Route::get('assets-addfiles', [AssetController::class, 'addfilesform']);
    Route::post('assets-storefiles', [AssetController::class, 'storefiles']);

    Route::get('/access-audio/{id}', [FileAccessController::class, 'audio']);
    Route::get('/access-document/{id}', [FileAccessController::class, 'docs']);
    Route::get('/access-dosya/{id}', [FileAccessController::class, 'dosya']);

    Route::get('/list-records/{type}', ListRecords::class);
});
