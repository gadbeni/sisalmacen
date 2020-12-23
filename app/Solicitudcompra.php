<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Solicitudcompra extends Model
{
    // protected $fillable = ['entidad','numerosolicitud','condicionegreso','condicion'];

    public function preventivo()
    {
     	return $this->hasMany(Preventivo::class);
    }

    // public function user(){
    // 	return $this->belongsTo(User::class);
    // }

    public function factura()
    {
     	return $this->hasOne(Factura::class);
    }

    //Union - para generar .PDF de detatalle de compra.
    public function entidad()
    {
        return $this->belongsTo(Entidad::class);
    }

    public function egresodetalles()
    {
        return $this->hasMany(Egresodetalle::class);
    }

    public function canceled()
    {
        return $this->morphMany(Canceled::class,'canceledgable');
    }

}
