<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioPeriodo extends Model
{
    
    public function usuario() {
    	return $this->belongsTo('App\Usuario');
    }

     public function periodo() {
    	return $this->belongsTo('App\Periodo');
    }

}
