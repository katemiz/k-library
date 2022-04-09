<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SimpleItemController;
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
    return Inertia::render('IndexGuest',["logout"=>false]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Index');
})->middleware(['auth','verified'])->name('dashboard');





Route::get('/aboutus', function () {
    return Inertia::render('AboutUs');
});

Route::get('/services', function () {
    return Inertia::render('Services');
});


require __DIR__.'/auth.php';


Route::middleware(['auth'])->group(function () {


    // ROLES
    Route::get('roles',[RoleController::class,'index']);
    Route::get('roles/{id}',[RoleController::class,'show']);
    Route::get('roles-list',[RoleController::class,'list']);
    Route::get('roles/form/{id}',[RoleController::class,'form']);
    Route::post('roles',[RoleController::class,'create']);
    Route::put('roles',[RoleController::class,'update']);
    Route::delete('roles',[RoleController::class,'destroy']);

    Route::get('role-skills/{id}',[RoleController::class,'getskills']);
    Route::post('role-skill',[RoleController::class,'setskills']);

    Route::get('role-language/{id}',[RoleController::class,'getlang']);
    Route::post('role-language',[RoleController::class,'setlang']);

    Route::get('role-diploma/{id}',[RoleController::class,'getdiploma']);
    Route::post('role-diploma',[RoleController::class,'setdiploma']);

    Route::get('role-profession/{id}',[RoleController::class,'getprofession']);
    Route::post('role-profession',[RoleController::class,'setprofession']);

    Route::get('role-experience/{id}',[RoleController::class,'getexperience']);
    Route::post('role-experience',[RoleController::class,'setexperience']);

    Route::post('role-docx/{id}',[RoleController::class,'docx']);



    // SKILLS TREE (AND SLEVELS)
    Route::get('slevels',[SkillController::class,'slevels']);
    Route::get('skills',[SkillController::class,'index']);
    Route::post('skills',[SkillController::class,'create']);
    Route::put('skills',[SkillController::class,'update']);
    Route::delete('skills',[SkillController::class,'destroy']);




    // BUSINESS CATEGORY
    Route::get('bcategory',[CategoryController::class,'index']);
    Route::get('bcategory/form/{id}',[CategoryController::class,'form']);
    Route::get('bcategory/{id}',[CategoryController::class,'show']);
    Route::post('bcategory',[CategoryController::class,'create']);
    Route::put('bcategory',[CategoryController::class,'update']);
    Route::delete('bcategory',[CategoryController::class,'destroy']);


    // SIMPLE ITEM (EDU/DIPLOMA, PROFESSION, LANGUAGE)

    Route::get('simpleitem/{type}',[SimpleItemController::class,'list']);
    Route::get('simpleitem-form/{type}',[SimpleItemController::class,'form']);
    Route::get('simpleitem-form/{type}/{id}',[SimpleItemController::class,'form']);
    Route::get('simpleitem/{type}/{id}',[SimpleItemController::class,'show']);
    Route::post('simpleitem-upsert/{type}',[SimpleItemController::class,'create']);
    Route::put('simpleitem-upsert/{type}',[SimpleItemController::class,'update']);
    Route::delete('simpleitem/{type}',[SimpleItemController::class,'destroy']);





});