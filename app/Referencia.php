<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referencia extends Model
{
    protected $fillable = ['referencia'];
    protected $connection = 'mysql';

    public function tbArticulo()
    {
        return $this->belongsTo(tbArticulo::class, 'articulo_id', 'Id');
    }
}
