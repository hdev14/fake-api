<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    protected $table = 'turma';

    protected $fillable = [
        'sigla',
        'descricao',
        'observacao',
        'horarios_de_aula',
        'ano_letivo',
        'periodo_letivo',
        'componente_curricular'
    ];

    public function usuario_turma()
    {
        return $this->hasMany('App\UsuarioTurma');
    }

    public function turma_local()
    {
        return $this->hasMany('App\TurmaLoca');
    }

    public function aulas()
    {
        return $this->hasMany('App\Aula');
    }

    public function materiais()
    {
        return $this->hasMany('App\Material');
    }
}
