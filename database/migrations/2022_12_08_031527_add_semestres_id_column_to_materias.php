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
        Schema::table('materias', function (Blueprint $table) {
            //Relacion
            //Un semestre puede tener muchas materias y una materia pertenece a un semestre.
            $table->unsignedBigInteger('semestres_id')->after('id')->nullable();

            $table->foreign('semestres_id')
                ->references('id')
                ->on('semestres')
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
        Schema::table('materias', function (Blueprint $table) {
            $table->dropForeign(['semestres_id']);
            //
        });
    }
};
