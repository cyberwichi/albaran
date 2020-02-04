<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    protected $connection = 'mysql';
    protected $fillable = ['email', 'password'];
  
}
