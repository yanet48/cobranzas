<!--Crear un usuario específico-->
@extends("layouts.template")



@section("contenido") 
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Crear documento cobranza</h1>           
    </div>
	<div class="input-group">
		<div class="input-group-btn col-md-7">   
			
			<input name="cliente" type="text" class="form-control input-sm required" id="txtCliente" placeholder="Nombre o razón social" oninvalid="this.setCustomValidity('Debe ingresar el nombre o la razón social del cliente')" required oninput="setCustomValidity('')" tabindex="6">
		</div>
		<div class="input-group-btn">
			<button id="btnAgregarCliente" class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCliente">
					<i class="fa fa-address-book-o" aria-hidden="true"></i>
			</button>
		</div>
		<div class="col-md-3">  
			
            <button id="btnAgregarServicio"   class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarServicio" >
                Agregar Servicio
            </button>
    	</div>
	</div>				
	<br>
    {!! Form::open(['method' => 'POST', 'action' => 'App\Http\Controllers\DocumentoController@store']) !!}
	<div class="container">
		<input id="hiddenCliente" type="hidden" name="cliente_id">
		<input id="hiddenListado" type="hidden" name="listadoServicios">
		<div class="form-group row">
			<div class="col-md-5">
				<label class="sr-only" for="txtDireccion">Dirección</label>
				<input name="direccion" type="text" class="form-control input-sm" id="txtDireccion" placeholder="Dirección" tabindex="7">
			</div>
			<div class="col-md-2">
					<label class="sr-only" for="txtDocumento">Documento</label>
			<input name="documento" type="text" class="form-control input-sm" id="txtDocumento" placeholder="Documento" tabindex="8">
			</div>
		</div>
		<!-- DATOS DE FACTURA -->
			<div class="form-group row">
				<div class="col-md-2">
					<label class="sr-only" for="txtFecha">Fecha de emisión</label>
					<input name="fecha_emision"  id="txtFecha" type="date" class="form-control input-sm" value="{{$FechaEmision}}">

				</div>
				<div class="col-md-2">
					<label class="sr-only" for="txtSerie">Serie</label>
					<input name="serie" type="text" class="form-control input-sm" id="txtSerie" placeholder="Serie" tabindex="2" value="{{$Serie}}">
				</div>
				<div class="col-md-3">
					<label class="sr-only" for="txtNumero">Número</label>
					<input name="numero" type="text" class="form-control input-sm" id="txtNumero" placeholder="Numero" tabindex="3" value="{{$Numero}}">
				</div>
				<div class="col-md-3">
					<label class="sr-only" for="txtCondicion">Condicion</label>
					<input name="condicion" type="text" class="form-control input-sm" id="txtCondicion" placeholder="Condicion" tabindex="3" value="{{$Condicion}}">
				</div>
				<div class="col-md-2">
						<select name="moneda" class="form-control input-sm" tabindex="4">
							<option value="SOL">SOLES</option>
							<option value="USD" selected="true">DOLARES</option>
						</select>
				</div>
			</div>
			<div class="col-md-3">
				<input name="estado"  type="hidden" class="form-control input-sm" id="txtEstado" placeholder="Condicion" tabindex="3" value="{{$Estado}}">
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
													
						</tbody>
					</table>
				</div>
			</div>
			<div class="form-group ">
				<button id="btnGuardarComprobante" class="btn btn-primary" tabindex="9">
						Guardar Documento
				</button>
				
			</div>
			<div class="form-group col-md-12">
				<table class="table-condensed pull-right table-striped">
						<thead id="tablaResumen">
													
						</thead>
				</table>
			</div>
</div>
        
    {!! Form::close() !!}
<div class="modal fade" id="modalAgregarCliente" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4>
					Buscar cliente					
				</h4>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
						<label class="sr-only">Buscar cliente</label>
						<div class="row">
							<div class="col-md-10">
								<input id="txtBuscadorCliente" class="form-control" type="text" name="BuscadorCliente" placeholder="Buscar cliente...">
							</div>
							<div class="col-md-2">
								<button id="btnBuscarCliente" type="submit" class="btn btn-primary btn-block">
									<i class="fa fa-search" aria-hidden="true"></i>									
								</button>
							</div>
						</div>						
						<hr/>
						<table width="100%" class="table-condensed table-striped table-bordered">
							<thead>
								<tr>
									<th width="5%">ID</th>
									<th width="20%">Nombre / Razón Social</th>
									<th width="20%">RUC</th>
									<th width="20%">Direccion</th>
									<th width="20%">Telefono</th>
									<th width="5%"></th>
								</tr>
							</thead>
							<tbody id="tablaClientes">
								
							</tbody>
						</table>						
					</div>
				</form>
			</div>

			<div class="modal-footer">				
				<button id="btnOkModalAgregarCliente" class="btn btn-block btn-primary" data-dismiss="modal">
					Confirmar
				</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modalAgregarServicio" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<legend>Agregar Servicio</legend>
			</div>

			<div class="modal-body">
				<div class="form-group row">
							<div class="col-md-12">								
								<textarea id="txtDescripcion"  class="form-control"   placeholder="Descripcion Servicio"></textarea>
							</div>							
				</div>
				<div class="row">
							<div class="col-md-3">
								<input id="txtPrecioUnitario" class="form-control" type="text" name="PrecioUnitario" placeholder="Precio">
							</div>
							<div class="col-md-3">
								<input id="txtTotal" class="form-control" type="text" name="Total" placeholder="Total">
							</div>
							<div class="col-md-2">
								<button id="btnAdicionarServicio" type="submit" class="btn btn-primary btn-block">
									<i class="fa fa-plus" aria-hidden="true"></i>									
								</button>
							</div>
							
				</div>
			</div>

			<div class="modal-footer">
				<button id="btnOkModalAgregarServicio" class="btn btn-block btn-primary" data-dismiss="modal">
					Confirmar
				</button>
			</div>        
		</div>
	</div>
</div>
<script type="text/javascript">
		var buscar_cliente_url = "{{ url('clientes/buscar?texto=') }}";
</script>
<script src="{{ asset('js/forms/documentos.js') }}"></script>
@endsection
