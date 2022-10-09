<!--Pantalla principal para los usuario-->
@extends("layouts.template")

@section("contenido") 
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ver documento cobranza</h1>           
</div>
<div class="form-group">
		<div class="col-md-7"> 
			<input name="cliente" type="text" class="form-control input-sm" id="txtCliente" value="{{$cliente->razonsocial}}" readonly="true">
</div>
<br>
<div class="container">
	<div class="form-group row">   
      <div class="col-md-10">		  
		    <input name="direccion" type="text" class="form-control input-sm" id="txtDireccion" readonly="true" value="{{$cliente->direccion}}">
	    </div>
	    <div class="col-md-2">		  
		    <input name="documento" type="text" class="form-control input-sm" id="txtDocumento" readonly="true" value="{{$cliente->documento}}" >
	    </div>    
  </div>
  <!-- DATOS DE FACTURA -->
  <div class="form-group row">
				<div class="col-md-2">
					<label class="sr-only" for="txtFecha">Fecha de emisión</label>
					<input name="fecha_emision"  id="txtFecha" type="date" class="form-control input-sm"  readonly="true"value="{{$documento->fecha_emision}}">

				</div>
				<div class="col-md-2">
					<label class="sr-only" for="txtSerie">Serie</label>
					<input name="serie" type="text" class="form-control input-sm" id="txtSerie" readonly="true"  value="{{$documento->serie}}">
				</div>
				<div class="col-md-3">
					<label class="sr-only" for="txtNumero">Número</label>
					<input name="numero" type="text" class="form-control input-sm" id="txtNumero" readonly="true" value="{{$documento->numero}}">
				</div>
				<div class="col-md-3">
					<label class="sr-only" for="txtCondicion">Condicion</label>
					<input name="condicion" type="text" class="form-control input-sm" id="txtCondicion"  readonly="true" value="{{$documento->condicion}}">
				</div>
				<div class="col-md-2">
        <input name="moneda" type="text" class="form-control input-sm" id="txtMoneda"  readonly="true" value="{{$documento->moneda}}">
				</div>
			</div>
			<div class="col-md-3">
				<input name="estado"  type="hidden" class="form-control input-sm" id="txtEstado" readonly="true" value="{{$documento->estado}}">
			</div>
</div> 
  <div class="form-group">
				<div class="col-md-12 pre-scrollable">
					<table width="100%" class="table-condensed table-striped table-bordered">
						<thead>
							<tr>
								<th class="text-center">DESCRIPCION DE SERVICIO</th>
								<th class="text-center" width="80px">P. Unitario</th>
								<th class="text-center" width="80px">Total</th>
								<th class="text-center" width="30px"></th>
							</tr>
						</thead> 
						<tbody id="tablaServicios">
            @foreach($servicios as $row)
              <tr>          
                <td>{{$row->descripcion}}</td>
                <td>{{$row->preciounitario}}</td>
                <td>{{$row->subtotal}}</td>          
               </tr>
            @endforeach 
						</tbody>
					</table>
				</div>
	</div>
  <div class="form-group">
  	<div class="col-md-12 text-left"> 
      <h1 class="h5">{{$TotalNumero}}</h1>  
    </div>    
	<div class="col-md-12 text-right"> 
      <h1 class="h5">Total: {{$total}}</h1>  
    </div>    
  </div>
  <div class="form-group ">
				<button id="btnImprimirComprobante" class="btn btn-primary" tabindex="9">
						Imprimir Documento
				</button>
			</div>
@endsection
