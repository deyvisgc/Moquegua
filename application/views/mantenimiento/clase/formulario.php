<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<h1>
						Registro de Clase<small></small>
					</h1>
					<ol class="breadcrumb">
						<li>
							<a href="<?= base_url() ?>bienvenida"><i class="fa fa-home"></i> Home</a>
						</li>
						<li class="active">Mant Clase.</li>
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
									<li class="pull-left header"><i class="fa fa-bezier-curve"></i> Clases.</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="dv_reporte">
										<div class="row">
											<div class="col-sm-12 box-body table-responsive">
												<p></p>
												<table class="table table-bordered" id="tb_clase">
													<thead>
														<tr>
															<th>NOMBRE</th>
															<th>SUPERIOR</th>
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
											<form class="form-horizontal" id="fm_clase">
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">NOMBRE</label>
													<div class="col-sm-3">
														<input type="text" id="in_cla_nombre" name="cla_nombre" class="form-control" value="" placeholder="Nombre">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">SUPERIOR</label>
													<div class="col-sm-3">
														<select class="form-control" id="in_cla_id_clase_superior">
														</select>
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
														<input type="hidden" id="in_cla_id_clase" name="cla_id_clase" value="">
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
			function init_clase() {
				$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
					var target = $(e.target).attr("href");
					if(target === '#dv_registro') {
						$('#in_cla_id_clase').val('');
						$('#fm_clase')[0].reset();
					}
					else if(target === '#dv_reporte') {
						$('#tb_clase').DataTable().ajax.reload();
					}
				});
				
				var id_tabla = "tb_clase";
				var url = "<?php echo base_url(); ?>mantenimiento/clase/buscar_x_nombre";
				var data = [];
				var columns = [
					{data: "cla_nombre"},
					{data: "cla_nombre_superior"},
					{data: "est_nombre"},
					{
						data: null,
						"render": function ( data, type, full, meta ) {
							return '<button  type="button" class="btn btn-warning btn-xs boton_hhh" onclick="mostrar(event)"><span class="glyphicon glyphicon-edit span_hhh" aria-hidden="true"> Editar</span></button>'+
								'<input type="hidden" name="cla_id_clase" value="'+full.cla_id_clase+'">'+
								'<input type="hidden" name="cla_nombre" value="'+full.cla_nombre+'">'+
								'<input type="hidden" name="cla_id_clase_superior" value="'+full.cla_id_clase_superior+'">'+
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
				func_reload_superior(null);
			}
			function mostrar(e) {
				var tr = $(e.target).closest('tr');
				$('#a_registro').tab('show');
				var cla_nombre = tr.find('input[name="cla_nombre"]').val();
				var cla_id_clase_superior = tr.find('input[name="cla_id_clase_superior"]').val();
				func_reload_superior(cla_id_clase_superior);
				var est_id_estado = tr.find('input[name="est_id_estado"]').val();
				var cla_id_clase = tr.find('input[name="cla_id_clase"]').val();
				$("#in_cla_nombre").val(cla_nombre);
				$("#in_est_id_estado").val(est_id_estado);
				$("#in_cla_id_clase").val(cla_id_clase);
			}
			function eliminar(e) {
				var tr = $(e.target).closest('tr');
				var cla_id_clase = tr.find('input[name="cla_id_clase"]').val();
				var data = {};
				data.cla_id_clase = cla_id_clase;
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>mantenimiento/clase/eliminar",
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							$('#tb_clase').DataTable().ajax.reload();
							add_mensaje(null, " Correcto. ", ' eliminado.', "success");
						}
					}
				});
			}
			function guardar() {
				var cla_id_clase = $("#in_cla_id_clase").val();
				var accion = "";
				if(cla_id_clase == '') {
					accion = "registrar";
				}
				else {
					accion = "actualizar";
				}
				var data = {};
				data.cla_nombre = $("#in_cla_nombre").val();
				data.cla_id_clase_superior = $("#in_cla_id_clase_superior").val();
				data.est_id_estado = $("#in_est_id_estado").val();
				data.cla_id_clase = cla_id_clase;
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "mantenimiento/clase/"+accion,
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							func_reload_superior(null);
							$('#a_reporte').tab('show');
							add_mensaje(null, " Correcto. ", ' datos guardados.', "success");
						}
					}
				});
			}
			
			function func_reload_superior(cla_id_clase_superior) {
				if(cla_id_clase_superior == null) {
					cla_id_clase_superior = '';
				}
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>mantenimiento/clase/buscar_all_superior",
					dataType: 'json',
					data: null,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							var select = $('#in_cla_id_clase_superior');
							select.empty();
							select.append('<option value="">---</option>');
							datos.list_clase.forEach(function(clase) {
								var selected = '';
								if(cla_id_clase_superior === clase.cla_id_clase) {
									selected = 'selected';
								}
								select.append('<option value="'+clase.cla_id_clase+'" '+selected+'>'+clase.cla_nombre+'</option>');
							});
						}
					}
				});
			}
			</script>
