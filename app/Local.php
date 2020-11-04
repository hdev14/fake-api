<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    protected $table = 'local';

    protected $fillable = ['local'];

    public function turma_local()
    {
        return $this->hasMany('App\TurmaLocal');
    }
}
