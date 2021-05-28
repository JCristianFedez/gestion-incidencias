@extends('layouts.app')

@section('tituloPagina', 'Créditos')


@section('content')
<main role="main">

    {{-- Galeria --}}
    <div class="container">

        {{-- Carusel de tecnologias y herramientas --}}
        @include('credits.includes.carrusel-herramientas-tecnologias')

        {{-- Carusel de librerias --}}
        @include('credits.includes.carrusel-librerias')

        {{-- Carusel agradecimientos --}}
        @include('credits.includes.carrusel-agradecimientos')
    </div>



</main>
@endsection

{{-- Script para cambiar de pagina dinamicamente --}}
@section('scripts')
<script src="{{ asset('owlcarousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('/js/carusel-card.js') }}"></script>
@endsection

{{-- Agregar css para esta pagina --}}
@section('css')
<link href="{{ asset('/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
<link href="{{ asset('/owlcarousel/assets/owl.theme.default.min.css') }}" rel="stylesheet">
<link href="{{ asset('/css/carusel-card-custom.css') }}" rel="stylesheet">

@endsection