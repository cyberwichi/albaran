<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class tbArticulo extends Model
{
    protected $table = 'tbarticulo';
    // protected $connection = 'sqlsrv';
    public $timestamps = false;
    protected $fillable = ['Nombre', 'UPC'];
    protected $connection = 'mysql';

    //const CREATED_AT = 'FechaAlta';
    //const UPDATED_AT = 'FechaModif';

    public function tbStockArt()
    {
        return $this->belongsTo(tbStockArt::class, 'AutoId', 'AutoId');
    }
    public function referencias()
    {
        return $this->hasMany(Referencia::class, 'articulo_id', 'AutoId');
    }
}
