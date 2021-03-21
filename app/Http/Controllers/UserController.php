<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;
use App\Http\Requests\UserFormRequest;
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
}
