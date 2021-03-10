<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Requests\UserFormRequest;
use App\Http\Requests\UserEditFormRequest;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   
    
     public function index(Request $request)
    {
        
        return view('usuarios.index', ['users'=>$users = User::all()]);

        
    }
}
