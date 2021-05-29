<?php

namespace Illuminate\Foundation\Auth;

use App\Models\Project;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait RegistersUsers
{
    use RedirectsUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 201)
                    : redirect($this->redirectPath());
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        $this->loadSelectProject($user);
    }

    /**
     * Le doy un projecto seleccionado a los support por defecto si 
     * no lo tienen
     */
    private function loadSelectProject(User $user){
        // Usuario no tiene un selected_project
        if($user->selected_project_id == null){
            // Admin y cliente
            if ($user->is_admin || $user->is_client){
                $project = Project::first();
                if($project != null){
                    $user->selected_project_id = $project->id;
                } else {
                    $user->selected_project_id = null;
                }

            }else{
                // support
                // Y si el usuario de soporte no esta asignado a ningun proyecto
                if($user->projects->first() != null){
                    $user->selected_project_id = $user->projects->first()->id;
                }
            }
            $user->save();   
        }
        
    }
}
