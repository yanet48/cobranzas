<!--Pantalla principal para los usuario-->
@extends("layouts.template")

@section("contenido") 

  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Cliente {{$cliente->razonsocial}}</h1>      
  </div>
 
   
    
    <table class="table" >      
      <tbody>
        <tr >
          <th scope="row">Id</th>
          <td>{{ $cliente->id }}</td>         
        </tr>
        <tr>
          <th scope="row">Razón Social</th>
          <td> {{ $cliente->razonsocial }}</td>
        </tr>
        <tr>
          <th scope="row">Documento</th>
          <td> {{ $cliente->documento }}</td>
        </tr>
        <tr>
          <th scope="row">Dirección</th>
          <td>{{ $cliente->direccion }}</td>
        </tr>
        <tr>
          <th scope="row">telefono</th>
          <td>{{ $cliente->telefono }}</td>
        </tr>
      </tbody>
    </table>

    
  
@endsection
