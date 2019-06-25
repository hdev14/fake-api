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
        Schema::create('vinculos', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->string('matriculaa', 45);
            $table->string('nome', 45);
            $table->string('curso', 45);
            $table->string('campus', 45);
            $table->string('situacao', 45);
            $table->boolean('cota_sistec');
            $table->boolean('cota_mec');
            $table->string('situacao_sistemica', 100);
            
        });

        Schema::create('usuarios', function (Blueprint $table) {
            
            $table->bigIncrements('id')->autoIncrement();
            $table->unsignedInteger('vinculo_id')->nullable();
            $table->string('matricula', 45);
            $table->string('nome_usual', 45);
            $table->text('url_foto');
            $table->string('tipo_vinculo', 45);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('vinculo_id')
                    ->references('id')
                    ->on('vinculos');
        });

        Schema::create('periodos', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->integer('ano_letivo');
            $table->integer('periodo_letivo');
            
        });

        Schema::create('boletins', function (Blueprint $table) {
            
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
                    ->on('usuarios');
        });

        Schema::create('etapas', function (Blueprint $table) {
            
            $table->bigIncrements('id')->autoIncrement();
            $table->unsignedInteger('boletin_id');
            $table->float('nota', 3, 2);
            $table->integer('faltas');

            $table->foreign('boletin_id')
                    ->references('id')
                    ->on('boletins');
            
        });

        Schema::create('turmas', function (Blueprint $table) {
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

        Schema::create('materials', function (Blueprint $table) {
            
            $table->bigIncrements('id')->autoIncrement();
            $table->unsignedInteger('turma_id');
            $table->text('url');
            $table->date('data_vinculacao');
            $table->text('descricao');

            $table->foreign('turma_id')
                    ->references('id')
                    ->on('turmas');
        });

        Schema::create('aulas', function (Blueprint $table) {
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
                    ->on('turmas');
        });

        Schema::create('locals', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->string('local', 100);
        });

        Schema::create('usuario_turmas', function (Blueprint $table) {
            
            $table->unsignedInteger('usuario_id');
            $table->unsignedInteger('turma_id');
            $table->boolean('professor');

            $table->foreign('usuario_id')
                    ->references('id')
                    ->on('usuarios');
            $table->foreign('turma_id')
                    ->references('id')
                    ->on('turmas');
                    
            $table->primary(['usario_id', 'turma_id']);

        });

        Schema::create('usuario_periodos', function (Blueprint $table) {
            
            $table->unsignedInteger('usuario_id');
            $table->unsignedInteger('periodo_id');


            $table->foreign('usuario_id')
                    ->references('id')
                    ->on('usuarios');

            $table->foreign('periodo_id')
                    ->references('id')
                    ->on('periodos');

            $table->primary(['usuario_id', 'periodo_id']);
        });

        Schema::create('turma_locals', function (Blueprint $table) {
            $table->unsignedInteger('turma_id');
            $table->unsignedInteger('local_id');


            $table->foreign('turma_id')
                    ->references('id')
                    ->on('turmas');

            $table->foreign('local_id')
                    ->references('id')
                    ->on('locals');
            
            $table->primary(['turma_id', 'local_id']);
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
    }
}
