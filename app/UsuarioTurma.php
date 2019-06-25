<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioTurma extends Model
{
    
    public function usuario() {
    	return $this->belongsTo('App\Usuario');
    }
    
    public function turma() {
    	return $this->belongsTo('App\Turma');
    }
    
}
