<?php

use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/reportar',[HomeController::class, "report"])->name("reportar");

Route::group(["middleware" => "admin"], function (){
    
    Route::get('/usuarios',[UserController::class, "index"])->name("usuarios");
    Route::get('/proyectos',[ProjectController::class, "index"])->name("proyectos");
    Route::get('/config',[ConfigController::class, "index"])->name("config");

});



