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
Route::post('/api/login',[authController::class,'login'])->name("apiLogin");
Route::post('/api/register', [authController::class,'register'])->name("apiRegister");
Route::post('/api/logout', [authController::class,'logout'])->name("apiLogout");

Route::get('/test-auth', function () {
    $empresa = App\Models\User::first();
    Auth::guard('web')->login($empresa);
    return   redirect('/usuario');
});
Route::view('/login','login')->name("login");

//auth

Route::middleware('auth:empresa')->get('/empresa',function (Request $request){
    return view('empresa',["request"=>$request]);}
    )->name("empresa");

    Route::get('/usuario',function (Request $request){
        return view('usuario',["request"=>$request]);}
        )->name("usuario");


