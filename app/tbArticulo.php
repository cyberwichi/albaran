<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class tbArticulo extends Model
{
    protected $table = 'tbarticulo';
    // protected $connection = 'sqlsrv';
    public $timestamps = false;
    protected $fillable = ['Nombre', 'UPC'];

    //const CREATED_AT = 'FechaAlta';
    //const UPDATED_AT = 'FechaModif';

    public function tbStockArt()
    {
        return $this->belongsTo(tbStockArt::class, 'Id', 'Articulo');
    }
    public function referencias()
    {
        return $this->hasMany(Referencia::class, 'articulo_id', 'Id');
    }
}
