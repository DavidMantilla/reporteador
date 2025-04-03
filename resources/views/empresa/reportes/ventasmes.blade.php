@extends('layouts.empresa')

@section('content')
    <input type="hidden" value="{{ Auth::guard('empresa')->user() }}" id="idempresa">
    <div class="container-fluid">
        <div class="row justify-content-center" style=" ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <form action="" id="formMes">
                            <div class="row">
                                <div class="col-md-3">

                                    <label for="" style="font-weight: bold;min-width: 100px">Mes</label>
                                    <select name="month" id="month" class="form-select">
                                        <option value="1">Enero</option>
                                        <option value="2">Febrero</option>
                                        <option value="3">Marzo</option>
                                        <option value="4">Abril</option>
                                        <option value="5">Marzo</option>
                                        <option value="6">Junio</option>
                                        <option value="7">Julio</option>
                                        <option value="8">Agosto</option>
                                        <option value="9">Septiembre</option>
                                        <option value="10">Octubre</option>
                                        <option value="11">Noviembre</option>
                                        <option value="12">Diciembre</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="" style="font-weight: bold;min-width: 100px">Año</label>
                                    <select name="anio" id="anio" class="form-select">
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                    </select>

                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="" style="font-weight: bold;min-width: 100px">Sucursal</label>
                                    <select name="sucursal" id="filsucursal" class="form-select">
                                        <option value=""></option>
                                    </select>

                                </div>
                                <div class="col-md-3">
                                    <br>
                                    <button class="btn btn-primary " style="color: aliceblue;">Consultar</button>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>

            </div>
            <div class="col-md-12">
                <div class="card" style="height: 95%">
                    <div class="card-header d-flex " style="justify-content: space-around; width: 100%">
                        <b>Ventas mensuales</b>
                        <div>
                            <button class="btn btn-dark" style="background: #ec0808" id="mesPdf"><i
                                    class="fa-solid fa-file-pdf"></i></button>
                            <button class="btn btn-dark" style="background: #029b38" id="mesExcel"><i
                                    class="fa-solid fa-file-excel"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive" style="border:1px solid #000;" id="mesTable">
                            <tr>
                                <th>Fecha</th>
                                <th>Sucursal</th>
                                <th> Cliente</th>
                                <th> NombreCliente</th>
                                <th> Importe</th>
                                <th> Impuesto</th>
                                <th> Facturado</th>
                            </tr>
                            <tr>
                                <td>2020-07-10</td>
                                <td>CLI-0827</td>
                                <td>CLI-0827</td>
                                <td>BAR TWINS</td>
                                <td>277.78</td>
                                <td>22.22</td>
                                <td>22737</td>
                            </tr>
                        </table>

                    </div>
                </div>

            </div>



        </div>
    @endsection
