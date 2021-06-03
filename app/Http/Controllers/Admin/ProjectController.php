<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Filesystem\Filesystem;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Funcion para cargar la vista de los proyectos
     */
    public function index()
    {
        return view("admin.projects.index");
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Funcion para almacenar un nuevo proyecto
     * @param Request $request Contiene los datos de el nuevo proyecto
     */
    public function store(Request $request)
    {
        $this->validate($request, Project::$rules, Project::$messages);

        Project::create($request->all());

        $this->setNewProjectWithSelectedProjectWhereIsTheFirstProject();

        return back()->with('notification', 'El proyecto se ha registrado correctamente.');
    }

    /**
     * Si es el primer proyecto creado se asigna como seleccionado a los usuarios que no
     * tengan ninguno y sean de administradores o cliente.
     * 
     * Tambien puede usarse si no hay proyectos activos y se restaura uno, este pasara a ser el 
     * selccionado
     */
    private function setNewProjectWithSelectedProjectWhereIsTheFirstProject()
    {
        if (count(Project::all()) == 1) {
            $users = User::whereIn("role", ["0", 2])
                ->whereNull("selected_project_id")->get();

            foreach($users as $user){
                $user->selected_project_id = Project::first()->id;
                $user->save();
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Funcion para mostrar el formulario para editar un proyecto
     * @param Integer $id Id del proyecto a editar
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $categories =  $project->categories;
        $levels = $project->levels;
        return view("admin.projects.edit", compact("project", "categories", "levels"));
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Funcion para actualizar un proyecto
     * @param Request $request Contiene los nuevos datos del proyecto
     * @param Integer $id Contiene el Id del proyecto a editar
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, Project::$rules, Project::$messages);

        Project::findOrFail($id)->update($request->all());
        return back()->with('notification', 'El proyecto se ha actualizado correctamente.');
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Funcion para eliminar un proyecto de forma suave
     * @param Integer $id Contiene le Id del proyecto a eliminar
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        ProjectUser::where("project_id", $id)->delete();

        // Si el proyecto dado de baja es el que tiene el usuario seleccionado se le selecciona
        // otro automaticamente
        $this->changeSelectedProjectsFromTheProjectToRemove($project);

        return back()->with('notification', 'El proyecto se ha deshabilitado correctamente.');
    }

    /**
     * Si el proyecto dado de baja es el que tiene el usuario seleccionado se le selecciona
     * otro automaticamente
     * @param Project $project Proyecto que se va a eliminar
     */
    private function changeSelectedProjectsFromTheProjectToRemove(Project $project)
    {
        $users = User::where("selected_project_id", $project->id)->get();
        foreach ($users as $user) {
            // Admin y cliente
            if ($user->is_admin || $user->is_client) {
                $project = Project::first();
                if ($project != null) {
                    $user->selected_project_id = $project->id;
                } else {
                    $user->selected_project_id = null;
                }
            } else {
                // Y si el usuario de soporte no esta asignado a ningun proyecto
                if ($user->projects->first() != null) {
                    $user->selected_project_id = $user->projects->first()->id;
                } else {
                    $user->selected_project_id = null;
                }
            }
            $user->save();
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Funcion para eliminar un proyecto de forma definitiva
     */
    public function forceDestroy($id)
    {
        $project = Project::withTrashed()->findOrFail($id);

        // Parte local//
        // $this->localDeleteDirectory($project);
        // Fin parte Local//

        // Parte para infinityfree //
        $this->infinityFreeDeleteDirectory($project);
        //Fin para infinityfree //

        $project->forceDelete();

        return back()->with("notification", "Proyecto eliminado completametnte exitosamente.");
    }

    /**
     * Elimina los archivos del proyecto pasada.
     * Usado para laravel en local
     * @param Project $project Proyecto con la cual se sacara la ruta para eliminar el directorio
     */
    private function localDeleteDirectory(Project $project)
    {
        $publicPath = $project->public_directory_path;

        // Elimino los archivos adjuntos de dicho proyecto
        Storage::deleteDirectory($publicPath);
    }

    /**
     * Elimina los archivos del proyecto pasado.
     * Usado para laravel en infinityFree
     * @param Project $project Proyecto con la cual se sacara la ruta para eliminar el directorio
     */
    private function infinityFreeDeleteDirectory(Project $project)
    {
        $publicPath = $project->infinity_free_directory_path;

        // Elimino los archivos adjuntos de dicho proyecto
        $filesistem = new Filesystem();
        $filesistem->deleteDirectory(substr($publicPath, 1));
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Funcion para restaurar los proyectos y las relaciones de los usuarios con tales proyectos
     */
    public function restore($id)
    {
        Project::withTrashed()->find($id)->restore();
        $projectUser = ProjectUser::withTrashed()->where("project_id", $id)->get();
        ProjectUser::withTrashed()->where("project_id", $id)->restore();
        $this->changeSelectedFromProjectRestore($projectUser, $id);
        $this->setNewProjectWithSelectedProjectWhereIsTheFirstProject();
        return back()->with('notification', 'El proyecto se ha habilitado correctamente.');
    }

    /**
     * Si el nivel dado de baja, elimina la relacion con el usuario y el proyecto
     *  y el proyecto de dicha relacion es el que tiene el usuario seleccionado se 
     * le selecciona otro automaticamente
     * @param Array $projectUser Array de projectUsers del proyecto a restaurar
     * @param Integer $id Id del proyecto a restaurar
     */
    private function changeSelectedFromProjectRestore($projectUser, $id)
    {
        $usersId = [];
        foreach ($projectUser as $pj) {
            $usersId[] = $pj->user_id;
        }

        $users = User::whereNull("selected_project_id")
            ->where("role", "1")
            ->whereIn("id", $usersId)
            ->get();

        foreach ($users as $user) {
            $user->selected_project_id = $id;
            $user->save();
        }
    }
}
