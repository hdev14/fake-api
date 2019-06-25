<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriarBanco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vinculo', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->string('matricula', 45);
            $table->string('nome', 45);
            $table->string('curso', 45);
            $table->string('campus', 45);
            $table->string('situacao', 45);
            $table->boolean('cota_sistec');
            $table->boolean('cota_mec');
            $table->string('situacao_sistemica', 100);
            
        });

        Schema::create('usuario', function (Blueprint $table) {
            
            $table->bigIncrements('id')->autoIncrement();
            $table->unsignedInteger('vinculo_id')->nullable();
            $table->string('matricula', 45);
            $table->string('nome_usual', 45);
            $table->text('url_foto');
            $table->string('tipo_vinculo', 45);
            $table->string('email')->unique();

            $table->foreign('vinculo_id')
                    ->references('id')
                    ->on('vinculo')
                    ->change();
        });

        Schema::create('periodo', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->integer('ano_letivo');
            $table->integer('periodo_letivo');
            
        });

        Schema::create('boletin', function (Blueprint $table) {
            
            $table->bigIncrements('id')->autoIncrement();
            $table->unsignedInteger('usuario_id');
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

            $table->foreign('usuario_id')
                    ->references('id')
                    ->on('usuario');
        });

        Schema::create('etapa', function (Blueprint $table) {
            
            $table->bigIncrements('id')->autoIncrement();
            $table->unsignedInteger('boletin_id');
            $table->float('nota', 3, 2);
            $table->integer('faltas');

            $table->foreign('boletin_id')
                    ->references('id')
                    ->on('boletin');
            
        });

        Schema::create('turma', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->string('sigla', 10);
            $table->text('descricao');
            $table->string('observacao', 100);
            $table->enum('horarios_de_aula', ['2M12 / 3M56', '2M34 / 3M12']);
            $table->integer('ano_letivo');
            $table->integer('periodo_letivo');
            $table->string('componente_curricular', 200);
            $table->date('data_inicio')->useCurrent();
            $table->date('data_fim');
        });

        Schema::create('material', function (Blueprint $table) {
            
            $table->bigIncrements('id')->autoIncrement();
            $table->unsignedInteger('turma_id');
            $table->text('url');
            $table->date('data_vinculacao');
            $table->text('descricao');

            $table->foreign('turma_id')
                    ->references('id')
                    ->on('turma');
        });

        Schema::create('aula', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->unsignedInteger('turma_id');
            $table->integer('etapa');
            $table->string('professor', 45);
            $table->integer('quantidade');
            $table->integer('faltas');
            $table->text('conteudo');
            $table->date('data')->useCurrent();

            $table->foreign('turma_id')
                    ->references('id')
                    ->on('turma');
        });

        Schema::create('local', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->string('local', 100);
        });

        Schema::create('usuario_turma', function (Blueprint $table) {
            
            $table->unsignedInteger('usuario_id');
            $table->unsignedInteger('turma_id');

            $table->boolean('professor');
        });

        Schema::table('usuario_turma', function (Blueprint $table) {
            $table->primary(['usario_id', 'turma_id']);
            $table->foreign('usuario_id')->references('id')->on('usuario');
            $table->foreign('turma_id')->references('id')->on('turma');
        });

        Schema::create('usuario_periodo', function (Blueprint $table) {
            
            $table->unsignedInteger('usuario_id');
            $table->unsignedInteger('periodo_id');

        });

        Schema::table('usuario_periodo', function (Blueprint $table) {

            $table->primary(['usuario_id', 'periodo_id']);
            
            $table->foreign('usuario_id')
                    ->references('id')
                    ->on('usuario');

            $table->foreign('periodo_id')
                    ->references('id')
                    ->on('periodo');
        });

        Schema::create('turma_local', function (Blueprint $table) {
            
            $table->unsignedInteger('turma_id');
            $table->unsignedInteger('local_id');

        });

        Schema::table('turma_local', function (Blueprint $table) {

            $table->primary(['turma_id', 'local_id']);

            $table->foreign('turma_id')
                    ->references('id')
                    ->on('turma');

            $table->foreign('local_id')
                    ->references('id')
                    ->on('local');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('vinculo');
        Schema::drop('usuario');
        Schema::drop('periodo');
        Schema::drop('boletin');
        Schema::drop('etapa');
        Schema::drop('turma');
        Schema::drop('material');
        Schema::drop('aula');
        Schema::drop('local');
        Schema::drop('usuario_turma');
        Schema::drop('usuario_periodo');
        Schema::drop('turma_local');
    }
}
