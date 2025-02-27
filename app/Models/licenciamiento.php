<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class licenciamiento extends Model
{
    use HasFactory;
    protected $table = "gg_licenciamiento";
    protected $primaryKey = "Id_Licencia";
}
