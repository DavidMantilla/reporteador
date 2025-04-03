<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LicenciamientoController;
use App\Http\Controllers\PartventaController;
use App\Http\Controllers\SucursalesController;
use App\Http\Controllers\VentasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name("apiLogin");

Route::post('/register', [authController::class, 'register'])->name("apiRegister");
Route::post('/update', [authController::class, 'update'])->name("apiUpdate");
Route::middleware(['auth:empresa','auth:web'])->post('/logout', [authController::class, 'logout'])->name("apiLogout");


Route::middleware('auth:empresa')->get(
    '/partVenta',
    [PartventaController::class, "index"]
)->name('ApipartVenta');

Route::middleware('auth:empresa')->get('/ventas/excel/periodo', [VentasController::class, "ExcelPeriodo"]);
Route::middleware('auth:empresa')->get('/ventas/pdf/periodo', [VentasController::class, "Pdfperiodo"]);
Route::middleware('auth:empresa')->get('/ventas/excel/comparativo', [VentasController::class, "ExcelComparativo"]);
Route::middleware('auth:empresa')->get('/ventas/pdf/comparalltivo', [VentasController::class, "Pdfcomparativo"]);
Route::middleware('auth:empresa')->get('/ventas/excel/mes', [VentasController::class, "excelMes"]);
Route::middleware('auth:empresa')->get('/ventas/pdf/mes', [VentasController::class, "PdfMes"]);



Route::middleware('auth:web')->post(
    '/nuevaSucursal',
    [SucursalesController::class, "store"]
)->name('ApiNuevaSucursal');


Route::middleware('auth:web')->post(
    '/nuevaLicencia',
    [LicenciamientoController::class, "store"]
)->name('ApiNuevaLicencia');
