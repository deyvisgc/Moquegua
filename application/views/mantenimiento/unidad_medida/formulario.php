<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<h1>
						Registro de Unidad de Medida<small></small>
					</h1>
					<ol class="breadcrumb">
						<li>
							<a href="<?= base_url() ?>bienvenida"><i class="fa fa-home"></i> Home</a>
						</li>
						<li class="active">Mant Uni.Medida.</li>
					</ol>
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Your Page Content Here -->
					<div class="row">
						<div class="col-md-12">
							<div class="nav-tabs-custom">
								<ul class="nav nav-tabs pull-right">
									<li><a href="#dv_registro" data-toggle="tab" id="a_registro">Registro</a></li>
									<li class="active"><a href="#dv_reporte" data-toggle="tab" id="a_reporte">Reporte</a></li>
									<li class="pull-left header"><i class="fa fa-balance-scale"></i> Uni.Medida.</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="dv_reporte">
										<div class="row">
											<div class="col-sm-12 box-body table-responsive">
												<p></p>
												<table class="table table-bordered" id="tb_unidad_medida">
													<thead>
														<tr>
															<th>NOMBRE</th>
															<th>NOMBRE CORTO</th>
															<th>ESTADO</th>
															<th>EDITAR</th>
															<th>ELIMINAR</th>
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									
									<div class="tab-pane" id="dv_registro">
										<div class="row">
											<p></p>
											<form class="form-horizontal" id="fm_unidad_medida">
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">NOMBRE</label>
													<div class="col-sm-3">
														<input type="text" id="in_unm_nombre" name="unm_nombre" class="form-control" value="" placeholder="Nombre">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">NOMBRE CORTO</label>
													<div class="col-sm-3">
														<input type="text" id="in_unm_nombre_corto" name="unm_nombre_corto" class="form-control" value="" placeholder="Nombre corto">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">ESTADO</label>
													<div class="col-sm-3">
														<select class="form-control" id="in_est_id_estado">
															<?php
															foreach ($list_estado as $valor) {
															?>
															<option value="<?= $valor->est_id_estado ?>">
																<?= $valor->est_nombre ?>
															</option>
															<?php
															}
															?>
														</select>
													</div>
												</div>
												<hr>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">&nbsp;&nbsp;&nbsp;</label>
													<div class="col-sm-3">
														<input type="hidden" id="in_unm_id_unidad_medida" name="unm_id_unidad_medida" value="">
														<button type="button" class="btn btn-primary" onclick="guardar();" id="btn-altas"><i class="fa fa-check-circle"></i> Guardar </button>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section><!-- /.content -->
			</div><!-- /.content-wrapper -->
			
			<script>
			function init_unidad_medida() {
				$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
					var target = $(e.target).attr("href");
					if(target === '#dv_registro') {
						$('#in_unm_id_unidad_medida').val('');
						$('#fm_unidad_medida')[0].reset();
					}
					else if(target === '#dv_reporte') {
						$('#tb_unidad_medida').DataTable().ajax.reload();
					}
				});
				
				var id_tabla = "tb_unidad_medida";
				var url = "<?php echo base_url(); ?>mantenimiento/unidad_medida/buscar_x_nombre_o_corto";
				var data = [];
				var columns = [
					{data: "unm_nombre"},
					{data: "unm_nombre_corto"},
					{data: "est_nombre"},
					{
						data: null,
						"render": function ( data, type, full, meta ) {
							return '<button  type="button" class="btn btn-warning btn-xs boton_hhh" onclick="mostrar(event)"><span class="glyphicon glyphicon-edit span_hhh" aria-hidden="true"> Editar</span></button>'+
								'<input type="hidden" name="unm_nombre" value="'+full.unm_nombre+'">'+
								'<input type="hidden" name="unm_nombre_corto" value="'+full.unm_nombre_corto+'">'+
								'<input type="hidden" name="unm_id_unidad_medida" value="'+full.unm_id_unidad_medida+'">'+
								'<input type="hidden" name="est_id_estado" value="'+full.est_id_estado+'">';
						}
					},
					{
						data: null,
						"render": function ( data, type, full, meta ) {
							return '<button  type="button" class="btn btn-danger btn-xs boton_hhh" onclick="eliminar(event)"><span class="glyphicon glyphicon-edit span_hhh" aria-hidden="true"> Eliminar</span></button>';
						}
					}
				];
				generar_tabla(id_tabla, url, data, columns);
			}
			function mostrar(e) {
				var tr = $(e.target).closest('tr');
				$('#a_registro').tab('show');
				var unm_nombre = tr.find('input[name="unm_nombre"]').val();
				var unm_nombre_corto = tr.find('input[name="unm_nombre_corto"]').val();
				var unm_id_unidad_medida = tr.find('input[name="unm_id_unidad_medida"]').val();
				var est_id_estado = tr.find('input[name="est_id_estado"]').val();
				$("#in_unm_nombre").val(unm_nombre);
				$("#in_unm_nombre_corto").val(unm_nombre_corto);
				$("#in_unm_id_unidad_medida").val(unm_id_unidad_medida);
				$("#in_est_id_estado").val(est_id_estado);
			}
			function eliminar(e) {
				var tr = $(e.target).closest('tr');
				var unm_id_unidad_medida = tr.find('input[name="unm_id_unidad_medida"]').val();
				var data = {};
				data.unm_id_unidad_medida = unm_id_unidad_medida;
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>mantenimiento/unidad_medida/eliminar",
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							$('#tb_unidad_medida').DataTable().ajax.reload();
							add_mensaje(null, " Correcto. ", ' eliminado.', "success");
						}
					}
				});
			}
			function guardar() {
				var unm_id_unidad_medida = $("#in_unm_id_unidad_medida").val();
				var accion = "";
				if(unm_id_unidad_medida == '') {
					accion = "registrar";
				}
				else {
					accion = "actualizar";
				}
				var data = {};
				data.unm_nombre = $("#in_unm_nombre").val();
				data.unm_nombre_corto = $("#in_unm_nombre_corto").val();
				data.unm_id_unidad_medida = $("#in_unm_id_unidad_medida").val();
				data.est_id_estado = $("#in_est_id_estado").val();
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "mantenimiento/unidad_medida/"+accion,
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							$('#a_reporte').tab('show');
							add_mensaje(null, " Correcto. ", ' datos guardados.', "success");
						}
					}
				});
			}
			</script>
