<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\Project;
use App\Models\ProjectUser;
use Illuminate\Http\Request;

class ProjectUserController extends Controller
{
    public function store(Request $request){
        
        $rules = [
            'project_id' => ['required', 'exists:projects,id'],
            'level_id' => ['required', 'exists:levels,id'],
            'user_id' => ['required', 'exists:users,id']
        ];

        $messages = [
            'project_id.required' => 'Es necesario seleccionar el proyecto.',
            'level_id.required' => 'Es necesario seleccionar el nivel.'
        ];

        $this->validate($request, $rules, $messages);
        
        // Si hay un usuario malicioso e intenta enlacar un proyecto con un nivel que no le corresponde
        $level = Level::find($request->level_id);
        if($level->project_id != $request->project_id){
            return back();
        }

        // Comprobamos que el usuario no pertenezca ya al proyecto
        $project_user = ProjectUser::where("project_id", $request->project_id)
            ->where("user_id",$request->user_id)->first();

        if($project_user){
            return back()->with("notification", "El usuario ya pertenece a este proyecto.");
        }

        $project_user = new ProjectUser();
        $project_user->project_id = $request->project_id;
        $project_user->user_id = $request->user_id;
        $project_user->level_id = $request->level_id;
        $project_user->save();

        return back();
    }

    public function update(Request $request){
        
        $rules = [
            'project_id' => ['required', 'exists:projects,id'],
            'level_id' => ['required', 'exists:levels,id'],
            'user_id' => ['required', 'exists:users,id'],
            'project_user_id' => ['required', 'exists:project_user,id']
        ];

        $messages = [
            'level_id.required' => 'Es necesario seleccionar el nivel.'
        ];

        $this->validate($request, $rules, $messages);
        
        // Si hay un usuario malicioso e intenta enlacar un proyecto con un nivel que no le corresponde
        $level = Level::find($request->level_id);
        if($level->project_id != $request->project_id){
            return back();
        }

        $project_user = ProjectUser::find($request->project_user_id);
        $project_user->project_id = $request->project_id;
        $project_user->user_id = $request->user_id;
        $project_user->level_id = $request->level_id;
        $project_user->save();

        return back()->with("notification", "Relacion actualizada.");
    }


    public function destroy($id){
        ProjectUser::find($id)->delete();
        return back()->with("notification", "Relacion eliminada.");
    }
}
