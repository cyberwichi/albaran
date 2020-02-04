<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maquina extends Model
{
    protected $connection = 'mysql';
    public function albaranmaquina()
    {
        return $this->HasMany(Albaranmaquina::class);
    }
}
