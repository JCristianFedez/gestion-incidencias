<?php

namespace App\Http\Controllers;

use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class DatatableController extends Controller
{
    public function users(){
        
        $users = User::all();

        return DataTables::of($users)
        ->addColumn('opciones', 'datatables.user.options')
        ->rawColumns(['opciones'])
        ->editColumn('role', function ($users) {
            return $users->role_name;
        })->editColumn('created_at', function ($users) {
            return $users->created_at->format('d/m/Y');
        })
        ->make(true);
    }
}
