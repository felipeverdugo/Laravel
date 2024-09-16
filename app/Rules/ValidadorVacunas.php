<?php

namespace App\Rules;

use App\Models\Aplicacion;
use App\Models\Vacuna;
use Attribute;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ValidadorVacunas implements Rule
{
    private $mensaje;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */

    public function validarCovid(int $id, int $value)
    {

        $fecha_aplicacion = Aplicacion::select('fecha_aplicacion')->where('vacuna_id', $value)
            ->where('user_id', $id)
            ->where('estado', '=', "APLICADA")
            ->orderBy('fecha_aplicacion', 'DESC')
            ->first();


        $ultimaAplicacion = $fecha_aplicacion ? $fecha_aplicacion->fecha_aplicacion : Carbon::now();

        $fecha_hoy = Carbon::now();
        $fecha_tres_semanas = $fecha_hoy->subDay(21)->format('Y-m-d');


        if (!($fecha_aplicacion === null || $ultimaAplicacion < $fecha_tres_semanas)) {
            $this->mensaje = 'Usted ya tiene la vacuna para el Covid-19 aplicada. Revise su correo para conocer su proximo turno';
            return false;
        }
        $fecha_aplicacion = Aplicacion::select('fecha_aplicacion')->where('vacuna_id', $value)
            ->where('user_id', $id)
            ->where('estado', '=', "PENDIENTE")
            ->first();
        if ($fecha_aplicacion) {
            $this->mensaje = 'Usted ya tiene un turno para el Covid-19';
            return false;
        }
        return true;
    }

    public function validarFiebreAmarilla(int $id, int $value)
    {
        $fecha_aplicacion = Aplicacion::select('fecha_aplicacion')->where('vacuna_id', $value)
            ->where('user_id', $id)
            ->where('estado', '=', "APLICADA")
            ->orderBy('fecha_aplicacion', 'DESC')
            ->first();

        if ($fecha_aplicacion === null) {
            return true;
        } else {
            return false;
        }
    }


    public function validarGripe(int $id, int $value)
    {


        $fecha_aplicacion = Aplicacion::select('fecha_aplicacion')->where('vacuna_id', $value)
            ->where('user_id', $id)
            ->where('estado', '=', "APLICADA")
            ->orderBy('fecha_aplicacion', 'DESC')
            ->first();



        $fecha_hoy = Carbon::now();
        $fecha_last_year = $fecha_hoy->subYear();
        $ultimaAplicacion = $fecha_aplicacion ? $fecha_aplicacion->fecha_aplicacion : Carbon::now();
        $edad = Carbon::createFromDate(Auth::user()->fecha_nac)->age;
        if (($edad <= 60) && ($fecha_aplicacion === null || $ultimaAplicacion < $fecha_last_year)) {
            return true;
        } else {
            return false;
        }
    }
    public function passes($attribute, $value)
    {



        if ($value === "1") {
            return $this->validarCovid(Auth::user()->id, $value);
        } elseif ($value === "2") {
            return $this->validarGripe(Auth::user()->id, $value);
        } else {
            return $this->validarFiebreAmarilla(Auth::user()->id, $value);
        }
    }






    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->mensaje ? $this->mensaje : 'No cumples los requisitos para darte esta vacuna';
    }
}
