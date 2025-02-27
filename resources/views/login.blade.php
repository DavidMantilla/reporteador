<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>login</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
</head>

<body>

    <div class="container-fluid login-container">
        <div class="row justify-content-center">
            <div class="col-lg-4">

                <div class="card" >
                    <div class="card-body" style="padding: 10px; margin: 0px">
                        <div class="container">
                            <div class="row justify-content-center" style="margin: 30px">
                                <div class="col-5" style="margin-top: 10px">
                                    
                                    <img src="/img/Recurso 2.svg" alt="" srcset="" width="100%" >
                                   <br><br>
                                    <h4 style="text-align: center; font-weight:bolder; color: black ">Login</h4>
                                </div>
                            </div>
                            

                            <div class="row justify-content-center">
                                <div class="col-md-11">

                                    <form action="{{route('apiLogin')}}" method="post" id="login">
                                         @csrf
                                         <input type="hidden" name="ruta" value='{{ route('home')}}'   style="margin-bottom: 20px"></span>                                        
                                        <label for="" class="label">Correo</label>
                                        <input type="email" class="form-control" name="correo"  style="margin-bottom: 30px">
                                        <label for="" class="label">Contraseña</label>
                                        <input type="password" class="form-control" name="password"  style="margin-bottom: 30px">
                                        <div class="d-none " style="color: red; padding: 10px;margin-left:auto" id="error">
                                            <b>Revisa tu usuario y/o contraseña</b> </div>
                                        <button class="btn btn-login"> Entrar</button>
                                        <br>
                                        <br>
                                        <br>
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
