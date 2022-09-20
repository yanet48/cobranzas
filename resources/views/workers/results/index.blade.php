<!-- Indice de resultados obtenidos por trabajador -->
@extends("layouts.template")

@section("contenido")    
      
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">{{$trabajador->name}}</h1>    
    @if(Auth::user()->role_id < 3)
      <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">        
          <a href="results/create" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Añadir Resultado</a>
        </div>     
      </div>
    @endif
  </div>

  @if(count($results))
    <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>
  @endif 

  <h2>Resultados</h2>
  <div class="table-responsive">
    <table class="table table-striped table-sm" id="id_table">
      <thead>
        <tr>
          <th>Fecha</th>
          <th>Temperatura</th>
          <th>Saturación de Oxigeno</th>
          @if(Auth::user()->role_id < 3)
            <th>Opciones</th>
          @endif
        </tr>
      </thead>
      <tbody>
      @foreach($results as $result)
        <tr>
          <td>{{$result->date}}</td>
          <td>{{$result->temperature}}</td>
          <td>{{$result->oxygen_saturation}}</td>
          @if(Auth::user()->role_id < 3) 
            <td>
              <a href= "results/{{$result->id}}"> Ver </a> &nbsp;
              <a href= "{{route('results.edit', [$trabajador -> id, $result -> id]) }}"> Editar </a> &nbsp;
              <meta name="csrf-token" content="{{ csrf_token() }}">
              <a href="results/{{$result->id}}" data-method="delete" class="jquery-postback">Delete</a>
            </td>            
          @endif
        </tr>
      @endforeach 
      </tbody>
    </table>
  </div>     
     

  <script>    
    var appSettings = {!! json_encode($results->toArray(), JSON_HEX_TAG) !!};
  </script>

  <script>
    //funcion para borrar un resultado
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });
    
    $(document).on('click', 'a.jquery-postback', function(e) {   
      
      e.preventDefault();   
      var $this = $(this);
      var indice = $this[0].toString();

      var result = confirm("Estas seguro que deseas eliminar al resultado: " +  indice.substring(indice.lastIndexOf('/') + 1,indice.size) + "???");
            
      if(result){        
    
        $.post({
            type: $this.data('method'),
            url: $this.attr('href')
        }).done(function (data) {
            alert('Resultado borrado exitosamente');
            console.log(data);
            window.location.reload();
        });
      }      
    });
    
  </script>
  
  <script type="text/javascript" src="{{ asset('js/dashboard.js') }}"></script>
@endsection

