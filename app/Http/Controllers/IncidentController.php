<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Incident;
use App\Models\Level;
use App\Models\Project;
use App\Models\ProjectUser;
use Illuminate\Http\Request;

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

    public function show($id){
        $incident = Incident::findOrFail($id);
        $messages = $incident->messages;
        return view("incidents.show", compact("incident","messages"));
    }

    public function create(){
        $categories = Category::where("project_id",auth()->user()->selected_project_id)->get();
        $levels = Level::where("project_id",auth()->user()->selected_project_id)->get();
        return view("incidents.create",compact("categories","levels"));
    }

    public function store(Request $request){
        $this->validate($request, Incident::$rules, Incident::$messages);
        
        $user = auth()->user();
        $incident = new Incident();
        $incident->category_id = $request->category_id ?: null;
        $incident->severity = $request->severity;
        $incident->title = $request->title;
        $incident->description = $request->description;
        $incident->client_id = $user->id;
        $incident->project_id = $user->selected_project_id;
        $incident->level_id = $request->level_id ?: null;
        $incident->save();

        return back()->with("notification","Incidencia registrada exitosamente.");
    }
    
    /**
     * Editar incidencia
     */
    public function edit($id){
        $incident = Incident::findOrFail($id);
        $categories = $incident->project->categories;
        return view("incidents.edit",compact("incident","categories"));
        
    }

    /**
     * Actualizar incidencia
     */
    public function update(Request $request, $id){

        $this->validate($request, Incident::$rules, Incident::$messages);
        
        $incident = Incident::findOrFail($id);

        if($request->level_id)
            $incident->level_id = $request->level_id;

        $incident->category_id = $request->category_id ?: null;
        $incident->severity = $request->severity;
        $incident->title = $request->title;
        $incident->description = $request->description;
        $incident->save();

        return redirect("/incidencia/ver/$id")->with("notification","Incidencia modificada exitosamente.");

    }

    /**
     * Atender incidencia
     */
    public function take($id){

        $incident = Incident::findOrFail($id);
        $user = auth()->user();

        // Si es administrador no se comprueba el nivel o el proyecto
        if($user->is_admin){
            $incident->support_id = $user->id;
            $incident->save();
    
            return back()->with("notification","Incidencia atendida");
        }

        // Si usuario no es de soporte
        if(! $user->is_support){
            return back();
        }

        $project_user = ProjectUser::where("project_id",$incident->project_id)
            ->where("user_id",$user->id)->first();

        // Si la incidencia no proyecto de la incidencia
        if(! $project_user){
            return back();
        }

        // Si el nivel de la incidencia no es el mismo que el del usuario
        if($project_user->level_id != $incident->level_id){
            return back();
        }

        $incident->support_id = $user->id;
        $incident->save();

        return back()->with("notification","Incidencia atendida");
    }

    /**
     * Desatender incidencia
     */
    public function disregard($id){

        $incident = Incident::findOrFail($id);
        $user = auth()->user();

        //Si es administrador no se comprueba el nivel o el proyecto
        if($user->is_admin){
            $incident->support_id = null;
            $incident->save();
    
            return back()->with("notification","Incidencia desatendida");
        }

        if($incident->support_id != $user->id){
            return back();
        }
        $incident->support_id = null;
        $incident->save();

        return back()->with("notification","Incidencia atendida");
    }

    /**
     * Marcar incidencia como resuelta
     */
    public function solve($id){
        $incident = Incident::findOrFail($id);

        // El usuario que la resuelve es el mismo que la publico
        if($incident->client_id != auth()->user()->id){
            return back();
        }

        $incident->active = 0;
        $incident->save();
        return back()->with("notification","Incidencia resuelta");
    }

    /**
     * Abrir incidencia
     */
    public function open($id){
        $incident = Incident::findOrFail($id);

        // El usuario que la abre es el mismo que la publico
        if($incident->client_id != auth()->user()->id){
            return back();
        }

        $incident->active = 1;
        $incident->save();
        return back()->with("notification","Incidencia abierta");
    
    }

    /**
     * Enviar al siguiente nivel la incidencia
     */
    public function nextLevel($id,Request $request){
        
        $incident = Incident::findOrFail($id);        
        $level = Level::find($incident->level_id);

        if(!$level){
            $nextLevel = Level::where("project_id",$incident->project->id)->orderBy('difficulty')->first();
        }else{
            $nextLevel = $level->next_level;
        }

        if($nextLevel){
            $incident->level_id = $nextLevel->id;
            $incident->support_id = null;
            $incident->save();

            if($request->ajax()){
                return response()->json([
                    "head" => "¡Correcto!",
                    "message" => "Incidencia derivada al siguiente nivel.",
                    "type" => "success",
                    ]);
            }

            return back()->with("notification","Incidencia derivada al siguiente nivel");
        }

        if($request->ajax()){
            return response()->json([
                "head" => "¡Error!",
                "message" => "No es posible derivar porque no hay un siguiente nivel",
                "type" => "error",
                ]);
        }
        return back()->with("notification","No es posible derivar porque no hay un siguiente nivel");
    }

}
