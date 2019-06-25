<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoletinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boletins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo_diario', 45);
            $table->string('disciplina', 45);
            $table->boolean('segundo_semestre');
            $table->integer('carga_horaria');
            $table->integer('carga_horaria_cumprida');
            $table->float('media_disciplina', 8, 2);
            $table->integer('numero_faltas');
            $table->float('percentual_carga_horaria_frequencia', 8, 2);
            $table->string('situacao', 45);
            $table->integer('quantidade_avaliacoes');
            $table->float('media_final_disciplina', 8, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boletins');
    }
}
