@extends('adminlte::page')

@section('content')

<div class="card" style="background-color: #fff">
    <div class="card-header bg-primary mb-3">
    <h3>Usuarios<a href="usuarios/create"><button type="button" class="btn btn-light float-right">Agregar usuario</button></a></h3>
    </div>
<div class="container p-2 my-2">


   
<table id="data-table" class="table ">
  <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">Nombre</th>
      <th scope="col">Email</th>
      
     
      <th scope="col" width="130px">Acciones</th>
      
    </tr>
  </thead>
  <tbody>
  @foreach($users as $user)
  
      <th scope="col">{{$user->id}}</th>
      <th scope="col">{{$user->name}}</th>
      <th scope="col">{{$user->email}}</th>
   
      <th scope="col" width="130px">Acciones</th>
@endforeach

  </tbody>
</table>
</div>
</div>


	


@endsection
