@extends('layouts.app')

@section('content')
<div class="card border-primary">
    <div class="card-header  bg-primary text-white">Proyecto</div>

    <div class="card-body">
        
        @include('layouts.includes.status')
        
        @include('layouts.includes.notification')

        @include('layouts.includes.errors')

        {{-- Formulario para editar proyecto --}}
        <form action=""  method="POST" class="row g-3">
            @csrf
            @method("PUT")
            <div class="col-md-12 form-group">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" id="name" class="form-control" value="{{old('name',$project->name)}}">
            </div>

            <div class="col-md-12 form-group">
                <label for="description" class="form-label">Descripción</label>
                <input type="text" name="description" id="description" class="form-control" value="{{old('description',$project->description)}}">
            </div>

            <div class="col-md-12 form-group">
                <label for="start" class="form-label">Fecha de inicio</label>
                <input type="date" name="start" id="start" class="form-control" value="{{old('start',$project->start)}}">
            </div>

            <div class="col-md-12 form-group">
                <input type="submit" value="Guardar Proyecto" class="btn btn-primary">
            </div>
        </form>

        {{-- Categorias y niveles --}}
        <div class="row">
            {{-- Categorias --}}
            <div class="col-md-6">
                <p>Categorías</p>

                {{-- Agregar Categoria --}}
                <form action="/categorias" method="POST" class="form-inline mb-3">
                    @csrf
                    <input type="hidden" name="project_id" value="{{ $project->id }}">

                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Ingrese nombre">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Añadir" class="btn btn-primary">
                    </div>
                </form>

                {{-- Categorias del proyecto --}}
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Nombre</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" 
                                        data-target="#modalEditCategory" title="Editar" data-category="{{ $category->id }}"
                                        data-name="{{ $category->name }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="/categoria/{{$category->id}}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Dar de baja">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Niveles --}}
            <div class="col-md-6">
                <p>Niveles</p>
                {{-- Agregar Nivel --}}
                <form action="/niveles" method="POST" class="form-inline mb-3">
                    @csrf
                    <input type="hidden" name="project_id" value="{{ $project->id }}">

                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Ingrese nombre">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Añadir" class="btn btn-primary">
                    </div>
                </form>

                {{-- Niveles del proyecto --}}
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Nivel</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($levels as $key => $level)
                                <tr>
                                    <td>N{{ $key+1 }}</td>
                                    <td>{{ $level->name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" 
                                        data-target="#modalEditLevel" data-level="{{ $level->id }}"
                                        data-name="{{ $level->name }}" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="/nivel/{{ $level->id }}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Dar de baja">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal edit category -->
<div class="modal fade" id="modalEditCategory" tabindex="-1" aria-labelledby="EditCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditCategoryModalLabel">Editar Categoría</h5>
                <button type="button" class="close text-black-50" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/categoria" method="POST">
                <div class="modal-body row">
                    @csrf
                    @method("PUT")
                    <input type="hidden" name="category_id" id="category_id" value="">
                    <div class="form-group col-12">
                        <label for="name">Nombre de la categoría</label>
                        <input type="text" name="name" id="category_name" class="form-control" value=""  >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal edit category -->
<div class="modal fade" id="modalEditLevel" tabindex="-1" aria-labelledby="EditLevelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditLevelModalLabel">Editar Nivel</h5>
                <button type="button" class="close text-black-50" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/nivel" method="POST">
                <div class="modal-body row">
                    @csrf
                    @method("PUT")
                    <input type="hidden" name="level_id" id="level_id" value="">
                    <div class="form-group col-12">
                        <label for="name">Nombre del nivel</label>
                        <input type="text" name="name" id="level_name" class="form-control" value=""  >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


{{-- Script para la edicion de categorias --}}
@section('scripts')
    <script src="{{ asset('/js/admin/projects/edit.js') }}"></script>
@endsection
