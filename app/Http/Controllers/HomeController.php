<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Incident;
use App\Models\ProjectUser;
use Illuminate\Http\Request;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        $selected_project_id =$user->selected_project_id;
        

        if($user->is_support){
            // dashboard table: Incidencias asignadas a mí
            $my_incidents = Incident::where("project_id",$selected_project_id)
                ->where("support_id", $user->id)
                ->get();

            // dashboard table: Incidencias sin asignar
            $projectUser = ProjectUser::where("project_id",$selected_project_id)
                ->where("user_id",$user->id)->first();

            $pending_incidents = Incident::where("support_id",null)
                ->where("level_id",$projectUser->level_id)
                ->get();
        }
        

        // Dashboard table: Incidencias asignadas por mi
        $incidents_by_me = Incident::where("client_id",$user->id)
            ->where("project_id",$selected_project_id)->get();
        
        
        if($user->is_client){
            return view('home',compact("incidents_by_me"));
        }

        return view('home',compact("my_incidents","pending_incidents","incidents_by_me"));
    }

    public function selectProject($id){
        // Validar que el usuario esta asociado con el proyecto

        $user = auth()->user();
        $user->selected_project_id = $id;
        $user->save();

        return back();
    }

}
