<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Canceled extends Model
{
	protected $fillable= ['user_id','motivo'];

    public function user()
    {
     	return $this->belongsTo(User::class);
    }

    public function canceledgable(){
        return $this->morphTo();
    }
}
