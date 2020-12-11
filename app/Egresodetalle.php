<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Egresodetalle extends Model
{
    protected $with = "solicitudcompra";
    //protected $fillable = ['idegreso','idfacturadetalle','idsolicitudcompra','cantidad','cantidadegresada','totalbs','condicion'];

    // public function factura(){
    // 	return $this->hasOne(Factura::class);
    // }

    public function egreso()
    {
    	return $this->belongsTo(Egreso::class);
    }

    public function facturadetalle()
    {
    	return $this->belongsTo(Facturadetalle::class);
    }

    public function solicitudcompra()
    {
    	return $this->belongsTo(Solicitudcompra::class);
    }
}
