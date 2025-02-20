<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
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
}
