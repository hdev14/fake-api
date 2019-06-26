<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vinculo extends Model
{
    protected $fillable = [
    	'matricula',
    	'nome',
    	'curso',
    	'campus',
    	'situacao',
    	'cota_sistec',
    	'cota_mec',
    	'situacao_sistemica',
    ];

    public function usuario() {
    	return $this->hasOne('App\Usuario');
    }
    
}
