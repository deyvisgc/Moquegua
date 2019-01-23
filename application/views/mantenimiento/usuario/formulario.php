<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<h1>
						Registro de Usuario<small></small>
					</h1>
					<ol class="breadcrumb">
						<li>
							<a href="<?= base_url() ?>bienvenida"><i class="fa fa-home"></i> Home</a>
						</li>
						<li class="active">Admin. Usuario.</li>
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
									<li class="pull-left header"><i class="fa fa-user-cog"></i> Usuarios.</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="dv_reporte">
										<div class="row">
											<div class="col-sm-12 box-body table-responsive">
												<p></p>
												<table class="table table-bordered" id="tb_usuario">
													<thead>
														<tr>
															<th>FOTO</th>
															<th>NOMBRE</th>
															<th>DOC</th>
															<th>NUMERO</th>
															<th>MOVIL</th>
															<th>FIJO</th>
															<th>USUARIO</th>
															<th>ROL</th>
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
											<form class="form-horizontal" id="fm_usuario">
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">NOMBRE</label>
													<div class="col-sm-3">
														<input type="text" id="in_per_nombre" name="per_nombre" class="form-control" value="" placeholder="Nombre">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">APELLIDO</label>
													<div class="col-sm-3">
														<input type="text" id="in_per_apellido" name="per_apellido" class="form-control" value="" placeholder="Apellido">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">TIPO DOCUMENTO</label>
													<div class="col-sm-3">
														<select class="form-control" id="in_tdo_id_tipo_documento">
															<?php
															foreach ($list_tipo_documento as $valor) {
															?>
															<option value="<?= $valor->tdo_id_tipo_documento ?>">
																<?= $valor->tdo_nombre ?>
															</option>
															<?php
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">NRO DOCUMENTO</label>
													<div class="col-sm-3">
														<input type="text" id="in_per_numero_doc" name="per_numero_doc" class="form-control" value="" maxlength="9" placeholder="Numero">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">DIRECCION</label>
													<div class="col-sm-3">
														<input type="text" id="in_per_direccion" name="per_direccion" class="form-control" value="" placeholder="Direccion">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">TEL. MOVIL</label>
													<div class="col-sm-3">
														<input type="text" id="in_per_tel_movil" name="per_tel_movil" class="form-control" value="" placeholder="Movil">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">TEL. FIJO</label>
													<div class="col-sm-3">
														<input type="text" id="in_per_tel_fijo" name="per_tel_fijo" class="form-control" value="" placeholder="Fijo">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">SUBIR IMAGEN:</label>
													<input type="hidden" class="form-control" name="per_foto" id="in_per_foto">
													<div class="col-sm-3">
														<button type="button" class="btn btn-primary" onclick="$('#in_foto').click();"><i class="fa fa-image"></i> Subir</button>
														<span id="span_foto">...</span>
														<input type="file" style="display: none;" id="in_foto" name="foto"/>
														<p></p>
														<div class="pull-left image">
															<img src="" class="img-circle" alt="User Image" style="max-width: 100px; height: 100px;" id="img_foto">
														</div>
													</div>
												</div>
												<hr>
												<h3>DATOS Acceso</h3>
												<hr>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">USUARIO</label>
													<div class="col-sm-3">
														<input type="text" id="in_usu_nombre" name="usu_nombre" class="form-control" value="" placeholder="Usuario">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">CLAVE</label>
													<div class="col-sm-3">
														<input type="password" id="in_usu_clave" name="usu_clave" class="form-control" value="" placeholder="Clave">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">ROL</label>
													<div class="col-sm-3">
														<select class="form-control" id="in_rol_id_rol">
															<?php
															foreach ($list_rol as $valor) {
															?>
															<option value="<?= $valor->rol_id_rol ?>">
																<?= $valor->rol_nombre ?>
															</option>
															<?php
															}
															?>
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
														<input type="hidden" name="usu_id_usuario" id="in_usu_id_usuario" value="">
														<button type="button" class="btn btn-primary" onclick="guardar();" id="btn-altas"><i class="fa fa-check-circle"></i> Guardar</button>
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
			function init_usuario() {
				preparar_subida_archivo(
					'in_foto',
					'img_foto',
					'in_per_foto',
					'span_foto',
					"<?php echo base_url(); ?>util/archivo/subir_imagen",
					"<?php echo base_url(); ?>",
					"<?php echo base_url(); ?>../resources/sy_file_repository/img_vacio.png"
					);
				
				$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
					var target = $(e.target).attr("href");
					if(target === '#dv_registro') {
						$('#in_usu_clave').prop('disabled', false);
						$('#in_usu_id_usuario').val('');
						$('#in_per_foto').val('');
						$('#span_foto').empty();
						$('#span_foto').append('...');
						$('#img_foto').attr("src", '');
						$('#fm_usuario')[0].reset();
					}
					else if(target === '#dv_reporte') {
						$('#tb_usuario').DataTable().ajax.reload();
					}
				});
				
				var id_tabla = "tb_usuario";
				var url = "<?php echo base_url(); ?>mantenimiento/usuario/buscar_x_nombre_o_documento";
				var data = null;
				var columns = [
					{
						data: null,
						"render": function ( data, type, full, meta ) {
							return '<div class="pull-left image">'+
								'<img src="'+BASE_URL+'../resources/sy_file_repository/'+full.per_foto+'" class="img-circle" alt="User Image" style="max-width: 100px; height: auto;" id="">'+
								'</div>';
						}
					},
					{
						data: null,
						"render": function ( data, type, full, meta ) {
							return full.per_nombre+' '+full.per_apellido;
						}
					},
					{data: "tdo_nombre"},
					{data: "per_numero_doc"},
					{data: "per_tel_movil"},
					{data: "per_tel_fijo"},
					{data: "usu_nombre"},
					{data: "rol_nombre"},
					{data: "est_nombre"},
					{
						data: null,
						"render": function ( data, type, full, meta ) {
							return '<button  type="button" class="btn btn-warning btn-xs boton_hhh" onclick="mostrar(event)"><span class="glyphicon glyphicon-edit span_hhh" aria-hidden="true"> Editar</span></button>'+
								'<input type="hidden" name="per_nombre" value="'+full.per_nombre+'">'+
								'<input type="hidden" name="per_apellido" value="'+full.per_apellido+'">'+
								'<input type="hidden" name="tdo_id_tipo_documento" value="'+full.tdo_id_tipo_documento+'">'+
								'<input type="hidden" name="per_numero_doc" value="'+full.per_numero_doc+'">'+
								'<input type="hidden" name="per_direccion" value="'+full.per_direccion+'">'+
								'<input type="hidden" name="per_tel_movil" value="'+full.per_tel_movil+'">'+
								'<input type="hidden" name="per_tel_fijo" value="'+full.per_tel_fijo+'">'+
								'<input type="hidden" name="per_foto" value="'+full.per_foto+'">'+
								'<input type="hidden" name="usu_nombre" value="'+full.usu_nombre+'">'+
								'<input type="hidden" name="rol_id_rol" value="'+full.rol_id_rol+'">'+
								'<input type="hidden" name="est_id_estado" value="'+full.est_id_estado+'">'+
								'<input type="hidden" name="usu_id_usuario" value="'+full.usu_id_usuario+'">';
						}
					}
				];
				generar_tabla(id_tabla, url, data, columns);
			}
			function mostrar(e) {
				var tr = $(e.target).closest('tr');
				$('#a_registro').tab('show');
				var per_nombre = tr.find('input[name="per_nombre"]').val();
				var per_apellido = tr.find('input[name="per_apellido"]').val();
				var tdo_id_tipo_documento = tr.find('input[name="tdo_id_tipo_documento"]').val();
				var per_numero_doc = tr.find('input[name="per_numero_doc"]').val();
				var per_direccion = tr.find('input[name="per_direccion"]').val();
				var per_tel_movil = tr.find('input[name="per_tel_movil"]').val();
				var per_tel_fijo = tr.find('input[name="per_tel_fijo"]').val();
				var per_foto = tr.find('input[name="per_foto"]').val();
				var usu_nombre = tr.find('input[name="usu_nombre"]').val();
				var rol_id_rol = tr.find('input[name="rol_id_rol"]').val();
				var est_id_estado = tr.find('input[name="est_id_estado"]').val();
				var usu_id_usuario = tr.find('input[name="usu_id_usuario"]').val();
				$('#img_foto').attr("src", BASE_URL+'../resources/sy_file_repository/'+per_foto);
				$("#in_per_nombre").val(per_nombre);
				$("#in_per_apellido").val(per_apellido);
				$("#in_tdo_id_tipo_documento").val(tdo_id_tipo_documento);
				$("#in_per_numero_doc").val(per_numero_doc);
				$("#in_per_direccion").val(per_direccion);
				$("#in_per_tel_movil").val(per_tel_movil);
				$("#in_per_tel_fijo").val(per_tel_fijo);
				$("#in_per_foto").val(per_foto);
				$("#in_usu_nombre").val(usu_nombre);
				$("#in_usu_clave").val('*****');
				$('#in_usu_clave').prop('disabled', true);
				$("#in_rol_id_rol").val(rol_id_rol);
				$("#in_est_id_estado").val(est_id_estado);
				$("#in_usu_id_usuario").val(usu_id_usuario);
			}
			function guardar() {
				var usu_id_usuario = $("#in_usu_id_usuario").val();
				var accion = "";
				if(usu_id_usuario == '') {
					accion = "registrar";
				}
				else {
					accion = "actualizar";
				}
				var data = {};
				data.per_nombre = $("#in_per_nombre").val();
				data.per_apellido = $("#in_per_apellido").val();
				data.tdo_id_tipo_documento = $("#in_tdo_id_tipo_documento").val();
				data.per_numero_doc = $("#in_per_numero_doc").val();
				data.per_direccion = $("#in_per_direccion").val();
				data.per_tel_movil = $("#in_per_tel_movil").val();
				data.per_tel_fijo = $("#in_per_tel_fijo").val();
				data.per_foto = $("#in_per_foto").val();
				data.usu_nombre = $("#in_usu_nombre").val();
				data.usu_clave = $("#in_usu_clave").val();
				data.rol_id_rol = $("#in_rol_id_rol").val();
				data.est_id_estado = $("#in_est_id_estado").val();
				data.usu_id_usuario = usu_id_usuario;
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "mantenimiento/usuario/"+accion,
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							$('#a_reporte').tab('show');
							add_mensaje(null, " Correcto. ", ' guardado.', "success");
						}
					}
				});
			}
			</script>
