<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Saldocompradetalles extends Model
{
    public function saldocompra()
    {
        return $this->belongsTo(Saldocompra::class);
    }

    public function meses()
    {
        return $this->belongsTo(Meses::class,'mes_id');
    }
}
