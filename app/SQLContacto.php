<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SQLContacto extends Model
{
    protected $table = 'tbContacto';
    protected $connection = 'sqlsrv';
}
