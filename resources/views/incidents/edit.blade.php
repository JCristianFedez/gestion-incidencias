@extends('layouts.app')

@section('tituloPagina', 'Editar Incidencia')

@section('content')

@include('layouts.includes.messages.status')

@include('layouts.includes.messages.notification')

@include('layouts.includes.messages.errors')

{{-- Formulario para editar incidencia --}}
<form action="" method="POST" class="row needs-validation" novalidate enctype="multipart/form-data">
    @csrf
    {{-- Categoria --}}
    <div class="col-md-4 form-group">
        <label for="category_id" class="form-label">Categoria</label>
        <select name="category_id" id="category_id" class="form-control">
            <option value="" @if (!$incident->category_id) selected @endif >General</option>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}" @if($incident->category_id == $category->id) selected @endif>
                {{ $category->name }}
            </option>
            @endforeach
        </select>
    </div>

    @if (auth()->user()->is_admin)
    {{-- Niveles --}}
    <div class="col-md-4 form-group">
        <label for="level_id" class="form-label">Nivel</label>
        <select name="level_id" id="level_id" class="custom-select">
            <option value="" @if (!$incident->level_id) selected @endif >General</option>
            @foreach ($levels as $level)
            <option value="{{ $level->id }}" @if ($incident->level_id == $level->id) selected @endif >{{ $level->name }}</option>
            @endforeach
        </select>
    </div>
    @endif

    {{-- Severidad --}}
    <div class="col-md-4 form-group">
        <label for="severity" class="form-label">Severidad</label>
        <select name="severity" id="severity" class="form-control">
            <option value="M" @if($incident->severity == "M") selected @endif>
                Menor
            </option>
            <option value="N" @if($incident->severity == "N") selected @endif>
                Normal
            </option>
            <option value="A" @if($incident->severity == "A") selected @endif>
                Alta
            </option>
        </select>
    </div>

    <div class="col-md-12 form-group">
        <label for="title" class="form-label">Titulo</label>
        <input type="text" name="title" id="title" class="form-control" value="{{old('title',$incident->title)}}"
            required minlength="5" maxlength="255">
        <div class="invalid-feedback">
            Porfavor introduzca un titulo valido.
        </div>
    </div>

    <div class="col-md-12 form-group">
        <label for="description" class="form-label">Descripción</label>
        <textarea name="description" id="description" class="form-control" required minlength="15"
            maxlength="255">{{old('description',$incident->description)}}</textarea>
        <div class="invalid-feedback">
            Porfavor introduzca una descripcion valida.
        </div>
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