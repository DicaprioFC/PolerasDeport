<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'nombre',
        'precio',
        'marca',
        'imagen',
        'oferta',
        'descripcion',
        'descuento',
        'id_usuario',
        'imagen_public_id',
        'stock',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'descuento' => 'decimal:2',
        'oferta' => 'boolean',
        'stock' => 'integer',
    ];

    // Relación: Un producto pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    // Relación: Un producto puede estar en muchos detalles de venta
    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class, 'producto_id');
    }
}
