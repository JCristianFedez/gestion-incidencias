<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ProjectUserController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DatatableController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\VarDumper\Cloner\Data;

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
    return view('welcome.welcome');
})->name("welcome");

Route::get('/creditos', function () {
    return view('credits.credit');
})->name("credits");

Route::get("/instrucciones", function () {
    return view('instructions.instructions');
})->name("instructions");

Auth::routes();

Route::middleware(['middleware' => 'project.selected'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get("/seleccionar/proyecto/{id}", [HomeController::class, "selectProject"])->name("seleccionar.proyecto");


    // Rutas de las incidencias
    Route::get('/reportar', [IncidentController::class, "create"])->name("reportar.create");
    Route::post('/reportar', [IncidentController::class, "store"])->name("reportar.store");

    Route::get("/incidencia/{id}/editar", [IncidentController::class, "edit"])->name("incidencia.edit");
    Route::post("/incidencia/{id}/editar", [IncidentController::class, "update"])->name("incidencia.update");

    Route::get("/incidencia/ver/{id}", [IncidentController::class, "show"])->name("incidencia.show");

    Route::get("/incidencia/{id}/atender", [IncidentController::class, "take"])->name("incidencia.take");
    Route::get("/incidencia/{id}/desatender", [IncidentController::class, "disregard"])->name("incidencia.disatend");
    Route::get("/incidencia/{id}/resolver", [IncidentController::class, "solve"])->name("incidencia.solve");
    Route::get("/incidencia/{id}/abrir", [IncidentController::class, "open"])->name("incidencia.open");
    Route::get("/incidencia/{id}/derivar", [IncidentController::class, "nextLevel"])->name("incidencia.nextLevel");
    // Fin rutas incidencias


    // Rutas de los mensages
    Route::post("/incidencia/{id}/mensajes", [MessageController::class, "store"])->name("incidencia.message.store");
});

Route::group(["middleware" => "admin"], function () {
    // Users
    Route::get('/usuarios', [UserController::class, "index"])->name("usuarios");
    Route::post('/usuarios', [UserController::class, "store"])->name("usuarios.store");
    Route::get('/usuario/{id}', [UserController::class, "edit"])->name("usuario.edit");
    Route::put('/usuario/{id}', [UserController::class, "update"])->name("usuario.update");
    Route::delete('/usuario/{id}', [UserController::class, "destroy"])->name("usuario.destroy");
    Route::delete('/usuario/{id}/delete', [UserController::class, "forcedestroy"])->name("usuario.force.destroy");
    Route::get('/usuario/{id}/restaurar', [UserController::class, "restore"])->name("usuario.restore");

    // Projects
    Route::get('/proyectos', [ProjectController::class, "index"])->name("proyectos");
    Route::post('/proyectos', [ProjectController::class, "store"])->name("proyectos.store");
    Route::get('/proyecto/{id}', [ProjectController::class, "edit"])->name("proyecto.edit");
    Route::put('/proyecto/{id}', [ProjectController::class, "update"])->name("proyecto.update");
    Route::delete('/proyecto/{id}', [ProjectController::class, "destroy"])->name("proyecto.destroy");
    Route::delete('/proyecto/{id}/delete', [ProjectController::class, "forcedestroy"])->name("proyecto.force.destroy");
    Route::get('/proyecto/{id}/restaurar', [ProjectController::class, "restore"])->name("proyecto.restore");

    // Category
    Route::post('/categorias', [CategoryController::class, "store"])->name("categorias.store");
    Route::put('/categoria', [CategoryController::class, "update"])->name("categoria.update");     //  No recojo el valor por {id} en update debido a que se pasa por un hidden
    Route::delete('/categoria/{id}', [CategoryController::class, "destroy"])->name("categoria.destroy");

    // Levels
    Route::post('/niveles', [LevelController::class, "store"])->name("niveles.store");
    Route::put('/nivel', [LevelController::class, "update"])->name("nivel.update");     //  No recojo el valor por {id} en update debido a que se pasa por un hidden
    Route::delete('/nivel/{id}', [LevelController::class, "destroy"])->name("nivel.destroy");

    // Prject-User
    Route::post("/proyecto-usuario", [ProjectUserController::class, "store"])->name("proyecto-user.store");
    Route::put("/proyecto-usuario", [ProjectUserController::class, "update"])->name("proyecto-user.update");
    Route::delete("/proyecto-usuario/{id}", [ProjectUserController::class, "destroy"])->name("proyecto-user.destory");

    Route::get('/config', [ConfigController::class, "index"])->name("config");

    // Datatables para cargar las tablas dinamicamente
    Route::get("/datatables/usuarios", [DatatableController::class, "users"])->name("datatables.users");
    Route::get("/datatables/usuario/{id}/proyectos", [DatatableController::class, "usersProjects"])->name("datatables.user.projects");
    Route::get("/datatables/proyectos", [DatatableController::class, "projects"])->name("datatables.projects");
    Route::get("/datatables/proyecto/{id}/categorias", [DatatableController::class, "projectsCategories"])->name("datatables.project.categories");
    Route::get("/datatables/proyecto/{id}/niveles", [DatatableController::class, "projectsLevels"])->name("datatables.project.levels");
});

Route::get("/datatables/dashboard/incidentsByMe", [DatatableController::class, "incidentsByMe"])->name("datatables.dashboard.incidentsByMe");
Route::get("/datatables/dashboard/myIncidents", [DatatableController::class, "myIncidents"])->name("datatables.dashboard.myIncidents");
Route::get("/datatables/dashboard/pendingIncidents", [DatatableController::class, "pendingIncidents"])->name("datatables.dashboard.pendingIncidents");
