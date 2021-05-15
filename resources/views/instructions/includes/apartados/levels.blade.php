<section id="levels">
    <h2>Niveles</h2>
</section>

<section id="see-levels">
    <h4>Ver niveles de proyecto</h4>
    <p>
        Para ver los niveles que tiene un proyecto, debe de dirigirse en el menú izquierdo al apartado de
        <a href="{{ route("proyectos") }}" class="btn btn-light">
            <i class="fas fa-project-diagram mr-3 fa-fw"></i>
            Proyectos
        </a>.
    </p>
    <p>
        Una vez le haya cargado la página, debe dirigirse a la <strong>tabla inferior</strong>, buscar el registro del proyecto del cual
        quiere ver sus niveles y en la columna <em>opciones</em> pinchar en el botón de <strong>Editar proyecto</strong>
        <a class="btn btn-sm btn-primary" title="" data-toggle="tooltip" data-placement="top"
            data-original-title="Editar">
            <i class="fas fa-edit"></i>
        </a>.
    </p>
    <p>
        Se le redirigirá a una ventana en la cual en la <strong>parte inferior</strong> aparecerá una tabla con todos los niveles
        del proyecto seleccionado.
    </p>
</section>

<section id="create-level">
    <h4>Agregar nivel a proyecto</h4>
    <p>
        Para agregar un nivel a un proyecto, debe de dirigirse en el menú izquierdo al apartado de
        <a href="{{ route("proyectos") }}" class="btn btn-light">
            <i class="fas fa-project-diagram mr-3 fa-fw"></i>
            Proyectos
        </a>.
    </p>
    <p>
        Una vez le haya cargado la página, debe dirigirse a la <strong>tabla inferior</strong>, buscar el registro del proyecto al cual
        le quiere agregar un nivel y en la columna <em>opciones</em> pinchar en el botón de
        <strong>Editar proyecto</strong>
        <a class="btn btn-sm btn-primary" title="" data-toggle="tooltip" data-placement="top"
            data-original-title="Editar">
            <i class="fas fa-edit"></i>
        </a>.
    </p>
    <p>
        Se le redirigirá a una ventana en la cual en la <strong>parte inferior</strong> aparecerá un campo numérico en el cual se debe de
        indicar la importancia y otro campo de texto en el cual debe de ingresar el nombre del nivel.
    </p>
    <p class="text-muted">
        Tenga en cuenta el nivel 1 tiene menos importancia que el nivel 2, por lo que cuando una incidencia de nivel 1
        se deriva al siguiente nivel esta pasara a estar en el nivel 2.
    </p>
</section>

<section id="edit-level">
    <h4>Editar nivel</h4>
    <p>
        Para editar un nivel de un proyecto, debe de dirigirse en el menú izquierdo al apartado de
        <a href="{{ route("proyectos") }}" class="btn btn-light">
            <i class="fas fa-project-diagram mr-3 fa-fw"></i>
            Proyectos
        </a>.
    </p>
    <p>
        Una vez le haya cargado la página, debe dirigirse a la <strong>tabla inferior</strong>, buscar el registro del proyecto del cual
        quiere editar un nivel y en la columna <em>opciones</em> pinchar en el botón de <strong>Editar proyecto</strong>
        <a class="btn btn-sm btn-primary" title="" data-toggle="tooltip" data-placement="top"
            data-original-title="Editar">
            <i class="fas fa-edit"></i>
        </a>.
    </p>
    <p>
        Se le redirigirá a una ventana en la cual en la <strong>parte inferior</strong> aparecerá una tabla con todos los niveles
        del proyecto seleccionado, en ella debe de buscar el registro del nivel a editar y en la columna
        <em>opciones</em> pinchar en el botón de <strong>Editar</strong>
        <a class="btn btn-sm btn-primary" title="" data-toggle="tooltip" data-placement="top"
            data-original-title="Editar">
            <i class="fas fa-edit"></i>
        </a>.
    </p>
    <p>
        Se abrirá un modal con dos campos, el primero es un campo de texto en el cual debe de introducir el nuevo nombre
        del nivel y el segundo es un campo numérico en el cual debe de ingresar la importancia del nivel
    </p>
    <p class="text-muted">
        Tenga en cuenta el nivel 1 tiene menos importancia que el nivel 2, por lo que cuando una incidencia de nivel 1
        se deriva al siguiente nivel esta pasara a estar en el nivel 2.
    </p>
</section>

<section id="delete-level">
    <h4>Eliminar nivel</h4>
    <p>
        Para eliminar un nivel de un proyecto, debe de dirigirse en el menú izquierdo al apartado de
        <a href="{{ route("proyectos") }}" class="btn btn-light">
            <i class="fas fa-project-diagram mr-3 fa-fw"></i>
            Proyectos
        </a>.
    </p>
    <p>
        Una vez le haya cargado la página, debe dirigirse a la <strong>tabla inferior</strong>, buscar el registro del proyecto del cual
        quiere eliminar un nivel y en la columna <em>opciones</em> pinchar en el botón de
        <strong>Editar proyecto</strong>
        <a class="btn btn-sm btn-primary" title="" data-toggle="tooltip" data-placement="top"
            data-original-title="Editar">
            <i class="fas fa-edit"></i>
        </a>.
    </p>
    <p>
        Se le redirigirá a una ventana en la cual en la <strong>parte inferior</strong> aparecerá una tabla con todos los niveles
        del proyecto seleccionado, en ella debe de buscar el registro del nivel a eliminar y en la columna
        <em>opciones</em> pinchar en el botón de <strong>Eliminar</strong>
        <a class="btn btn-sm btn-danger" title="" data-toggle="tooltip" data-placement="top"
            data-original-title="Eliminar">
            <i class="fas fa-trash"></i>
        </a>.
    </p>
    <p class="text-muted">
        Tenga en cuenta que al eliminar un nivel, todas las incidencias de dicho nivel pasaran al siguiente nivel. De no
        ser posible pasaran al nivel general.
    </p>
</section>