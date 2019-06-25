<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    //

    public function vinculo() {
        return $this->belongsTo('App\Vinculo');
    }

    public function usuario_periodo() {
    	return $this->hasMany('App\UsuarioPeriodo');
    }

    public function usuario_turma() {
    	return $this->hasMany('App\UsuarioTurma');
    }

    public function boletins() {
        return $this->hasMany('App\Boletin');
    }
    

}

