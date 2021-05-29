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
     * 
     * @param Request $request Datos de la nueva relacion entre usuario y proyecto
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
        $level = Level::findOrFail($request->level_id);
        if ($level->project_id != $request->project_id) {
            return back();
        }

        // Comprobamos que el usuario no pertenezca ya al proyecto
        $temp = $this->verifyUserDoesNotAlreadyBelongToTheProject($request);
        if ($temp != null) {
            return $temp;
        }

        // Si el usuario al que se le asigna el proyecto no tiene ningun proyecto
        // seleccionado se le asigna este
        $user = User::findOrFail($request->user_id);
        if ($user->selected_project_id == null){
            $user->selected_project_id = $request->project_id;
            $user->save();
        }

        $project_user = new ProjectUser();
        $project_user->project_id = $request->project_id;
        $project_user->user_id = $request->user_id;
        $project_user->level_id = $request->level_id;
        $project_user->save();

        return back()->with("notification", "Usuario agregado al proyecto.");
    }

    /**
     * Comprobamos que el usuario no pertenezca ya al proyecto, en caso de que pertenezca 
     * y el proyecto este activo enviara mensaje de error, en caso de que pertenezca pero 
     * este deshabilitada la relacion esta se reactivara y mostrara mensage de exito
     * 
     * @param Request $request Datos de la relacion entre un proyecto y un usuario
     */
    private function verifyUserDoesNotAlreadyBelongToTheProject(Request $request)
    {
        $project_user = ProjectUser::where("project_id", $request->project_id)
            ->where("user_id", $request->user_id)->first();

        if ($project_user != null) {
            if ($project_user->deleted_at == null) {
                return back()->with("notification", "El usuario ya pertenece a este proyecto.");
            } else {
                $project_user->restore();
                return back()->with("notification", "Usuario agregado al proyecto.");
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Funcion para actualizar una relacion entre un usuario y un proyecto
     * 
     * @param Request $request Contiene id de la relacion entre usuario y proyecto a demas de 
     * los nuevos datos de la relacion
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
        $this->disregardedAllIncidentsThatUserAttendingIfTheLevelIsChangedAndTheLevelOfTheIncidentsIsNotGeneral(
            $project_user,
            $request
        );

        $project_user->project_id = $request->project_id;
        $project_user->user_id = $request->user_id;
        $project_user->level_id = $request->level_id;
        $project_user->save();

        return back()->with("notification", "Relacion actualizada.");
    }

    /**
     * Desatiende todas las incidencias que estaba atendiendo el usuario si se le cambia
     * el nivel en el proyecto. Las incidencias de nivel general no se desatienden
     * 
     * @param ProjectUser $project_user Relacion a editar
     * @param Request $request Nuevos datos de la relacion
     */
    private function disregardedAllIncidentsThatUserAttendingIfTheLevelIsChangedAndTheLevelOfTheIncidentsIsNotGeneral(ProjectUser $project_user, Request $request)
    {
        if ($project_user->level_id != $request->level_id) {

            $user = User::findOrFail($project_user->user_id);
            $incidents = $user->list_of_incidents_take;
            if ($incidents != null) {
                foreach ($incidents as $incident) {
                    // Incidencias de nivel distinto a general
                    if ($incident->level_id != null) {
                        $incident->support_id = null;
                        $incident->save();
                    }
                }
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Funcion para eliminar una relacion
     * 
     * @param Integer $id Id de la relacion entre usuario y proyecto a elmiinar
     */
    public function destroy($id)
    {
        $projectUser = ProjectUser::findOrFail($id);
        $projectUser->forceDelete();

        // Se desatienden todas las incidencias que eran atendidas por el usuario en el proyecto
        // de la relacion
        $this->disregardedAllIncidentsThatUserAttendingInTheRelationshipProject($projectUser);

        // Se elimina el usuario de soporte en las incidencias de nivel general si
        // el usuario que la atiende estaba relacionado con el proyecto con el nivel 
        // eliminado
        $this->neglectGeneralLevelIncidentIfTheUserWhoAttendsItWasTheOneFromTheRelationship($projectUser);

        // Se modifica el proyecto selccionado para los usuarios de soporte
        $this->modifiedSelectedProjectForSupportUsers($projectUser);

        return back()->with("notification", "Relacion eliminada.");
    }

    /**
     * Se desatienden todas las incidencias que eran atendidas por el usuario en el proyecto
     * de la relacion
     * 
     * @param ProjectUser $projectUser Relacion entre usuario y proyecto del cual se eliminaran las incidencias
     * que el usuario esta atendiendo en dicho proyecto
     */
    private function disregardedAllIncidentsThatUserAttendingInTheRelationshipProject(ProjectUser $projectUser)
    {
        $incidents = Incident::where("support_id", $projectUser->user_id)
            ->where("project_id", $projectUser->project_id)
            ->where("level_id", $projectUser->level_id)->get();
        foreach ($incidents as $incident) {
            $incident->support_id = null;
            $incident->save();
        }
    }

    /**
     * Se modifica el proyecto seleccionado para usuarios el soporte al que vaya dirigida
     * la relacion si tiene seleccionado el proyecto que se va a eliminar en la relacion
     * 
     * @param ProjectUser $projectUser Es la relacion que contiene el usuario y el proyecto
     */
    private function modifiedSelectedProjectForSupportUsers(ProjectUser $projectUser)
    {
        $user = User::findOrFail($projectUser->user_id);
        if (
            $user->selected_project_id == $projectUser->project_id
            && $user->is_support
        ) {
            if ($user->projects->first() != null) {
                $user->selected_project_id = $user->projects->first()->id;
            } else {
                $user->selected_project_id = null;
            }
            $user->save();
        }
    }

    /**
     * Se elimina el usuario de soporte en las incidencias de nivel general si
     * el usuario que la atiende estaba relacionado con el proyecto con el nivel 
     * eliminado
     * 
     * @param ProjectUser $projectUser Es la relacion que contiene el usuario y el proyecto
     */
    private function neglectGeneralLevelIncidentIfTheUserWhoAttendsItWasTheOneFromTheRelationship(ProjectUser $projectUser)
    {
        $incidentsToDeleteSupportId = Incident::whereNull("level_id")
            ->where("project_id", $projectUser->project_id)
            ->where("support_id", $projectUser->user_id)
            ->get();

        foreach ($incidentsToDeleteSupportId as $incident) {
            $incident->support_id = null;
            $incident->save();
        }
    }
}
