<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\Message;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Funcion para cargar la vista de usuarios
     */
    public function index()
    {
        return view("admin.users.index");
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Funcion para almacenar un nuevo usuario
     * 
     * @param Request $request Contiene los datos del nuevo usuario
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:255'],
            'rol' => ["required", "in:0,1,2"]
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


        return back()->with("notification", "Usuario registrado exitosamente.");
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Funcion para mostrar el formulario para editar un usuario
     * 
     * @param Integer $id Id del usuario a editar
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $projects = Project::all();

        return view("admin.users.edit", compact("user", "projects"));
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Funcion para actualizar un usuario
     * 
     * @param Integer $id Id del usuario a editar
     * @param Request $request Nuevos datos del usuario
     */
    public function update($id, Request $request)
    {

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['nullable', 'string', 'min:8', 'max:255'],
            'rol' => ["required", "in:0,1,2"]
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

        // Si se introduce nueva contraseña esta se cifrara para luego almacenarse
        $password = $request->password;
        if ($password != null) {
            $user->password = bcrypt($password);
        }

        // Comprobarmos si ahora el usuario es cliente y si antes era
        // admin o support le quitamos todas las incidencias que estaba atendiendo
        $this->neglectAllUserIncidents($user);

        // Comprobamos si ahora el usuario no es support le quitamos todas
        // las relaciones con proyectos
        $this->removeOrRestoreAllRelationshipsOfAUserToProjects($user);

        $user->save();

        return back()->with("notification", "Usuario modificado exitosamente.");
    }

    /**
     * Se desatienden todas las incidencias del usuario si se modifica a rol de cliente
     * 
     * @param User $user Usuario el cual se comprobara si es cliente y eliminara todas las
     * incidencias que esta atendiendo
     */
    private function neglectAllUserIncidents(User $user)
    {
        if ($user->role == 2) {
            $incidencias = Incident::where("support_id", $user->id)->get();
            foreach ($incidencias as $incidencia) {
                $incidencia->support_id = null;
                $incidencia->save();
            }
        }
    }

    /**
     * Si el usuario ahora no es soporte se le eliminan todas las relaciones con proyectos, si
     * el usuario ahora es support se intenta recuerar las posibles relaciones antiguas
     * 
     * @param User $user Usuario el cual se va a modificar
     */
    private function removeOrRestoreAllRelationshipsOfAUserToProjects(User $user)
    {
        if ($user->role != 1) {
            $projectUser = ProjectUser::where("user_id", $user->id)->get();
            foreach ($projectUser as $pj) {
                $pj->delete();
            }
        } else { // Si es support intentamos recuperar las relaciones con sus proyectos
            $projectUser = ProjectUser::withTrashed()->where("user_id", $user->id)->get();
            foreach ($projectUser as $pj) {
                $pj->restore();
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Funcion para desactivar un usuario
     * 
     * @param Integer $id Id del usuario a desactivar
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();
        return back()->with("notification", "Usuario desactivado exitosamente.");
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Funcion para eliminar un usuario definitivamente
     * 
     * @param Integer $id Id del usuario a eliminar definitivamente
     */
    public function forceDestroy($id)
    {
        User::withTrashed()->findOrFail($id)->forceDelete();

        return back()->with("notification", "Usuario eliminado completametnte exitosamente.");
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Funcion para restaurar un usuario
     * 
     * @param Integer $id Id del usuario a restaurar
     */
    public function restore($id)
    {
        User::withTrashed()->find($id)->restore();
        return back()->with('notification', 'El usuario se ha activado correctamente.');
    }
}
