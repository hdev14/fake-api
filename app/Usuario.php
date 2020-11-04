<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Usuario extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $table = 'usuario';

    protected $fillable = [
        'matricula',
        'senha',
        'nome_usual',
        'url_foto',
        'tipo_vinculo',
        'email'
    ];

    public function getAuthIdentifierName()
    {
        return $this->matricula;
    }

    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function getAuthIdentifier()
    {
        return $this->matricula;
    }

    public function vinculo()
    {
        return $this->belongsTo('App\Vinculo');
    }

    public function usuario_periodo()
    {
        return $this->hasMany('App\UsuarioPeriodo');
    }

    public function usuario_turma()
    {
        return $this->hasMany('App\UsuarioTurma');
    }

    public function boletins()
    {
        return $this->hasMany('App\Boletin');
    }
}

