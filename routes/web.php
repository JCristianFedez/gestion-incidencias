<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ProjectUserController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncidentController;
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

Route::get("/seleccionar/proyecto/{id}",[HomeController::class, "selectProject"])->name("seleccionar.proyecto");

Route::get('/reportar',[IncidentController::class, "create"])->name("reportar.create");
Route::post('/reportar',[IncidentController::class, "store"])->name("reportar.store");

Route::get("/ver/incidencia/{id}", [IncidentController::class, "show"])->name("incidencia.show");

Route::group(["middleware" => "admin"], function (){
    // Users
    Route::get('/usuarios',[UserController::class, "index"])->name("usuarios");
    Route::post('/usuarios',[UserController::class, "store"])->name("usuarios.store");
    Route::get('/usuario/{id}',[UserController::class, "edit"])->name("usuario.edit");
    Route::put('/usuario/{id}',[UserController::class, "update"])->name("usuario.update");
    Route::delete('/usuario/{id}',[UserController::class, "destroy"])->name("usuario.destroy");

    // Projects
    Route::get('/proyectos',[ProjectController::class, "index"])->name("proyectos");
    Route::post('/proyectos',[ProjectController::class, "store"])->name("proyectos.store");
    Route::get('/proyecto/{id}',[ProjectController::class, "edit"])->name("proyecto.edit");
    Route::put('/proyecto/{id}',[ProjectController::class, "update"])->name("proyecto.update");
    Route::delete('/proyecto/{id}',[ProjectController::class, "destroy"])->name("proyecto.destroy");
    Route::get('/proyecto/{id}/restaurar',[ProjectController::class, "restore"])->name("proyecto.restore");

    // Category
    Route::post('/categorias',[CategoryController::class, "store"])->name("categorias.store");
    Route::put('/categoria',[CategoryController::class, "update"])->name("categoria.update");     //  No recojo el valor por {id} en update debido a que se pasa por un hidden
    Route::delete('/categoria/{id}',[CategoryController::class, "destroy"])->name("categoria.destroy");

    // Levels
    Route::post('/niveles',[LevelController::class, "store"])->name("niveles.store");
    Route::put('/nivel',[LevelController::class, "update"])->name("nivel.update");     //  No recojo el valor por {id} en update debido a que se pasa por un hidden
    Route::delete('/nivel/{id}',[LevelController::class, "destroy"])->name("nivel.destroy");

    // Prject-User
    Route::post("/proyecto-usuario", [ProjectUserController::class,"store"])->name("proyecto-user.store");
    Route::delete("/proyecto-usuario/{id}", [ProjectUserController::class,"destroy"])->name("proyecto-user.destory");

    Route::get('/config',[ConfigController::class, "index"])->name("config");

});



