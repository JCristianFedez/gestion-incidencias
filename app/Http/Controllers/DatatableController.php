<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class DatatableController extends Controller
{
    /**
     * Usado para la tabla de todos los usuarios
     */
    public function users()
    {

        $users = User::withTrashed();

        return DataTables::of($users)
            ->addColumn('opciones', 'datatables.users.IndexOptions')
            ->addColumn('status', function ($users) {
                return $users->status;
            })
            ->rawColumns(['opciones', 'status'])
            ->editColumn('role', function ($users) {
                return $users->role_name;
            })->editColumn('created_at', function ($users) {
                return $users->created_at->format('d/m/Y');
            })
            ->make(true);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Usado para la tabla de la relacion entre usuarios y proyectos
     */
    public function usersProjects($id)
    {

        $projectUser = ProjectUser::where("user_id", $id);

        return DataTables::of($projectUser)
            ->addColumn('options', 'datatables.users.editOptions')
            ->addColumn('projectsName', function ($projectUser) {
                return $projectUser->project->name;
            })->addColumn('levelsName', function ($projectUser) {
                return $projectUser->level->name;
            })
            ->rawColumns(['options'])
            ->editColumn('created_at', function ($projectUser) {
                return $projectUser->created_at->format('d/m/Y');
            })
            ->make(true);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Usado para la tabla de todos los proyectos
     */
    public function projects()
    {

        $projects = Project::withTrashed();

        return DataTables::of($projects)
            ->addColumn('opciones', 'datatables.projects.IndexOptions')
            ->rawColumns(['opciones'])
            ->editColumn('status', function ($projects) {
                return $projects->status;
            })->make(true);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Usado para la tabla de todos las categorias de los proyectos
     */
    public function projectsCategories($id)
    {

        $categories = Project::find($id)->categories;

        return DataTables::of($categories)
            ->addColumn('options', 'datatables.projects.edit.categoriesOption')
            ->rawColumns(['options'])
            ->editColumn('created_at', function ($category) {
                return $category->created_at->format('d/m/Y');
            })
            ->make(true);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Usado para la tabla de todos las categorias de los proyectos
     */
    public function projectsLevels($id)
    {

        $levels = Project::findOrFail($id)->levels;

        return DataTables::of($levels)
            ->addColumn('options', 'datatables.projects.edit.levelsOption')
            ->rawColumns(['options'])
            ->editColumn('created_at', function ($level) {
                return $level->created_at->format('d/m/Y');
            })
            ->make(true);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Usado para la tabla de las incidencias asignadas a mi
     */
    public function incidentsByMe()
    {
        $user = User::findOrFail(auth()->user()->id);
        $selected_project_id = $user->selected_project_id;

        if ($selected_project_id) {

            $incidents_by_me = Incident::where('project_id', $selected_project_id)
            ->where('support_id', $user->id)
            ->where("active","1")
            ->get();
        } else {
            $incidents_by_me = [];
        }


        return DataTables::of($incidents_by_me)
            ->addColumn('options', 'datatables.dashboard.incidentsByMeOptions')
            ->addColumn('category', function ($incident) {
                return $incident->category_name;
            })->addColumn('status', function ($incident) {
                return $incident->state;
            })
            ->rawColumns(['options', 'category', 'status'])
            ->editColumn('severity', function ($incident) {
                return $incident->severity_full;
            })->editColumn('created_at', function ($incident) {
                return $incident->created_at->format('d/m/Y');
            })->editColumn('title', function ($incident) {
                return $incident->title_short;
            })
            ->make(true);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Usado para la tabla de mis incidencias
     */
    public function myIncidents()
    {
        $user = User::findOrFail(auth()->user()->id);
        $selected_project_id = $user->selected_project_id;

        if ($selected_project_id) {
            $my_incidents = Incident::where('client_id', $user->id)
                ->where('project_id', $selected_project_id)->get();
        } else {
            $my_incidents = [];
        }

        return DataTables::of($my_incidents)
            ->addColumn('options', 'datatables.dashboard.myIncidentsOptions')
            ->addColumn('category', function ($incident) {
                return $incident->category_name;
            })->addColumn('status', function ($incident) {
                return $incident->state;
            })->addColumn('supportName', function ($incident) {
                return $incident->support_name ?: "Sin asignar";
            })
            ->rawColumns(['options', 'category', 'status', 'supportName'])
            ->editColumn('severity', function ($incident) {
                return $incident->severity_full;
            })->editColumn('created_at', function ($incident) {
                return $incident->created_at->format('d/m/Y');
            })->editColumn('title', function ($incident) {
                return $incident->title_short;
            })
            ->make(true);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Usado para la tala de incidencias pendientes
     */
    public function pendingIncidents()
    {
        $user = User::findOrFail(auth()->user()->id);
        $selectedProjectId = $user->selected_project_id;


        $pending_incidents = $this->loadPendingIncident($selectedProjectId, $user);

        return DataTables::of($pending_incidents)
            ->addColumn('options', 'datatables.dashboard.pendingIncidentsOptions')
            ->addColumn('category', function ($incident) {
                return $incident->category_name;
            })->addColumn('status', function ($incident) {
                return $incident->state;
            })
            ->rawColumns(['options', 'category', 'status'])
            ->editColumn('severity', function ($incident) {
                return $incident->severity_full;
            })->editColumn('created_at', function ($incident) {
                return $incident->created_at->format('d/m/Y');
            })->editColumn('title', function ($incident) {
                return $incident->title_short;
            })
            ->make(true);
    }

    /**
     * Devuelve un array con las incidencias pendientes del usuario pasado como parametro en el 
     * proyecto pasado como parametro
     * 
     * @param Integer $selectedProjectId Id del proyecto seleccionado
     * @param User $user Usuario del cual se cargaran las inciencias
     */
    private function loadPendingIncident($selectedProjectId, User $user)
    {
        if ($selectedProjectId != null) {

            if ($user->is_support || $user->is_admin) {

                // Si es admin puede ver todas las incidencias del proyecto seleccionado
                if ($user->is_admin) {
                    $pendingIncidents = Incident::whereNull('support_id')
                    ->where('project_id', $selectedProjectId)
                    ->where("active","1")
                    ->get();
                } else { // Si es de soporte solo puede atender incidencias de su proyecto y nivel
                    $projectUser = ProjectUser::where('project_id', $selectedProjectId)->where('user_id', $user->id)->first();
                    if ($projectUser != null) {
                        $pendingIncidents = Incident::whereNull('support_id')
                        ->where('level_id', $projectUser->level_id)
                        ->where("active","1")
                        ->get();
                    } else {
                        $pendingIncidents = collect(); // Vacio cuando no tiene proyecto seleccionado
                    }

                    // Agregar inicdencias de nivel general
                    $incidents_general_level = Incident::whereNull("support_id")
                        ->whereNull("level_id")
                        ->where("project_id", $selectedProjectId)
                        ->where("active","1")
                        ->get();
                    foreach ($incidents_general_level as $incident) {
                        $pendingIncidents[] = $incident;
                    }
                }
            } else {
                $pendingIncidents = [];
            }
        } else {
            $pendingIncidents = [];
        }

        return $pendingIncidents;
    }
}
