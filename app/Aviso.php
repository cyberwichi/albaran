<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Aviso extends Model
{
    protected $fillable = ['contacto_id', 'empleado_id', 'fechaPrevista', 'comentario', 'terminada'];
    protected $connection = 'mysql';
    
    public function detalleavisos()
    {
        return $this->hasMany(DetalleAviso::class);
    }
    public function Empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id', 'id');
    }
    public function tbContacto()
    {
        return $this->belongsTo(tbContacto::class, 'contacto_id', 'Id');
    }

}
