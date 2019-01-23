<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Reporte Ganancias<small></small>
		</h1>
		<ol class="breadcrumb">
			<li>
				<a href="<?= base_url() ?>bienvenida"><i class="fa fa-home"></i> Home</a>
			</li>
			<li class="active">Reporte Ganancias.</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<!-- Your Page Content Here -->
		<div class="row">
			<div class="col-md-12">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs pull-right">
						<li><a href="#dv_mov_diario_salida" data-toggle="tab" id="a_mov_diario_salida">Ganancias</a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="dv_mov_diario_ingreso">
							<div class="row">
								<div class="form-group">
									<label for="" class="col-sm-2 control-label">FECHA INICIO</label>
									<div class="col-sm-3">
										<input type="date" id="in_fecha_ini" name="fecha_ini" class="form-control" value="" placeholder="Fecha inicio">
									</div>
									<label for="" class="col-sm-2 control-label">FECHA FIN</label>
									<div class="col-sm-3">
										<input type="date" id="in_fecha_fin" name="fecha_fin" class="form-control" value="" placeholder="Fecha fin">
									</div>
								</div>
								<br>
								<hr>
								<div class="form-group">
									<div class="col-sm-3">
										<button type="button" class="btn btn-primary" onclick="filtrar_fecha_ganancias();" id="btn-altas"><i class="fa fa-check-circle"></i> Filtrar por Fecha</button>
									</div>
								</div>
								<br>
								<br>
								<hr>
								<div class="row" style="margin: 16px;">
									<div class="col-sm-12 box-body table-responsive">
										<table class="table table-bordered" id="tb_reporte_ganancia">
											<thead>
											<tr>
												<th>FECHA</th>
												<th>PRODUCTOS</th>
												<th>CANTIDAD</th>
												<th>PRECIO</th>
												<th>CAJA</th>
												<th>GANANCIAS</th>

											</tr>
											</thead>
											<tbody>
											</tbody>
											<tfoot>
											<tr>
												<th colspan="5" class=" alinear_derecha">&nbsp;Total Ganancias:</th>
												<th class=" alinear_derecha"><span id="sp_total_ingreso"></span></th>
											</tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section><!-- /.content -->
</div><!-- /.content-wrapper -->

<script>

	function init_ganancias() {
		$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
			var target = $(e.target).attr("href");
			if(target === '#dv_mov_diario_salida') {
				$('#tb_reporte_ganancia').DataTable().ajax.reload();
			}
		});
		var fecha_actual_hoy = get_fhoy();
		$('#in_fecha_ini').val(fecha_actual_hoy);
		$('#in_fecha_fin').val(fecha_actual_hoy);




	}
	function filtrar_fecha_ganancias() {


		var general_id_tabla = "tb_reporte_ganancia";
		var general_url = "<?php echo base_url(); ?>reporte/ganancias/rporte_ganancias";
		var general_data = [];
		var mov_diario_dataSrc = function(res){
			$('#sp_total_ingreso').text(res.data_totales.monto_final);
			return res.data;
		}
		var mov_diario_data = function() {

			var data = {};

			data.fecha_ini = $("#in_fecha_ini").val();
			data.fecha_fin = $("#in_fecha_fin").val();

			return data;
		};
		var general_columns = [
			{data: "sal_fecha_doc_cliente"},
			{data: "pro_nombre"},
			{data: "sad_cantidad"},
			{data: "sad_valor"},
			{data: "caj_descripcion"},
			{data: "sad_ganancias"}

		];


		generar_tabla_ajx2(general_id_tabla, general_url, 'POST',mov_diario_data,mov_diario_dataSrc,general_columns);
		/*$('#tb_reporte_ganancia').DataTable().ajax.reload();*/
	}
	function generar_tabla_ajx2(id_tabla, url, type, data, dataSrc, columns) {
		$('#'+id_tabla).DataTable({
			ajax: {
				url: url,
				type: type,
				data: data,
				dataSrc: dataSrc
			},
			columns: columns,
			language: {
				"decimal": "",
				"emptyTable": "No hay información",
				"info": "Mostrando _START_ a _END_ de _TOTAL_ Datos",
				"infoEmpty": "Mostrando 0 to 0 of 0 Datos",
				"infoFiltered": "(Filtrado de _MAX_ total datos)",
				"infoPostFix": "",
				"thousands": ",",
				"lengthMenu": "Mostrar _MENU_ Entradas",
				"loadingRecords": "Cargando...",
				"processing": "Procesando...",
				"search": "Buscar:",
				"zeroRecords": "No se encontraron datos",
				"paginate": {
					"first": "Primero",
					"last": "Ultimo",
					"next": "Siguiente",
					"previous": "Anterior"
				}
			},
			destroy: true

		});
	}
</script>
