<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    //Union - para generar .PDF de detatalle de compra.
    public function proveedor()
    {
     	return $this->belongsTo(Proveedor::class);
    }

    //Union - para generar .PDF de detatalle de compra.
    public function solicitudcompra()
    {
        return $this->belongsTo(Solicitudcompra::class);
    }

    //Union - para generar .PDF de detatalle de compra.
    public function facturadetalle()
    {
        return $this->hasMany(Facturadetalle::class);
    }
}
