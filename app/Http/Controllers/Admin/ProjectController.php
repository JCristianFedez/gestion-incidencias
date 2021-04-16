<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Level;
use App\Models\Project;
use App\Models\ProjectUser;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request){

        return view("admin.projects.index");
    }

    public function store(Request $request){
        $this->validate($request, Project::$rules, Project::$messages);
        
        Project::create($request->all());

        return back()->with('notification', 'El proyecto se ha registrado correctamente.');
    }

    public function edit($id){
        $project = Project::find($id);
        $categories =  $project->categories; //Category::where("project_id",$id)->get();
        $levels = $project->levels;  //Level::where("project_id",$id)->get();
        return view("admin.projects.edit", compact("project","categories", "levels"));
    }

    public function update(Request $request, $id){
        $this->validate($request, Project::$rules, Project::$messages);

        Project::find($id)->update($request->all());
        return back()->with('notification', 'El proyecto se ha actualizado correctamente.');
    }

    public function destroy($id){
        Project::find($id)->delete();
        ProjectUser::where("project_id",$id)->delete();
        return back()->with('notification', 'El proyecto se ha deshabilitado correctamente.');
    }

    public function forceDestroy($id){
        Project::withTrashed()->findOrFail($id)->forceDelete();

        return back()->with("notification","Proyecto eliminado completametnte exitosamente.");
	}

    public function restore($id){
        Project::withTrashed()->find($id)->restore();
        ProjectUser::withTrashed("project_id",$id)->restore();

        return back()->with('notification', 'El proyecto se ha habilitado correctamente.');
    }


}
