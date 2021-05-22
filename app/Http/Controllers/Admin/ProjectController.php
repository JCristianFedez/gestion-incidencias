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

    /**
     * Funcion para almacenar un nuevo proyecto
     */
    public function store(Request $request)
    {
        $this->validate($request, Project::$rules, Project::$messages);

        Project::create($request->all());

        return back()->with('notification', 'El proyecto se ha registrado correctamente.');
    }

    /**
     * Funcion para mostrar el formulario para editar un proyecto
     */
    public function edit($id)
    {
        $project = Project::find($id);
        $categories =  $project->categories;
        $levels = $project->levels;
        return view("admin.projects.edit", compact("project", "categories", "levels"));
    }

    /**
     * Funcion para actualizar un proyecto
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, Project::$rules, Project::$messages);

        Project::find($id)->update($request->all());
        return back()->with('notification', 'El proyecto se ha actualizado correctamente.');
    }

    /**
     * Funcion para eliminar un proyecto de forma suave
     */
    public function destroy($id)
    {
        Project::find($id)->delete();
        ProjectUser::where("project_id", $id)->delete();

        // Si el proyecto dado de baja es el que tiene el usuario seleccionado se le selecciona
        // otro automaticamente
        $user = User::find(auth()->user()->id);
        if ($user->selected_project_id == $id) {
            // Admin y cliente
            if ($user->is_admin || $user->is_client) {
                $user->selected_project_id = Project::first()->id;
            } else {
                // Y si el usuario de soporte no esta asignado a ningun proyecto
                if ($user->projects->first()) {
                    $user->selected_project_id = $user->projects->first()->id;
                }
            }
            $user->save();
        }

        return back()->with('notification', 'El proyecto se ha deshabilitado correctamente.');
    }

    /**
     * Funcion para eliminar un proyecto de forma definitiva
     */
    public function forceDestroy($id)
    {
        $project = Project::withTrashed()->findOrFail($id);

        // Parte local//
        $publicPath = $project->public_directory_path;

        // Elimino los archivos adjuntos de dicho proyecto
        Storage::deleteDirectory($publicPath);
        // Fin parte Local//

        // Parte para infinityfree //
        /*
            $publicPath = $project->infinity_free_directory_path;
            // Elimino los archivos adjuntos de dicho proyecto
            $filesistem = new Filesystem();
            $filesistem->deleteDirectory(substr($publicPath, 1));
        */
        //Fin para infinityfree //

        $project->forceDelete();

        return back()->with("notification", "Proyecto eliminado completametnte exitosamente.");
    }

    /**
     * Funcion para restaurar los proyectos y las relaciones de los usuarios con tales proyectos
     */
    public function restore($id)
    {
        Project::withTrashed()->find($id)->restore();
        ProjectUser::withTrashed("project_id", $id)->restore();

        return back()->with('notification', 'El proyecto se ha habilitado correctamente.');
    }
}
