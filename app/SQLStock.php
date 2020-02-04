<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SQLStock extends Model
{
    protected $table = 'tbStockArt';
    protected $connection = 'sqlsrv';
}
