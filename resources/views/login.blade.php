<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>login</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>

    <div class="container-fluid login-container">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card">
                    <div class="card-body">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-10">
                                    <h2 class="login-title">login</h2>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-10">

                                    <form action="{{route('apiLogin')}}" method="post" id="login">
                                         @csrf
                                         <input type="hidden" name="ruta" value='{{ route('home')}}'></span>                                        
                                        <label for="" class="label">Correo</label>
                                        <input type="email" class="form-control" name="correo">
                                        <label for="" class="label">Contraseña</label>
                                        <input type="password" class="form-control" name="password">
                                        <div class="d-none " style="color: red; padding: 10px;margin-left:auto" id="error">
                                            <b>Revisa tu usuario y/o contraseña</b> </div>
                                        <button class="btn btn-login"> Entrar</button>
                                </div>




                                </form>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>



</body>

</html>
