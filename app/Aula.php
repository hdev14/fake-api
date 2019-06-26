<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    
    protected $table = 'aula';

    protected $fillable = [
    	'etapa',
    	'professor',
    	'quantidade',
    	'faltas',
    	'conteudo',
    	'data',
    ];

    public function turma() {
    	return $this->belongsTo('App\Turma');
    }
}
