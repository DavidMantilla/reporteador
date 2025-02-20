
@extends('layouts.usuario')

@section('content')

<h1>@auth('web') Hola {{ Auth::guard('web')->user()->Nombre  }}</h1>
    @else
<p>No estás autenticado.</p>@endauth
@endsection