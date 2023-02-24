<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('semestres', function (Blueprint $table) {
            //Relacion
            //Una carrera puede tener muchos semestres y un semestre pertenece a una carrera.
            $table->unsignedBigInteger('carreras_id')->after('id')->nullable();

            $table->foreign('carreras_id')
                ->references('id')
                ->on('carreras')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
             // Para que se elimine el campo cuando se haga un rollback de la BDD
        Schema::table('semestres', function (Blueprint $table) {
            $table->dropForeign(['carreras_id']);
        });
    }
};
