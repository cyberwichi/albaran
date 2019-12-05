<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Albaran extends Model
{
    public function detallealbaran()
    {
        return $this->HasMany(DetalleAlbaran::class);
    }
    public function albaranmaquina()
    {
        return $this->HasMany(Albaranmaquina::class);
    }
}
