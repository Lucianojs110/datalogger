<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;
use App\Http\Requests\UserFormRequest;
use App\Http\Requests\UserEditFormRequest;
use Session;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['administrador']);
        return view('usuarios.index');
    }

    public function tabla()
    {
           
        return  User::With('roles')->get();

    }

    public function store(UserFormRequest $request)
    {
        $usuario = new User();
        $usuario->name = request('name');
        $usuario->email = request('email');
        $usuario->password = bcrypt(request('password'));
        $usuario->save();
        $usuario->asignarRol(request('rol'));
       
    }

    public function update(UserEditFormRequest $request, User $usuario)
    {
       

        $usuario->name = $request->get('name');
        $usuario->email = $request->get('email');

        
        $pass = $request->get('password');
        if ($pass != null) {
            $usuario->password = bcrypt($request->get('password'));
        } else {
            unset($usuario->password);
        }
        //modificamos esta parte para que actualice roles de usuarios
        //si tiene rol actualizamos el rol
        // si no tiene rol le asignamos un rol
        $role = $usuario->roles;
        if (count($role) > 0) {
            $role_id = $role[0]->id;
            User::find($usuario->id)->roles()->updateExistingPivot($role_id, ['role_id' => $request->get('rol')]);
        } else {
            $usuario->asignarRol($request->get('rol'));
        }

        $usuario->update();
       
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();
    }
}
