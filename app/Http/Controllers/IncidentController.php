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

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Funcion para cargar la vista de una incidencia en aprticular
     * 
     * @param Integer $id Id de la incidencia que se va a ver
     */
    public function show($id)
    {
        $incident = Incident::findOrFail($id);

        $user = User::findOrFail(auth()->user()->id);

        $temp = $this->userCanSeeTheIncident($user, $incident);
        if ($temp != null) {
            return $temp;
        }


        $messages = $incident->messages;
        return view("incidents.show", compact("incident", "messages"));
    }

    /**
     * Se comprueba que el usuario puede o no ver la incidencia, en caso de no tener permisos
     * para verla se le redigira a la ventana anterior
     * 
     * @param User $user Usuario que la intenta ver
     * @param Incident $incident Incidencia a ver
     * @return Back Redirige atras si no tiene permisos para ver la incidencia
     * @return null Si tiene permisos para ver la incidencia
     */
    private function userCanSeeTheIncident(User $user, Incident $incident)
    {
        // Si el proyecto de la incidencia es distinto al del seleccionado por el usuario
        if ($user->selected_project_id != $incident->project_id) {
            return redirect("home");
        }

        // Usuarios de soporte
        if ($user->is_support) {

            $projectUser = ProjectUser::where("user_id", $user->id)
                ->where("project_id", $incident->project_id)
                ->where("level_id", $incident->level_id)->first();

            // Se comprueba que el usuario tenga asignacion al proyecto y la inciencia
            // tenga el nivel como general
            if ($projectUser == null && $incident->level_id == null) {
                $projectUser = ProjectUser::where("user_id", $user->id)
                    ->where("project_id", $incident->project_id)
                    ->first();
            }

            // Si el usuario de soporte no tiene una relacion con el proyecto y nivel de la incidencia
            // no la puede ver y tampoco es la incidencia de soporte
            if ($projectUser == null && $incident->client_id != $user->id) {
                return redirect("home");
            }

            // Usuarios cliente
        } else if ($user->is_client) {

            // Si no es la incidencia del cliente
            if ($incident->client_id != $user->id) {
                return redirect("home");
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Funcion encargada de mostrar un formulario para crear una nueva incidencia
     */
    public function create()
    {
        $categories = Category::where("project_id", auth()->user()->selected_project_id)->get();
        $levels = Level::where("project_id", auth()->user()->selected_project_id)
            ->orderBy('difficulty')->get();
        return view("incidents.create", compact("categories", "levels"));
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Funcion encargada de almacenar una nueva incidencia
     * 
     * @param Request $request Contiene los datos de la nueva incidencia
     */
    public function store(Request $request)
    {

        $this->validate($request, Incident::$rules, Incident::$messages);

        // Se comprueba si tiene archivo adjunto y en caso de tener se almacena
        $url = $this->saveAttachment($request);

        $user = User::findOrFail(auth()->user()->id);
        $incident = new Incident();
        $incident->category_id = $request->category_id != null ? $request->category_id : null;
        $incident->severity = $request->severity;
        $incident->title = $request->title;
        $incident->description = $request->description;
        $incident->client_id = $user->id;
        $incident->project_id = $user->selected_project_id;
        $incident->level_id = $request->level_id != null ? $request->level_id : null;
        $incident->attached_file = $url != null ? $url : null;
        $incident->save();

        return back()->with("notification", "Incidencia registrada exitosamente.");
    }

    /**
     * Si la incidencia contiene un archivo adjunto este se almacena
     * 
     * @param Request $request Contiene los datos de la incidencia
     * @return null Si no se almacena archivo adjunto
     * @return String String con la Url del archivo adjunto si existe
     */
    private function saveAttachment(Request $request)
    {
        if ($request->file("adjunto") != null) {

            $incidentId = Incident::all()->last();
            $incidentId = $incidentId != null ? $incidentId->id + 1 : 1;

            $user = User::findOrFail(auth()->user()->id);

            $projectId = Project::findOrFail($user->selected_project_id);
            if ($projectId == null) {
                return null;
            }
            $projectId = $projectId->id;

            $categoryId = $request->category_id != null ? $request->category_id : 0;

            // Parte en local //
            $url = $this->saveAttachmentLocally($request, $projectId, $categoryId, $incidentId);
            // Fin parte local //

            // Parte para InfinityFree //
            // $url = $this->saveAttachmentInfinityFree($projectId,$categoryId,$incidentId);
            //Fin infinityfree //

            return $url;
        }
        return null;
    }

    /**
     * Almacena el archivo adjunto en el servidor local y retorna la url del archivo adjunto.
     * 
     * @param Request $request Contiene el archivo adjunto
     * @param Integer $projectId Id del proyecto de la incidencia
     * @param Integer $categoryId Id de la categoria de la incidencia
     * @param Integer $incidentId Id de la incidencia
     */
    private function saveAttachmentLocally(Request $request, $projectId, $categoryId, $incidentId)
    {
        $adjunto = $request->file("adjunto")->storeAs(
            "public/Project-$projectId/Category-$categoryId/Year-" . date("Y") . "/Month-" . date("m") . "/Day-" . date("d") . "/Incident-Id-$incidentId/attached-file",
            $request->file("adjunto")->getClientOriginalName()
        );
        $url = Storage::url($adjunto);

        return $url;
    }

    /**
     * Almacena el archivo adjunto en el servidor de infinity free y retorna la url del archivo adjunto.
     * 
     * @param Integer $projectId Id del proyecto de la incidencia
     * @param Integer $categoryId Id de la categoria de la incidencia
     * @param Integer $incidentId Id de la incidencia
     */
    private function saveAttachmentInfinityFree($projectId, $categoryId, $incidentId)
    {
        $path = "storage/Project-$projectId/Category-$categoryId/Year-" . date("Y") . "/Month-" . date("m") . "/Day-" . date("d") . "/Incident-Id-$incidentId/attached-file";

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        move_uploaded_file($_FILES["adjunto"]["tmp_name"], $path . "/" . $_FILES["adjunto"]["name"]);

        $url = "/" . $path . "/" . $_FILES["adjunto"]["name"];

        return $url;
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Carga la vista para editar una incidencia
     * 
     * @param Integer $id Id de la incidencia a editar
     */
    public function edit($id)
    {
        $incident = Incident::findOrFail($id);

        // Si la intenta editar un usuario que no la ha creado
        if ($incident->client_id != auth()->user()->id) {
            return redirect("home");
        }

        $categories = $incident->project->categories;
        $levels = $incident->project->levels;
        return view("incidents.edit", compact("incident", "categories", "levels"));
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Actualizar los datos de una incidencia
     * 
     * @param Request $request Contiene los nuevos datos de la incidencia
     * @param Integer $id Id de la incidencia a editar
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, Incident::$rules, Incident::$messages);

        $incident = Incident::findOrFail($id);


        // Si tiene un archivo adjunto
        $url = $this->updateAttachment($request, $incident);

        $incident->level_id = $request->level_id ? $request->level_id : null;
        $incident->category_id = $request->category_id ? $request->category_id : null;
        $incident->severity = $request->severity;
        $incident->title = $request->title;
        $incident->description = $request->description;
        $incident->attached_file = $url != null ? $url : $incident->attached_file;
        $incident->save();

        // Si se ha cambiado el nivel a uno distinto de general se elimina al usuario de soporte
        $this->removeSupportUserIfLevelHasBeenChangedToSomethingOtherThanGeneral($incident);

        return redirect("/incidencia/ver/$id")->with("notification", "Incidencia modificada exitosamente.");
    }

    /**
     * Si se edita el archivo adjunto de la incidencia
     * 
     * @param Request $request Contiene los datos de la incidencia
     * @param Incident $incident Incidencia a editar
     * @return null Si no se almacena archivo adjunto
     * @return String String con la Url del archivo adjunto si existe
     */
    private function updateAttachment(Request $request, Incident $incident)
    {
        if ($request->file("adjunto") != null) {
            $incidentId = $incident->id;

            $projectId = Project::findOrFail($incident->project_id)->id;

            $categoryId = $incident->category_id != null ? $incident->category_id : 0;

            // Si antes tenia un archivo adjunto se elimina y se guarda el nuevo
            // Parte local //
            $url = $this->updateAttachmentLocally($incident, $request, $projectId, $categoryId, $incidentId);
            // Fin parte local //

            // Inicio para infinityfree //
            // $url = $this->updateAttachmentInfinityFree($incident, $projectId, $categoryId, $incidentId);
            //FIn infinityfree //

            return $url;
        }
        return null;
    }

    /**
     * Actualiza el fichero adjunto en el servidor local de la incidencia si se envia uno nuevo
     * 
     * @param Incident $incident Incidencia la cual se va a editar
     * @param Request $request Contiene los nuevos datos de la incidencia
     * @param Integer $projectId Id del proyecto
     * @param Integer $categoryId Id de la categoria
     * @param Integer $incidentId Id de la incidencia
     */
    private function updateAttachmentLocally(Incident $incident, Request $request, $projectId, $categoryId, $incidentId)
    {
        if ($incident->attached_file != null) {
            $publicRoute = $incident->file_public_path;
            if (Storage::exists($publicRoute))
                Storage::delete($publicRoute);
        }

        $adjunto = $request->file("adjunto")->storeAs(
            "public/Project-$projectId/Category-$categoryId/Year-" . date("Y") . "/Month-" . date("m") . "/Day-" . date("d") . "/Incident-Id-$incidentId/attached-file",
            $request->file("adjunto")->getClientOriginalName()
        );

        $url = Storage::url($adjunto);

        return $url;
    }

    /**
     * Actualiza el fichero adjunto de la servidor infinity free incidencia si se envia uno nuevo
     * 
     * @param Incident $incident Incidencia la cual se va a editar
     * @param Integer $projectId Id del proyecto
     * @param Integer $categoryId Id de la categoria
     * @param Integer $incidentId Id de la incidencia
     */
    private function updateAttachmentInfinityFree(Incident $incident, $projectId, $categoryId, $incidentId)
    {
        if ($incident->attached_file != null) {
            if (file_exists(substr($incident->attached_file, 1)))
                unlink(substr($incident->attached_file, 1));
        }

        $path = "storage/Project-$projectId/Category-$categoryId/Year-" . date("Y") . "/Month-" . date("m") . "/Day-" . date("d")      . "/Incident-Id-$incidentId/attached-file";

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        move_uploaded_file($_FILES["adjunto"]["tmp_name"], $path . "/" . $_FILES["adjunto"]["name"]);

        $url = "/" . $path . "/" . $_FILES["adjunto"]["name"];

        return $url;
    }

    /**
     * Si se ha cambiado el nivel a uno distinto de general se elimina al usuario de soporte si este no 
     * tiene el rol de administrador
     * 
     * @param Incident $incident Incidencia a editar
     */
    private function removeSupportUserIfLevelHasBeenChangedToSomethingOtherThanGeneral(Incident $incident)
    {
        if ($incident->level_id != null && $incident->support_id != null) {
            $user = User::findOrFail($incident->support_id);

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
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Atender incidencia
     * 
     * @param Integer $id Id de la incidencia a atender
     * @param Request $request Contiene los datos usados para atender la incidencia
     */
    public function take($id, Request $request)
    {

        $incident = Incident::findOrFail($id);
        $user = User::findOrFail(auth()->user()->id);

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
        if ($project_user == null) {
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

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Desatender incidencia
     * 
     * @param Integer $id Id de la incidencia a desatender
     * @param Request $request Contiene los datos para desatender la incidencia
     */
    public function disregard($id, Request $request)
    {

        $incident = Incident::findOrFail($id);
        $user = User::findOrFail(auth()->user()->id);

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

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Marcar incidencia como resuelta
     * 
     * @param Integer $id Id de la incidencia a marcar como resuelta
     * @param Request $request Datos usados para marcar la incidencia como resuelta
     */
    public function solve($id, Request $request)
    {
        $incident = Incident::findOrFail($id);

        // El usuario que la resuelve no es el que la publico
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

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Abrir incidencia
     * 
     * @param Integer $id Id de la incidencia
     * @param Request $request Datos usados para abrir la incidencia
     */
    public function open($id, Request $request)
    {
        $incident = Incident::findOrFail($id);

        // El usuario que la abre no es el mismo que la publico
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

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Enviar al siguiente nivel la incidencia
     * 
     * @param Integer $id Id de la incidencia a pasar al siguiente nivel
     * @param Request $request Datos usados para pasar la incidencia al siguiente nivel
     */
    public function nextLevel($id, Request $request)
    {

        $incident = Incident::findOrFail($id);
        $level = Level::find($incident->level_id);

        // Si el nivel de la incidencia es general se le asigna el primer nivel del proyecto
        if ($level == null) {
            $nextLevel = Level::where("project_id", $incident->project->id)->orderBy('difficulty')->first();
        } else { // Se le asigna la siguiente nivel
            $nextLevel = $level->next_level;
        }

        if ($nextLevel != null) {
            $incident->level_id = $nextLevel->id;

            $user = User::findOrFail($incident->support_id);
            // Si el usuario que la atiende es de soporte, se elimina el usuario que atiende la incidencia
            if ($user != null) {
                if ($user->is_support) {
                    $incident->support_id = null;
                }
            }

            $incident->save();

            // Si el usuario que la ha derivado al siguiente nivel le enviamos la ruta de home
            // para que nos rediriga alli, ya que el usuario no tendria permiso para ver las
            // incidencias del siguiente nivel
            if(auth()->user()->is_support){
                $redirect = route("home");
            } else {
                $redirect = null;
            }

            if ($request->ajax()) {
                return response()->json([
                    "head" => "¡Correcto!",
                    "message" => "Incidencia derivada al siguiente nivel.",
                    "type" => "success",
                    "redirect" => $redirect
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
