<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLoteLaboratorioToAplicaciones extends Migration
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
            $table->string('lote')->nullable();
            $table->string('laboratorio')->nullable();
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
            $table->dropColumn('lote');
            $table->dropColumn('laboratorio');
        });
    }
}
