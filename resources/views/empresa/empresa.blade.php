@extends('layouts.empresa')

@section('content')
    <input type="hidden" value="{{ Auth::guard('empresa')->user()}}" id="idempresa">
    <div class="container-fluid">
        <div class="row justify-content-start" style=" ">
            <div class="col-lg-6 col-md-8">
                <div class="card" style="height: 95%">
                    <div class="card-header">
                        <b>Ventas por empresa</b>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart"></canvas>

                    </div>
                </div>

            </div>
            <div class="col-lg-3 col-md-4">
                <div class="card" style="height: 95%">
                    <div class="card-header">
                        <b>Ventas por hora</b>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li class="list"><span>11:00am</span><b>$10</b></li>
                            <li class="list"><span>21:00am</span><b>$20</b></li>
                            <li class="list"><span>31:00am</span><b>$30</b></li>
                            <li class="list"><span>41:00am</span><b>$40</b></li>
                            <li class="list"><span>51:00am</span><b>$50</b></li>
                            <li class="list"><span>61:00am</span><b>$60</b></li>
                            <li class="list"><span>71:00am</span><b>$70</b></li>
                            <li class="list"><span>81:00am</span><b>$80</b></li>
                            <li class="list"><span>91:00am</span><b>$90</b></li>
                            <li class="list"><span>101:00am</span><b>$100</b></li>
                        </ul>


                    </div>
                    <div class="card-footer">
                        <div class="col-6">
                            <b>Total: </b><span style="font-size: 20px;font-weight: bolder; color:#EE5D31">$200</span>
                        </div>
                    </div>

                </div>

            </div>
            <div class="col-lg-3 col-md-12">
                <div class="card" style="height: 95%">
                    <div class="card-header">
                        <b>top 10 productos más populares por ingreso </b>
                    </div>

                    <div class="card-body">
                        <div class="row" style="justify-content: flex-end">
                            <div class="col-12" style="height: 80%;">
                                <ul id="productList">
                                    <li class="list"><span>11:00am</span><b>$10</b></li>
                                    
                                </ul>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="col-6">
                            <b>Total: </b><span style="font-size: 20px;font-weight: bolder; color:#EE5D31">$200</span>
                        </div>
                    </div>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">
           
                <div class="card">
                    <div class="card-header card-header-secondary"> cuentas atendidas</div>
                    <div class="card-body">

                        <div class="d-flex" style="justify-content: space-between">
                            <div style="text-align: center">

                                <b style="color: #f34916">Cuentas</b> <br>
                                <span style="font-size: 20px" id="Numcuentas"> 0</span>
                            </div>
                            <div>
                                <b style="color: #eb3e0a">Importe</b> <br>
                                <span style="font-weight: bolder; font-size: 20px" id="importe"> $0.0</span>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-header">Ventas por forma pago</div>
                    <div class="card-body">

                        <ul>
                            <li class="list"><span>Efectivo </span><b>$10</b> <span>0.0%</span></li>
                            <li class="list"><span>Tarjeta </span><b>$10</b> <span>0.0%</span></li>
                            <li class="list"><span>Otros </span><b>$10</b> <span>0.0%</span></li>
                        </ul>   
                    </div>
                </div>
            </div>
            
            <div class="col-lg-5 col-md-6">
                <div class="card">
                    <div class="card-header "> Metas de ventas</div>
                    <div class="card-body">
                        <div class="row">
                            <div  class="col-4">
                                <b> Meta diaria</b>
                                <canvas id="diaria" style="max-width: 100%"></canvas>
                            </div>
                            <div  class="col-4">
                                <b> Meta mensual</b>
                                <canvas id="mensual"  style="max-width: 100%"></canvas>
                            </div>
                            <div  class="col-4">
                                <b> Meta Anual</b>
                                <canvas id="anual"  style="max-width: 100%"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
           
        </div>

    @endsection
