<?php

namespace App\Http\Controllers;

use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class DatatableController extends Controller
{
    public function users(){
        
        $user = User::all();

        return DataTables::of($user)
        ->addColumn('opciones', 'datatables.user.options')
        ->rawColumns(['opciones'])
        ->editColumn('role', function ($users) {
            return $users->role_name;
        })->make(true);
    }
}
