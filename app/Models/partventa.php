<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class partventa extends Model
{
    use HasFactory;
    protected $table = "GG_PartVta";
    protected $primaryKey = "Id_Ventas";

    protected $fillable = [
        'Articulo',
        'Descripcion',
        'No_Referen',
        'Serie',
        'Cantidad',
        'Precio',
        'Descuento'
    ];
}
