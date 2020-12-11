<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function facturadetalle()
    {
    	return $this->hasMany(Facturadetalle::class);
    }
}
