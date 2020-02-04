<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleAlbaran extends Model
{
    protected $connection = 'mysql';
    public function albaran()
    {
        return $this->belongsTo(Albaran::class);
    }
}
