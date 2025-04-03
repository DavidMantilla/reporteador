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
                            
                            <form action="{{Route('ApiNuevaSucursal')}}" method="post" id="formsucursal">
                                <div class="row justify-content-start">
                                    @csrf
                                    
                                    @php echo $request->get('id')!=""?"<input type='hidden' value='".$request->get('id')."' name='id'>":""; @endphp
                                    <div class="alert alert-danger" style="display: none" id="error">debes llenar todos los campos</div>
                                    <div class="alert alert-secondary" style="display: none" id="exito">se ha registrado el usuario con <b>éxito</b></b> </div>
                                    <div class="col-md-6" ><label class="label" for="">Empresa</label>
                                    <select name="slempresa" id="slempresa" class="form-select" >
                                        <option value="">Seleccione empresa</option>
                                        <option value=""></option>
                                        <option value=""></option>
                                    </select>
                                    </div>
                                  
                                    <div class="col-md-6"><label class="label" for="">Sucursal</label>
                                        <input type="text" class="form-control" name="Sucursal" id="Sucursal">
                                    </div>
                                    
                                    <div class="col-md-6"><label class="label" for="">SUID</label>
                                        <input type="text" class="form-control" name="SUID" id="SUID">
                                    </div>
                                    <div class="col-md-6"><label class="label" for="">Estado</label> <br>
                                        <input type="checkbox" class="form-check-input" name="Estado" id="Estado">
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
