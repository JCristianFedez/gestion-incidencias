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
                    @if (auth()->user()->id != $message->user_id)
                        {{-- <a class="mr-3" href="#"> --}}
                            <img class="rounded-circle img-fluid bg-secondary mr-3" src="{{ asset($message->user->avatar_path) }}" width="48">
                        {{-- </a> --}}
                        <div class="media-body ">
                            {{ $message->message }}
                            <br>
                            <small class="text-muted">{{ $message->user->name }} | {{ $message->created_at }}</small>
                            <hr>
                        </div>
                    @endif

                    @if (auth()->user()->id == $message->user_id)
                        <div class="media-body text-right">
                            {{ $message->message }}
                            <br>
                            <small class="text-muted">{{ $message->user->name }} | {{ $message->created_at }}</small>
                            <hr>
                        </div>
                        {{-- <a class="mr-3" href="#"> --}}
                            <img class="rounded-circle img-fluid bg-secondary ml-3" src="{{ asset($message->user->avatar_path) }}" width="48">
                        {{-- </a> --}}
                    @endif
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
