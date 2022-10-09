<!--Pantalla principal para los usuario-->
@extends("layouts.template")

@section("contenido") 

  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Listado Clientes</h1>
    @if(Auth::user()->role_id == 1)    
      <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">        
          <a href="/clientes/create" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Crear Cliente</a>
        </div>     
      </div>
    @endif
  </div>
 
  @if(count($clientes))
  
    <table class="table " id="id_table">
      <thead class="thead-dark">
        <tr>          
          <th scope="col">Id</th>
          <th scope="col">Razon Social</th>
          <th scope="col">Documento</th>          
          <th scope="col">Direccion</th>
          <th scope="col">Telefono</th>
          @if(Auth::user()->role_id == 1)
            <th scope="col">Opciones</th>          
          @endif
        </tr>
      </thead>
      <tbody>

      @foreach($clientes as $row)
        <tr>          
          <td>{{$row->id}}</td>
          <td>{{$row->razonsocial}}</td>
          <td>{{$row->documento}}</td>          
          <td>{{$row->direccion}}</td>          
          <td>{{$row->telefono}}</td>                    
          @if(Auth::user()->role_id == 1)
            <td>
              <a href= "{{route('clientes.show', $row -> id) }}"> Ver </a> &nbsp;
              <a href= "{{route('clientes.edit', $row -> id) }}"> Editar </a> &nbsp;
              <meta name="csrf-token" content="{{ csrf_token() }}">
              <a href="{{ route('clientes.destroy', $row->id) }}" data-method="delete" class="jquery-postback">Delete</a>
            </td>          
          @endif
        </tr>
      @endforeach 

      </tbody>
    </table>
    
  @else
    {{"No existen clientes registrados"}}
  @endif
  
  <script>
    //funcion para borrar un usuario
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });
    
    $(document).on('click', 'a.jquery-postback', function(e) {   
      
      e.preventDefault();   
      var $this = $(this);
      var indice = $this[0].toString();

      var result = confirm("Estas seguro que deseas eliminar el cliente: " +  indice.substring(indice.lastIndexOf('/') + 1,indice.size) + "???");
            
      if(result){        
    
        $.post({
            type: $this.data('method'),
            url: $this.attr('href')
        }).done(function (data) {
            alert('Usuario borrado exitosamente');
            console.log(data);
            window.location.reload();
        });
      }      
    });
    
  </script>

@endsection
