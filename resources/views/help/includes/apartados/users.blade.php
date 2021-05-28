<section id="users">
    <h2>Usuarios</h2>
</section>

<section id="see-users">
    <h4>Ver usuarios</h4>
    <p>
        Para ver a los usuarios registrados en la aplicación, debe de dirigirse en el menú izquierdo al apartado de
        <a href="{{ route("usuarios") }}" class="btn btn-light" role="button">
            <i class="fas fa-users-cog mr-3 fa-fw"></i>
            Usuarios
        </a>.
    </p>
    <p>
        Una vez le haya cargado la página, le aparecerá en la <strong>parte inferior de la página</strong> una tabla con
        todos los usuarios registrados.
    </p>
</section>

<section id="create-user">
    <h4>Crear usuario</h4>
    <p>
        Para crear un usuario, debe de dirigirse en el menú izquierdo al apartado de
        <a href="{{ route("usuarios") }}" class="btn btn-light" role="button">
            <i class="fas fa-users-cog mr-3 fa-fw"></i>
            Usuarios
        </a>.
    </p>
    <p>
        Una vez le haya cargado la página, le aparecerá en la <strong>parte superior de la página</strong> un
        formulario, el cual debe de rellenar con los datos del nuevo usuario.
    </p>
    <p class="text-muted">
        La contraseña se almacena cifrada para una mayor seguridad.
    </p>
</section>

<section id="edit-user">
    <h4>Editar usuario</h4>
    <p>
        Para editar un usuario, debe de dirigirse en el menú izquierdo al apartado de
        <a href="{{ route("usuarios") }}" class="btn btn-light" role="button">
            <i class="fas fa-users-cog mr-3 fa-fw"></i>
            Usuarios
        </a>.
    </p>
    <p>
        Una vez le haya cargado la página, debe dirigirse a la <strong>tabla inferior</strong>, buscar el registro del
        usuario que quiere editar y en la columna <em>opciones</em> pinche en el botón de <strong>Editar
            usuario</strong>
        <a class="btn btn-sm btn-primary" title="" data-toggle="tooltip" data-placement="top"
            data-original-title="Editar" role="button">
            <i class="fas fa-user-edit"></i>
        </a>.
    </p>
    <p>
        Se le redirigirá a una ventana en la cual aparecerá un formulario en la
        <strong>parte superior</strong>, el cual debe de rellenar con los <strong>nuevos datos del usuario</strong>.
    </p>
</section>

<section id="disabled-user">
    <h4>Dar de baja a un usuario</h4>
    <p>
        Para dar de baja a un usuario, debe de dirigirse en el menú izquierdo al apartado de
        <a href="{{ route("usuarios") }}" class="btn btn-light" role="button">
            <i class="fas fa-users-cog mr-3 fa-fw"></i>
            Usuarios
        </a>.
    </p>
    <p>
        Una vez le haya cargado la página, debe dirigirse a la <strong>tabla inferior</strong> buscar el registro del
        usuario que quiere
        dar de baja y en la columna <em>opciones</em> pinche en el botón de <strong>Dar de baja</strong>
        <a class="btn btn-sm btn-warning" title="" data-toggle="tooltip" data-placement="top"
            data-original-title="Dar de baja" role="button">
            <i class="fas fa-user-times"></i>
        </a>.
    </p>
</section>

<section id="enabled-user">
    <h4>Restaurar usuario</h4>
    <p>
        Para volver a activar una cuenta de usuario, debe de dirigirse en el menú izquierdo al apartado de
        <a href="{{ route("usuarios") }}" class="btn btn-light" role="button">
            <i class="fas fa-users-cog mr-3 fa-fw"></i>
            Usuarios
        </a>.
    </p>
    <p>
        Una vez le haya cargado la página, debe dirigirse a la <strong>tabla inferior</strong>, buscar el registro del
        usuario que quiere
        restaurar y en la columna <em>opciones</em> pinche en el botón de <strong>Restaurar usuario</strong>
        <a class="btn btn-sm btn-success" title="" data-toggle="tooltip" data-placement="top"
            data-original-title="Restaurar" role="button">
            <i class="fas fa-trash-restore"></i>
        </a>.
    </p>
</section>

<section id="delete-user">
    <h4>Eliminar usuarios</h4>
    <p>
        Para eliminar un usuario, debe de dirigirse en el menú izquierdo al apartado de
        <a href="{{ route("usuarios") }}" class="btn btn-light" role="button">
            <i class="fas fa-users-cog mr-3 fa-fw"></i>
            Usuarios
        </a>.
    </p>
    <p>
        Una vez le haya cargado la página, debe dirigirse a la <strong>tabla inferior</strong>, buscar el registro del
        usuario que quiere
        eliminar y en la columna <em>opciones</em> pinche en el botón de <strong>Eliminar usuario</strong>
        <a class="btn btn-sm btn-danger" title="" data-toggle="tooltip" data-placement="top"
            data-original-title="Eliminar" role="button">
            <i class="fas fa-minus-circle"></i>
        </a>.
    </p>
    <p class="text-muted">
        Tenga en cuenta que para eliminar un usuario antes debe de haberlo dado de baja, si quiere saber como hacerlo
        <a href="#disabled-user">pinche aqui</a>.
    </p>
</section>

<section id="create-project-user">
    <h4>Asignar un proyecto a un usuario de soporte</h4>
    <p>
        Para asignar un proyecto a un usuario, debe de dirigirse en el menú izquierdo al apartado de
        <a href="{{ route("usuarios") }}" class="btn btn-light" role="button">
            <i class="fas fa-users-cog mr-3 fa-fw"></i>
            Usuarios
        </a>.
    </p>
    <p>
        Una vez le haya cargado la página, debe dirigirse a la <strong>tabla inferior</strong>, buscar el registro del
        usuario que quiere
        asignar un proyecto y en la columna <em>opciones</em> pinche en el botón de <strong>Editar usuario</strong>
        <a class="btn btn-sm btn-primary" title="" data-toggle="tooltip" data-placement="top"
            data-original-title="Editar" role="button">
            <i class="fas fa-user-edit"></i>
        </a>.
    </p>
    <p>
        Se le redirigirá a una ventana en la cual en la <strong>parte inferior</strong> le aparecerán dos campos de
        selección, en el
        de la <strong>izquierda seleccionará el proyecto</strong> y en el de la <strong>derecha el nivel</strong> que
        será asignado al usuario en dicho
        proyecto.
    </p>
    <p class="text-muted">
        Tenga en cuenta que esta acción solo puede realizarse sobre usuarios de soporte.
    </p>
</section>

<section id="edit-project-user">
    <h4>Editar la asignación de un proyecto a un usuario de Soporte</h4>
    <p>
        Para editar la asignación de un proyecto a un usuario, debe de dirigirse en el menú izquierdo al apartado de
        <a href="{{ route("usuarios") }}" class="btn btn-light" role="button">
            <i class="fas fa-users-cog mr-3 fa-fw"></i>
            Usuarios
        </a>.
    </p>

    <p>
        Una vez le haya cargado la página, debe dirigirse a la <strong>tabla inferior</strong>, buscar el registro del
        usuario que quiere
        editar la asignación de un proyecto y en la columna <em>opciones</em> pinche en el botón de <strong>Editar
            usuario</strong>
        <a class="btn btn-sm btn-primary" title="" data-toggle="tooltip" data-placement="top"
            data-original-title="Editar" role="button">
            <i class="fas fa-user-edit"></i>
        </a>.
    </p>

    <p>
        Se le redirigirá a una ventana en la cual en la <strong>parte inferior</strong> aparecerá una tabla con todos
        los proyectos a los
        que pertenece el usuario seleccionado, en la tabla debe de buscar la relación que quiere editar y pinchar en el
        botón de
        <strong>Editar</strong>
        <a class="btn btn-sm btn-primary" title="" data-toggle="tooltip" data-placement="top"
            data-original-title="Editar" role="button">
            <i class="fas fa-edit"></i>
        </a>.
    </p>

    <p>
        Se le abrirá un modal en el cual indicara el nuevo nivel que tendrá el usuario asignado en el proyecto.
    </p>

    <p class="text-muted">
        Tenga en cuenta que esta acción solo puede realizarse sobre usuarios de soporte con proyectos asignados.
    </p>
</section>

<section id="delete-project-user">
    <h4>Eliminar la asignación de un proyecto a un usuario de Soporte</h4>
    <p>
        Para eliminar la asignación de un proyecto a un usuario, debe de dirigirse en el menú izquierdo al apartado de
        <a href="{{ route("usuarios") }}" class="btn btn-light" role="button">
            <i class="fas fa-users-cog mr-3 fa-fw"></i>
            Usuarios
        </a>.
    </p>

    <p>
        Una vez le haya cargado la página, debe dirigirse a la <strong>tabla inferior</strong>, buscar el registro del
        usuario que quiere
        eliminar la asignación de un proyecto y en la columna <em>opciones</em> pinche en el botón de <strong>Editar
            usuario</strong>
        <a class="btn btn-sm btn-primary" title="" data-toggle="tooltip" data-placement="top"
            data-original-title="Editar" role="button">
            <i class="fas fa-user-edit"></i>
        </a>.
    </p>

    <p>
        Se le redirigirá a una ventana en la cual en la <strong>parte inferior</strong> aparecerá una tabla con todos
        los proyectos a los
        que pertenece el usuario seleccionado, en la tabla debe de buscar la relación que quiere editar y pinchar en el
        botón de
        <strong>Eliminar</strong>
        <a class="btn btn-sm btn-danger" title="" data-toggle="tooltip" data-placement="top"
            data-original-title="Dar de baja" role="button">
            <i class="fas fa-trash"></i>
        </a>.
    </p>

    <p class="text-muted">
        Tenga en cuenta que esta acción solo puede realizarse sobre usuarios de soporte con proyectos asignados.
    </p>
</section>