<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facturadetalle extends Model
{
	//Union - para generar .PDF de detatalle de compra.
    public function factura()
    {
    	return $this->belongsTo(Factura::class);
    }

    //Union - para generar .PDF de detatalle de compra.
    public function articulo()
    {
     	return $this->belongsTo(Articulo::class);
    }

    public function egresodetalles()
    {
    	return $this->hasMany(Egresodetalle::class,'facturadetalle_id');
    }
}
