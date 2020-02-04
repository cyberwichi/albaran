<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbStockArt extends Model
{
    protected $table = 'tbstockart';
    public $timestamps = false;
    protected $primaryKey = 'AutoId';
    protected $fillable = [
        'Stock', 'UdsPed', 'Articulo', 'AutoId', 'UdsComp'
    ];
    protected $connection = 'mysql';

    //const CREATED_AT = 'FechaAlta';
    //const UPDATED_AT = 'FechaModif';

    public function tbArticulo()
    {
        return $this->belongsTo(tbArticulo::class, 'Articulo', 'Id');
    }
}
