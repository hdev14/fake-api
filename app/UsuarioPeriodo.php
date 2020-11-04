<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioPeriodo extends Model
{
    protected $table = 'usuario_periodo';

    public function usuario()
    {
        return $this->belongsTo('App\Usuario');
    }

    public function periodo()
    {
        return $this->belongsTo('App\Periodo');
    }
}
