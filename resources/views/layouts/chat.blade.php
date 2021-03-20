<div class="card border-primary">
    <div class="card-header  bg-primary text-white">Discusion</div>

    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <ul class="list-unstyled">
            @foreach ($messages as $message)
                <li class="media">
                    <a class="mr-3" href="#">
                        <img class="rounded-circle img-fluid bg-secondary" src="{{ asset($message->user->avatar_path) }}" width="48">
                    </a>
                    <div class="media-body">
                        {{ $message->message }}
                        <br>
                        <small class="text-muted">{{ $message->user->name }} | {{ $message->created_at }}</small>
                        <hr>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="card-footer">
        <form action="/incidencia/{{ $incident->id }}/mensajes" method="POST">
            @csrf
            <div class="input-group">
                <input type="text" class="form-control" name="message">
                <span class="input-group-append">
                    <button class="btn btn-default" type="submit">Enviar</button>
                </span>
            </div>    
        </form>        
    </div>
</div>