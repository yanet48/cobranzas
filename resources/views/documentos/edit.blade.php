<!--Editar un cliente específica-->
@extends("layouts.template")

@section("contenido") 
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Editar Cliente</h1>            
    </div>
  
    {!! Form::model($cliente, ['method' => 'PATCH', 'action' => ['App\Http\Controllers\ClienteController@update', $cliente->id]]) !!}
        <table>
            <tr>
                <td>{!! Form::label('razonsocial', 'Razón Social') !!} </td>
                <td>{!! Form::text('razonsocial', null, ['class' => 'form-control', 'required']) !!} </td>
            </tr> 
            <tr>
                <td>{!! Form::label('documento', 'Documento') !!} </td>
                <td>{!! Form::text('documento', null, ['class' => 'form-control', 'required']) !!} </td>
            </tr> 
            <tr>
                <td>{!! Form::label('direccion', 'Dirección') !!} </td>
                <td>{!! Form::text('direccion', null, ['class' => 'form-control', 'required']) !!} </td>
            </tr> 
            <tr>
                <td>{!! Form::label('telefono', 'Teléfono') !!} </td>
                <td>{!! Form::text('telefono', null, ['class' => 'form-control', 'required']) !!} </td>
            </tr>           
            
            <tr>
                <td >{!! Form::submit('Modificar Cliente', ['class' => 'btn btn-primary' ]) !!} </td>
                <td>{!! Form::reset('Restaurar', ['class' => 'btn btn-danger' ]) !!} </td>
            </tr>            

        </table>
    {!! Form::close() !!}
@endsection