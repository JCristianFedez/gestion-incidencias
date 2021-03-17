@extends('layouts.app')

@section('content')
<div class="card border-primary">
    <div class="card-header  bg-primary text-white">{{ __('Dashboard') }}</div>

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

        <form action=""  method="POST" class="row g-3">
            @csrf

            <div class="col-md-6 form-group">
                <label for="category_id" class="form-label">Categoria</label>
                <select name="category_id" id="category_id" class="form-control">
                    <option value="" >General</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 form-group">
                <label for="severity" class="form-label">Severidad</label>
                <select name="severity" id="severity" class="form-control">
                    <option value="M">Menor</option>
                    <option value="N">Normal</option>
                    <option value="A">Alta</option>
                </select>
            </div>

            <div class="col-md-12 form-group">
                <label for="title" class="form-label">Titulo</label>
                <input type="text" name="title" id="title" class="form-control" value="{{old('title')}}">
            </div>

            <div class="col-md-12 form-group">
                <label for="description" class="form-label">Descripción</label>
                <textarea name="description" id="description" class="form-control">{{old('description')}}</textarea>
            </div>

            <div class="col-md-12 form-group">
                <input type="submit" value="Registrar Incidencia" class="btn btn-primary">
            </div>
        </form>
    </div>
</div>
@endsection
