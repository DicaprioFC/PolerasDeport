<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = ['user_id', 'total', 'cod_autorizacion','cuenta_generada'];

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class);
    }

    
}
