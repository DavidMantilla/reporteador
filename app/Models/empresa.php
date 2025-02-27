<?php

namespace App\Models;

use Flat3\Lodata\Attributes\LodataRelationship;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Empresa extends Authenticatable 
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "gg_empresa";
    protected $fillable = ['Id_Empresa','NomComercial','RazonSocial', 'FechaAlta','Logotipo','GUID','Estado', 'Correo', 'password'];
    protected $primaryKey ='Id_Empresa';
    protected $hidden = [
        'password',
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
}

