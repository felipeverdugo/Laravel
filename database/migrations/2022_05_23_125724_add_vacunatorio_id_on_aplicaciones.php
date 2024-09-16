<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVacunatorioIdOnAplicaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('aplicaciones', function (Blueprint $table) {
            $table->date('fecha_turno')->nullable()->change();
            $table->unsignedBigInteger('vacunatorio_id')->nullable();
            $table->foreign('vacunatorio_id')->references('id')->on('vacunatorios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aplicaciones', function (Blueprint $table) {
            $table->date('fecha_turno')->nullable(false)->change();
            $table->dropForeign('aplicaciones_vacunatorio_id_foreign');
            $table->dropColumn('vacunatorio_id');
        });
    }
}
