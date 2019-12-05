<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleAlbaran extends Model
{
    public function albaran()
    {
        return $this->belongsTo(Albaran::class);
    }
}
