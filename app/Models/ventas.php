<?php

namespace App\Models;

use Flat3\Lodata\Attributes\LodataRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ventas extends Model
{
    use HasFactory;
    protected $table = "gg_ventas";
    protected $primaryKey = "Id_Ventas";
    protected $casts = [
        'FechaDoc' => 'datetime',
    ];
    #[LodataRelationship()]
    public function sucursales()
    {
        return $this->belongsTo(sucursales::class, 'Id_Sucursal', 'Id_Sucursal');
    }
    
}
