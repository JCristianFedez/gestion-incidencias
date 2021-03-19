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
            <div class="card border-info mb-3">
                <div class="card-header bg-info">
                    <h5 class="card-title font-weight-bold text-white">Incidencias asignadas a mí</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Código</th>
                                    <th>Categoría</th>
                                    <th>Severidad</th>
                                    <th>Estado</th>
                                    <th>Fecha creación</th>
                                    <th>Resumen</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Incidencias sin asignar --}}
            <div class="card border-info mb-3">
                <div class="card-header bg-info">
                    <h5 class="card-title font-weight-bold text-white">Incidencias sin asignar</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Código</th>
                                    <th>Categoría</th>
                                    <th>Severidad</th>
                                    <th>Estado</th>
                                    <th>Fecha creación</th>
                                    <th>Resumen</th>
                                    <th>Opción</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Incidencias asignadas a otros --}}
            <div class="card border-info mb-3">
                <div class="card-header bg-info">
                    <h5 class="card-title font-weight-bold text-white">Incidencias sin asignar</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Código</th>
                                    <th>Categoría</th>
                                    <th>Severidad</th>
                                    <th>Estado</th>
                                    <th>Fecha creación</th>
                                    <th>Resumen</th>
                                    <th>Responsable</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
