@extends('layouts.empresa')

@section('content')
    <input type="hidden" value="{{ Auth::guard('empresa')->user() }}" id="idempresa">
    <div class="container-fluid">
        <div class="row justify-content-center" style=" ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <form action="" id="formComparativo">
                            <div class="d-flex" style="gap: 10px; justify-content: center; align-items: center">
                               <label for="" style="font-weight: bold;min-width: 100px" >Sucursal</label>
                              <select name="sucursal" id="filsucursal" class="form-select">
                                <option value="">hola</option>
                              </select>
                                <button class="btn btn-primary " style="color: aliceblue;">Consultar</button>

                            </div>
                        </form>

                    </div>
                </div>

            </div>
            <div class="col-md-12">
                <div class="card" style="height: 95%">
                    <div class="card-header d-flex " style="justify-content: space-around; width: 100%">
                        <b>comparativo de ventas Anuales</b>
                        <div>
                            <button class="btn btn-dark" style="background: #ec0808" id="ComparativoPdf"><i class="fa-solid fa-file-pdf"></i></button>
                            <button class="btn btn-dark" style="background: #029b38" id="ComparativoExcel"><i class="fa-solid fa-file-excel" ></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table" style="border:1px solid #000;" id="compAniostable">
                            <tr>
                                <th> Sucursal</th>
                                <th>Año</th>
                                <th>Total Ventas</th>
                                <th> Numero Transacciones</th>
                            </tr>
                            <tr>
                                <td>2020-07-10</td>
                                <td>CLI-0827</td>
                                <td>BAR TWINS</td>
                                <td>277.78</td>
                              
                            </tr>
                        </table>

                    </div>
                </div>

            </div>



        </div>
    @endsection
