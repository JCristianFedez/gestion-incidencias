<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request){

        return view("admin.users.index");
    }

    public function store(Request $request){
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8','max:255'],
            'rol' => ["required","in:0,1,2"]
        ];

        $messages = [
            'name.required' => 'Es necesario ingresar el nombre del usuario.',
    	    'name.max' => 'El nombre es demasiado extenso.',
    		'email.required' => 'Es indispensable ingresar el e-mail del usuario.',
    		'email.email' => 'El e-mail ingresado no es válido.',
    		'email.max' => 'El e-mail es demasiado extenso.',
    		'email.unique' => 'Este e-mail ya se encuentra en uso.',
    		'password.required' => 'Olvidó ingresar una contraseña.',
    		'password.min' => 'La contraseña debe presentar al menos 6 caracteres.',
    		'password.min' => 'La contraseña debe presentar menos de 255 caracteres.',
            'rol.required' => 'El rol es obligatorio',
            'rol.in' => 'Rol invalido'
        ];

        $this->validate($request, $rules, $messages);

    	$user = new User();
    	$user->name = $request->name;
    	$user->email = $request->email;
    	$user->password = bcrypt($request->password);
    	$user->role = $request->rol; //0: Admin | 1: Support | 2:Client	
    	$user->save();

        
        return back()->with("notification","Usuario registrado exitosamente.");
    }

    public function edit($id){
        $user = User::findOrFail($id);
        $projects = Project::all();
        $projects_user = ProjectUser::where("user_id",$user->id)->get();

        return view("admin.users.edit", compact("user","projects","projects_user"));
    }

    public function update($id, Request $request){

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['nullable','string', 'min:8','max:255'],
            'rol' => ["required","in:0,1,2"]
        ];

        $messages = [
            'name.required' => 'Es necesario ingresar el nombre del usuario.',
    	    'name.max' => 'El nombre es demasiado extenso.',
    		'email.required' => 'Es indispensable ingresar el e-mail del usuario.',
    		'email.email' => 'El e-mail ingresado no es válido.',
    		'email.max' => 'El e-mail es demasiado extenso.',
    		'password.min' => 'La contraseña debe presentar al menos 6 caracteres.',
    		'password.min' => 'La contraseña debe presentar menos de 255 caracteres.',
            'rol.required' => 'El rol es obligatorio',
            'rol.in' => 'Rol invalido'
        ];

        $this->validate($request, $rules, $messages);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->role = $request->rol;
        
        $password = $request->password;
        if($password){
            $user->password = bcrypt($password);
        }
        
        // Comprobarmos si ahora el usuario es cliente y si antes era
        // admin o support le quitamos todas las incidencias que estaba atendiendo
        if($user->role == 2){
            $incidencias = Incident::where("support_id",$user->id)->get();
            for ($i=0; $i < count($incidencias); $i++) { 
                $incidencias[$i]->support_id = null;
                $incidencias[$i]->save();
            }
        }

        // Comprobamos si ahora el usuario no es support le quitamos todas
        // las relaciones con proyectos
        if($user->role != 1){
            $projectUser = ProjectUser::where("user_id",$user->id)->get();
            for ($i=0; $i < count($projectUser); $i++) { 
                $projectUser[$i]->delete();
            }

        }else{ // Si es support intentamos recuperar las relaciones con sus proyectos
            $projectUser = ProjectUser::withTrashed()->where("user_id",$user->id)->get();
            for ($i=0; $i < count($projectUser); $i++) { 
                $projectUser[$i]->restore();
            }
        }

        $user->save();


        return back()->with("notification","Usuario modificado exitosamente.");
    }

    public function destroy($id){
        $user = User::findOrFail($id);

		$user->delete();
        return back()->with("notification","Usuario desactivado exitosamente.");

	}

    public function forceDestroy($id){
        $user = User::withTrashed()->findOrFail($id);
        // TODO: Eliminar todas los registros realcionados con este usuario
		$user->forceDelete();
        return back()->with("notification","Usuario eliminado completametnte exitosamente.");

	}

    public function restore($id){
        User::withTrashed()->find($id)->restore();
        return back()->with('notification', 'El usuario se ha activado correctamente.');
    }
}
