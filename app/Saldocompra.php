<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaldoCompra extends Model
{
	protected $table = 'saldocompras';

	public function sucursal() {
        return $this->belongsTo(Sucursal::class);
    }

	public function saldocompradetalles()
    {
    	return $this->hasMany(Saldocompradetalles::class);
    }
}
