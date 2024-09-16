<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vacunatorio;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Kineticamobile\Lumki\Controllers\UserController as BaseController;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::all();
        $arrayRoles = [];
        foreach ($roles as $key => $rol) {
            $arrayRoles = Arr::prepend($arrayRoles, $rol->name);
        }
        $defaults = [
            'rol' => $arrayRoles,
            'name' => '',
            'dni' => '',
            'blocked' => true,
        ];

        $filtros = array_merge($defaults, $request->get('filtros', []));
        $whereContains = fn ($column1,$column2,$text) => function ($q) use ($column1,$column2,$text) {
            $matcher = Str::of($text)
                ->replace(['\\', '_', '%'], ['\\\\', '\\_', '\\%'])
                ->start('%')
                ->finish('%');
            if ($column2 == '') {
                return $q->where($column1, 'like', $matcher);
            }
            return $q->where($column1, 'like', $matcher)
                ->orWhere($column2, 'like', $matcher);    
        };
        if ($request->has('ocultarBloqueados')) {
            $filtros['blocked'] = true;
        } else {
            $filtros['blocked'] = false;
        }
        $users = User::query()
            ->when(!empty($filtros['rol']), function ($q) use ($filtros) {
                $q->whereHas('roles', function ($q2) use ($filtros) {
                    $q2->whereIn('name', $filtros['rol']);
                });
            })
            ->when(!empty($filtros['name']),$whereContains('name','last_name',$filtros['name']))
            ->when(!empty($filtros['dni']),  $whereContains('dni','', $filtros['dni']))
            ->when(!empty($filtros['blocked']), function ($qq) {
                $qq->where('blocked_at', null);
            })
            ->sortable(['name' => 'desc'])
            ->paginate(10);

        return view('lumki::users.index', [
            'users' => $users,
            'filtros' => $filtros,
            'roles' =>  $roles
        ]);
    }

    public function block(User $user)
    {
        $user->blocked = !$user->blocked;
        $user->save();

        return redirect()->route('lumki.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lumki::users.create', [
            'roles' => Role::all(),
            'custom_fields' => config('lumki.custom_fields'),
            'vacunatorios' => Vacunatorio::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'dni' => ['required', 'regex:/^[0-9]+$/', 'string', 'max:8',  'min:7', 'unique:users'],
            'vacunatorio_id' => ['required'],
        ]);

        $data = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'dni' => $validatedData['dni'],
            'vacunatorio_id' => $validatedData['vacunatorio_id'],
        ];

        foreach (config('lumki.custom_fields') as $item) {
            $data[$item['name']] = $request->{$item['name']};
        }

        $user = User::create($data);
        $user->syncRoles(request('roles'));

        return redirect(route('lumki.users.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('lumki::users.edit', [
            'user' => $user,
            'roles' => Role::all(),
            'custom_fields' => config('lumki.custom_fields'),
            'vacunatorios' => Vacunatorio::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = [];

        if ($request->has('name')) {
            $rules['name'] = ['required', 'string', 'max:255'];
        }

        if ($request->has('email')) {
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id];
        }

        if ($request->filled('password')) {
            $rules['password'] = ['sometimes', 'required', 'string', 'min:8', 'confirmed'];
        }
        if ($request->has('vacunatorio_id'))
            $rules['vacunatorio_id'] = ['required'];
        $validatedData = $request->validate($rules);

        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }
        foreach (config('lumki.custom_fields') as $item) {
            $validatedData[$item['name']] = $request->{$item['name']};
        }

        $user->update($validatedData);
        $user->syncRoles(request('roles'));

        return redirect()->route('lumki.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('lumki.users.index');
    }
}
