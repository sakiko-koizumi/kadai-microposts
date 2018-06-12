    @if (Auth::user()->is_favourite($micropost->id))
        {!! Form::open(['route' => ['user.unfavourites', $micropost->id], 'method' => 'delete']) !!}
            {!! Form::submit('Unfavourites', ['class' => "btn btn-danger btn-xs"]) !!}
        {!! Form::close() !!}
    @else
        {!! Form::open(['route' => ['user.favourites', $micropost->id]]) !!}
            {!! Form::submit('favourites', ['class' => "btn btn-primary btn-xs"]) !!}
        {!! Form::close() !!}
    @endif
