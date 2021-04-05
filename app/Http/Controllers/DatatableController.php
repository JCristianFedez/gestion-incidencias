<?php

namespace App\Http\Controllers;

use App\Models\Project;
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
}
