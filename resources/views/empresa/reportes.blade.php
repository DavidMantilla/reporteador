@extends('layouts.empresa')

@section('content')
    <div class="container-fluid">
        <div class="row" style="margin-top:30px ">
            <div class="col-fixed-2">
                <a href="{{ Route('periodo') }}" class="menuReporte">
                    <div class="card " style="height:90%;margin-left: auto">
                        <div class="card-body" style="margin-top:20px">
                            <i class="fa-solid fa-chart-simple fa-4x "
                                style="color: aliceblue;text-align: center;width: 100%;"></i>
                            <hr style="color: aliceblue;border:solid 2px #fff">
                            <p style="text-align: center;color: aliceblue !important">

                                Ventas por periodo
                            </p>

                        </div>
                    </div>
                </a>
            </div>
            <div class="col-fixed-2">
                <a href="{{ Route('comparativo') }}" class="menuReporte">
                    <div class="card" style="height:90%;margin-left: auto">
                        <div class="card-body" style="margin-top:30px">
                            <i class="fa-solid fa-magnifying-glass-chart fa-4x "
                                style="color: rgb(250, 250, 250);text-align: center;width: 100%;"></i>
                            <hr style="color: rgb(249, 242, 242);border:solid 2px #fff">
                            <p style="text-align: center;color: aliceblue !important">

                                Comparativo de ventas anuales
                            </p>

                        </div>
                    </div>
                </a>
            </div>
            <div class="col-fixed-2">
                <a href="{{Route('mes')}}" class="menuReporte">
                    <div class="card" style="height:90%;margin-left: auto">
                        <div class="card-body" style="margin-top:20px">
           
                            <i class="fa-regular fa-calendar-days fa-4x "
                                style="color: aliceblue;text-align: center;width: 100%;"></i>
                            <hr style="color: aliceblue;border:solid 2px #fff">
                            <p style="text-align: center;color: aliceblue !important">

                                Ventas mensuales
                            </p>

                        </div>
                    </div>
                </a>
            </div>
            <div class="col-fixed-2 d-none">
                <a href="" class="menuReporte">
                    <div class="card" style="height:90%;margin-left: auto">
                        <div class="card-body" style="margin-top:20px">
                           
                            <i class="fa-solid fa-chart-column fa-4x "
                                style="color: aliceblue;text-align: center;width: 100%;"></i>
                            <hr style="color: aliceblue;border:solid 2px #fff">
                            <p style="text-align: center;color: aliceblue !important">

                                Ventas anuales
                            </p>

                        </div>
                    </div>
                </a>
            </div>
            <div class="col-fixed-2 d-none">
                <a href="" class="menuReporte">
                    <div class="card" style="height:90%;margin-left: auto">
                        <div class="card-body" style="margin-top:20px">
                           
                            <i class="fa-solid fa-chart-line fa-4x "
                                style="color: aliceblue;text-align: center;width: 100%;"></i>
                            <hr style="color: aliceblue;border:solid 2px #fff">
                            <p style="text-align: center;color: aliceblue !important">

                                Comparativo de ventas anual a la fecha
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-fixed-2 d-none">
                <a href="" class="menuReporte">
                    <div class="card" style="height:90%;margin-left: auto">
                        <div class="card-body" style="margin-top:20px">
                          
                            <i class="fa-solid fa-calendar-day fa-4x "
                                style="color: aliceblue;text-align: center;width: 100%;"></i>
                            <hr style="color: aliceblue;border:solid 2px #fff">
                            <p style="text-align: center;color: aliceblue !important">

                                Ventas diarias
                            </p>

                        </div>
                    </div>
                </a>
            </div>
            <div class="col-fixed-2 d-none">
                <a href="" class="menuReporte">
                    <div class="card" style="height:90%;margin-left: auto">
                        <div class="card-body" style="margin-top:20px">
                           <div style="display: flex; justify-content: center;">
                            <i class="fa-solid fa-mug-hot fa-4x "
                                style="color: aliceblue"></i>
                                <i class="fa-solid fa-circle-up fa-2x" style="color: aliceblue;"></i>
                            
                           </div>
                                <hr style="color: aliceblue;border:solid 2px #fff">
                            <p style="text-align: center;color: aliceblue !important">

                               Producto mas vendido
                            </p>

                        </div>
                    </div>
                </a>
            </div>
            <div class="col-fixed-2 d-none">
                <a href="" class="menuReporte">
                    <div class="card" style="height:90%;margin-left: auto">
                        <div class="card-body" style="margin-top:20px">
                           
                            <div style="display: flex; justify-content: center;">
                                <i class="fa-solid fa-mug-hot fa-4x "
                                    style="color: aliceblue"></i>
                                    <i class="fa-solid fa-circle-down fa-2x" style="color: aliceblue;"></i>
                                
                               </div>
                            <hr style="color: aliceblue;border:solid 2px #fff">
                            <p style="text-align: center;color: aliceblue !important">

                                Producto menos vendido
                            </p>

                        </div>
                    </div>
                </a>
            </div>
            <div class="col-fixed-2 d-none">
                <a href="" class="menuReporte">
                    <div class="card" style="height:90%;margin-left: auto">
                        <div class="card-body" style="margin-top:20px">
                           
                            <div style="display: flex; justify-content: center;align-items: baseline">
                                <i class="fa-solid fa-user fa-4x" style="color: aliceblue;"></i>
                                <i class="fa-solid fa-receipt  fa-3x" style="color: aliceblue"></i>
                               
                                
                               </div>
                            <hr style="color: aliceblue;border:solid 2px #fff">
                            <p style="text-align: center;color: aliceblue !important">

                                Clientes, tiket y venta promedio por hora
                            </p>

                        </div>
                    </div>
                </a>
            </div>
            <div class="col-fixed-2 d-none">
                <a href="" class="menuReporte">
                    <div class="card" style="height:90%;margin-left: auto">
                        <div class="card-body" style="margin-top:20px">
                           
                            <div style="display: flex; justify-content: center;">
                                <i class="fa-solid fa-users fa-4x "
                                    style="color: aliceblue"></i>
                                
                               </div>
                            <hr style="color: aliceblue;border:solid 2px #fff">
                            <p style="text-align: center;color: aliceblue !important">
                                Comparativo anual de clientes
                            </p>

                        </div>
                    </div>
                </a>
            </div>
            <div class="col-fixed-2 d-none">
                <a href="" class="menuReporte">
                    <div class="card" style="height:90%;margin-left: auto">
                        <div class="card-body" style="margin-top:20px">
                           
                            <div style="display: flex; justify-content: center;align-items: baseline">
                                <i class="fa-solid fa-dollar-sign fa-4x "
                                    style="color: aliceblue"></i>
                                    
                                
                               </div>
                            <hr style="color: aliceblue;border:solid 2px #fff">
                            <p style="text-align: center;color: aliceblue !important">

                                Ventas por día
                            </p>

                        </div>
                    </div>
                </a>
            </div>
            <div class="col-fixed-2 d-none">
                <a href="" class="menuReporte">
                    <div class="card" style="height:90%;margin-left: auto">
                        <div class="card-body" style="margin-top:20px">
                           
                            <div style="display: flex; justify-content: center;align-items: baseline">
                                <i class="fa-regular fa-clock fa-4x "
                                    style="color: aliceblue"></i>
                                    <i class="fa-solid fa-chart-simple fa-3x" style="color: aliceblue;margin:2px;"></i>
                                
                               </div>
                            <hr style="color: aliceblue;border:solid 2px #fff">
                            <p style="text-align: center;color: aliceblue !important">

                                Ventas por hora
                            </p>

                        </div>
                    </div>
                </a>
            </div>
            <div class="col-fixed-2 d-none">
                <a href="" class="menuReporte">
                    <div class="card" style="height:90%;margin-left: auto">
                        <div class="card-body" style="margin-top:20px">
                           
                            <div style="display: flex; justify-content: center;align-items: baseline">
                                <i class="fa-solid fa-dollar-sign fa-4x "  style="color: aliceblue"></i>
                                  
                                
                               </div>
                               <hr style="color: aliceblue;border:solid 2px #fff">
                            <p style="text-align: center;color: aliceblue !important">

                                Acumulado de ventas
                            </p>

                        </div>
                    </div>
                </a>
            </div>
            <div class="col-fixed-2 d-none">
                <a href="" class="menuReporte">
                    <div class="card" style="height:90%;margin-left: auto">
                        <div class="card-body" style="margin-top:20px" >
                           
                            <div style="display: flex; justify-content: center;align-items: flex-start; gap:4px">
                                <i class="fa-solid fa-dollar-sign fa-2x "  style="color: aliceblue"></i>
                                <i class="fa-solid fa-chart-line fa-4x"  style="color: aliceblue"></i>
                                
                               </div>
                               <hr style="color: aliceblue;border:solid 2px #fff">
                            <p style="text-align: center;color: aliceblue !important">

                                Analisis diaro de ventas
                            </p>

                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
