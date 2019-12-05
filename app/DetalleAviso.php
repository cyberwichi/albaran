<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleAviso extends Model
{
    public function articulo()
    {
        return $this->belongsTo(tbArticulo::class);
    }
}
