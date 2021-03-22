@if (session("notification"))
    <div class="toast fixed-top fade show ml-auto" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="fas fa-bell text-warning mr-3"></i>
            <strong class="mr-auto">Atencion</strong>
            <small>Ahora mismo</small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true" class="text-black-50">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            {{ session("notification") }}
        </div>
    </div>
@endif