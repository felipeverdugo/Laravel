<?php

use App\Models\Vacunatorio;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacunatorioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacunatorios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('direccion')->nullable();
            $table->string('zona');
            $table->softDeletes();
        });
        Vacunatorio::insert([
            [
                'id'=> 1,
                'nombre'=>'Centro',
                'zona' => 'Centro',
            ],[
                'id'=> 2,
                'nombre'=>'Cementerio',
                'zona' => 'Cementerio',
            ],[
                'id'=> 3,
                'nombre'=>'Terminal',
                'zona' => 'Terminal',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vacunatorios');
    }
}
