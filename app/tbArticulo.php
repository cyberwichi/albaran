<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbArticulo extends Model
{
    protected $table = 'tbArticulo';
    public $timestamps = false;
    protected $fillable=['Nombre','UPC'];

    //const CREATED_AT = 'FechaAlta';
    //const UPDATED_AT = 'FechaModif';
    
}

