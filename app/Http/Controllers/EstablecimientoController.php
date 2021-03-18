<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Establecimiento;

class EstablecimientoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {  
        return view('establecimientos.index');
       

    }

    public function tabla()
    {
           
        return  Establecimiento::where('activo', 1)->get();
        
    }
    
     public function show(Establecimiento $establecimiento)
    {
        
        return $establecimiento;    
    }

    public function store(Request $request)
    {
        
        $establecimiento = new Establecimiento();
        $establecimiento->nombre = request('nombre');
        $establecimiento->descripcion = request('descripcion');
        $establecimiento->ubicacion = request('ubicacion');
        $establecimiento->id_usuario= 1;
        $establecimiento->activo= 1;
        $establecimiento->save();

    }
    public function update(Request $request, Establecimiento $establecimiento)
    {
        
        $establecimiento->update($request->all());

    }

    //public function destroy(Establecimiento $establecimiento)
    //{
    //    $establecimiento->delete();
   // }

    public function destroy(Establecimiento $establecimiento)
    {
        $establecimiento->activo = 0;
        $establecimiento->update();
    }
}
