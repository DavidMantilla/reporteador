@extends('layouts.empresa')

@section('content')
    <input type="hidden" value="{{ Auth::guard('empresa')->user()}}" id="idempresa">
    <div class="container-fluid">
        <div class="row justify-content-start" style=" ">
            <form action="" id="search">
           <div class="row" style="padding:20px;background-color: #ddd;border:solid #000 1px">

               <div class="col-md-3">
                Fecha Inicial:
                <input type="date" name="finicio" id="finicio" class="form-control" style="border: 1px solid #000">
               </div>
               
               <div class="col-md-3">
                Fecha Final:
                <input type="date" name="ffin" id="ffin" class="form-control" style="border: 1px solid #000">
               </div>
               <div class="col-md-3">
                Sucursal:
                 <select name="SlSucursal" id="SlSucursal" class="form-select" style="border: 1px solid #000">
                    <option value="">Sucursal</option> 
                 </select>
               </div>
               
               <div class="col-md-3">
                <br>
                <button class="btn btn-primary" style="color: aliceblue"> Actualizar <div class="fa-solid fa-rotate" ></div> </button>
               </div>
           </div>
        </form>
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
                        <ul id="horas" style="max-height: 300px; overflow-y: scroll">
                          
                        </ul>


                    </div>
                    <div class="card-footer">
                        <div class="col-6">
                            <b>Total: </b><span style="font-size: 20px;font-weight: bolder; color:#EE5D31"  id="totalHora">$200</span>
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
                                   
                                    
                                </ul>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="col-6">
                            <b>Total: </b><span style="font-size: 20px;font-weight: bolder; color:#EE5D31" id="totalproductos">$200</span>
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
