<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Incident;
use App\Models\ProjectUser;
use App\Models\User;
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

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Funcion encargada de cargar la vista del dashboard
     */
    public function index()
    {        
        return view("home");
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Funcion encargada de seleccionar un proyecto (Selector del menu superior)
     */
    public function selectProject($id){
        // Validar que el usuario esta asociado con el proyecto

        $user = User::find(auth()->user()->id);

        // Usuario de soporte solo puede acceder a los proyectos que tenga asignados
        if($user->projects->find($id) == null && $user->is_support){
            return back();
        }

        $user->selected_project_id = $id;
        $user->save();

        return back();
    }

}
