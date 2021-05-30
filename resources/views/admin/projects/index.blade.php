@extends('layouts.app')

@section('tituloPagina', 'Proyectos')

@section('content')

@include('layouts.includes.messages.status')

@include('layouts.includes.messages.notification')

{{-- @include('layouts.includes.messages.errors') --}}

<form action="" method="POST" class="row needs-validation mb-4" novalidate>
    @csrf
    <div class="col-md-12 form-group">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
            value="{{old('name')}}" required minlength="5" maxlength="255">
        @if(count($errors) == 0)
        <span class="invalid-feedback" role="alert">
            Porfavor introduzca un nombre valido. Debe contener entre 5 y 255 caracteres.
        </span>
        @endif
        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="col-md-12 form-group">
        <label for="description" class="form-label">Descripción</label>
        <input type="text" name="description" id="description"
            class="form-control @error('description') is-invalid @enderror" value="{{old('description')}}" required
            minlength="15" maxlength="255">
        @if(count($errors) == 0)
        <span class="invalid-feedback" role="alert">
            Porfavor introduzca una descripción valida. Debe contener entre 15 y 255 caracteres.
        </span>
        @endif
        @error('description')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="col-md-12 form-group">
        <label for="start" class="form-label">Fecha de inicio</label>
        <input type="date" name="start" id="start" class="form-control @error('start') is-invalid @enderror"
            value="{{old('start', date('Y-m-d'))}}" required>
        @if(count($errors) == 0)
        <span class="invalid-feedback" role="alert">
            Porfavor introduzca una fecha valida.
        </span>
        @endif
        @error('start')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
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