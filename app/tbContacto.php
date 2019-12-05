<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbContacto extends Model
{
    protected $table = 'tbcontacto';
    public $timestamps = false;
    protected $fillable = ['Nombre', 'Nif'];

    //const CREATED_AT = 'FechaAlta';
    //const UPDATED_AT = 'FechaModif';
    public function aviso()
    {
        return $this->hasMany(Aviso::class, 'AutoId',  'contacto_id');
    }
}
