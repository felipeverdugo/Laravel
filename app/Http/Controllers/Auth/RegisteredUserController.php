<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Vacuna;
use App\Models\Aplicacion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Mail\WelcomeTokenReceived;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Support\Facades\Session;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' =>['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'dni' => ['required','regex:/^[0-9]+$/', 'string', 'max:8',  'min:7','unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'fecha_nac' =>['required', 'date', 'before:'. Carbon::now()],
           
         
        ]);

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'dni' => $request->dni,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_token' => substr(mt_rand(1000,time()),0,4),
            'fecha_nac' =>$request->fecha_nac,
        ]);
        
        $user->assignRole('Paciente');
        
        if(isset($request->vacuna_covid)){
           $user->aplicaciones()->create([
               'vacuna_id' => 1,
               'fecha_aplicacion' => $request->vacuna_covid, 
               'estado' => 'APLICADA',
               'created_at' => null
            ]);
        }
        if(isset($request->vacuna_fiebre)){
           $user->aplicaciones()->create([
               'vacuna_id' => 2,
               'fecha_aplicacion' => $request->vacuna_fiebre,
               'estado' => 'APLICADA',
               'created_at' => null
            ]);
        }
        if(isset($request->vacuna_gripe)){
           $user->aplicaciones()->create([
               'vacuna_id' => 3,
               'fecha_aplicacion' => $request->vacuna_gripe,
               'estado' => 'APLICADA',
               'created_at' => null
            ]);
        }
        event(new Registered($user));
       
        // Auth::login($user);
        try{
            Mail::to($user->email)->send(new WelcomeTokenReceived($user));
        }catch(\Exception $e){
           
            return redirect()->route('login')->with('error', 'No se pudo enviar el mail con causa: ' . $e);
        }

        return redirect()->route('login',['success' => 'Registro completo, revise su email para obtener el token e iniciar sesión.']);
    }
}
