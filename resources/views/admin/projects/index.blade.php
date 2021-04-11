@extends('layouts.app')

@section('tituloPagina', 'Proyectos')

@section('content')

@include('layouts.includes.messages.status')

@include('layouts.includes.messages.notification')

@include('layouts.includes.messages.errors')

<form action="" method="POST" class="row needs-validation mb-4" novalidate>
    @csrf

    <div class="col-md-12 form-group">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}" required minlength="5"
            maxlength="255">
        <div class="invalid-feedback">
            Porfavor introduzca un nombre valido.
        </div>
    </div>

    <div class="col-md-12 form-group">
        <label for="description" class="form-label">Descripción</label>
        <input type="text" name="description" id="description" class="form-control" value="{{old('description')}}"
            required minlength="15" maxlength="255">
        <div class="invalid-feedback">
            Porfavor introduzca una descripción valida.
        </div>
    </div>

    <div class="col-md-12 form-group">
        <label for="start" class="form-label">Fecha de inicio</label>
        <input type="date" name="start" id="start" class="form-control" value="{{old('start', date('Y-m-d'))}}"
            required>
        <div class="invalid-feedback">
            Porfavor introduzca una fecha valida.
        </div>
    </div>

    <div class="col-md-12 form-group">
        <input type="submit" value="Registrar Proyecto" class="btn btn-primary">
    </div>
</form>

{{-- Tabla de todos los proyectos --}}
<div id="all-projects-table" style="min-height: 600px" id="allProjectsTable">
    @include('admin.projects.includes.index.projects-table')
</div>
@endsection

{{-- Script para cambiar de pagina dinamicamente --}}
@section('scripts')
<script src="{{ asset('/js/admin/projects/index.js') }}"></script>
<script src="{{ asset('/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('js/library/sweetalert2-all.min.js') }}"></script>
@endsection

{{-- Agregar css para esta pagina --}}
@section('css')
<link href="{{ asset('/datatables/datatables.min.css') }}" rel="stylesheet">
@endsection