<section id="projects">
    <h2>Proyectos</h2>
</section>

<section id="see-projects">
    <h4>Ver proyectos</h4>
    <p>
        Para ver los proyectos, debe de dirigirse en el menú izquierdo al apartado de
        <a href="{{ route("proyectos") }}" class="btn btn-light">
            <i class="fas fa-project-diagram mr-3 fa-fw"></i>
            Proyectos
        </a>.
    </p>
    <p>
        Una vez le haya cargado la página, le aparecerá en la <strong>parte inferior de la página</strong> una tabla con
        todos los
        proyectos.
    </p>
</section>

<section id="create-project">
    <h4>Crear proyecto</h4>
    <p>
        Para crear proyectos, debe de dirigirse en el menú izquierdo al apartado de
        <a href="{{ route("proyectos") }}" class="btn btn-light">
            <i class="fas fa-project-diagram mr-3 fa-fw"></i>
            Proyectos
        </a>.
    </p>
    <p>
        Una vez le haya cargado la página, le aparecerá en la <strong>parte superior de la página</strong> un
        formulario, el cual debe de
        rellenar con los datos del nuevo proyecto.
    </p>
</section>

<section id="edit-project">
    <h4>Editar proyecto</h4>
    <p>
        Para editar un proyecto, debe de dirigirse en el menú izquierdo al apartado de
        <a href="{{ route("proyectos") }}" class="btn btn-light">
            <i class="fas fa-project-diagram mr-3 fa-fw"></i>
            Proyectos
        </a>.
    </p>
    <p>
        Una vez le haya cargado la página, debe dirigirse a la <strong>tabla inferior</strong>, buscar el registro del
        proyecto que
        quiere editar y en la columna <em>opciones</em> pinche en el botón de <strong>Editar proyecto</strong>
        <a class="btn btn-sm btn-primary" title="" data-toggle="tooltip" data-placement="top"
            data-original-title="Editar">
            <i class="fas fa-edit"></i>
        </a>.
    </p>
    <p>
        Se le redirigirá a una ventana en la cual aparecera un formulario en la
        <strong>parte superior</strong>, el cual debe de rellenar con los nuevos datos del proyecto.
    </p>
</section>

<section id="disabled-project">
    <h4>Dar de baja a un proyecto</h4>
    <p>
        Para dar de baja a un proyecto, debe de dirigirse en el menú izquierdo al apartado de
        <a href="{{ route("proyectos") }}" class="btn btn-light">
            <i class="fas fa-project-diagram mr-3 fa-fw"></i>
            Proyectos
        </a>.
    </p>
    <p>
        Una vez le haya cargado la página, debe dirigirse a la <strong>tabla inferior</strong>, buscar el registro del
        proyecto que
        quiere
        dar de baja y en la columna <em>opciones</em> pinche en el botón de <strong>Dar de baja</strong>
        <a class="btn btn-sm btn-danger" title="" data-toggle="tooltip" data-placement="top"
            data-original-title="Dar de baja">
            <i class="fas fa-trash"></i>
        </a>.
    </p>
</section>

<section id="enabled-project">
    <h4>Restaurar proyecto</h4>
    <p>
        Para volver a activar un proyecto, debe de dirigirse en el menú izquierdo al apartado de
        <a href="{{ route("proyectos") }}" class="btn btn-light">
            <i class="fas fa-project-diagram mr-3 fa-fw"></i>
            Proyectos
        </a>.
    </p>
    <p>
        Una vez le haya cargado la página, debe dirigirse a la <strong>tabla inferior</strong>, buscar el registro del
        proyecto que
        quiere restaurar y en la columna <em>opciones</em> pinche en el botón de <strong>Restaurar proyecto</strong>
        <a class="btn btn-sm btn-success" title="" data-toggle="tooltip" data-placement="top"
            data-original-title="Restaurar">
            <i class="fas fa-trash-restore"></i>
        </a>.
    </p>
</section>

<section id="delete-project">
    <h4>Eliminar proyecto</h4>
    <p>
        Para eliminar un proyecto, debe de dirigirse en el menú izquierdo al apartado de
        <a href="{{ route("proyectos") }}" class="btn btn-light">
            <i class="fas fa-project-diagram mr-3 fa-fw"></i>
            Proyectos
        </a>.
    </p>
    <p>
        Una vez le haya cargado la página, debe dirigirse a la <strong>tabla inferior</strong>, buscar el registro del
        proyecto que
        quiere eliminar y en la columna <em>opciones</em> pinche en el botón de <strong>Eliminar proyecto</strong>
        <a class="btn btn-sm btn-danger" title="" data-toggle="tooltip" data-placement="top"
            data-original-title="Eliminar">
            <i class="fas fa-minus-circle"></i>
        </a>.
    </p>
    <p class="text-muted">
        Tenga en cuenta que para eliminar un proyecto antes debe de haberlo dado de baja, si quiere saber como hacerlo
        <a href="#disabled-project">pinche aqui</a>.
    </p>
</section>

<section id="change-project">
    <h4>Cambiar de proyecto</h4>
    <p>
        Para cambiar de proyecto debe de pinchar en el <strong>selector del menú superior</strong>
        @if (auth()->user()->selected_project_id)
        <select id="select-project-instruction" class="custom-select d-inline-block w-auto">
            @foreach (auth()->user()->list_of_projects as $project)
            <option value="{{ $project->id }}" @if($project->id ==
                auth()->user()->selected_project_id) selected @endif>
                {{ $project->name }}
            </option>
            @endforeach
        </select>
        @else
        <select class="custom-select">
            <option selected>No pertenece a ningun proyecto</option>
        </select>
        @endif
        .
    </p>
    <p>
        Se le desplegara una lista con todos los proyectos en los que puede participar, en ella debe de <strong> pinchar
            en el proyecto que desea </strong>, automáticamente la aplicación se actualizara mostrando las incidencias
        de dicho proyecto así como cuando se cree una nueva se creara sobre dicho proyecto.
    </p>
    <p class="text-muted">
        Los usuarios de soporte que no tengan ningún proyecto asignado no podrán usar esta funcionalidad.
    </p>
</section>