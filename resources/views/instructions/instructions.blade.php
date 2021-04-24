@extends('layouts.app')

@section('tituloPagina', 'Instrucciones')


@section('content')
<main>

    <div class="container">
        POR HACER, ADEMAS CON JQUERY AJUSTAR EL HEIGHT DEL TEXTO A LA DERECHA AUTOMATICAMENTE.
        PONER UN HEIGHT DE 80VH MINIMO Y TOCAR EL HEIGTH CON EL DEL MENU DE LA IZQUIERDA
        <div class="row">

            <div class="col-12 col-lg-3 mt-3" id="indice">
                @include('instructions.includes.vertical-index')
            </div>

            <div id="instructions-container" class="col-12 col-lg-9 mt-4 shadow" data-spy="scroll" data-target="#scrollspy-demo" data-offset="100">
                <h2 class="mt-2" id="about">About this demo</h2>
                <h2 id="users">Usuarios</h2>
                <h4 id="see-users">Ver usuarios</h4>
                <h4 id="create-users">Crear usuarios</h4>
                <h4 id="edit-users">Editar usuarios</h4>
                <h4 id="delete-users">Eliminar usuarios</h4>
            </div>
        </div>

    </div>
</main>
@endsection

{{-- Script para cambiar de pagina dinamicamente --}}
@section('scripts')
<script src="{{ asset('/js/instructions/main.js') }}"></script>
@endsection

{{-- Agregar css para esta pagina --}}
@section('css')
<link href="{{ asset('/css/instructions/main.css') }}" rel="stylesheet">
@endsection