<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Incident;
use App\Models\Project;
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
}
