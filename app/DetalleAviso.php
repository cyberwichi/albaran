<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleAviso extends Model
{
    protected $connection = 'mysql';
    public function articulo()
    {
        return $this->belongsTo(tbArticulo::class, 'articulo_id', 'AutoId');
    }
}
