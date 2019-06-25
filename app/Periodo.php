<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    //

    public function usuario_periodo() {
    	return $this->hasMany('App\UsuarioPeriodo');
    }
    
}
