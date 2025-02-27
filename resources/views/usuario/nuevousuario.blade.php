@extends('layouts.usuario')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <br>
            <br>
            <br>
            <div class="card">

                <div class="card-body">

                    <div class="row justify-content-center">
                        <div class="col-md-10">

                            <div class="alert alert-danger" style="display: none" id="error">debes llenar todos los campos
                            </div>
                            <div class="alert alert-secondary" style="display: none" id="exito">se ha registrado el
                                usuario con <b>éxito</b></b> </div>
                            <form action=" {{ $request->get('id') != '' ? Route('apiUpdate') : Route('apiRegister') }}"
                                method="post" id="usuario">
                                <div class="row justify-content-left">
                                    @csrf
                                    @php
                                        echo $request->get('id') != ''
                                            ? "<input type='hidden' value='" .
                                                $request->get('id') .
                                                "'
                                        name='id'>"
                                        : ''; @endphp

                                    <div class="col-md-6"><label class="label" for="">Nombre Completo</label>
                                        <input type="text" class="form-control" name="Nombre">
                                    </div>



                                    <div class="col-md-6"><label class="label" for="">Administrador</label> <br>
                                        <input type="checkbox" class="form-check-input" name="Admin">
                                    </div>
                                    <div class="col-md-6"><label class="label" for="">Correo</label>
                                        <input type="email" class="form-control" name="Correo">
                                    </div>
                                    <div class="col-md-6"><label class="label" for="">contraseña</label>
                                        <input type="password" Class="form-control" name="password">
                                    </div>
                                    <div class="col-md-6"><label class="label" for=""> confirme su
                                            contraseña</label>
                                        <input type="password" Class="form-control" name="password2">
                                    </div>
                                    <div class="col-md-8" style="margin: auto">
                                        <br>
                                        <button class="btn btn-primary text-light"
                                            style="width: 100%; margin: auto">Guardar</button>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
