var listadoServicios=[];
$(document).ready(function (){

	//var fechaEmision = new Date();
	
	$('#btnAdicionarServicio').on('click', function(e){
		e.preventDefault();
		$("#tablaServicios").html("");
		if ($("#txtDescripcion").val()=='')
		{
			alert('Debe ingresar descripcion')
		 	e.preventDefault();
		}
		else if ($("#txtPrecioUnitario").val()=='')
		{
			alert('Debe ingresar precio unitario')
		 	e.preventDefault();
		}
		else if ($("#txtTotal").val()=='')
		{
			alert('Debe ingresar total')
		 	e.preventDefault();
		}
		else
		{
		var descripcion_servicio = $('#txtDescripcion').val();
		var preciounitario = $('#txtPrecioUnitario').val();
		var total = $('#txtTotal').val();
		listadoServicios[listadoServicios.length] = {
			'descripcion_servicio':descripcion_servicio,
			'preciounitario': preciounitario,
			'total': total,			
		};		
		actualizarTablaServicios();
		$('#txtDescripcion').val('');
		$('#txtPrecioUnitario').val('');
		$('#txtTotal').val('');
		}
	});

	$('#btnBuscarCliente').on('click', function(e) {
		debugger;
		e.preventDefault();
		var str = $("#txtBuscadorCliente").val();
		//var url = "{{ url('clientes/buscar?texto=') }}" + str;
		var url = buscar_cliente_url + str;
		$.get(url , function( data ){			    
			var clientes = data["clientes"];
			$("#tablaClientes").html("");
			for(i=0; i < clientes.length; i++){
				var cliente_id = clientes[i]["id"];
				var cliente_razonsocial = clientes[i]["razonsocial"];
				var cliente_documento = "-";
				if(clientes[i]["documento"] != null){
					var cliente_documento = clientes[i]["documento"];	
				}
				var cliente_direccion = "-";
				if(clientes[i]["direccion"] != null){
					var cliente_direccion = clientes[i]["direccion"];	
				}
				var cliente_telefono = "-";
				if(clientes[i]["telefono"] != null){
					var cliente_telefono = clientes[i]["telefono"];	
				}
				$("#tablaClientes").append(
					$('<tr></tr>').html(
						"<td class='td_cliente_id'>" 
							+ cliente_id
						+ "</td><td class='td_cliente_razonsocial'>"
							+ cliente_razonsocial
						+ "</td><td class='td_cliente_documento'>"
							+ cliente_documento
						+ "</td><td class='td_cliente_direccion'>"
							+ cliente_direccion							
						+ "</td><td class='td_cliente_telefono'>"
							+ cliente_telefono
						+ "</td><td>"
							+ "<a class='btn-agregar-cliente btn btn-sm btn-block btn-link'>"
								+ '<i class="fa fa-share" aria-hidden="true"></i>'
							+ "</a>"
						+ "</td>"

					)
				);
			}
		});
	});

	$(document).on('click', '.btn-agregar-cliente', function() {
		
		var cliente_id = $(this).parents("tr").find(".td_cliente_id").html();
		var cliente_razonsocial = $(this).parents("tr").find(".td_cliente_razonsocial").html();	
		var cliente_documento = $(this).parents("tr").find(".td_cliente_documento").html();			
		var cliente_direccion = $(this).parents("tr").find(".td_cliente_direccion").html();			
		var cliente_telefono = $(this).parents("tr").find(".td_cliente_telefono").html();			
		
		$("#hiddenCliente").val(cliente_id);

		$("#txtCliente").val(cliente_razonsocial);
		$("#txtCliente").prop( "disabled", true );
		$("#txtDireccion").val(cliente_direccion);
		//$("#txtDireccion").prop( "disabled", true );
		$("#txtDocumento").val(cliente_documento);
		$("#txtDocumento").prop( "disabled", true );
		
		$("#btnOkModalAgregarCliente").click();
	});
	$(document).on('submit', function(e){
		
		if ($("#hiddenCliente").val()=='')
		{
			alert('Debe ingresar un cliente')
		 	e.preventDefault();
		}
		else if (listadoServicios.length== 0)
		{
			alert('Debe agregar servicios')
		 	e.preventDefault();
		}
		else
		{
		if(! confirm("¿Guardar documento?, una vez ingresado al sistema no podrá ser modificado.")){
			e.preventDefault();
		}
		var servicios = JSON.stringify(listadoServicios);
		$("#hiddenListado").val(servicios);
		/*alert(requestData);
		var url = "{{ url('documentos/print') }}";
		/*
		var url = comprobante_vistaprevia_url;
		var request;
		
		request = $.ajax({
			url: url,
			method: "POST",
			dataType: "json",
			data: { data: requestData }
		});*/
		}
	});
});

function descartarServicio(posicion){
	listadoServicios.splice(posicion, 1);
	actualizarTablaServicios();
}

function actualizarTablaServicios(){
	$("#tablaServicios").html("");
	var resumen_total = 0;
	for(i=0; i < listadoServicios.length; i++){
		$("#tablaServicios").append(
			$('<tr></tr>').html(
				"<td>" 
					+ "<textarea class='form-control input-sm text-left' readonly='true' value='"+ listadoServicios[i]["descripcion_servicio"] + "'> "+ listadoServicios[i]["descripcion_servicio"]+"</textarea>"
				+ "</td><td>"
					+ "<input type='number' class='form-control input-sm text-right' readonly='true' value="+ listadoServicios[i]["preciounitario"] + ">"
				+ "</td><td class='td_subTotal'>" 
					+ "<input type='number' class='form-control input-sm text-right' readonly='true' value="+ listadoServicios[i]["total"] + ">"					
				+ "</td><td class='text-center'>"
					+ "<a style='color: #8a8686;' onclick='descartarServicio(" + i + ");''><i class='fa fa-trash'></i></a>"
				+ "</td>"
			)                
		);
		resumen_total += parseFloat(listadoServicios[i]["total"]);
	}
	$("#tablaResumen").html("");
	$("#tablaResumen").append(
	$('<tr></tr>').html(
		"<th>Total</th><td>"
		+ resumen_total.toFixed(2)
		+ "</td>"
	)
	);
}
