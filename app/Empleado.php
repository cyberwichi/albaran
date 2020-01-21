<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Empleado extends Model
{
    public function avisos(){
        return $this->HasMany(Aviso::class);
    }
}