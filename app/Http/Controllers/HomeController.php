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
        

        if ($selected_project_id) {

            if ($user->is_support || $user->is_admin) {
                $my_incidents = Incident::where('project_id', $selected_project_id)->where('support_id', $user->id)->get();


                // Si es admin puede ver todas las incidencias
                if($user->is_admin){
                    $pending_incidents = Incident::where('support_id', null)->get();

                }else{// Si es de soporte solo puede atender incidencias de su proyecto y nivel
                    $projectUser = ProjectUser::where('project_id', $selected_project_id)->where('user_id', $user->id)->first();
                    if ($projectUser) {
                        $pending_incidents = Incident::where('support_id', null)->where('level_id', $projectUser->level_id)->get();
                    } else {
                        $pending_incidents = collect(); // Vacio cuando no project associated
                    }
                }
            }

            $incidents_by_me = Incident::where('client_id', $user->id)
                                        ->where('project_id', $selected_project_id)->get();
            
            if($user->is_client){
                return view('home',compact("incidents_by_me"));
            }
        
        } else {
            $pending_incidents = [];
            $incidents_by_me = [];
            $my_incidents = [];
        }

        return view('home',compact("my_incidents","pending_incidents","incidents_by_me"));
    }

    public function selectProject($id){
        // Validar que el usuario esta asociado con el proyecto

        $user = auth()->user();
        
        // Usuario de soporte solo puede acceder a los proyectos que tenga asignados
        if(! $user->projects->find($id) && $user->is_support){
            return back();
        }

        $user->selected_project_id = $id;
        $user->save();

        return back();
    }

}
