@extends('layouts.empresa')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1><b>Bienvenido</b>  
                 @auth('empresa') {{ Auth::guard('empresa')->user()->NomComercial }} @else
                    <p>No estás autenticado.</p>@endauth</h1>
             
                


                </div>
                <div class="col-md-12"></div>
            </div>
        </div>
    @endsection
