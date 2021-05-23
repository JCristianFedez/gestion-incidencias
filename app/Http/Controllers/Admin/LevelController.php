<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\Level;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    /**
     * Funcion para almacenar un nuevo nivel
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
        $nextsLevels = Level::where("project_id", $request->project_id)
            ->where("difficulty", ">=", $request->difficulty)->orderBy('difficulty')->get();

        for ($i = (count($nextsLevels) - 1); $i >= 0; $i--) {
            $nextsLevels[$i]->difficulty++;
            $nextsLevels[$i]->save();
        }

        Level::create($request->all());

        return back()->with('notification', 'El nivel se ha creado correctamente.');
    }

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


        // Se organiza la dificultad de los niveles entre la dificultad actual del nivel y la última.
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
        if ($incidents) {
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

        $level->forceDelete();

        // Se elimina el usuario de soporte en las incidencias de nivel general si
        // el usuario que la atiende estaba relacionado con el proyecto con el nivel 
        // eliminado

        $usersId = [];
        foreach ($projectUsers as $user) {
            $usersId[] = $user->user_id;
        }

        $incidentsToDeleteSupportId = Incident::whereNull("level_id")
        ->where("project_id",$project->id)
        ->whereIn("support_id",$usersId)
        ->get();
        
        foreach ($incidentsToDeleteSupportId as $incident) {
            $incident->support_id = null;
            $incident->save();
        }
        
        // Se eliminan las relaciones de usuarios con dicho nivel
        $projectUsers->forceDelete();

        // Actualiza el nivel de dificultad de los niveles posteriores.
        $nextsLevels = Level::where("project_id", $project->id)
            ->where("difficulty", ">", $difficulty)->orderBy('difficulty')->get();

        for ($i = 0; $i < count($nextsLevels); $i++) {
            $nextsLevels[$i]->difficulty--;
            $nextsLevels[$i]->save();
        }

        if ($request->ajax()) {
            return response()->json([
                "head" => "¡Correcto!",
                "message" => "El nivel se ha eliminado correctamente.",
                "type" => "success",
            ]);
        }

        return back()->with('notification', 'El nivel se ha eliminado correctamente.');
    }

    // Mi pequeño api para recuperar los niveles de un proyecto
    public function byProject($id)
    {
        return Level::where("project_id", $id)->get();
    }
}
