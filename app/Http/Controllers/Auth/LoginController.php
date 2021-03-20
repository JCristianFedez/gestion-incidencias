<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Le doy un projecto seleccionado a los support por defecto si 
     * no lo tienen
     */
    public function authenticated(){
        $user = auth()->user();

        // user don't have a selected_project
        if(! $user->selected_project_id){
            // Admin and client
            if ($user->is_admin || $user->is_client){
                $user->selected_project_id = Project::first()->id;

            }else{
                // support
                // Y si el usuario de soporte no esta asignado a ningun proyecto
                $user->selected_project_id = $user->projects->first()->id;
            }
            $user->save();   
        }
        
    }
}
