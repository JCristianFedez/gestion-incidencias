<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class DatatableController extends Controller
{
    /**
     * Usado para la tabla de todos los usuarios
     */
    public function users(){
        
        $users = User::all();

        return DataTables::of($users)
        ->addColumn('opciones', 'datatables.users.IndexOptions')
        ->rawColumns(['opciones'])
        ->editColumn('role', function ($users) {
            return $users->role_name;
        })->editColumn('created_at', function ($users) {
            return $users->created_at->format('d/m/Y');
        })
        ->make(true);
    }

    /**
     * Usado para la tabla de todos los proyectos
     */
    public function projects(){

        $projects = Project::withTrashed();

        return DataTables::of($projects)
        ->addColumn('opciones', 'datatables.projects.IndexOptions')
        ->rawColumns(['opciones'])
        ->editColumn('status', function($projects){
            return $projects->status;
        })->make(true);

    }

    /**
     * Usado para la tabla de las incidencias asignadas a mi
     */
    public function incidentsByMe(){
        $user = auth()->user();
        $selected_project_id =$user->selected_project_id;
        
        if ($selected_project_id) {

            $incidents_by_me = Incident::where('project_id', $selected_project_id)->where('support_id', $user->id)->get();

        } else {
            $incidents_by_me = [];
        }


        return DataTables::of($incidents_by_me)
        ->addColumn('options', 'datatables.dashboard.incidentsByMeOptions')
        ->addColumn('category', function($incident){
            return $incident->category_name;
        })->addColumn('status', function($incident){
            return $incident->state;
        })
        ->rawColumns(['options','category','status'])
        ->editColumn('severity', function($incident){
            return $incident->severity_full;
        })->editColumn('created_at', function($incident){
            return $incident->created_at->format('d/m/Y');
        })->editColumn('title', function($incident){
            return $incident->title_short;
        })
        ->make(true);
    }

    /**
     * Usado para la tabla de mis incidencias
     */
    public function myIncidents(){
        $user = auth()->user();
        $selected_project_id =$user->selected_project_id;
        
        if ($selected_project_id) {
            $my_incidents = Incident::where('client_id', $user->id)
            ->where('project_id', $selected_project_id)->get();
        } else {
            $my_incidents = [];
        }

        return DataTables::of($my_incidents)
        ->addColumn('options', 'datatables.dashboard.myIncidentsOptions')
        ->addColumn('category', function($incident){
            return $incident->category_name;
        })->addColumn('status', function($incident){
            return $incident->state;
        })->addColumn('supportName', function($incident){
            return $incident->support_name ?: "Sin asignar";
        })
        ->rawColumns(['options','category','status','supportName'])
        ->editColumn('severity', function($incident){
            return $incident->severity_full;
        })->editColumn('created_at', function($incident){
            return $incident->created_at->format('d/m/Y');
        })->editColumn('title', function($incident){
            return $incident->title_short;
        })
        ->make(true);
    }

    /**
     * Usado para la tala de incidencias pendientes
     */
    public function pendingIncidents(){
        $user = auth()->user();
        $selected_project_id =$user->selected_project_id;
        

        if ($selected_project_id) {

            if ($user->is_support || $user->is_admin) {

                // Si es admin puede ver todas las incidencias
                if($user->is_admin){
                    $pending_incidents = Incident::where('support_id', null)->
                    where('project_id', $selected_project_id)->get();

                }else{// Si es de soporte solo puede atender incidencias de su proyecto y nivel
                    $projectUser = ProjectUser::where('project_id', $selected_project_id)->where('user_id', $user->id)->first();
                    if ($projectUser) {
                        $pending_incidents = Incident::where('support_id', null)->where('level_id', $projectUser->level_id)->get();
                    } else {
                        $pending_incidents = collect(); // Vacio cuando no project associated
                    }
                }
            }
        
        } else {
            $pending_incidents = [];
        }

        return DataTables::of($pending_incidents)
        ->addColumn('options', 'datatables.dashboard.pendingIncidentsOptions')
        ->addColumn('category', function($incident){
            return $incident->category_name;
        })->addColumn('status', function($incident){
            return $incident->state;
        })
        ->rawColumns(['options','category','status'])
        ->editColumn('severity', function($incident){
            return $incident->severity_full;
        })->editColumn('created_at', function($incident){
            return $incident->created_at->format('d/m/Y');
        })->editColumn('title', function($incident){
            return $incident->title_short;
        })
        ->make(true);
    }
}
