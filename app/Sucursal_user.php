<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sucursal_user extends Model
{
    protected $table='sucursal_user';
    protected $primaryKey='id';

    protected $fillable =[
    	'sucursal_id',
    	'user_id'
    ];

    protected $guarded =[

    ];
}
