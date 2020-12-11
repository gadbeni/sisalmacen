<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preventivo extends Model
{
    // protected $fillable = ['idsolicitudcompra','idproyecto','idpartida','numeropreventivo','monto','condicion'];

    public function solicitudcompra()
    {
    	return $this->belongsTo(Solicitudcompra::class);
    }

    public function proyecto()
    {
    	return $this->belongsTo(Proyecto::class);
    }

    public function partida()
    {
     	return $this->belongsTo(Partida::class);
    }
}
