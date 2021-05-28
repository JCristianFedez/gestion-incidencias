@extends('layouts.app')

@section('content')
<div>

    <div class="text-center">
        <h1 class="mb-1 bolder-text responsive-text font-initial">Sistema de Gestión de Incidencias</h1>
        <h3 class="mb-5 text-white bolder-text responsive-text"><em>Gestiona tus incidencias de forma rápida y sencilla</em></h3>
    </div>


</div>
@endsection


{{-- Agregar css para esta pagina --}}
@section('css')
<link href="{{ asset('/css/welcome/main.css') }}" rel="stylesheet">

@endsection