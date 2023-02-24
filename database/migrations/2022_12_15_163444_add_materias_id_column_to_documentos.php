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
        Schema::table('documentos', function (Blueprint $table) {
           //Relacion
            //Una materia puede tener muchos documentos y un documento pertenece a una materia.
            $table->unsignedBigInteger('materias_id')->after('id')->nullable();

            $table->foreign('materias_id')
                ->references('id')
                ->on('materias')
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
        Schema::table('documentos', function (Blueprint $table) {
            $table->dropForeign(['materias_id']);
        });
    }
};
