<?php

namespace App\Http\Controllers;
use App\Models\Temperatura;

use Illuminate\Http\Request;

class TemperaturaController extends Controller
{
    

    public function store (Request $request)
    {

      $temperatura =  new Temperatura();
      $temperatura->id_unidad = request('id_unidad');
      $temperatura->temperatura= floatval(request('temperatura'));
     
      $temperatura->save();
       
    }



}
