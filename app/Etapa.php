<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Etapa extends Model
{
    //

    public function boletin() {
    	return $this->belongsTo('App\Boletin');
    }
    
}
