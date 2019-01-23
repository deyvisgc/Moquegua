<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<h1>
						Reporte Movimiento<small></small>
					</h1>
					<ol class="breadcrumb">
						<li>
							<a href="<?= base_url() ?>bienvenida"><i class="fa fa-home"></i> Home</a>
						</li>
						<li class="active">Reporte Movimiento.</li>
					</ol>
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Your Page Content Here -->
					<div class="row">
						<div class="col-md-12">
							<div class="nav-tabs-custom">
								<ul class="nav nav-tabs pull-right">
									<li><a href="#dv_mov_diario_salida" data-toggle="tab" id="a_mov_diario_salida">VENTA</a></li>
									<li class="active"><a href="#dv_mov_diario_ingreso" data-toggle="tab" id="a_mov_diario_ingreso">COMPRA</a></li>
									<li class="pull-left header"><i class="fa fa-chart-line"></i> Movimiento diario <span id="sp_tipo_movimiento">Compra.</span></li>
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
													<button type="button" class="btn btn-primary" onclick="filtrar_movimiento_diario_ingreso();" id="btn-altas"><i class="fa fa-check-circle"></i> Filtar por Fecha</button>
												</div>
											</div>
											<br>
											<br>
											<hr>
											<div class="row" style="margin: 16px;">
												<div class="col-sm-12 box-body table-responsive">
													<table class="table table-bordered" id="tb_mov_diario_ingreso">
														<thead>
															<tr>
																<th>FECHA</th>
																<th>PROVEEDOR</th>
																<th>DOC.</th>
																<th>NRO.</th>
																<th>S/. COMPRA</th>
															</tr>
														</thead>
														<tbody>
														</tbody>
														<tfoot>
															<tr>
																<th colspan="4" class=" alinear_derecha">&nbsp;Total Compra:</th>
																<th class=" alinear_derecha"><span id="sp_total_ingreso"></span></th>
															</tr>
														</tfoot>
													</table>
												</div>
											</div>
										</div>
									</div>
									
									<div class="tab-pane" id="dv_mov_diario_salida">
										<div class="row">
											<div class="form-group">
												<label for="" class="col-sm-2 control-label">FECHA INICIO</label>
												<div class="col-sm-3">
													<input type="date" id="in_fecha_ini2" name="fecha_ini2" class="form-control" value="" placeholder="Fecha inicio">
												</div>
												<label for="" class="col-sm-2 control-label">FECHA INICIO</label>
												<div class="col-sm-3">
													<input type="date" id="in_fecha_fin2" name="fecha_fin2" class="form-control" value="" placeholder="Fecha fin">
												</div>
											</div>
											<br>
											<hr>
											<div class="form-group">
												<div class="col-sm-3">
													<button type="button" class="btn btn-primary" onclick="filtrar_movimiento_diario_salida();" id="btn-altas"><i class="fa fa-check-circle"></i> Filtar por Fecha</button>
												</div>
											</div>
											<br>
											<br>
											<hr>
											<div class="row" style="margin: 16px;">
												<div class="col-sm-12 box-body table-responsive">
													<table class="table table-bordered" id="tb_mov_diario_salida">
														<thead>
															<tr>
																<th>FECHA</th>
																<th>CLIENTE</th>
																<th>N°CAJA</th>
																<th>DOC.</th>
																<th>NRO.</th>
																<th>S/. VENTA</th>
															</tr>
														</thead>
														<tbody>
														</tbody>
														<tfoot>
															<tr>
																<th colspan="5" class=" alinear_derecha">&nbsp;Total Venta:</th>
																<th class=" alinear_derecha"><span id="sp_total_salida"></span></th>
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
			function init_movimiento() {
				$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
					var target = $(e.target).attr("href");
					if(target === '#dv_mov_diario_salida') {
						$('#sp_tipo_movimiento').text('Venta.');
						$('#tb_mov_diario_salida').DataTable().ajax.reload();
					}
					else if(target === '#dv_mov_diario_ingreso') {
						$('#sp_tipo_movimiento').text('Compra.');
						$('#tb_mov_diario_ingreso').DataTable().ajax.reload();
					}
				});
				
				var fecha_actual_hoy = get_fhoy();
				$('#in_fecha_ini').val(fecha_actual_hoy);
				$('#in_fecha_fin').val(fecha_actual_hoy);
				$('#in_fecha_ini2').val(fecha_actual_hoy);
				$('#in_fecha_fin2').val(fecha_actual_hoy);
				
				var mov_diario_id_tabla = "tb_mov_diario_ingreso";
				var mov_diario_url = "<?php echo base_url(); ?>reporte/movimiento/bmovimiento_diario_ingreso";
				var mov_diario_dataSrc = function(res){
					$('#sp_total_ingreso').text(res.data_totales.ing_monto);
					return res.data;
				}
				var mov_diario_data = function() {
					var data = {};
					data.fecha_ini = $("#in_fecha_ini").val();
					data.fecha_fin = $("#in_fecha_fin").val();
					return data;
				};
				var mov_diario_columns = [
					{data: "ing_fecha_registro"},
					{data: "emp_razon_social"},
					{data: "tdo_nombre"},
					{data: "ing_numero_doc_proveedor"},
					{data: "ing_monto", className: "alinear_derecha"}
				];
				
				var mov_diario_id_tabla2 = "tb_mov_diario_salida";
				var mov_diario_url2 = "<?php echo base_url(); ?>reporte/movimiento/bmovimiento_diario_salida";
				var mov_diario_dataSrc2 = function(res){
					$('#sp_total_salida').text(res.data_totales.sal_monto);
					return res.data;
				}
				var mov_diario_data2 = function() {
					var data = {};
					data.fecha_ini = $("#in_fecha_ini2").val();
					data.fecha_fin = $("#in_fecha_fin2").val();
					return data;
				};
				var mov_diario_columns2 = [
					{data: "sal_fecha_registro"},
					{data: "emp_razon_social"},
					{data: "caj_descripcion"},
					{data: "tdo_nombre"},
					{data: "sal_numero_doc_cliente"},
					{data: "sal_monto", className: "alinear_derecha"}
				];
				
				generar_tabla_ajx(mov_diario_id_tabla, mov_diario_url, 'POST', mov_diario_data, mov_diario_dataSrc, mov_diario_columns);
				generar_tabla_ajx(mov_diario_id_tabla2, mov_diario_url2, 'POST', mov_diario_data2, mov_diario_dataSrc2, mov_diario_columns2);
			}
			function filtrar_movimiento_diario_ingreso() {

				$('#tb_mov_diario_ingreso').DataTable().ajax.reload();
			}
			function filtrar_movimiento_diario_salida() {
				$('#tb_mov_diario_salida').DataTable().ajax.reload();
			}
			</script>
