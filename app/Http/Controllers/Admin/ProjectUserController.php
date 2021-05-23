<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\Level;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectUserController extends Controller
{
    /**
     * Funcion para almacenar una relacion entre usuario y proyecto
     */
    public function store(Request $request)
    {

        $rules = [
            'project_id' => ['required', 'exists:projects,id'],
            'level_id' => ['required', 'exists:levels,id'],
            'user_id' => ['required', 'exists:users,id']
        ];

        $messages = [
            'project_id.required' => 'Es necesario seleccionar el proyecto.',
            'level_id.required' => 'Es necesario seleccionar el nivel.'
        ];

        $this->validate($request, $rules, $messages);

        // Si hay un usuario malicioso e intenta enlacar un proyecto con un nivel que no le corresponde
        $level = Level::find($request->level_id);
        if ($level->project_id != $request->project_id) {
            return back();
        }

        // Comprobamos que el usuario no pertenezca ya al proyecto
        $project_user = ProjectUser::where("project_id", $request->project_id)
            ->where("user_id", $request->user_id)->first();

        if ($project_user) {
            if ($project_user->deleted_at == null) {
                return back()->with("notification", "El usuario ya pertenece a este proyecto.");
            } else {
                $project_user->restore();
                return back()->with("notification", "Usuario agregado al proyecto.");
            }
        }

        $project_user = new ProjectUser();
        $project_user->project_id = $request->project_id;
        $project_user->user_id = $request->user_id;
        $project_user->level_id = $request->level_id;
        $project_user->save();

        return back()->with("notification", "Usuario agregado al proyecto.");
    }

    /**
     * Funcion para actualizar una relacion entre un usuario y un proyecto
     */
    public function update(Request $request)
    {

        $rules = [
            'project_id' => ['required', 'exists:projects,id'],
            'level_id' => ['required', 'exists:levels,id'],
            'user_id' => ['required', 'exists:users,id'],
            'project_user_id' => ['required', 'exists:project_user,id']
        ];

        $messages = [
            'level_id.required' => 'Es necesario seleccionar el nivel.'
        ];

        $this->validate($request, $rules, $messages);

        // Si hay un usuario malicioso e intenta enlacar un proyecto con un nivel que no le corresponde
        $level = Level::find($request->level_id);
        if ($level->project_id != $request->project_id) {
            return back();
        }

        $project_user = ProjectUser::find($request->project_user_id);

        // Se desatienden todas las incidencias que estaba atendiendo el usuario si se le cambia el nivel
        if ($project_user->level_id != $request->level_id) {

            $user = User::find($project_user->user_id);
            $incidents = $user->list_of_incidents_take;
            if ($incidents) {
                foreach ($incidents as $incident) {
                    $incident->support_id = null;
                    $incident->save();
                }
            }
        }

        $project_user->project_id = $request->project_id;
        $project_user->user_id = $request->user_id;
        $project_user->level_id = $request->level_id;
        $project_user->save();

        return back()->with("notification", "Relacion actualizada.");
    }


    /**
     * Funcion para eliminar una relacion
     */
    public function destroy($id)
    {
        $projectUser = ProjectUser::find($id);

        $incidents = Incident::where("support_id", $projectUser->user_id)
            ->where("project_id", $projectUser->project_id)
            ->where("level_id", $projectUser->level_id)->get();
        for ($i = 0; $i < count($incidents); $i++) {
            $incidents[$i]->support_id = null;
            $incidents[$i]->save();
        }


        $user = User::find($projectUser->user_id);
        // Se modifica el proyecto selccionado para los usuarios de soporte
        if (
            $user->selected_project_id == $projectUser->project_id
            && $user->role == 1
        ) {
            if ($user->projects->first()) {
                $user->selected_project_id = $user->projects->first()->id;
            } else {
                $user->selected_project_id = null;
            }
            $user->save();
        }

        // Se elimina el usuario de soporte en las incidencias de nivel general si
        // el usuario que la atiende estaba relacionado con el proyecto con el nivel 
        // eliminado
        $incidentsToDeleteSupportId = Incident::whereNull("level_id")
        ->where("project_id",$projectUser->project_id)
        ->where("support_id",$projectUser->user_id)
        ->get();
        
        foreach ($incidentsToDeleteSupportId as $incident) {
            $incident->support_id = null;
            $incident->save();
        }

        $projectUser->forceDelete();
        return back()->with("notification", "Relacion eliminada.");
    }
}
