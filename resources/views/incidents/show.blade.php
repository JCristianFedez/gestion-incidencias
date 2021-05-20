@extends('layouts.app')

@section('tituloPagina', 'Informacion de Incidencia')

@section('content')

@include('layouts.includes.messages.status')

@include('layouts.includes.messages.notification')

@include('layouts.includes.messages.errors')

{{-- Tabla con la info de la incidencia --}}
<div class="table-responsive mb-3">
    <table class="table table-striped table-bordered table-hover" id="tabla-incidencia">
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
                <td>{{ $incident->level_name }}</td>
                <td>{{ $incident->state }}</td>
                <td>{{ $incident->severity_full }}</td>
            </tr>
        </tbody>
    </table>
</div>

{{-- Tabla con mas info de la incidencia --}}
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover" id="tabla-incidencia-2">
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
                @if ($incident->attached_file)
                <td>
                    <a href="{{$incident->attached_file}}" aria-label="Descargar fichero adjunto" data-toggle="tooltip"
                        data-placement="top" title="Descargar fichero" target="_blank" role="button">
                        {{$incident->file_name}}
                    </a>
                </td>
                @else
                <td>No se han adjuntado archivos</td>
                @endif
            </tr>
        </tbody>
    </table>
</div>

<div id="action-butons">
    {{-- Boton: Atender incidencia --}}
    @if ($incident->support_id == null
    && $incident->active
    && (auth()->user()->canTake($incident) || auth()->user()->is_admin))
    <a href="{{ route("incidencia.take", $incident->id) }}" class="btn btn-primary btn-sm btn-action-js"
        data-success-message="Incidencia atendida correctamente" data-error-message="Error al atender incidencia" role="button">
        Atender Incidencia
    </a>
    @endif

    {{-- Boton: Desatender incidencia --}}
    @if ($incident->support_id != null
    && $incident->active
    && (auth()->user()->canTake($incident) || auth()->user()->is_admin))
    <a href="{{ route("incidencia.disatend", $incident->id) }}" class="btn btn-warning btn-sm btn-action-js"
        data-success-message="Incidencia desatendida correctamente" data-error-message="Error al desatender incidencia" role="button">
        Desatender Incidencia
    </a>
    @endif

    {{-- Botones: volver a abrir | marcar como resuelta --}}
    @if (auth()->user()->id == $incident->client->id)

    @if ($incident->active) {{-- Marcar como resuelta --}}
    <a href="{{ route("incidencia.solve",$incident->id) }}" class="btn btn-success btn-sm btn-action-js"
        data-success-message="Incidencia resuelta correctamente" data-error-message="Error al resolver incidencia" role="button">
        Marcar como resuelta
    </a>
    <a href="{{ route("incidencia.edit", $incident->id) }}" class="btn btn-warning btn-sm" role="button">
        Editar incidencia
    </a>
    @else {{--  Volver a abrir --}}
    <a href="{{ route("incidencia.open", $incident->id) }}" class="btn btn-info btn-sm btn-action-js"
        data-success-message="Incidencia abierta correctamente" data-error-message="Error al abrir incidencia" role="button">
        Volver a abrir la incidencia
    </a>
    @endif

    @endif
    {{-- Boton: Derivar al siguiente nivel --}}
    @if ((auth()->user()->id == $incident->support_id && $incident->active) || ($incident->active &&
    auth()->user()->is_admin))
    @if ((!$incident->level && count($incident->project->levels) > 0) || $incident->level->next_level)
    <a href="{{ route("incidencia.nextLevel", $incident->id) }}" class="btn btn-danger btn-sm btn-action-js"
        data-success-message="Incidencia derivada correctamente" data-error-message="Error al derivar incidencia" role="button">
        Derivar al siguiente nivel
    </a>
    @endif
    @endif
</div>

@include('incidents.includes.chat')
@endsection


{{-- Script para cambiar de pagina dinamicamente --}}
@section('scripts')
<script src="{{ asset('/js/incidents/show.js') }}"></script>
<script src="{{ asset('/js/library/jquery-toast-plugin.min.js') }}"></script>

@endsection

{{-- Agregar css para esta pagina --}}
@section('css')
<link href="{{ asset('/css/library/jquery-toast-plugin.min.css') }}" rel="stylesheet">
@endsection