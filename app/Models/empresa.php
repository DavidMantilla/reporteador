<?php

namespace App\Models;

use Flat3\Lodata\Attributes\LodataRelationship;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Empresa extends Authenticatable  implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "gg_empresa";
    protected $fillable = ['Id_Empresa','NomComercial','RazonSocial', 'FechaAlta','Logotipo','GUID','Estado', 'Correo', 'password','Clave','meta'];
    protected $primaryKey ='Id_Empresa';
    protected $hidden = [
        'password',
        'Clave'
    ];
    public $timestamps = false;
    #[LodataRelationship()]
    public function sucursales()
    {
        return $this->hasMany(sucursales::class, 'Id_Empresa', 'Id_Empresa');
    }


    public function getAuthPassword()
    {
        return $this->password; // Indicar que se use 'Clave' como el campo de la contraseña
    }

     public function getJWTIdentifier()
    {
        return $this->getKey(); // Devuelve el ID del usuario
    }

    public function getJWTCustomClaims()
    {
        return ['Id_Empresa' => $this->Id_Empresa,
            'NomComercial' => $this->NomComercial,
            'RazonSocial' => $this->RazonSocial,
            'Estado' => $this->Estado,
            'Correo' => $this->Correo,
            'guard'=>"empresa"
        ]; 
    }


}

