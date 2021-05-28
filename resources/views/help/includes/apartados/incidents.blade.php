<section id="incidents">
    <h2>Incidencias</h2>
</section>

<section id="see-incidents">
    <h4>Ver incidencias</h4>
    <p>
        Para ver las incidencias, debe de dirigirse en el menú izquierdo al apartado de
        <a href="{{ route("home") }}" class="btn btn-light" role="button">
            <i class="fa fa-th-large mr-3 fa-fw"></i>
            Dashboard
        </a>.
    </p>

    <p>
        @if (auth()->user()->is_client)
        Una vez le haya cargado la página, le aparecerá la siguiente tabla.
        @else
        Una vez le haya cargado la página, le aparecerán las siguientes tablas.
        @endif
    </p>

    <ol>
        @if (! auth()->user()->is_client)
        <li>
            <strong>Incidencias asignadas a mí</strong>
            <ul>
                <li>En esta tabla puede ver todas las incidencias que está atendiendo.</li>
            </ul>
        </li>
        @endif
        <li>
            <strong>Mis incidencias</strong>
            <ul>
                <li>En esta tabla puede ver todas las incidencias que ha reportado.</li>
            </ul>
        </li>
        @if (! auth()->user()->is_client)
        <li>
            <strong>Incidencias sin asignar</strong>
            <ul>
                <li>En esta tabla puede ver todas las incidencias que está atendiendo.</li>
            </ul>
        </li>
        @endif
    </ol>

    <p>
        Si desea ver mas información acerca de una incidencia dirigase a la columna <em>opciones</em> de dicha
        incidencia y pinche en el botón de <strong>Ver</strong>
        <a class="btn btn-info btn-sm" role="button">
            Ver
        </a>
    </p>
</section>

<section id="create-incident">
    <h4>Crear incidencia</h4>
    <p>
        Para crear una incidencia, debe de dirigirse en el menú izquierdo al apartado de
        <a href="{{ route("reportar.create") }}" class="btn btn-light" role="button">
            <i class="fa fa-address-card mr-3 fa-fw"></i>
            Reportar
        </a>.
    </p>
    <p>
        Una vez le haya cargado la página, le aparecerá en la parte superior de la página un formulario, el cual debe de
        rellenar con los datos de la incidencia.
    </p>
</section>

<section id="edit-incident">
    <h4>Editar incidencia</h4>
    <p>
        Para editar una incidencia, debe de dirigirse en el menú izquierdo al apartado de
        <a href="{{ route("home") }}" class="btn btn-light" role="button">
            <i class="fa fa-th-large mr-3 fa-fw"></i>
            Dashboard
        </a>.
    </p>
    <p>
        Una vez le haya cargado la página, debe dirigirse a la <strong>tabla de mis incidencias</strong>,
        buscar el registro de la incidencia que quiere editar y en la columna <em>opciones</em> pinchar en el botón de
        <strong>Ver</strong>
        <a class="btn btn-info btn-sm" role="button">
            Ver
        </a>.
    </p>
    <p>
        Se le redirigirá a una ventana en la cual aparecerá toda la información
        de la incidencia. En esta ventana debe de pinchar en el botón <strong>Editar incidencia</strong>
        <a class="btn btn-warning btn-sm" role="button">
            Editar incidencia
        </a>.
    </p>
    <p>
        Se le redirigirá a una ventana en la cual aparecerá un formulario, el cual debe de rellenar con los nuevos datos
        de la incidencia.
    </p>
    <p class="text-muted">
        Las incidencias solo las puede editar el usuario que la haya creado.
    </p>
</section>

@if (! auth()->user()->is_client)
<section id="take-incident">
    <h4>Atender incidencia</h4>
    <p>
        Para atender una incidencia, debe de dirigirse en el menú izquierdo al apartado de
        <a href="{{ route("home") }}" class="btn btn-light" role="button">
            <i class="fa fa-th-large mr-3 fa-fw"></i>
            Dashboard
        </a>.
    </p>
    <p>
        Una vez le haya cargado la página, debe dirigirse a la <strong>tabla de incidencias sin asignar</strong>,
        busca el registro de la incidencia que quiere atender y en la columna <em>opciones</em> pinchar en el botón de
        <strong>Atender</strong>
        <a class="btn btn-primary btn-sm" role="button">
            Atender
        </a>.
    </p>
    <p>
        También la puede atender pinchando en el botón de <strong>Ver</strong>
        <a class="btn btn-info btn-sm" role="button">
            Ver
        </a>.
    </p>
    <p>
        Se le redirigirá a una ventana en la cual aparecerá toda la información
        de la incidencia. En esta ventana debe de pinchar en el botón <strong>Atender incidencia</strong>
        <a class="btn btn-primary btn-sm" role="button">
            Atender incidencia
        </a>.
    </p>
    <p class="text-muted">
        Las incidencias solo pueden ser atendidas por usuarios de administración o usuarios de soporte con suficiente
        nivel en el proyecto en el que se ha creado.
    </p>
</section>

<section id="disregard-incident">
    <h4>Desatender incidencia</h4>
    <p>
        Para desatender una incidencia, debe de dirigirse en el menú izquierdo al apartado de
        <a href="{{ route("home") }}" class="btn btn-light" role="button">
            <i class="fa fa-th-large mr-3 fa-fw"></i>
            Dashboard
        </a>.
    </p>
    <p>
        Una vez le haya cargado la página, debe dirigirse a la <strong>tabla de incidencias asignadas a mí</strong>,
        busca el registro de la incidencia que quiere desatender y en la columna <em>opciones</em> pinchar en el botón
        de <strong>Desatender</strong>
        <a class="btn btn-warning btn-sm" role="button">
            Desatender
        </a>.
    </p>
    <p>
        También la puede desatender pinchando en el botón de <strong>Ver</strong>
        <a class="btn btn-info btn-sm" role="button">
            Ver
        </a>.
    </p>
    <p>
        Se le redirigirá a una ventana en la cual aparecerá toda la información
        de la incidencia. En esta ventana debe de pinchar en el botón <strong>Desatender incidencia</strong>
        <a class="btn btn-warning btn-sm" role="button">
            Desatender incidencia
        </a>.
    </p>
</section>
@endif

<section id="solve-incident">
    <h4>Marcar incidencia como resuelta</h4>
    <p>
        Para marcar como resuelta una incidencia, debe de dirigirse en el menú izquierdo al apartado de
        <a href="{{ route("home") }}" class="btn btn-light">
            <i class="fa fa-th-large mr-3 fa-fw"></i>
            Dashboard
        </a>.
    </p>
    <p>
        Una vez le haya cargado la página, debe dirigirse a la <strong>tabla de mis incidencias</strong>,
        buscar el registro de la incidencia que quiere marcar como resuelta y en la columna <em>opciones</em> pinchar en
        el botón de <strong>Ver</strong>
        <a class="btn btn-info btn-sm" role="button">
            Ver
        </a>.
    </p>
    <p>
        Se le redirigirá a una ventana en la cual aparecerá toda la información
        de la incidencia. En esta ventana debe de pinchar en el botón <strong>Marcar como resuelta</strong>
        <a class="btn btn-success btn-sm" role="button">
            Marcar como resuelta
        </a>.
    </p>
    <p class="text-muted">
        Las incidencias solo pueden ser marcadas como resuelta por el usuario que las creo.
    </p>
</section>

<section id="open-incident">
    <h4>Volver a abrir incidencia</h4>
    <p>
        Para volver a abrir una incidencia, debe de dirigirse en el menú izquierdo al apartado de
        <a href="{{ route("home") }}" class="btn btn-light" role="button">
            <i class="fa fa-th-large mr-3 fa-fw"></i>
            Dashboard
        </a>.
    </p>
    <p>
        Una vez le haya cargado la página, debe dirigirse a la <strong>tabla de mis incidencias</strong>,
        buscar el registro de la incidencia que quiere volver a abrir y en la columna <em>opciones</em> pinchar en
        el botón de <strong>Ver</strong>
        <a class="btn btn-info btn-sm" role="button">
            Ver
        </a>.
    </p>
    <p>
        Se le redirigirá a una ventana en la cual aparecerá toda la información
        de la incidencia. En esta ventana debe de pinchar en el botón <strong>Volver a abrir la incidencia</strong>
        <a class="btn btn-info btn-sm" role="button">
            Volver a abrir la incidencia
        </a>.
    </p>
    <p class="text-muted">
        Esta acción solo se puede realizar si la incidencia se había marcado como resuelta anteriormente y por el
        usuario que la creo.
    </p>
</section>

@if (! auth()->user()->is_client)
<section id="nextlevel-incident">
    <h4>Derivar incidencia al siguiente nivel</h4>
    <p>
        Para derivar una incidencia al siguiente nivel, debe de dirigirse en el menú izquierdo al apartado de
        <a href="{{ route("home") }}" class="btn btn-light" role="button">
            <i class="fa fa-th-large mr-3 fa-fw"></i>
            Dashboard
        </a>.
    </p>
    <p>
        Una vez le haya cargado la página, debe dirigirse a la <strong>tabla de Incidencias asignadas a mí</strong>,
        buscar el registro de la incidencia que quiere derivar al siguiente nivel y en la columna <em>opciones</em>
        pinchar en el botón de <strong>Ver</strong>
        <a class="btn btn-info btn-sm" role="button">
            Ver
        </a>.
    </p>
    <p>
        Se le redirigirá a una ventana en la cual aparecerá toda la información
        de la incidencia. En esta ventana debe de pinchar en el botón <strong>Derivar al siguiente nivel</strong>
        <a class="btn btn-danger btn-sm" role="button">
            Derivar al siguiente nivel
        </a>.
    </p>
    <p class="text-muted">
        Esta acción solo la puede realizar un administrador o el usuario que esta atendiendo la incidencia, para saber
        como atender una incidencia <a href="#take-incident">pinche aqui</a>
    </p>
</section>
@endif