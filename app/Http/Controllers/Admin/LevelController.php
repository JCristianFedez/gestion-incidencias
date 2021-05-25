<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\Level;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    /**
     * Funcion para almacenar un nuevo nivel
     * @param Request $request Contiene los valores enviados por el usuario
     * para crear un nuevo nivel
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => ["required", "min:5", "max:255"],
            'project_id' => ["required", "exists:projects,id"],
            'difficulty' => ["required"]
        ];

        $messages = [
            'name.required' => 'Es necesario ingresar un nombre para el nivel.',
            'name.min' => 'El nivel necesita un minimo de 5 caracteres.',
            'name.max' => 'El nivel no puede tener mas de 255 caracteres.',
            'difficulty.required' => 'Es necesario ingresar un nivel de dificultad.',
        ];

        $this->validate($request, $rules, $messages);

        // Se comprueba si el proyecto ya tiene un nivel con el nombre introducido
        if (Level::where("project_id", $request->project_id)->where("name", $request->name)->first()) {
            return back()->with('notificationError', 'El proyecto ya tiene un nivel con ese nombre.');
        }

        // Actualiza el nivel de dificultad de los niveles posteriores.
        $this->updateDifficultyLevelOfLaterLevels($request);

        Level::create($request->all());

        return back()->with('notification', 'El nivel se ha creado correctamente.');
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Actuaiza el nivel de dificultad de los niveles con mas dificultad de el proyecto de dicho
     * nivel, es decir, si se crea un nivel con dificultad "4" se actualiza la dificultad de los niveles
     * igual y superiores a este sumandole uno a su dificultad
     * 
     * @param Request $request Datos enviados por el usuario mediante los cuales se creara un nivel
     */
    private function updateDifficultyLevelOfLaterLevels(Request $request)
    {
        $nextsLevels = Level::where("project_id", $request->project_id)
            ->where("difficulty", ">=", $request->difficulty)->orderBy('difficulty')->get();

        for ($i = (count($nextsLevels) - 1); $i >= 0; $i--) {
            $nextsLevels[$i]->difficulty++;
            $nextsLevels[$i]->save();
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Funcion encargada de actualizar un nivel
     * @param Request $request Datos enviados por el usuario mediante los cuales se actualizara un nivel
     */
    public function update(Request $request)
    {
        $rules = [
            'name' => ["required", "min:5", "max:255"],
            'level_id' => ["required", "exists:levels,id"],
            'difficulty' => ["required"]
        ];

        $messages = [
            'name.required' => 'Es necesario ingresar un nombre para el nivel.',
            'name.min' => 'El nivel necesita un minimo de 5 caracteres.',
            'name.max' => 'El nivel no puede tener mas de 255 caracteres.',
            'level.required' => 'Es necesario ingresar un nivel de dificultad.',
        ];

        $this->validate($request, $rules, $messages);

        $level = Level::find($request->level_id);

        // Se verifica que no haya un nivel con el mismo nombre en el mismo proyecto
        $temp = $this->verifiedProjectDoesNotHaveLevelWithSameNameAndDifficulty($level, $request);
        if ($temp != null) {
            return $temp;
        }


        // Se organiza la dificultad de los niveles entre la dificultad actual del nivel y la última.
        $this->difficultyLevelsOrganizedBetweenTheCurrentDifficultyOfTheLevelAndTheLast($level, $request);

        $level->name = $request->name;
        $level->difficulty = $request->difficulty;
        $level->save();

        if ($request->ajax()) {
            return response()->json([
                "head" => "¡Correcto!",
                "message" => "El nivel se ha actualizado correctamente.",
                "type" => "success",
            ]);
        }

        return back()->with('notification', 'El nivel se ha actualizado correctamente.');
    }

    /**
     * Se verifica que no haya un nivel con el mismo nombre en el mismo proyecto
     * @param Level $level Nivel a actualizar
     * @param Request $request Nuevos datos del nivel
     * @return return Devuelve si ha el fallo a devolver si ya habia un nivel igual
     */
    private function verifiedProjectDoesNotHaveLevelWithSameNameAndDifficulty(Level $level, Request $request)
    {
        if ((Level::where("project_id", $level->project_id)->where("name", $request->name)->first())
            && ($level->difficulty == $request->difficulty)
        ) {
            if ($request->ajax()) {
                return response()->json([
                    "head" => "¡Error!",
                    "message" => "El proyecto ya tiene un nivel con ese nombre",
                    "type" => "error",
                ]);
            }
            return back()->with('notificationError', 'El proyecto ya tiene un nivel con ese nombre.');
        }
    }

    /**
     * Se organiza la dificultad de los niveles entre la dificultad actual del nivel y la última.
     * @param Level $level Nivel a actualizar
     * @param Request $request Nuevos datos del nivel
     */
    private function difficultyLevelsOrganizedBetweenTheCurrentDifficultyOfTheLevelAndTheLast(Level $level, Request $request)
    {
        if ($level->difficulty != $request->difficulty) {

            // Si la nueva dificultad es superior a la actual
            if ($request->difficulty > $level->difficulty) {
                $prevLevels = Level::where("project_id", $level->project_id)->where("difficulty", ">", $level->difficulty)
                    ->where("difficulty", "<=", $request->difficulty)->orderBy('difficulty')->get();

                $level->difficulty = -1;
                $level->save();

                for ($i = 0; $i < count($prevLevels); $i++) {
                    $prevLevels[$i]->difficulty--;
                    $prevLevels[$i]->save();
                }
            } else { // Si la nueva dificultad es menor a la actual
                $prevLevels = Level::where("project_id", $level->project_id)->where("difficulty", "<", $level->difficulty)
                    ->where("difficulty", ">=", $request->difficulty)->orderBy('difficulty')->get();

                $level->difficulty = -1;
                $level->save();

                for ($i = (count($prevLevels) - 1); $i >= 0; $i--) {
                    $prevLevels[$i]->difficulty++;
                    $prevLevels[$i]->save();
                }
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Funcion para eliminar un nivel
     */
    public function destroy($id, Request $request)
    {
        $level = Level::find($id);
        $project = $level->project;
        $difficulty = $level->difficulty;
        $projectUsers = ProjectUser::where("level_id", $id)->get();

        $incidents = Incident::where("level_id", $id)->get();

        // Si hay incidencias asignadas en este nivel, intentarán pasar primero al siguiente nivel, 
        // si no es posible al anterior y si tampoco el general
        $this->reorganizeTheLevelOfTheIncidentsOfTheLevelToBeEliminated($incidents, $level);

        $level->forceDelete();

        // Se elimina el usuario de soporte en las incidencias de nivel general si
        // el usuario que la atiende estaba relacionado con el proyecto con el nivel 
        // eliminado
        $this->deleteSupportUserOfIncidentsWhichHaveLevelToDelete($projectUsers, $project);

        // Se eliminan las relaciones de usuarios con dicho nivel
        foreach ($projectUsers as $projectUser) {
            $projectUser->forceDelete();
        }

        // Actualiza el nivel de dificultad de los niveles posteriores.
        $this->updateTheDifficultyLevelOfLaterLevels($project, $difficulty);

        if ($request->ajax()) {
            return response()->json([
                "head" => "¡Correcto!",
                "message" => "El nivel se ha eliminado correctamente.",
                "type" => "success",
            ]);
        }

        return back()->with('notification', 'El nivel se ha eliminado correctamente.');
    }

    /**
     * Si hay incidencias asignadas en este nivel, intentarán pasar primero al siguiente nivel, 
     * si no es posible al anterior y si tampoco el general
     * @param Incident[] $incidents Incidencias a las cuales se le modificara el nivel
     * @param Level $level Nivel que se va a eliminar posteriormente
     */
    private function reorganizeTheLevelOfTheIncidentsOfTheLevelToBeEliminated($incidents, Level $level)
    {
        if ($incidents != null) {
            if ($level->next_level) {
                foreach ($incidents as $incident) {
                    $incident->level_id = $level->next_level->id;
                    $incident->support_id = null;
                    $incident->save();
                }
            } else if ($level->previous_level) {
                foreach ($incidents as $incident) {
                    $incident->level_id = $level->previous_level->id;
                    $incident->support_id = null;
                    $incident->save();
                }
            } else {
                foreach ($incidents as $incident) {
                    $incident->level_id = null;
                    $incident->support_id = null;
                    $incident->save();
                }
            }
        }
    }

    /**
     * Se elimina el usuario de soporte en las incidencias de nivel general si
     * el usuario que la atiende estaba relacionado con el proyecto con el nivel 
     * eliminado
     * @param ProjectUser[] $projectUsers Relaciones de proyectos con usuarios de soportes a partir de un nivel
     * @param Project $project Proyecto el cual contiene el nivel que se va a eliminar
     */
    private function deleteSupportUserOfIncidentsWhichHaveLevelToDelete($projectUsers, Project $project)
    {
        $usersId = [];
        foreach ($projectUsers as $user) {
            $usersId[] = $user->user_id;
        }

        $incidentsToDeleteSupportId = Incident::whereNull("level_id")
            ->where("project_id", $project->id)
            ->whereIn("support_id", $usersId)
            ->get();

        foreach ($incidentsToDeleteSupportId as $incident) {
            $incident->support_id = null;
            $incident->save();
        }
    }

    /**
     * Actualiza el nivel de dificultad de los niveles posteriores.
     * @param Project $project Proyecto al que pertenece el nivel
     * @param Integer $difficulty Dificultad del nivel a eliminar
     */
    private function updateTheDifficultyLevelOfLaterLevels(Project $project, $difficulty)
    {
        $nextsLevels = Level::where("project_id", $project->id)
            ->where("difficulty", ">", $difficulty)->orderBy('difficulty')->get();

        for ($i = 0; $i < count($nextsLevels); $i++) {
            $nextsLevels[$i]->difficulty--;
            $nextsLevels[$i]->save();
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    // Mi pequeño api para recuperar los niveles de un proyecto
    public function byProject($id)
    {
        return Level::where("project_id", $id)->get();
    }
}
