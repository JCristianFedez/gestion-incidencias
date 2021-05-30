@extends('layouts.app')

@section('tituloPagina', 'Editar proyecto')


@section('content')

@include('layouts.includes.messages.status')

@include('layouts.includes.messages.notification')

@include('layouts.includes.messages.notification-error')

{{-- @include('layouts.includes.messages.errors') --}}

{{-- Formulario para editar proyecto --}}
<form action="" method="POST" class="row needs-validation mb-4" novalidate>
    @csrf
    @method("PUT")
    <div class="col-md-12 form-group">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
            value="{{old('name',$project->name)}}" required minlength="5" maxlength="255">
        @if(count($errors) == 0)
        <span class="invalid-feedback" role="alert">
            Porfavor introduzca un nombre valido. Debe de contener entre 5 y 255 caracteres.
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
            class="form-control @error('description') is-invalid @enderror"
            value="{{old('description',$project->description)}}" required minlength="15" maxlength="255">
        @if(count($errors) == 0)
        <span class="invalid-feedback" role="alert">
            Porfavor introduzca una descripción valido. Debe de contener entre 15 y 255 caracteres.
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
            value="{{old('start',$project->start)}}" required>
        @if(count($errors) == 0)
        <span class="invalid-feedback" role="alert">
            Porfavor introduzca una fecha valida.
        </span>
        @endif
        @error('description')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="col-md-12 form-group">
        <input type="submit" value="Actualizar Proyecto" class="btn btn-primary">
    </div>
</form>

{{-- Categorias y niveles --}}
<div class="row">
    {{-- Categorias --}}
    <div class="col-xl-6 mb-5 pb-5">
        <p>Categorías</p>

        {{-- Agregar Categoria --}}
        <form action="/categorias" method="POST" class="mb-3 needs-validation" novalidate>
            <div class="form-row">
                @csrf
                <input type="hidden" name="project_id" value="{{ $project->id }}">

                <div class="form-group col-xl-6 mb-xl-0 mb-3">
                    <input type="text" name="name" class="form-control " placeholder="Ingrese nombre" required
                        minlength="5" maxlength="255">
                    <span class="invalid-feedback" role="alert">
                        Campo obligatorio y debe de contener entre 5 y 255 caracteres.
                    </span>
                </div>
                <div class="form-group col-xl-3 mb-xl-0 mb-3">
                    <input type="submit" value="Añadir" class="btn btn-primary w-100">
                </div>
            </div>
        </form>

        {{-- Categorias del proyecto --}}
        <div id="all-categories-table">
            @include('admin.projects.includes.edit.categories-table')
        </div>
    </div>

    {{-- Niveles --}}
    <div class="col-xl-6 mb-5 pb-5">
        <p>Niveles</p>
        {{-- Agregar Nivel --}}
        <form action="/niveles" method="POST" class="mb-3 needs-validation" novalidate>
            <div class="form-row">
                @csrf
                <input type="hidden" name="project_id" value="{{ $project->id }}">

                <div class="form-group col-xl-3 mb-xl-0 mb-3">
                    <input type="number" id="level-difficulty" name="difficulty" class="form-control"
                        placeholder="Dificultad" required min="1" max="{{ count($levels)+1 }}"
                        value="{{ count($levels)+1 }}">
                    <span class="invalid-feedback" role="alert">
                        Campo obligatorio.
                    </span>
                </div>

                <div class="form-group col-xl-6 mb-xl-0 mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Ingrese nombre" required
                        minlength="5" maxlength="255">
                    <span class="invalid-feedback" role="alert">
                        Campo obligatorio y debe de contener entre 5 y 255 caracteres.
                    </span>
                </div>


                <div class="form-group col-xl-3 mb-xl-0 mb-3">
                    <input type="submit" value="Añadir" class="btn btn-primary w-100">
                </div>
            </div>
        </form>

        {{-- Niveles del proyecto --}}
        <div id="all-levels-table">
            @include('admin.projects.includes.edit.levels-table')
        </div>
    </div>
</div>

<!-- Modal editar categoria -->
@include('admin.projects.includes.edit.modal-edit-category')

<!-- Modal editar nivel -->
@include('admin.projects.includes.edit.modal-edit-level')

@endsection


{{-- Script para la edicion de categorias --}}
@section('scripts')
<script src="{{ asset('/js/admin/projects/edit.js') }}" type="module"></script>
<script src="{{ asset('/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('js/library/sweetalert2-all.min.js') }}"></script>
<script src="{{ asset('/js/library/jquery-toast-plugin.min.js') }}"></script>
@endsection

{{-- Agregar css para esta pagina --}}
@section('css')
<link href="{{ asset('/datatables/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('/css/library/jquery-toast-plugin.min.css') }}" rel="stylesheet">
@endsection