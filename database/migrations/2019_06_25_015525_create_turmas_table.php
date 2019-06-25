<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTurmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turmas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sigla', 10);
            $table->text('descricao');
            $table->string('observacao', 100);
            $table->enum('horarios_de_aula', ['2M12 / 3M56', '2M34 / 3M12']);
            $table->integer('ano_letivo');
            $table->integer('periodo_letivo');
            $table->string('componente_curricular', 100);
            $table->date('data_inicio');
            $table->date('data_fim');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('turmas');
    }
}
