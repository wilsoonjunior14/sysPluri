<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Matriculas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matricula', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_curso')->unsigned();

            $table->integer('id_aluno')->unsigned();
            $table->timestamps();
        });

        Schema::table('matricula', function(Blueprint $table){
            $table->foreign('id_curso')->references('id')->on('curso')->onDelete('cascade');
            $table->foreign('id_aluno')->references('id')->on('aluno')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matricula');
    }
}
