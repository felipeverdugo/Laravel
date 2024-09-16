<?php

use App\Models\Vacuna;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacunasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacunas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('restriccion_etarea');
            $table->string('distancia_dosis'); //tiempo en meses entre dosis
            $table->boolean('requiere_validacion');
        });
        $vacunas = [
            [
                'nombre'              => 'Covid-19',
                'restriccion_etarea'  => '',
                'distancia_dosis'     => '3',
                'requiere_validacion' => false
            ], [
                'nombre'              => 'Gripe',
                'restriccion_etarea'  => '60',
                'distancia_dosis'     => '12',
                'requiere_validacion' => false
            ], [
                'nombre'              => 'Fiebre amarilla',
                'restriccion_etarea'  => '',
                'distancia_dosis'     => '',
                'requiere_validacion' => true
            ],
        ];
        foreach ($vacunas as $vacuna) {
            Vacuna::firstOrCreate($vacuna);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vacunas');
    }
}
