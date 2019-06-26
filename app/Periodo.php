<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{	
	protected $table = 'periodo';
	
    protected $fillable = [
    	'ano_letivo',
    	'periodo_letivo',
    ];

    public function usuario_periodo() {
    	return $this->hasMany('App\UsuarioPeriodo');
    }
    
}
