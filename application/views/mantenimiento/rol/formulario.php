<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<h1>
						Registro de Rol<small></small>
					</h1>
					<ol class="breadcrumb">
						<li>
							<a href="<?= base_url() ?>bienvenida"><i class="fa fa-home"></i> Home</a>
						</li>
						<li class="active">Admin. Rol.</li>
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
									<li class="pull-left header"><i class="fa fa-id-card"></i> Roles.</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="dv_reporte">
										<div class="row">
											<div class="col-sm-12 box-body table-responsive">
												<p></p>
												<table class="table table-bordered" id="tb_rol">
													<thead>
														<tr>
															<th>NOMBRE</th>
															<th>ESTADO</th>
															<th></th>
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
											<form class="form-horizontal" id="fm_rol">
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">NOMBRE</label>
													<div class="col-sm-3">
														<input type="text" id="in_rol_nombre" name="rol_nombre" class="form-control" value="" placeholder="Nombre">
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
												<input type="hidden" id="in_rol_id_rol" name="rol_id_rol" value="">
												<hr>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">&nbsp;&nbsp;&nbsp;</label>
													<div class="col-sm-3">
														<input type="hidden" name="cur_id_curso" id="in_cur_id_curso" value="">
														<button type="button" class="btn btn-primary" onclick="guardar();" id="btn-altas"><i class="fa fa-check-circle"></i> Guardar Curso</button>
													</div>
												</div>
											</form>
										</div>
										<div class="row">
											<table class="table table-bordered" id="tb_rol2" style="display: none; width: 500px;">
												<thead>
													<tr>
														<td colspan="4"><h3>PRIVILEGIOS</h3></td>
													</tr>
													<tr>
														<th>#</th>
														<th>NOMBRE</th>
														<th>ESTADO</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section><!-- /.content -->
			</div><!-- /.content-wrapper -->
			
			<script>
			function init_rol() {
				$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
					var target = $(e.target).attr("href");
					if(target === '#dv_registro') {
						$('#in_rol_id_rol').val('');
						$('#tb_rol2').hide();
						$('#fm_rol')[0].reset();
					}
					else if(target === '#dv_reporte') {
						$('#tb_rol').DataTable().ajax.reload();
					}
				});
				
				var id_tabla = "tb_rol";
				var url = "<?php echo base_url(); ?>mantenimiento/rol/buscar_x_nombre";
				var data = [];
				var columns = [
					{data: "rol_nombre"},
					{data: "est_nombre"},
					{
						data: null,
						"render": function ( data, type, full, meta ) {
							
							return '<button  type="button" class="btn btn-warning btn-xs boton_hhh" onclick="mostrar(event)"><span class="glyphicon glyphicon-edit span_hhh" aria-hidden="true"> Editar</span></button>'+
								'<input type="hidden" name="rol_nombre" value="'+full.rol_nombre+'">'+
								'<input type="hidden" name="est_id_estado" value="'+full.est_id_estado+'">'+
								'<input type="hidden" name="rol_id_rol" value="'+full.rol_id_rol+'">';
						}
					}
				];
				generar_tabla(id_tabla, url, data, columns);
			}
			function mostrar(e) {
				var tr = $(e.target).closest('tr');
				$('#a_registro').tab('show');
				var rol_nombre = tr.find('input[name="rol_nombre"]').val();
				var est_id_estado = tr.find('input[name="est_id_estado"]').val();
				var rol_id_rol = tr.find('input[name="rol_id_rol"]').val();
				$("#in_rol_nombre").val(rol_nombre);
				$("#in_est_id_estado").val(est_id_estado);
				$("#in_rol_id_rol").val(rol_id_rol);
				$('#tb_rol2').show();
				func_buscar_privilegios(null);
			}
			function guardar() {
				var rol_id_rol = $("#in_rol_id_rol").val();
				var accion = "";
				if(rol_id_rol == '') {
					accion = "registrar";
				}
				else {
					accion = "actualizar";
				}
				var data = {};
				data.rol_nombre = $("#in_rol_nombre").val();
				data.est_id_estado = $("#in_est_id_estado").val();
				data.rol_id_rol = $("#in_rol_id_rol").val();
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "mantenimiento/rol/"+accion,
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							$('#a_reporte').tab('show');
							add_mensaje(null, " Correcto. ", ' Rol guardado.', "success");
						}
					}
				});
			}
			
			function func_agregar_fila(list_rol) {
				var tbody = $('#tb_rol tbody');
				tbody.empty();
				var i = 0;
				list_rol.forEach(function(rol) {
					i++;
					tbody.append('<tr>'+
						'<td>'+i+'</td>'+
						'<td>'+rol.rol_nombre+'</td>'+
						'<td>'+rol.est_nombre+'</td>'+
						'<td>'+
						'<button class="btn btn-warning" type="button" onclick="mostrar_marco_formeditar_rol(event)">Actualizar</button>'+
						'<input type="hidden" name="rol_id_rol" value="'+rol.rol_id_rol+'">'+
						'<input type="hidden" name="est_id_estado" value="'+rol.est_id_estado+'">'+
						'</td>'+
						'</tr>');
				});
			}
			function func_buscar_privilegios(e) {
				var data = {};
				data.rol_id_rol = $("#in_rol_id_rol").val();
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "mantenimiento/rol/buscar_privilegio_x_rol",
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							func_agregar_fila_priviletio(datos.list_rol_has_privilegio);
						}
					}
				});
			}
			function func_agregar_fila_priviletio(list_rol_has_privilegio) {
				var tbody = $('#tb_rol2 tbody');
				tbody.empty();
				var i = 0;
				list_rol_has_privilegio.forEach(function(rol_has_privilegio) {
					i++;
					var select_html = '<select class="form-control" name="privilegio" onchange="func_cambiar_estado_privilegio(event)">';
					select_html += '<option value="1">DESHABILITAR</option>';
					var selected = "";
					if(rol_has_privilegio.pri_id_privilegio2 > 0) {
						selected = "selected";
					}
					select_html += '<option value="2" '+selected+'>HABILITAR</option>';
					select_html += '</select>';
					tbody.append('<tr>'+
						'<td>'+i+'</td>'+
						'<td>'+rol_has_privilegio.pri_nombre+'</td>'+
						'<td>'+
						select_html+
						'<input type="hidden" name="pri_id_privilegio" value="'+rol_has_privilegio.pri_id_privilegio+'">'+
						'</td>'+
						'</tr>');
				});
			}
			function func_cambiar_estado_privilegio(e) {
				var tr = $(e.target).closest('tr');
				var valor = $(e.target).val();
				var pri_id_privilegio = tr.find('input[name="pri_id_privilegio"]').val();
				var data = {};
				data.rol_id_rol = $("#in_rol_id_rol").val();
				data.pri_id_privilegio = pri_id_privilegio;
				var accion = 'quitar_privilegio';
				if(valor === '2'){
					var accion = 'agregar_privilegio';
				}
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "mantenimiento/rol/"+accion,
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							if(accion === 'agregar_privilegio') {
								add_mensaje(null, " Correcto. ", ' Privilegio agregado.', "success");
							}
							else if(accion === 'quitar_privilegio') {
								add_mensaje(null, " Correcto. ", ' Privilegio quitado.', "success");
							}
						}
					}
				});
			}
			</script>
