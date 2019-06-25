<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boletin extends Model
{
    //

    public function usuario() {
    	return $this->belognsTo('App\Usuario');
    }

    public function etapas() {
    	return $this->hasMany('App\Etapa');
    }
    
    
}
