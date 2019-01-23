$(function(){
			return ;
			$('#tb_profesor').DataTable({
				ajax: {
					url: "<?php echo base_url(); ?>" + "mantenimiento/profesor/buscar_xll",
					type: "POST",
					data: { texto: "" }
				},
				columns: [
					{data: "per_nombre"},
					{data: "per_apellido"},
					{data: "tip_documento_nombre"},
					{data: "per_nro_documento"},
					{data: "per_tel_movil"},
					{data: "per_tel_fijo"},
					{
						data: null,
						"render": function ( data, type, full, meta ) {
							
							return '<button  type="button" class="btn btn-warning btn-xs boton_hhh" onclick="mostrar_marco_formeditar_clase(event)"><span class="glyphicon glyphicon-edit span_hhh" aria-hidden="true"> Editar</span></button>'+
								// '<input type="hidden" name="cla_id_clase" value="'+full.cla_id_clase+'">'+
								// '<input type="hidden" name="cla_nombre" value="'+full.cla_nombre+'">'+
								// '<input type="hidden" name="cla_id_clase_superior" value="'+full.cla_id_clase_superior+'">'+
								'<input type="hidden" name="pro_id_profesor" value="'+full.pro_id_profesor+'">';
						}
					}
				],
				"language": {
					"decimal": "",
					"emptyTable": "Tabla vacia.",
					"info": "Mostrando _START_ a _END_ de _TOTAL_ entradas.",
					"infoEmpty": "Mostrando 0 a 0 de 0 entradas.",
					"infoFiltered": "(filtrado de _MAX_ entradas totales)",
					"infoPostFix": "",
					"thousands": ",",
					"lengthMenu": "Mostrar _MENU_ entradas",
					"loadingRecords": "Cargando...",
					"processing": "Procesando...",
					"search": "Buscar",
					"zeroRecords": "No se encontraron registros coincidentes.",
					"paginate": {
						"first": "Primero",
						"last": "Final",
						"next": "Siguiente",
						"previous": "Anterior"
					},
					"aria": {
						"sortAscending": ": activar para ordenar la columna ascendente.",
						"sortDescending": ": activar para ordenar la columna descendente."
					}
				}
			});
		});