@extends('layouts.app')

@section('tituloPagina', 'Reportar Incidencia')

@section('content')

@include('layouts.includes.messages.status')

@include('layouts.includes.messages.notification')

@include('layouts.includes.messages.errors')

{{-- Formulario para crear incidencia --}}
<form action="" method="POST" class="row needs-validation" novalidate enctype="multipart/form-data">
    @csrf
    {{-- Categoría --}}
    <div class="form-group @if (auth()->user()->is_admin) col-md-4  @else col-md-6 @endif">
        <label for="category_id" class="form-label">Categoría</label>
        <select name="category_id" id="category_id" class="custom-select">
            <option value="">General</option>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    @if (auth()->user()->is_admin)
    {{-- Niveles --}}
    <div class="col-md-4 form-group">
        <label for="level_id" class="form-label">Nivel</label>
        <select name="level_id" id="level_id" class="custom-select">
            <option value="">General</option>
            @foreach ($levels as $level)
            <option value="{{ $level->id }}">{{ $level->name }}</option>
            @endforeach
        </select>
    </div>
    @endif

    {{-- Severidad --}}
    <div class="form-group @if (auth()->user()->is_admin) col-md-4  @else col-md-6 @endif">
        <label for="severity" class="form-label">Severidad</label>
        <select name="severity" id="severity" class="custom-select">
            <option value="M">Menor</option>
            <option value="N">Normal</option>
            <option value="A">Alta</option>
        </select>
    </div>

    <div class="col-md-12 form-group">
        <label for="title" class="form-label">Título</label>
        <input type="text" name="title" id="title" class="form-control" value="{{old('title')}}" required minlength="5"
            maxlength="255">
        <span class="invalid-feedback" role="alert">
            Porfavor introduzca un título valido. Entre 5 y 255 caracteres.
        </span>
    </div>

    <div class="col-md-12 form-group">
        <label for="description" class="form-label">Descripción</label>
        <textarea name="description" id="description" class="form-control" required minlength="15"
            maxlength="255">{{old('description')}}</textarea>
        <span class="invalid-feedback" role="alert">
            Porfavor introduzca una descripcion valida. Entre 15 y 255 caracteres.
        </span>
    </div>

    <div class="col-md-12 form-group">
        <label for="archio-adjunto" class="form-label">Adjuntar archivo</label>
        <input type="file" name="adjunto" id="archio-adjunto"
            accept=".jpg,.jpeg,.bmp,.png,.doc,.docx,.csv,.rtf,.xlsx,.xls,.txt,.pdf,.zip,.txt">
    </div>

    <div class="col-md-12 form-group">
        <input type="submit" value="Registrar Incidencia" class="btn btn-primary">
    </div>
</form>
@endsection