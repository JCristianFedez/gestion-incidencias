<?php

namespace App\Http\Controllers;

use App\Models\Adjunto;
use App\Models\Category;
use App\Models\Incident;
use App\Models\Level;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IncidentController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Funcion para cargar la vista de una incidencia en aprticular
     */
    public function show($id)
    {
        $incident = Incident::findOrFail($id);

        $user = User::find(auth()->user()->id);

        // Usuarios de soporte
        if ($user->role == 1) {

            $project_user = ProjectUser::where("user_id", $user->id)
                ->where("project_id", $incident->project_id)
                ->where("level_id", $incident->level_id)->first();

            // Se comprueba que el usuario tenga asignacion al proyecto y la inciencia
            // tenga el nivel como general
            if (!$project_user && $incident->level_id == null) {
                $project_user = ProjectUser::where("user_id", $user->id)
                    ->where("project_id", $incident->project_id)
                    ->first();
            }

            // Si el usuario de soporte no tiene una relacion con el proyecto y nivel de la incidencia
            // no la puede ver y tampoco es la incidencia de soporte
            if (!$project_user && $incident->client_id != $user->id) {
                return back();
            }

            // Usuarios cliente
        } else if ($user->role == 2) {

            // Si no es la incidencia del cliente
            if ($incident->client_id != $user->id) {
                return back();
            }
        }

        $messages = $incident->messages;
        return view("incidents.show", compact("incident", "messages"));
    }

    /**
     * Funcion encargada de mostrar un formulario para crear una nueva incidencia
     */
    public function create()
    {
        $categories = Category::where("project_id", auth()->user()->selected_project_id)->get();
        $levels = Level::where("project_id", auth()->user()->selected_project_id)->get();
        return view("incidents.create", compact("categories", "levels"));
    }

    /**
     * Funcion encargada de almacenar una nueva incidencia
     */
    public function store(Request $request)
    {

        $this->validate($request, Incident::$rules, Incident::$messages);

        // Si tiene archivo adjunto
        if ($request->file("adjunto")) {

            $incidentId = Incident::all()->last()->id + 1;

            $projectId = Project::findOrFail(auth()->user()->selected_project_id)->id;

            $category = Category::find($request->category_id);
            $categoryId = ($category) ? $category->id : 0;

            // Parte en local //
            $adjunto = $request->file("adjunto")->storeAs(
                "public/Project-$projectId/Category-$categoryId/Year-" . date("Y") . "/Month-" . date("m") . "/Day-" . date("d") . "/Incident-Id-$incidentId/attached-file",
                $request->file("adjunto")->getClientOriginalName()
            );
            $url = Storage::url($adjunto);
            // Fin parte local //


            // Parte para InfinityFree //
            /*$path = "storage/Project-$projectId/Category-$categoryId/Year-".date("Y")."/Month-".date("m")."/Day-".date("d")      ."/Incident-Id-$incidentId/attached-file";

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            move_uploaded_file($_FILES["adjunto"]["tmp_name"],$path ."/". $_FILES["adjunto"]["name"]);

            $url = "/".$path."/".$_FILES["adjunto"]["name"];*/
            //FIn infinityfree //
        }


        $user = auth()->user();
        $incident = new Incident();
        $incident->category_id = $request->category_id ?: null;
        $incident->severity = $request->severity;
        $incident->title = $request->title;
        $incident->description = $request->description;
        $incident->client_id = $user->id;
        $incident->project_id = $user->selected_project_id;
        $incident->level_id = $request->level_id ?: null;
        $incident->attached_file = isset($url) ? $url : null;
        $incident->save();

        return back()->with("notification", "Incidencia registrada exitosamente.");
    }

    /**
     * Editar incidencia
     */
    public function edit($id)
    {
        $incident = Incident::findOrFail($id);
        $categories = $incident->project->categories;
        $levels = $incident->project->levels;
        return view("incidents.edit", compact("incident", "categories", "levels"));
    }

    /**
     * Actualizar incidencia
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, Incident::$rules, Incident::$messages);

        $incident = Incident::findOrFail($id);

        // Si tiene un archivo adjunto
        if ($request->file("adjunto")) {
            $incidentId = $incident->id;

            $projectId = Project::findOrFail($incident->project_id)->id;

            $category = Category::find($incident->category_id);
            $categoryId = ($category) ? $category->id : 0;

            // Si antes tenia un archivo adjunto se elimina y se guarda el nuevo
            // Parte local //
            if ($incident->attached_file) {
                $publicRoute = $incident->file_public_path;
                if (Storage::exists($publicRoute))
                    Storage::delete($publicRoute);
            }

            $adjunto = $request->file("adjunto")->storeAs(
                "public/Project-$projectId/Category-$categoryId/Year-" . date("Y") . "/Month-" . date("m") . "/Day-" . date("d") . "/Incident-Id-$incidentId/attached-file",
                $request->file("adjunto")->getClientOriginalName()
            );

            $url = Storage::url($adjunto);
            // Fin parte local //

            // Inicio para infinityfree //
            /*if ($incident->attached_file) {
                if (file_exists(substr($incident->attached_file, 1)))
                    unlink(substr($incident->attached_file, 1));
            }

            $path = "storage/Project-$projectId/Category-$categoryId/Year-".date("Y")."/Month-".date("m")."/Day-".date("d")      ."/Incident-Id-$incidentId/attached-file";

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            move_uploaded_file($_FILES["adjunto"]["tmp_name"],$path ."/". $_FILES["adjunto"]["name"]);

            $url = "/".$path."/".$_FILES["adjunto"]["name"];*/
            //FIn infinityfree //
        }

        $incident->level_id = $request->level_id ?: null;
        $incident->category_id = $request->category_id ?: null;
        $incident->severity = $request->severity;
        $incident->title = $request->title;
        $incident->description = $request->description;
        $incident->attached_file = isset($url) ? $url : $incident->attached_file;
        $incident->save();

        // Si se ha cambiado el nivel a uno distinto de general se elimina al usuario de soporte
        if ($incident->level_id != null && $incident->support_id != null) {
            $user = User::find($incident->support_id);

            // Usuario de soporte
            if ($user->role == 1) {

                $project_user = ProjectUser::where("project_id", $incident->project_id)
                    ->where("user_id", $user->id)
                    ->where("level_id", $incident->level_id)
                    ->first();

                if ($project_user == null) {
                    $incident->support_id = null;
                    $incident->save();
                }
            }
        }

        return redirect("/incidencia/ver/$id")->with("notification", "Incidencia modificada exitosamente.");
    }

    /**
     * Atender incidencia
     */
    public function take($id, Request $request)
    {

        $incident = Incident::findOrFail($id);
        $user = auth()->user();

        // Si es administrador no se comprueba el nivel o el proyecto
        if ($user->is_admin) {
            $incident->support_id = $user->id;
            $incident->save();

            if ($request->ajax()) {
                return response()->json([
                    "head" => "¡Correcto!",
                    "message" => "Incidencia atendida.",
                    "type" => "success",
                ]);
            }

            return back()->with("notification", "Incidencia atendida");
        }

        // Si usuario no es de soporte
        if (!$user->is_support) {
            return back();
        }

        $project_user = ProjectUser::where("project_id", $incident->project_id)
            ->where("user_id", $user->id)->first();

        // Si la incidencia no proyecto de la incidencia
        if (!$project_user) {
            return back();
        }

        // Si el nivel de la incidencia no es el mismo que el del usuario
        if (
            $project_user->level_id != $incident->level_id
            && $incident->level_id != null
        ) {
            return back();
        }

        $incident->support_id = $user->id;
        $incident->save();

        if ($request->ajax()) {
            return response()->json([
                "head" => "¡Correcto!",
                "message" => "Incidencia atendida.",
                "type" => "success",
            ]);
        }

        return back()->with("notification", "Incidencia atendida");
    }

    /**
     * Desatender incidencia
     */
    public function disregard($id, Request $request)
    {

        $incident = Incident::findOrFail($id);
        $user = auth()->user();

        if ($incident->support_id != $user->id) {
            return back();
        }
        $incident->support_id = null;
        $incident->save();

        if ($request->ajax()) {
            return response()->json([
                "head" => "¡Correcto!",
                "message" => "Incidencia desatendida.",
                "type" => "success",
            ]);
        }

        return back()->with("notification", "Incidencia desatendida");
    }

    /**
     * Marcar incidencia como resuelta
     */
    public function solve($id, Request $request)
    {
        $incident = Incident::findOrFail($id);

        // El usuario que la resuelve es el mismo que la publico
        if ($incident->client_id != auth()->user()->id) {
            return back();
        }

        $incident->active = 0;
        $incident->save();

        if ($request->ajax()) {
            return response()->json([
                "head" => "¡Correcto!",
                "message" => "Incidencia resuelta.",
                "type" => "success",
            ]);
        }

        return back()->with("notification", "Incidencia resuelta");
    }

    /**
     * Abrir incidencia
     */
    public function open($id, Request $request)
    {
        $incident = Incident::findOrFail($id);

        // El usuario que la abre es el mismo que la publico
        if ($incident->client_id != auth()->user()->id) {
            return back();
        }

        $incident->active = 1;
        $incident->save();

        if ($request->ajax()) {
            return response()->json([
                "head" => "¡Correcto!",
                "message" => "Incidencia abierta.",
                "type" => "success",
            ]);
        }

        return back()->with("notification", "Incidencia abierta");
    }

    /**
     * Enviar al siguiente nivel la incidencia
     */
    public function nextLevel($id, Request $request)
    {

        $incident = Incident::findOrFail($id);
        $level = Level::find($incident->level_id);

        if (!$level) {
            $nextLevel = Level::where("project_id", $incident->project->id)->orderBy('difficulty')->first();
        } else {
            $nextLevel = $level->next_level;
        }

        if ($nextLevel) {
            $incident->level_id = $nextLevel->id;
            $incident->support_id = null;
            $incident->save();

            if ($request->ajax()) {
                return response()->json([
                    "head" => "¡Correcto!",
                    "message" => "Incidencia derivada al siguiente nivel.",
                    "type" => "success",
                ]);
            }

            return back()->with("notification", "Incidencia derivada al siguiente nivel");
        }

        if ($request->ajax()) {
            return response()->json([
                "head" => "¡Error!",
                "message" => "No es posible derivar porque no hay un siguiente nivel",
                "type" => "error",
            ]);
        }
        return back()->with("notification", "No es posible derivar porque no hay un siguiente nivel");
    }
}
