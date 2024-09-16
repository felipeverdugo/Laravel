<?php

namespace App\Http\Livewire;

use App\Mail\CreacionTurno;
use Exception;
use Carbon\Carbon;
use App\Models\Vacuna;
use Livewire\Component;
use App\Models\Aplicacion;
use App\Models\Vacunatorio;
use App\Rules\ValidadorVacunas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MisAplicacionesComponent extends Component
{
    public $aplicaciones, $nombre,  $vacunas, $aplicacionesPendientes;
    public $vacuna_id, $vacunatorios, $vacunatorio_id;
    public $isModalOpen = 0;

    public function render()
    {
        $this->aplicacionesPendientes = Auth::user()->aplicacionesPendientes()->get();
        $this->aplicaciones = Auth::user()->aplicacionesNoPendientes()->get();

        return view('livewire.aplicaciones.index');
    }

    public function create()
    {

        $this->resetCreateForm();
        $this->openModalPopover();
    }

    public function openModalPopover()
    {
        $this->vacunatorios = Vacunatorio::all();
        $this->vacunas = Vacuna::all();
        $this->isModalOpen = true;
    }

    public function closeModalPopover()
    {
        $this->isModalOpen = false;
    }

    private function resetCreateForm()
    {
        $this->vacuna_id = null;
        $this->vacunatorio_id = null;
      
    }

    public function store()
    {
        //  dd($this);
        $this->validate([
            'vacuna_id' => ['required', new ValidadorVacunas()],
            'vacunatorio_id' => ['required']
        ]);

        $apl = $this->vacuna_id;
        $ultimoTurno = Aplicacion::where('vacuna_id', $this->vacuna_id)
            ->where('estado', '!=', 'CANCELADA')
            ->orderBy('fecha_turno', 'DESC')->first();

        $fechaUltimo = $ultimoTurno ? $ultimoTurno->fecha_turno : Carbon::now();

        $fechaMinima = Carbon::now()->addWeek(1);
        if ($fechaMinima > $fechaUltimo) {
            $fechaUltimo = $fechaMinima;
        }
        $fechaTurno = $fechaUltimo->addDay();
        $user_id =  Auth::user()->id;
        $turno = Aplicacion::create(
            [
                'vacuna_id' => $this->vacuna_id,
                'user_id' => $user_id,
                'fecha_turno' => $fechaTurno,
                'vacunatorio_id' => $this->vacunatorio_id,
            ]
        );


        session()->flash('message', 'Turno creado.');

        $this->closeModalPopover();
        $this->resetCreateForm();
        try {
            Mail::to($turno->paciente->email)->send(new CreacionTurno($turno));
        } catch (\Exception $e) {

            return session()->flash('message', 'No se pudo enviar el mail con causa: ' . $e->getMessage());
        }
       

    }

    // public function edit($id)
    // {
    //     $aplicacion = Aplicacion::findOrFail($id);
    //     $this->aplicacion_id = $id;
    //     $this->nombre = $aplicacion->nombre;

    //     $this->openModalPopover();
    // }

    public function delete($id)
    {
        try {
            $app =  Aplicacion::find($id);
            $app->estado = "CANCELADA";
            $app->save();

            session()->flash('message', 'Turno cancelado.');
        } catch (Exception $e) {

            session()->flash('message', 'El turno para la vacuna ' . Aplicacion::find($id)->vacuna->nombre . ' no se puede eliminar.');
            return false;
        }
    }
}
