<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectUser;
use Illuminate\Http\Request;

class ProjectUserController extends Controller
{
    public function store(Request $request){
        
        // Asegurarnos de que:
        // El nivel preteneze al proyecto
        // El proyecto existe
        // El nivel existe
        // El usuario existe
        
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


    public function destroy($id){
        ProjectUser::find($id)->delete();
        return back()->with("notification", "Relacion eliminada.");
    }
}
