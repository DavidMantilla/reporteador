<?php

namespace App\Models;

use Flat3\Lodata\Attributes\LodataRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sucursales extends Model
{
    use HasFactory;
    protected $table = "GG_Sucursales";
    protected $primaryKey = "Id_Sucursal";
    protected $fillable = ['Id_Sucursal', 'FechaAlta', 'Id_Empresa', 'SUID','Estado'];
    #[LodataRelationship()]
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'Id_Empresa', 'Id_Empresa');
    }
    #[LodataRelationship()]
    public function licenciamientos()
    {
        return $this->hasMany(licenciamiento::class, 'Id_Sucursal', 'Id_Sucursal');
    }
    #[LodataRelationship()]
    public function ventas()
    {
        return $this->hasMany(ventas::class, 'Id_Sucursal', 'Id_Sucursal');
    }

    



}
