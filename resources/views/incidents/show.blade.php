@extends('layouts.app')

@section('content')
<div class="card border-primary mb-3">
    <div class="card-header  bg-primary text-white">Informacion de Incidencia</div>

    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        @if (session("notification"))
        <div class="alert alert-success">
            {{ session("notification") }}
        </div>
        @endif

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="table-responsive mb-3">
            <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Código</th>
                        <th>Proyecto</th>
                        <th>Categoria</th>
                        <th>Fecha de envio</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $incident->id }}</td>
                        <td>{{ $incident->project->name }}</td>
                        <td>{{ $incident->category_name }}</td>
                        <td>{{ $incident->created_at }}</td>
                    </tr>
                </tbody>
                <thead class="thead-dark">
                    <tr>
                        <th>Asignado a</th>
                        <th>Nivel</th>
                        <th>Estado</th>
                        <th>Severidad</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $incident->support_name }}</td>
                        <td>{{ $incident->level->name }}</td>
                        <td>{{ $incident->state }}</td>
                        <td>{{ $incident->severity_full }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <tbody>
                    <tr>
                        <th>Título</th>
                        <td>{{ $incident->title }}</td>
                    </tr>
                    <tr>
                        <th>Descripcíon</th>
                        <td>{{ $incident->description }}</td>
                    </tr>
                    <tr>
                        <th>Adjuntos</th>
                        <td>No se han adjuntado archivos</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Boton: Atender incidencia --}}
        @if ($incident->support_id == null
            && $incident->active
            && auth()->user()->canTake($incident))
            <a href="/incidencia/{{ $incident->id }}/atender" class="btn btn-primary btn-sm">
                Atender Incidencia
            </a>
        @endif

        {{-- Botones: volver a abrir | marcar como resuelta --}}
        @if (auth()->user()->id == $incident->client->id)

            @if ($incident->active) {{-- Marcar como resuelta --}}
                <a href="/incidencia/{{ $incident->id }}/resolver" class="btn btn-success btn-sm">
                    Marcar como resuelta
                </a>
                <a href="/incidencia/{{ $incident->id }}/editar" class="btn btn-warning btn-sm">
                    Editar incidencia
                </a>
            @else    {{--  Volver a abrir --}}
                <a href="/incidencia/{{ $incident->id }}/abrir" class="btn btn-info btn-sm">
                    Volver a abrir la incidencia
                </a>
            @endif

        @endif

        {{-- Boton: Derivar al siguiente nivel --}}
        @if (auth()->user()->id == $incident->support_id
            && $incident->active)
            <a href="/incidencia/{{ $incident->id }}/derivar" class="btn btn-danger btn-sm">
                Derivar al siguiente nivel
            </a>
        @endif
    </div>
</div>

    @include('layouts.chat')
@endsection
