<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Direccionadministrativa extends Model
{
    public function unidades () {
        return $this->hasMany(Unidadadministrativa::class);
    }
}
