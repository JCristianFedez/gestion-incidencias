@extends('layouts.app')

@section('content')
<div class="card border-primary">
    <div class="card-header bg-primary text-white">Dashboard</div>

    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        {{-- Tablas de incidencias --}}
        <div>

            {{-- Incidencias asignadas a mi --}}
            @if (auth()->user()->is_support)
                {{-- Incidencias asignadas a mi --}}
                <div class="card border-info mb-3">
                    <div class="card-header bg-info">
                        <h5 class="card-title font-weight-bold text-white">Incidencias asignadas a mí</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Código</th>
                                        <th>Categoría</th>
                                        <th>Severidad</th>
                                        <th>Estado</th>
                                        <th>Fecha creación</th>
                                        <th>Título</th>
                                    </tr>
                                </thead>
                                <tbody id="dashboard_my_incidents">
                                    @foreach ($my_incidents as $incident)
                                        <tr>
                                            <td>{{ $incident->id }}</td>
                                            <td>{{ $incident->category_name }}</td>
                                            <td>{{ $incident->severity_full }}</td>
                                            <td>{{ $incident->id }}</td>
                                            <td>{{ $incident->created_at }}</td>
                                            <td>{{ $incident->title_short }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Incidencias reportadas por mi --}}
            <div class="card border-info mb-3">
                <div class="card-header bg-info">
                    <h5 class="card-title font-weight-bold text-white">Mis Incidencias</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Código</th>
                                    <th>Categoría</th>
                                    <th>Severidad</th>
                                    <th>Estado</th>
                                    <th>Fecha creación</th>
                                    <th>Título</th>
                                    <th>Responsable</th>
                                </tr>
                            </thead>
                            <tbody id="dashboard_by_me">
                                @foreach ($incidents_by_me as $incident)
                                    <tr>
                                        <td>{{ $incident->id }}</td>
                                        <td>{{ $incident->category_name }}</td>
                                        <td>{{ $incident->severity_full }}</td>
                                        <td>{{ $incident->id }}</td>
                                        <td>{{ $incident->created_at }}</td>
                                        <td>{{ $incident->title_short }}</td>
                                        <td>
                                            {{ $incident->support_id ?: "Sin asignar" }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Incidencias sin asignar --}}
            @if (auth()->user()->is_support)
                {{-- Incidencias sin asignar --}}
                <div class="card border-info mb-3">
                    <div class="card-header bg-info">
                        <h5 class="card-title font-weight-bold text-white">Incidencias sin asignar</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Código</th>
                                        <th>Categoría</th>
                                        <th>Severidad</th>
                                        <th>Estado</th>
                                        <th>Fecha creación</th>
                                        <th>Título</th>
                                        <th>Opción</th>
                                    </tr>
                                </thead>
                                <tbody id="dashboard_pending_incidents">
                                    @foreach ($pending_incidents as $incident)
                                        <tr>
                                            <td>{{ $incident->id }}</td>
                                            <td>{{ $incident->category_name }}</td>
                                            <td>{{ $incident->severity_full }}</td>
                                            <td>{{ $incident->id }}</td>
                                            <td>{{ $incident->created_at }}</td>
                                            <td>{{ $incident->title_short }}</td>
                                            <td>
                                                <a href="" class="btn btn-primary btn-sm">
                                                    Atender
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
