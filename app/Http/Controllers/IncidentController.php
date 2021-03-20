<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Incident;
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
        return view("incidents.show", compact("incident"));
    }

    public function create(){
        $categories = Category::where("project_id",1)->get();
        return view("incidents.create",compact("categories"));
    }

    public function store(Request $request){
        
        $rules = [
            "category_id" => ["nullable","exists:categories,id"],
            "severity" => ["required","in:M,N,A"],
            "title" => ["required","min:5"],
            "description" => ["required","min:15"]
        ];

        $messages = [
            "category_id.exists" => "La categoria seleccionada no existe en nuestra base de datos.",
            "title.required" => "Es necesario ingresar un título para la incidencia.",
            "title.min" => "El título debe presentar al menos 5 caracteres.",
            "description.required" => "Es necesario ingresar una descripción para la incidencia.",
            "description.min" => "La descripción debe presentar al menos 15 caracteres."
        ];

        $this->validate($request, $rules, $messages);
        $user = auth()->user();
        $incident = new Incident();
        $incident->category_id = $request->category_id ?: null;
        $incident->severity = $request->severity;
        $incident->title = $request->title;
        $incident->description = $request->description;
        $incident->client_id = $user->id;
        $incident->project_id = $user->selected_project_id;
        $incident->level_id = Project::find($user->selected_project_id)->first_level_id;
        $incident->save();

        return back()->with("notification","Incidencia registrada exitosamente.");
    }
    
    /**
     * Atender incidencia
     */
    public function take($id){

        $incident = Incident::findOrFail($id);
        $user = auth()->user();

        // Si usuario no es soporte
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
     * Editar incidencia
     */
    public function edit($id){
        $incident = Incident::findOrFail($id);

        
    }

    /**
     * Enviar al siguiente nivel la incidencia
     */
    public function nextLevel($id){
        $incident = Incident::findOrFail($id);
        $level_id = $incident->level_id;

        $project = $incident->project;
        $levels = $project->levels;

        $next_level_id = $this->getNextLevelId($level_id, $levels);
    
        if($next_level_id){
            $incident->level_id = $next_level_id;
            $incident->save();
            return back()->with("notification","Incidencia pasada al siguiente nivel");
        }

        return back()->with("notification","No es posible derivar porque no hay un siguiente nivel");
    }

    public function getNextLevelId($level_id, $levels){
        if(sizeof($levels) <= 1){
            return null;
        }

        $position = -1;
        for ($i=0; $i < sizeof($levels); $i++) { 
            if($levels[$i]->id == $level_id){
                $position = $i;
                break;
            }
        }

        if($position == -1){
            return null;
        }

        if($position == sizeof($levels)-1){
            return null;
        }

        return $levels[$position+1]->id;

    }
}
