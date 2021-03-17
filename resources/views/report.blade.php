@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">{{ __('Dashboard') }}</div>

    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form action="" class="row g-3">
            <div class="col-md-6 form-group">
                <label for="category_id" class="form-label">Categoria</label>
                <select name="category_id" id="category_id" class="custom-select">
                    <option value="0">General</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 form-group">
                <label for="severity" class="form-label">Severidad</label>
                <select name="severity" id="severity" class="custom-select">
                    <option value="M">Menor</option>
                    <option value="N">Normal</option>
                    <option value="A">Alta</option>
                </select>
            </div>

            <div class="col-md-12 form-group">
                <label for="title" class="form-label">Titulo</label>
                <input type="text" name="title" id="title" class="form-control">
            </div>

            <div class="col-md-12 form-group">
                <label for="description" class="form-label">Descripción</label>
                <textarea name="description" id="description" class="form-control"></textarea>
            </div>

            <div class="col-md-12 form-group">
                <input type="submit" value="Registrar Incidencia" class="btn btn-primary">
            </div>
        </form>
    </div>
</div>
@endsection
