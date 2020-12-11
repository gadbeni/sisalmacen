<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    //protected $fillable = ['iddireccionadministrativa','idunidadejecutora','codigo','nombre','condicion'];

    // public function egresos(){
    // 	return $this->hashMany(Egreso::class);
    // }
    public function direccionadministrativa()
    {
     	return $this->belongsTo(Direccionadministrativa::class);
    }

    public function unidadadministrativa()
    {
     	return $this->belongsTo(Unidadadministrativa::class);
    }
}
