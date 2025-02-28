<?php

namespace App\Models;

use Flat3\Lodata\Attributes\LodataRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class licenciamiento extends Model
{
    use HasFactory;
    protected $table = "gg_licenciamiento";
    protected $primaryKey = "Id_Licencia";

    #[LodataRelationship()]
    public function sucursales()
    {
        return $this->belongsTo(sucursales::class, 'Id_Sucursal', 'Id_Sucursal');
    }
}
