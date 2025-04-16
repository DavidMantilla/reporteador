

@extends('layouts.empresa')

@section('content')
    <input type="hidden" value="{{ Auth::guard('empresa')->user() }}" id="idempresa">
    <div class="container-fluid">
        <div class="row justify-content-center" style=" ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <form action="" id="formAnio">
                            <div class="row">
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
                        <b>Ventas por periodo</b>
                        <div>
                            <button class="btn btn-dark" style="background: #ec0808" id="AnioPdf"><i
                                    class="fa-solid fa-file-pdf"></i></button>
                            <button class="btn btn-dark" style="background: #029b38" id="AnioExcel"><i
                                    class="fa-solid fa-file-excel"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive" style="border:1px solid #000;" id="Aniotable">
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
