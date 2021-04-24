@extends('layouts.app')

@section('tituloPagina', 'Instrucciones')


@section('content')
<main>

    <div class="container-fluid">
        POR HACER
        <div class="row">

            <div class="col-12 col-lg-3 mt-3 d-block" id="index-container">
                @include('instructions.includes.vertical-index')
            </div>

            <div id="instructions-container" class="col-12 col-lg-9 mt-3 shadow">
                <h1 class="mt-2 h1 text-center">Manual de ayuda</h1>

                {{-- Sobre la aplicacion --}}
                <article class="mb-5 border-bottom border-black">
                    @include('instructions.includes.apartados.introduction')</article>

                {{-- Usuarios --}}
                <article class="mb-5 border-bottom border-black">
                    @include('instructions.includes.apartados.users')
                </article>

                {{-- Proyectos --}}
                <article class="mb-5 border-bottom border-black">
                    @include('instructions.includes.apartados.projects')
                </article>

                {{-- Incidencias --}}
                <article class="mb-5 border-bottom border-black">
                    @include('instructions.includes.apartados.incidents')
                </article>

                {{-- Niveles --}}
                <article class="mb-5 border-bottom border-black">
                    @include('instructions.includes.apartados.levels')
                </article>

                {{-- Categorias --}}
                <article class="mb-5 border-bottom border-black">
                    @include('instructions.includes.apartados.categories')
                </article>

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