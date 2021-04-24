@extends('layouts.app')

@section('tituloPagina', 'Instrucciones')


@section('content')
<main>

    <div class="container">
        POR HACER, ADEMAS CON JQUERY AJUSTAR EL HEIGHT DEL TEXTO A LA DERECHA AUTOMATICAMENTE.
        PONER UN HEIGHT DE 80VH MINIMO Y TOCAR EL HEIGTH CON EL DEL MENU DE LA IZQUIERDA
        <div class="row">

            <div class="col-4 col-lg-3 mt-3">
                @include('instructions.includes.vertical-index')
            </div>

            <div id="instructions-container" class="col-8 col-lg-9 mt-4" data-spy="scroll" data-target="#scrollspy-demo" data-offset="10">
                <div class="row">
                    <div class="col-auto mr-auto">
                        <h1 class="display-4 mb-0">Indice</h1>
                        <p class="lead">Components(12): Scrollspy: Example with nested nav</p>
                    </div>
                </div>
                <h2 class="mt-2" id="about">About this demo</h2>
                <p class="my-2"><a href="components-12.html#scrollspy-example-with-nested-nav">Scrollspy demo</a> using
                    three-level nested <a href="components-9.html">Navigation</a>s.</p>
                <ul class="struct">
                    <li>Container <code>div.container</code>
                        <ul>
                            <li>Left <code>div.col-4.col-lg-3</code>
                                <ul>
                                    <li>Navigation <code>nav.nav.nav-pills.flex-column</code> <a
                                            class="btn btn-sm btn-outline-info my-1 px-1 py-0" data-toggle="collapse"
                                            href=".a1-1" aria-control=".a1-1" aria-expanded="false">Attribute</a>
                                        <ul>
                                            <li class="att collapse a1-1">Attribute <code>id="scrollspy-demo"</code>
                                            </li>
                                            <li>Item <code>a.list-group-item</code> <a
                                                    class="btn btn-sm btn-outline-info my-1 px-1 py-0"
                                                    data-toggle="collapse" href=".a1-2" aria-control=".a1-2"
                                                    aria-expanded="false">Attribute</a>
                                                <ul class="collapse a1-2">
                                                    <li class="att">Attribute
                                                        <code>href=&quot;#{position-id}&quot;</code></li>
                                                </ul>
                                            </li>
                                            <li>Or nested navigation <code>nav.nav.nav-pills.flex-column</code>
                                                <ul>
                                                    <li class="att">( <code>id</code> is not required for inner navs)
                                                    </li>
                                                    <li>Item <code>a.list-group-item</code> <a
                                                            class="btn btn-sm btn-outline-info my-1 px-1 py-0"
                                                            data-toggle="collapse" href=".a1-3" aria-control=".a1-3"
                                                            aria-expanded="false">Attributes</a>
                                                        <ul class="collapse a1-3">
                                                            <li class="att">Attribute
                                                                <code>href=&quot;#{position-id}&quot;</code></li>
                                                            <li class="cls">Indent <code>.ml-(4|5)</code> (⇒ <a
                                                                    href="utilities-4.html#spacing">Spacing</a> )</li>
                                                        </ul>
                                                    </li>
                                                    <li>Can be nested any levels</li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li>Right <code>div.col-8.col-lg-9</code> - Scrolling contents (here) <a
                                    class="btn btn-sm btn-outline-info my-1 px-1 py-0" data-toggle="collapse"
                                    href=".a1-4" aria-control=".a1-4" aria-expanded="false">Attributes</a>
                                <ul>
                                    <li class="att collapse a1-4">Attribute <code>data-spy="scroll"</code></li>
                                    <li class="att collapse a1-4">Attribute <code>data-target="#scrollspy-demo"</code>
                                    </li>
                                    <li class="att collapse a1-4">Attribute <code>data-offset="10"</code> (⇒ <a
                                            href="#note">Note</a> )</li>
                                    <li class="att collapse a1-4">Style
                                        <code>style="height: 32rem; overflow-y: scroll;"</code></li>
                                    <li>Scrolling elements <a class="btn btn-sm btn-outline-info my-1 px-1 py-0"
                                            data-toggle="collapse" href=".a1-5" aria-control=".a1-5"
                                            aria-expanded="false">Attribute</a>
                                        <ul class="collapse a1-5">
                                            <li>Set <code>id="{position-id}"</code> to the tracking targets</li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="alert alert-info" id="note" role="alert"><strong>Note: </strong>This demo sets
                    <code>data-offset="10"</code> (px) for adjusting scrolling position calculation. Ideally, it should
                    be <code>"0"</code> . But it sometimes causes a problem that it does not activate a pill when a use
                    click a pill to scroll the page (possibly by numerical errors). Setting an offset around
                    <code>"10"</code> results to natural behaviors.</div>
                <p>Below are dummy scrolling contents. Each heading have a specific <code>id="{position-id}"</code> for
                    scroll tracking.</p>
                <h2 id="picture">Pictures</h2>
                <h4 id="picture-1">Picture 1</h4>
                <h5 id="picture-1-1">Picture 1-1</h5><img class="img-fluid mb-4" src="../img/1920x1080.svg">
                <h5 id="picture-1-2">Picture 1-2</h5><img class="img-fluid mb-4" src="../img/1920x1080.svg">
                <h5 id="picture-1-3">Picture 1-3</h5><img class="img-fluid mb-4" src="../img/1920x1080.svg">
                <h4 id="picture-2">Picture 2</h4>
                <h5 id="picture-2-1">Picture 2-1</h5><img class="img-fluid mb-4" src="../img/1920x1080.svg">
                <h5 id="picture-2-2">Picture 2-2</h5><img class="img-fluid mb-4" src="../img/1920x1080.svg">
                <h5 id="picture-2-3">Picture 2-3</h5><img class="img-fluid mb-4" src="../img/1920x1080.svg">
                <h2 id="slide">Slides</h2>
                <h4 id="slide-1">Slide 1</h4><img class="img-fluid mb-4" src="../img/slide-1.svg">
                <h4 id="slide-2">Slide 2</h4><img class="img-fluid mb-4" src="../img/slide-2.svg">
                <h4 id="slide-3">Slide 3</h4><img class="img-fluid mb-4" src="../img/slide-3.svg">
            </div>
        </div>

    </div>
</main>
@endsection

{{-- Script para cambiar de pagina dinamicamente --}}
{{-- @section('scripts')
<script src="{{ asset('/js/instructions/main.js') }}"></script>
@endsection --}}

{{-- Agregar css para esta pagina --}}
@section('css')
<link href="{{ asset('/css/instructions/main.css') }}" rel="stylesheet">
@endsection