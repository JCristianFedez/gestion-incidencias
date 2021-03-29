<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th data-sortable="true">
                    E-mail
                    <div class="btn-group-vertical">
                        <button class="btn btn-outline-dark btn-sm order-data py-0" aria-hidden="true" data-orden="asc"
                            data-campo="email">
                            <i class="fa fa-sort-up"></i>
                        </button>
                        <button class="btn btn-outline-dark btn-sm order-data py-0" aria-hidden="true" data-orden="desc"
                            data-campo="email">
                            <i class="fa fa-sort-down"></i>
                        </button>
                    </div>
                </th>
                <th data-sortable="true">
                    Nombre
                    <div class="btn-group-vertical">
                        <button class="btn btn-outline-dark btn-sm order-data py-0" aria-hidden="true" data-orden="asc"
                            data-campo="name">
                            <i class="fa fa-sort-up"></i>
                        </button>
                        <button class="btn btn-outline-dark btn-sm order-data py-0" aria-hidden="true" data-orden="desc"
                            data-campo="name">
                            <i class="fa fa-sort-down"></i>
                        </button>
                    </div>
                </th>
                <th>Rol</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($users as $user)
            <tr>
                <td>{{ $user->email }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->role_name }}</td>
                <td>
                    <a href="/usuario/{{$user->id}}" class="btn btn-sm btn-primary" title="Editar" data-toggle="tooltip"
                        data-placement="left">
                        <i class="fas fa-user-edit"></i>
                    </a>
                    <form action="/usuario/{{$user->id}}" method="POST" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="Dar de baja" data-toggle="tooltip"
                            data-placement="right">
                            <i class="fas fa-user-times"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{-- Pagination --}}
<div class="d-flex justify-content-center" id="paginacionUsuarios">
    {!! $users->links() !!}
</div>