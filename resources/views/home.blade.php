@extends('layouts.app')

@section('tituloPagina', 'Dashboard')

@section('content')


@include('layouts.includes.status')

@include('layouts.includes.notification')

@include('layouts.includes.errors')

{{-- Tablas de incidencias --}}
<div>

    {{-- Incidencias asignadas a mi --}}
    @if (auth()->user()->is_support || auth()->user()->is_admin)
    {{-- Incidencias asignadas a mi --}}
    <div class="card border-secondary mb-3">
        <div class="card-header bg-gradient-info">
            <h5 class="card-title font-weight-bold text-white">Incidencias asignadas a mí</h5>
        </div>
        <div class="card-body">
            @include('dashboard.includes.incidenciasAsignadasAmi-table')
        </div>
    </div>
    @endif

    {{-- Incidencias reportadas por mi --}}
    <div class="card border-info mb-3">
        <div class="card-header bg-gradient-info">
            <h5 class="card-title font-weight-bold text-white">Mis Incidencias</h5>
        </div>
        <div class="card-body">
            @include('dashboard.includes.misIncidencias-table')
        </div>
    </div>

    {{-- Incidencias sin asignar --}}
    @if (auth()->user()->is_support || auth()->user()->is_admin)
    {{-- Incidencias sin asignar --}}
    <div class="card border-info mb-3">
        <div class="card-header bg-gradient-info">
            <h5 class="card-title font-weight-bold text-white">Incidencias sin asignar</h5>
        </div>
        <div class="card-body">
            @include('dashboard.includes.incidenciasSinAsingar-table')
        </div>
    </div>
    @endif
</div>

@endsection

{{-- Script para cambiar de pagina dinamicamente --}}
@section('scripts')
<script src="{{ asset('/js/dashboard/home.js') }}"></script>
<script src="{{ asset('/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('/js/library/jquery-toast-plugin.min.js') }}"></script>

@endsection

{{-- Agregar css para esta pagina --}}
@section('css')
<link href="{{ asset('/datatables/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('/css/library/jquery-toast-plugin.min.css') }}" rel="stylesheet">

@endsection