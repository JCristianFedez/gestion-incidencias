<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\Level;
use App\Models\ProjectUser;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function store(Request $request){
        $rules = [
            'name' => ["required","min:5","max:255"],
            'project_id' => ["required","exists:projects,id"],
            'difficulty' => ["required"]
        ];
    
        $messages = [
            'name.required' => 'Es necesario ingresar un nombre para el nivel.',
            'name.min' => 'El nivel necesita un minimo de 5 caracteres.',
            'name.max' => 'El nivel no puede tener mas de 255 caracteres.',  
            'difficulty.required' => 'Es necesario ingresar un nivel de dificultad.',
        ];

        $this->validate($request, $rules, $messages);

        if(Level::where("project_id",$request->project_id)->where("name",$request->name)->first()){
            return back()->with('notificationError', 'El proyecto ya tiene un nivel con ese nombre.');
        }


        // Update the level of difficulty of the later levels
        $nextsLevels = Level::where("project_id",$request->project_id)
        ->where("difficulty",">=",$request->difficulty)->orderBy('difficulty')->get();

        for ($i = (count($nextsLevels) - 1); $i >= 0; $i--) { 
            $nextsLevels[$i]->difficulty++;
            $nextsLevels[$i]->save();
        }

        Level::create($request->all());

        return back()->with('notification', 'El nivel se ha creado correctamente.');
    }

    public function update(Request $request){
        $rules = [
            'name' => ["required","min:5","max:255"],
            'level_id' => ["required","exists:levels,id"],
            'difficulty' => ["required"]
        ];
    
        $messages = [
            'name.required' => 'Es necesario ingresar un nombre para el nivel.',
            'name.min' => 'El nivel necesita un minimo de 5 caracteres.',
            'name.max' => 'El nivel no puede tener mas de 255 caracteres.',  
            'level.required' => 'Es necesario ingresar un nivel de dificultad.',
        ];

        $this->validate($request, $rules, $messages);
        
        $level = Level::find($request->level_id);

        //It is verified that there is not a level with the same name in the same project
        if((Level::where("project_id",$level->project_id)->where("name",$request->name)->first()) &&
        $level->difficulty == $request->difficulty){
            if($request->ajax()){
                return response()->json([
                    "head" => "¡Error!",
                    "message" => "El proyecto ya tiene un nivel con ese nombre",
                    "type" => "error",
                    ]);
            }

            return back()->with('notificationError', 'El proyecto ya tiene un nivel con ese nombre.');
        }

        
        if($level->difficulty != $request->difficulty){
            // Arranged the difficulty of the levels between the current difficulty of the level and the later one
            if($request->difficulty > $level->difficulty){
                $prevLevels = Level::where("project_id",$level->project_id)->where("difficulty",">",$level->difficulty)
                ->where("difficulty","<=",$request->difficulty)->orderBy('difficulty')->get();
                

                $level->difficulty = -1;
                $level->save();
    
                for ($i=0; $i < count($prevLevels); $i++) { 
                    $prevLevels[$i]->difficulty--;
                    $prevLevels[$i]->save();
                }
            }else{
                $prevLevels = Level::where("project_id",$level->project_id)->where("difficulty","<",$level->difficulty)
                ->where("difficulty",">=",$request->difficulty)->orderBy('difficulty')->get();
    

                $level->difficulty = -1;
                $level->save();

                for ($i = (count($prevLevels) - 1); $i >= 0; $i--) { 
                    $prevLevels[$i]->difficulty++;
                    $prevLevels[$i]->save();
                }
            }
            
        }

        $level->name = $request->name;
        $level->difficulty = $request->difficulty;
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

    public function destroy($id, Request $request){
        $level = Level::find($id);
        $project = $level->project;
        $difficulty = $level->difficulty;

        $incidents = Incident::where("level_id",$id)->get();

        // If there are incidents assigned at this level, they will try to go first 
        // to the next level, if it is not possible to the previous one and if neither 
        // can the general
        if($incidents){
            if($level->next_level){
                for ($i=0; $i < count($incidents); $i++) { 
                    $incidents[$i]->level_id = $level->next_level->id;
                    $incidents[$i]->save();
                }

            }else if($level->previous_level){
                for ($i=0; $i < count($incidents); $i++) { 
                    $incidents[$i]->level_id = $level->previous_level->id;
                    $incidents[$i]->save();
                }

            }else{
                for ($i=0; $i < count($incidents); $i++) { 
                    $incidents[$i]->level_id = null;
                    $incidents[$i]->save();
                }
            }
        }
        $level->forceDelete();
        ProjectUser::where("level_id",$id)->delete();

         // Update the level of difficulty of the later levels
        $nextsLevels = Level::where("project_id",$project->id)
        ->where("difficulty",">",$difficulty)->orderBy('difficulty')->get();

        for ($i = 0; $i < count($nextsLevels); $i++) { 
            $nextsLevels[$i]->difficulty--;
            $nextsLevels[$i]->save();
        }

        if($request->ajax()){
            return response()->json([
                "head" => "¡Correcto!",
                "message" => "El nivel se ha eliminado correctamente.",
                "type" => "success",
                ]);
        }

        return back()->with('notification', 'El nivel se ha eliminado correctamente.');
    }

    // Mi pequeño api
    public function byProject($id){
        return Level::where("project_id",$id)->get();
    }
}
