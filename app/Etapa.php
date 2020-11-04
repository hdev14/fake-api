<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Etapa extends Model
{
    protected $table = 'etapa';

    protected $fillable = [
        'nota',
        'faltas'
    ];

    public function boletin()
    {
        return $this->belongsTo('App\Boletin');
    }
}
