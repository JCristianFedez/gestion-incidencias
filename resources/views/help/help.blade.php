@extends('layouts.app')

@section('tituloPagina', 'Ayuda')


@section('content')
<main>

    <div class="container-fluid">
        <div class="row">

            <div class="col-12 col-lg-3 mt-3 d-block" id="index-container">
                @include('help.includes.vertical-index')
            </div>

            <div id="instructions-container" class="col-12 col-lg-9 mt-3 shadow">
                <h1 class="mt-2 h1 text-center">Manual de ayuda</h1>

                {{-- Sobre la aplicacion --}}
                <article class="mb-5 border-bottom border-black">
                    @include('help.includes.apartados.introduction')
                </article>

                {{-- Usuarios --}}
                @if (auth()->user()->is_admin)
                <article class="mb-5 border-bottom border-black">
                    @include('help.includes.apartados.users')
                </article>

                {{-- Proyectos --}}
                <article class="mb-5 border-bottom border-black">
                    @include('help.includes.apartados.projects')
                </article>

                {{-- Niveles --}}
                <article class="mb-5 border-bottom border-black">
                    @include('help.includes.apartados.levels')
                </article>

                {{-- Categorias --}}
                <article class="mb-5 border-bottom border-black">
                    @include('help.includes.apartados.categories')
                </article>
                @endif

                {{-- Incidencias --}}
                <article class="mb-5 border-bottom border-black">
                    @include('help.includes.apartados.incidents')
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