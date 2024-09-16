<?php

namespace App\Http\Livewire;

use Exception;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\Aplicacion;
use App\Mail\AplicacionRecibida;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AplicacionesEnfermeroComponent extends Component
{
    public $zona, $aplicaciones, $nombre,  $vacunas, $obs;
    public $vacuna_id, $vacunatorios, $vacunatorio_id;
    public  $aplicacion_id, $lote, $laboratorio, $aplicacion;
    public $isModalOpen = 0;

    public function render()
    {
        $this->aplicaciones = Aplicacion::all();
        // $this->aplicaciones = Aplicacion::where('vacunatorio_id', Auth::user()->vacunatorio->id)
        //                                     ->where('estado', '!=', 'CANCELADA')
        //                                     ->whereDate('fecha_turno', Carbon::now())->get();
        return view('livewire.aplicacionesEnfermero.index');
    }

    public function create()
    {

        $this->resetCreateForm();
        $this->openModalPopover();
    }

    public function openModalPopover()
    {
        $this->isModalOpen = true;
    }

    public function closeModalPopover()
    {
        $this->isModalOpen = false;
    }

    private function resetCreateForm()
    {
        $this->aplicacion_id = null;
        $this->aplicacion = null;
        $this->lote = null;
        $this->laboratorio = null;
        $this->obs = null;
    }

    public function store()
    {

        $this->validate([
            'aplicacion_id' => ['required',],
            'lote' => ['required', 'string'],
            'laboratorio' => ['required', 'string']
        ]);
        $this->aplicacion = Aplicacion::find($this->aplicacion_id);
        $this->aplicacion->lote = $this->lote;
        $this->aplicacion->laboratorio = $this->laboratorio;
        $this->aplicacion->fecha_aplicacion = Carbon::now();
        $this->aplicacion->estado = 'APLICADA';
        $this->aplicacion->obs = $this->obs;

        $this->aplicacion->save();

        try {
            Mail::to($this->aplicacion->paciente->email)->send(new AplicacionRecibida($this->aplicacion));
        } catch (\Exception $e) {
            return session()->flash('message', 'No se pudo enviar el mail con causa: ' . $e->getMessage());
        }
        // session()->flash('message', $this->aplicacion ? 'Turno actualizado.' : 'Turno creado.');

        $this->closeModalPopover();
        $this->resetCreateForm();
    }

    public function edit($id)
    {
        $this->aplicacion = Aplicacion::findOrFail($id);
        $this->aplicacion_id = $id;


        $this->openModalPopover();
    }

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
