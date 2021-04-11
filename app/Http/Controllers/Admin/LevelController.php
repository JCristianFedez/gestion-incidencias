<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function store(Request $request){
        $rules = [
            'name' => ["required","min:5","max:255"],
            'project_id' => ["required","exists:projects,id"]
        ];
    
        $messages = [
            'name.required' => 'Es necesario ingresar un nombre para el nivel.',
            'name.min' => 'El nivel necesita un minimo de 5 caracteres.',
            'name.max' => 'El nivel no puede tener mas de 255 caracteres.',  
        ];

        $this->validate($request, $rules, $messages);

        if(Level::where("project_id",$request->project_id)->where("name",$request->name)->first()){
            return back()->with('notificationError', 'El proyecto ya tiene un nivel con ese nombre.');
        }

        Level::create($request->all());

        return back()->with('notification', 'El nivel se ha creado correctamente.');
    }

    public function update(Request $request){
        $rules = [
            'name' => ["required","min:5","max:255"],
            'level_id' => ["required","exists:levels,id"]
        ];
    
        $messages = [
            'name.required' => 'Es necesario ingresar un nombre para el nivel.',
            'name.min' => 'El nivel necesita un minimo de 5 caracteres.',
            'name.max' => 'El nivel no puede tener mas de 255 caracteres.',
        ];

        $this->validate($request, $rules, $messages);
        
        $level = Level::find($request->level_id);

        //It is verified that there is not a level with the same name in the same project
        if(Level::where("project_id",$level->project_id)->where("name",$request->name)->first()){
            if($request->ajax()){
                return response()->json([
                    "head" => "¡Error!",
                    "message" => "El proyecto ya tiene un nivel con ese nombre",
                    "type" => "error",
                    ]);
            }

            return back()->with('notificationError', 'El proyecto ya tiene un nivel con ese nombre.');
        }

        $level->name = $request->name;
        $level->save();

        if($request->ajax()){
            return response()->json([
                "head" => "¡Correcto!",
                "message" => "El nivel se ha actualizado correctamente.",
                "type" => "success",
                ]);
        }

        return back()->with('notification', 'El nivel se ha actualizado correctamente.');
    }

    public function destroy($id){

        Level::find($id)->delete();
        return back()->with('notification', 'El nivel se ha eliminado correctamente.');
    }

    // Mi pequeño api
    public function byProject($id){
        return Level::where("project_id",$id)->get();
    }
}
