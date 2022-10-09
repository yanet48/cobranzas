<!--Crear un usuario específico-->
@extends("layouts.template")

@section("contenido") 
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Crear Cliente</h1>           
    </div>
  
    {!! Form::open(['method' => 'POST', 'action' => 'App\Http\Controllers\ClienteController@store']) !!}
        <table>
            <tr>
                <td>{!! Form::label('razonsocial', 'Razón Social') !!} </td>
                <td>{!! Form::text('razonsocial', null, ['class' => 'form-control', 'required']) !!} </td>
            </tr>
            <tr>
                <td>{!! Form::label('documento', 'Documento(RUC)') !!} </td>
                <td>{!! Form::text('documento', null, ['class' => 'form-control', 'required']) !!} </td>
            </tr>
            <tr>
                <td>{!! Form::label('direccion', 'Dirección') !!} </td>
                <td>{!! Form::text('direccion', null, ['class' => 'form-control', 'required']) !!} </td>
            </tr>
            <tr>
                <td>{!! Form::label('telefono', 'Telefono') !!} </td>
                <td>{!! Form::text('telefono', null, ['class' => 'form-control', 'required']) !!} </td>
            </tr>
           
            <tr>
                <td >{!! Form::submit('Crear Cliente', ['class' => 'btn btn-primary' ]) !!} </td>
                <td>{!! Form::reset('Borrar', ['class' => 'btn btn-danger' ]) !!} </td>
            </tr>            

        </table>
    {!! Form::close() !!}
@endsection
