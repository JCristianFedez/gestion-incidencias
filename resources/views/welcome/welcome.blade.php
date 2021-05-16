@extends('layouts.app')

@section('content')
<div>

    <div class="container text-center text">
        <h1 class="mb-1 display-1 sub-titulo">Sistema de Gestion de Incidencias</h1>
        <h3 class="mb-5 text-white sub-titulo"><em>Gestiona tus incidencias de forma rapida y sencilla</em></h3>
    </div>


</div>
@endsection


{{-- Agregar css para esta pagina --}}
@section('css')
<link href="{{ asset('/css/welcome/main.css') }}" rel="stylesheet">

@endsection