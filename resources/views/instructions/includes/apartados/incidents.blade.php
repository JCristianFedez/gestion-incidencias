<section id="incidents">
    <h2>Incidencias</h2>
</section>

<section id="see-incidents">
    <h4>Ver incidencias</h4>
    <p>
        Para ver las incidencias, debe de dirigirse en el menú izquierdo al apartado de
        <a href="{{ route("home") }}" class="btn btn-light">
            <i class="fa fa-th-large mr-3 fa-fw"></i>
            Dashboard
        </a>.
    </p>

    <p>
        @if (auth()->user()->is_client)
        Una vez le haya cargado la pagina, le aparecerá la siguiente tabla.
        @else
        Una vez le haya cargado la pagina, le aparecerán las siguientes tablas.
        @endif
    </p>

    <ol>
        @if (! auth()->user()->is_client)
        <li>
            <strong>Incidencias asignadas a mi</strong>
            <ul>
                <li>En esta tabla puede ver todas las incidencias que esta atendiendo.</li>
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
                <li>En esta tabla puede ver todas las incidencias que esta atendiendo.</li>
            </ul>
        </li>
        @endif
    </ol>

    <p>
        Si desea ver mas información acerca de una incidencia dirigase a la columna <em>opciones</em> de dicha
        incidencia y pinche en el botón de <strong>Ver</strong>
        <a class="btn btn-info btn-sm">
            Ver
        </a>
    </p>
</section>

<section id="create-incident">
    <h4>Crear incidencia</h4>
    <p>
        Para crear una incidencia, debe de dirigirse en el menú izquierdo al apartado de
        <a href="{{ route("reportar.create") }}" class="btn btn-light">
            <i class="fa fa-address-card mr-3 fa-fw"></i>
            Reportar
        </a>.
    </p>
    <p>
        Una vez le haya cargado la pagina, le aparecerá en la parte superior de la pagina un formulario, el cual debe de
        rellenar con los datos de la incidencia.
    </p>
</section>

<section id="edit-incident">
    <h4>Editar incidencia</h4>
</section>

<section id="take-incident">
    <h4>Atender incidencia</h4>
</section>

<section id="disregard-incident">
    <h4>Desatender incidencia</h4>
</section>

<section id="solve-incident">
    <h4>Marcar incidencia como resuelta</h4>
</section>

<section id="open-incident">
    <h4>Volver a abrir incidencia</h4>
</section>

<section id="nextlevel-incident">
    <h4>Derivar incidencia al siguiente nivel</h4>
</section>