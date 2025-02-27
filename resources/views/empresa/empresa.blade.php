@extends('layouts.empresa')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center" style=" ">
            <div class="col-md-6">
                <div class="card" style="height: 95%">
                    <div class="card-header">
                        <b>Ventas por empresa</b>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart"></canvas>

                    </div>
                </div>

            </div>
            <div class="col-md-3">
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
            <div class="col-md-3">
                <div class="card" style="height: 95%">
                    <div class="card-header">
                        <b>top 10 productos más populares por ingreso </b>
                    </div>

                    <div class="card-body">
                        <div class="row" style="justify-content: flex-end">
                            <div class="col-12" style="height: 80%;">hola</div>

                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="col-6">
                            <b>Total: </b><span style="font-size: 20px;font-weight: bolder; color:#EE5D31">$200</span>
                        </div>
                    </div>

                </div>

            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header card-header-primary"> cuentas abiertas</div>
                    <div class="card-body">
                        <div class="d-flex" style="justify-content: space-between">
                            <div style="text-align: center">

                                <b style="color: #EE5D31">Cuentas</b> <br>
                                <span style="font-size: 20px"> 0</span>
                            </div>
                            <div>
                                <b style="color: #EE5D31">Importe</b> <br>
                                <span style="font-weight: bolder; font-size: 20px"> $0.0</span>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="card">
                    <div class="card-header card-header-secondary"> cuentas atendidas</div>
                    <div class="card-body">

                        <div class="d-flex" style="justify-content: space-between">
                            <div style="text-align: center">

                                <b style="color: #f34916">Cuentas</b> <br>
                                <span style="font-size: 20px"> 0</span>
                            </div>
                            <div>
                                <b style="color: #eb3e0a">Importe</b> <br>
                                <span style="font-weight: bolder; font-size: 20px"> $0.0</span>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">

                    <div class="card-body" style="padding: 0px">
                        <div
                            style="padding: 10px;border-bottom: 1px #aaa solid;display: flex; justify-content: space-between">
                            <span style="min-width: 200px"><i class="fa-solid fa-users fa-2x" style="color: #d24216"></i>
                                &nbsp;&nbsp;<b>Clientes
                                    Atendidos</b></span> <b style="margin: 2px auto;">0</b>
                        </div>
                        <div
                            style="padding: 10px;border-bottom: 1px #aaa solid;display: flex; justify-content: space-between">
                            <span style="min-width: 200px"><i class="fa-solid fa-file-invoice-dollar fa-2x"
                                    style="color: #d24216"></i> &nbsp;&nbsp;<b>Cuentas cerradas</b></span> <b
                                style="margin: 2px auto;">0</b>
                        </div>
                        <div
                            style="padding: 10px;border-bottom: 1px #aaa solid;display: flex; justify-content: space-between">
                            <span style="min-width: 200px"> <img src="/img/comedor.png" alt=""
                                    style="width: 30px;margin-right: 20px">&nbsp;&nbsp; <b>Mesas Ocupadas </b></span> <b
                                style="margin: 2px auto;">0</b>
                        </div>
                        <div
                            style="padding: 10px;border-bottom: 1px #aaa solid;display: flex; justify-content: space-between">
                            <span style="min-width: 200px"><i class="fa-solid fa-hand-holding-dollar fa-2x"
                                    style="color: #d24216"></i> &nbsp;&nbsp; <b>Descuentos</b></span> <b
                                style="margin: 2px auto;">0</b>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-5">
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
            <div class="col-md-4">
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
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Ventas por forma servicio</div>
                    <div class="card-body">
                        <ul>
                            <li class="list"><span>Comedor </span><b>$10</b> <span>0.0%</span></li>
                            <li class="list"><span>Domicilio </span><b>$10</b> <span>0.0%</span></li>
                            <li class="list"><span>Otros </span><b>$10</b> <span>0.0%</span></li>
                        </ul>   

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header"> Ventas por forma tipo</div>
                    <div class="card-body">
                        <ul>
                            <li class="list"><span>Alimentos </span><b>$10</b> <span>0.0%</span></li>
                            <li class="list"><span>bebidas </span><b>$10</b> <span>0.0%</span></li>
                            <li class="list"><span>Otros </span><b>$10</b> <span>0.0%</span></li>
                        </ul>   
                    </div>
                </div>
            </div>
        </div>

        <script>
            const ctx = document.getElementById('myChart');
            const diaria = document.getElementById('diaria');
            const mensual = document.getElementById('mensual');
            const anual = document.getElementById('anual');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                    datasets: [{
                        label: '# of Votes',
                        data: [12, 19, 3, 5, 2, 3],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            new Chart(diaria, {
                type: 'doughnut',
                data: {
                    
                    datasets: [{
                        
                        data: [12, 19],
                        borderWidth: 1
                    }]
                },
                
            });
            new Chart(mensual, {
                type: 'doughnut',
                data: {
                    
                    datasets: [{
                        
                        data: [12, 19],
                        borderWidth: 1
                    }]
                },
                
            });

            new Chart(anual, {
                type: 'doughnut',
                data: {
                    
                    datasets: [{
                        
                        data: [12, 19],
                        borderWidth: 1
                    }]
                },
                
            });

        </script>
    @endsection
