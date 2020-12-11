<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meses extends Model
{
	protected $table='meses';
	public function saldocompradetalles()
    {
    	return $this->hasMany(Saldocompradetalles::class);
    }
}
