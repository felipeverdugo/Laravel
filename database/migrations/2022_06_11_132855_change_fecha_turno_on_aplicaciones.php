<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFechaTurnoOnAplicaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aplicaciones', function (Blueprint $table) {
            $table->dateTime('fecha_turno')->nullable()->change();           
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
            $table->date('fecha_turno')->nullable()->change();           
        }); 
    }
}
