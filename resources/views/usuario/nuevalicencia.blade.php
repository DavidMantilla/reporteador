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
                        <div class="col-11" style="padding-right: 10px">
                            
                            <form action="{{$request->get('id')!=""?  Route('apiUpdate')  : Route('apiRegister') }}" method="post" id="empresa">
                                <div class="row justify-content-start">
                                    @csrf
                                    @php echo $request->get('id')!=""?"<input type='hidden' value='".$request->get('id')."' name='id'>":""; @endphp
                                    <div class="alert alert-danger" style="display: none" id="error">debes llenar todos los campos</div>
                                    <div class="alert alert-secondary" style="display: none" id="exito">se ha registrado el usuario con <b>éxito</b></b> </div>
                                    <div class="col-md-6"><label class="label" for="">Empresa</label>
                                      <select name="slempresa" id="slempresa" class="form-select"></select>
                                    </div>
                                    <div class="col-md-6"><label class="label" for="">Sucursal</label>
                                        <select name="slsucursal" id="slsucursal" class="form-select"></select>
                                    </div>
                                    
                                   
                                    <div class="col-md-6"><label class="label" for="">Id Unico</label>
                                        <input type="text" class="form-control" name="Id_Unico">
                                    </div>
                                    <div class="col-md-6"><label class="label" for="">Estado</label> <br>
                                        <input type="checkbox" class="form-check-input" name="Estado">
                                    </div>
                                    <div class="col-md-6"><label class="label" for="">Fecha inicial</label>
                                        <input type="date" class="form-control" name="FechaInicial">
                                    </div>
                                    <div class="col-md-6"><label class="label" for="">Fecha final</label>
                                        <input type="date" Class="form-control" name="FechaFinal">
                                    </div>
                                    
                                    
                                    <div class="col-md-7" style="margin: auto">
                                        <br>
                                        <button class="btn btn-primary text-light " style="width: 100%">Guardar</button>
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
