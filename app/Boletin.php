<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boletin extends Model
{
    protected $table = 'boletin';

    protected $fillable = [
        'codigo_diario',
        'disciplina',
        'segundo_semestre',
        'carga_horario',
        'carga_horario_cumprida',
        'media_disciplina',
        'numero_faltas',
        'percentual_carga_horaria_frequencia',
        'situacao',
        'quantidade_avaliacoes',
        'media_final_disciplina'
    ];

    public function usuario()
    {
        return $this->belognsTo('App\Usuario');
    }

    public function etapas()
    {
        return $this->hasMany('App\Etapa');
    }
}
