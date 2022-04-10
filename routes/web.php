<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AssetController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('IndexGuest', ['logout' => false]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Index');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/aboutus', function () {
    return Inertia::render('AboutUs');
});

Route::get('/services', function () {
    return Inertia::render('Services');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {
    // LIBRARY ASSET
    Route::get('assets/{asset_type}', [AssetController::class, 'list']);
    Route::get('assets-select-type', [AssetController::class, 'typeselect']);
    Route::get('assets-form/{asset_type}', [AssetController::class, 'form']);
    Route::get('assets-form/{asset_type}/{id}', [
        AssetController::class,
        'form',
    ]);
    Route::get('assets/{asset_type}/{id}', [AssetController::class, 'show']);
    Route::post('assets-upsert/{asset_type}', [
        AssetController::class,
        'create',
    ]);
    Route::put('assets-upsert/{asset_type}', [
        AssetController::class,
        'update',
    ]);
    Route::delete('assets/{asset_type}', [AssetController::class, 'destroy']);
});
