<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TurmaLocal extends Model
{
    
    public function Turma() {
    	return $this->belongsTo('App\Turma');
    }

    public function local() {
    	return $this->belongsTo('App\Local');
    }
    
}
