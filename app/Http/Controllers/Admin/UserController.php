<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\Message;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        if ($user->is_support) {
            $projects = Project::all();
            return view("admin.users.edit", compact("user", "projects"));
        }

        return view("admin.users.edit", compact("user"));
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
            'password.min' => 'La contraseña debe presentar al menos 8 caracteres.',
            'password.min' => 'La contraseña debe presentar menos de 255 caracteres.',
            'rol.required' => 'El rol es obligatorio',
            'rol.in' => 'Rol invalido'
        ];

        $this->validate($request, $rules, $messages);

        $user = User::findOrFail($id);
        $this->modifiedSelectedProjectForUsers($user, $request);

        // Esta funcion se utiliza cuando se va a cambiar el rol de un usuario de administracion o cliente a soporte 
        // se le eliminan las incidencias y archivos adjuntos los cuales esten en proyectos con los que no tenga relacion
        $this->deleteIncidentsAndFileAttachmentFromProjectsThatYouCannotAccess($user, $request);

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
        if ($user->is_client) {
            $incidencias = Incident::where("support_id", $user->id)->get();
            foreach ($incidencias as $incidencia) {
                $incidencia->support_id = null;
                $incidencia->save();
            }
        }
    }

    /**
     * Si el usuario ahora no es soporte se le eliminan todas las relaciones con proyectos
     * Si el usuario ahora es support se intenta recuerar las posibles relaciones antiguas
     * 
     * @param User $user Usuario el cual se va a modificar
     */
    private function removeOrRestoreAllRelationshipsOfAUserToProjects(User $user)
    {
        if (!$user->is_support) {
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

    /**
     * Se modifica el proyecto seleccionado si el usuario pasa a ser de soporte
     * y el proyecto que tenia seleccionado previamente no coincide con ninguna relacion
     * del usuario
     * 
     * @param User $user Usuario que se va a modificar
     * @param Request $request Contiene los nuevos datos del usuario
     */
    private function modifiedSelectedProjectForUsers(User $user, Request $request)
    {
        // Si el usuario de soporte tiene una relacion con el proyecto que tiene seleccionado este 
        // no se le cambia
        $projectUser = ProjectUser::withTrashed()->where("project_id", $user->selected_project_id)
            ->where("user_id", $user->id)->first();

        // Si el usuario antes no era de soporte y se le va a hacer de soporte y el proyecto
        // seleccionado no coincide con ninguna de sus relaciones
        if (!$user->is_support && $request->rol == 1 && $projectUser == null) {
            if ($user->projects->first() != null) {
                $user->selected_project_id = $user->projects->first()->id;
            } else {
                $user->selected_project_id = null;
            }
        }
    }

    /**
     * Elimina las incidencias y archivos adjuntos si el usuario de los proyectos a los cuales
     * el usuario no tenga permitido acceder.
     * Esta funcion se utiliza cuando se va a cambiar el rol de un usuario de administracion o cliente a soporte 
     * se le eliminan las incidencias y archivos adjuntos los cuales esten en proyectos con los que no tenga relacion
     * 
     * @param User $user Usuario que se va a modificar
     * @param Request $request Contiene los nuevos datos del usuario
     */
    private function deleteIncidentsAndFileAttachmentFromProjectsThatYouCannotAccess(User $user, Request $request)
    {

        if (!$user->is_support && $request->rol == 1) {
            $projectsUser = ProjectUser::withTrashed()->where("user_id", $user->id)->get();
            $projectsUsersId = [];
            foreach ($projectsUser as $pj) {
                $projectsUsersId[] = $pj->id;
            }
            
            $incidents = Incident::where("client_id", $user->id)
            ->whereNotIn("project_id", $projectsUsersId)->get();

            foreach ($incidents as $incident) {
                if ($incident->attached_file != null) {
                    $publicRoute = $incident->attached_file;

                    $partsOfPublicRoute = explode("/", $publicRoute);
                    array_splice($partsOfPublicRoute, -2);
                    $publicRoute = implode("/", $partsOfPublicRoute);

                    $filesistem = new Filesystem();
                    $filesistem->deleteDirectory(substr($publicRoute, 1));
                }
                $incident->delete();
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
        $this->neglectIncidentsUserAttending($user);
        $user->delete();
        return back()->with("notification", "Usuario desactivado exitosamente.");
    }

    /**
     * Todas las incidencias atendidas atendidas por el usuario se desatienden
     * 
     * @param User $user Usuario a deshabilitar
     */
    private function neglectIncidentsUserAttending(User $user)
    {
        $incidents = $user->list_of_incidents_take;
        foreach ($incidents as $incident) {
            $incident->support_id = null;
            $incident->save();
        }
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
        $user = User::withTrashed()->findOrFail($id);

        // Local
        // $this->deleteFileAttachmentLocal($user);

        // InifnityFree
        $this->deleteFileAttachmentInfinityFree($user);

        $user->forceDelete();

        return back()->with("notification", "Usuario eliminado completametnte exitosamente.");
    }

    /**
     * Elimina los archivos adjuntos de las incidencias del usuario a eliminar
     * Usado en local
     * 
     * @param User $user Usuario a eliminar
     */
    private function deleteFileAttachmentLocal(User $user)
    {
        $incidents = $user->list_of_incidents_client;

        foreach ($incidents as $incident) {
            if ($incident->file_public_path != null) {
                $publicRoute = $incident->file_public_path;

                $partsOfPublicRoute = explode("/", $publicRoute);
                array_splice($partsOfPublicRoute, -2);
                $publicRoute = implode("/", $partsOfPublicRoute);

                if (Storage::exists($publicRoute)) {
                    Storage::deleteDirectory($publicRoute);
                }
            }
        }
    }

    /**
     * Elimina los archivos adjuntos de las incidencias del usuario a eliminar
     * Usado en ininityFree
     * 
     * @param User $user Usuario a eliminar
     */
    private function deleteFileAttachmentInfinityFree(User $user)
    {
        $incidents = $user->list_of_incidents_client;

        foreach ($incidents as $incident) {
            if ($incident->attached_file != null) {
                $publicRoute = $incident->attached_file;

                $partsOfPublicRoute = explode("/", $publicRoute);
                array_splice($partsOfPublicRoute, -2);
                $publicRoute = implode("/", $partsOfPublicRoute);

                $filesistem = new Filesystem();
                $filesistem->deleteDirectory(substr($publicRoute, 1));
            }
        }
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
