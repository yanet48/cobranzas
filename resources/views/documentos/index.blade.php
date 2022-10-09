<!--Pantalla principal para los usuario-->
@extends("layouts.template")

@section("contenido") 

  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Listado Documento Cobranzas</h1>
    @if(Auth::user()->role_id == 1)    
      <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">        
          <a href="/documentos/create" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Crear Documento</a>
        </div>     
      </div>
    @endif
  </div>
 
  @if(count($documentos))
  
    <table class="table " id="id_table">
      <thead class="thead-dark">
        <tr>          
          <th scope="col">Id</th>
          <th scope="col">Razon Social</th>
          <th scope="col">Documento</th>          
          <th scope="col">Serie</th>
          <th scope="col">Numero</th>
          <th scope="col">Fecha Emision</th>
          <th scope="col">Condicion</th>
          <th scope="col">Moneda</th>
          <th scope="col">Estado</th>
          @if(Auth::user()->role_id == 1)
            <th scope="col">Opciones</th>          
          @endif
        </tr>
      </thead>
      <tbody>

      @foreach($documentos as $row)
        <tr>          
          <td>{{$row->id}}</td>
          <td>{{$row->razonsocial}}</td>
          <td>{{$row->documento}}</td>
          <td>{{$row->serie}}</td>          
          <td>{{$row->numero}}</td>          
          <td>{{$row->fecha_emision}}</td>                    
          <td>{{$row->condicion}}</td>                    
          <td>{{$row->moneda}}</td>  
          <td>{{$row->estado}}</td>                  
          @if(Auth::user()->role_id == 1)
            <td>
              <a href= "{{route('documentos.show', $row -> id) }}"> Ver </a> &nbsp;
              <a href= "{{route('documentos.edit', $row -> id) }}"> Imprimir </a> &nbsp;
              <meta name="csrf-token" content="{{ csrf_token() }}">
              <a href="{{ route('documentos.destroy', $row->id) }}" data-method="delete" class="jquery-postback">Anular</a>
            </td>          
          @endif
        </tr>
      @endforeach 

      </tbody>
    </table>
    
  @else
    {{"No existen documentos registrados"}}
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

      var result = confirm("Estas seguro que deseas anular el documento de cobranza : " +  indice.substring(indice.lastIndexOf('/') + 1,indice.size) + "???");
            
      if(result){        
    
        $.post({
            type: $this.data('method'),
            url: $this.attr('href')
        }).done(function (data) {
            alert('Documento anulado exitosamente');
            console.log(data);
            window.location.reload();
        });
      }      
    });
    
  </script>

@endsection
