<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVinculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vinculos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('matricula', 45);
            $table->string('nome', 45);
            $table->string('curso', 45);
            $table->string('campus', 45);
            $table->string('situacao', 45);
            $table->boolean('cota_sistec');
            $table->boolean('cota_mec');
            $table->string('situacao_sistemica', 100);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vinculos');
    }
}
