<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\LicenciamientoController;
use App\Http\Controllers\PartventaController;
use App\Http\Controllers\SucursalesController;
use Flat3\Lodata\Transaction\Option\Id;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Exports\VentasExport;
use App\Http\Controllers\VentasController;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Ventas;
use Barryvdh\DomPDF\Facade\Pdf;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    print_r(csrf_token());
    return redirect('login');
})->name("home");

Route::view('/login', 'login')->name("login");

//auth empresa

Route::middleware('auth:empresa')->get(
    '/empresa',
    function (Request $request) {
        return view('empresa.empresa', ["request" => $request]);
    }
)->name("empresa");


Route::middleware('auth:empresa')->get(
    '/reportes',
    function (Request $request) {
        return view('empresa.reportes', ["request" => $request]);
    }
)->name("empresa");

Route::middleware('auth:empresa')->get(
    '/reportes/periodo',
    function (Request $request) {
        return view('empresa.reportes.ventasperiodo', ["request" => $request]);
    }
)->name("periodo");

Route::middleware('auth:empresa')->get(
    '/reportes/comparativo',
    function (Request $request) {
        return view('empresa.reportes.comparativo', ["request" => $request]);
    }
)->name("comparativo");


Route::middleware('auth:empresa')->get(
    '/reportes/ventasMes',
    function (Request $request) {
        return view('empresa.reportes.ventasmes', ["request" => $request]);
    }
)->name("mes");


Route::middleware('auth:empresa')->get(
    '/reportes/ventasAnio',
    function (Request $request) {
        return view('empresa.reportes.ventasAnio', ["request" => $request]);
    }
)->name("anio");


Route::middleware('auth:empresa')->get(
    '/reportes/comparativofecha',
    function (Request $request) {
        return view('empresa.reportes.comparativofecha
        ', ["request" => $request]);
    }
)->name("comparativofecha");






//usuario

Route::middleware('auth:web')->get(
    '/usuario',
    function (Request $request) {
        return view('usuario.usuario', ["request" => $request]);
    }
)->name('usuario');

Route::middleware('auth:web')->get(
    '/nuevaempresa',
    function (Request $request) {
        return view('usuario.nuevaempresa', ["request" => $request]);
    }
)->name('nuevaemp');

Route::middleware('auth:web')->get(
    '/nuevousuario',
    function (Request $request) {
        return view('usuario.nuevousuario', ["request" => $request]);
    }
)->name('nuevousu');

Route::middleware('auth:web')->get(
    '/sucursales/{id}',
    function ($id) {
        return view('usuario.mostrarSucursales', ["id" => $id]);
    }
)->name('sucursales');




Route::middleware('auth:web')->get(
    '/nuevalicencia',
    function (Request $request) {
        return view('usuario.nuevalicencia', ["request" => $request]);
    }
)->name('nuevalicencia');



Route::middleware('auth:web')->get(
    '/nuevasucursal',
    function (Request $request) {
        return view('usuario.nuevasucursal', ["request" => $request]);
    }
)->name('nuevasucursal');
