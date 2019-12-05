<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Albaranmaquina extends Model
{
    public function albaran()
    {
        return $this->belongsTo(Albaran::class);
    }
    public function maquina()
    {
        return $this->belongsTo(Maquina::class);
    }
}
