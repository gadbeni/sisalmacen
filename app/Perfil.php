<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
	protected $fillable = ['user_id','nombre','apaterno','amaterno','ci','telefono','direccion'];
}
