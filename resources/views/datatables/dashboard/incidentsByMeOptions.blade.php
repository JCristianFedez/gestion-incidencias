<div class="text-center">
    <form action="{{ route('incidencia.disatend', $id) }}" method="GET" class="d-inline-block not-send w-100 mb-1">
        @csrf
        <input type="hidden" data-incident-name="{{$title}}" value="{{$title}}">
        <button type="submit" class="btn btn-warning btn-sm btn-block disatend-incident w-100" data-action="disatend-incident">
            Desatender
        </button>
    </form>
    
    <a href="{{ route("incidencia.show",$id) }}" class="btn btn-info btn-sm btn-block w-100">
        Ver
    </a>
</div>