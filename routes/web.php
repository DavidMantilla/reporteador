<?php

use App\Http\Controllers\authController;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

//api login
Route::post('/api/login', [authController::class, 'login'])->name("apiLogin");

Route::post('/api/register', [authController::class, 'register'])->name("apiRegister");
Route::post('/api/update', [authController::class, 'update'])->name("apiUpdate");
Route::middleware(['auth:empresa','auth:web'])->post('/api/logout', [authController::class, 'logout'])->name("apiLogout");


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








//usuario


Route::middleware('auth:web')->get(
    '/usuario',
    function (Request $request) {
        return view('usuario.usuario', ["request" => $request]);
    }
)->name("usuario");

Route::middleware('auth:web')->get(
    '/nuevaempresa',
    function (Request $request) {
        return view('usuario.nuevaempresa',["request" => $request]);
    }
)->name("nuevaemp");

Route::middleware('auth:web')->get(
    '/nuevousuario',
    function (Request $request) {
        return view('usuario.nuevousuario',["request" => $request]);
    }
)->name("nuevousu");
