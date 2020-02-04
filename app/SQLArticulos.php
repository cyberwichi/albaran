<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SQLArticulos extends Model
{
    protected $table = 'tbArticulo';
    protected $connection = 'sqlsrv';
}
