<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Egreso extends Model
{
    // protected $fillable = ['idoficina','idcuenta','codigopedido','fechasolicitud','fechasalida','condicion'];
    public function getFechaSalidaAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d\TH:i');
    }
    // public function proyecto(){
    // 	return $this->belongsTo(Proyecto::class,'idproyecto');
    // }

    public function egresodetalle()
    {
    	return $this->hasMany(Egresodetalle::class);
    }

    public function direccionadministrativa()
    {
    	return $this->belongsTo(Direccionadministrativa::class);
    }

    public function unidadadministrativa()
    {
        return $this->belongsTo(Unidadadministrativa::class);
    }

    public function cuenta()
    {
        return $this->belongsTo(Cuenta::class);
    }

     public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

     public function canceled()
    {
        return $this->morphMany(Canceled::class,'canceledgable');
    }
}
