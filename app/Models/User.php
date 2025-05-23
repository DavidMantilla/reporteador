<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable  implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = "gg_usuarios";
    protected $primaryKey = "Id_Usuario";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Id_Usuario',
        'Codigo',
        'Nombre',
        'Clave',
        'Admin',
        'Correo'
    ];
    public $timestamps = false;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'Clave'
    ];

    public function getAuthPassword()
    {
        return $this->Clave; // Indicar que se use 'Clave' como el campo de la contraseña
    }

     public function getJWTIdentifier()
    {
        return $this->getKey(); // Devuelve el ID del usuario
    }

    public function getJWTCustomClaims()
    {
        return [ 'Id_Usuario'=>$this->Id_Usuario,
        'Codigo'=>$this->Codigo,
        'Nombre'=>$this->Nombre,
        'Clave'=>$this->Clave,
        'Admin'=>$this->Admin,
        'Correo'=>$this->Correo,
        'guard'=>"usuario"]; 
    }


}
