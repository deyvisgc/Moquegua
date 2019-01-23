<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<h1>
						Datos de Empresa<small></small>
					</h1>
					<ol class="breadcrumb">
						<li>
							<a href="<?= base_url() ?>bienvenida"><i class="fa fa-home"></i> Home</a>
						</li>
						<li class="active">Mant Datos de Empresa.</li>
					</ol>
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Your Page Content Here -->
					<div class="row">
						<div class="col-md-12">
							<div class="nav-tabs-custom">
								<ul class="nav nav-tabs pull-right">
									<li class="active"><a href="#dv_reporte" data-toggle="tab" id="a_reporte">Empresa</a></li>
									<li class="pull-left header"><i class="fa fa-building"></i> Datos de Empresa.</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="dv_reporte">
										<div class="row">
											<form class="form-horizontal" id="fm_datos_empresa_local">
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">RUC</label>
													<div class="col-sm-3">
														<input type="text" id="in_daemlo_ruc" name="daemlo_ruc" class="form-control" value="<?= $datos_empresa_local->daemlo_ruc ?>" placeholder="RUC">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">NOMBRE EMPRESA(juridico)</label>
													<div class="col-sm-3">
														<input type="text" id="in_daemlo_nombre_empresa_juridica" name="daemlo_nombre_empresa_juridica" class="form-control" value="<?= $datos_empresa_local->daemlo_nombre_empresa_juridica ?>" placeholder="Nombre Empresa(juridico)">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">NOMBRE EMPRESA(fantasia)</label>
													<div class="col-sm-3">
														<input type="text" id="in_daemlo_nombre_empresa_fantasia" name="daemlo_nombre_empresa_fantasia" class="form-control" value="<?= $datos_empresa_local->daemlo_nombre_empresa_fantasia ?>" placeholder="Nombre Empresa(fantasia)">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">CODIGO POSTAL</label>
													<div class="col-sm-3">
														<input type="text" id="in_daemlo_codigo_postal" name="daemlo_codigo_postal" class="form-control" value="<?= $datos_empresa_local->daemlo_codigo_postal ?>" placeholder="Codigo postal">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">DIRECCION</label>
													<div class="col-sm-3">
														<input type="text" id="in_daemlo_direccion" name="daemlo_direccion" class="form-control" value="<?= $datos_empresa_local->daemlo_direccion ?>" placeholder="Direccion">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">CIUDAD</label>
													<div class="col-sm-3">
														<input type="text" id="in_daemlo_ciudad" name="daemlo_ciudad" class="form-control" value="<?= $datos_empresa_local->daemlo_ciudad ?>" placeholder="Ciudad">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">ESTADO(DEPARTAMENTO)</label>
													<div class="col-sm-3">
														<input type="text" id="in_daemlo_estado" name="daemlo_estado" class="form-control" value="<?= $datos_empresa_local->daemlo_estado ?>" placeholder="Estado(departamento)">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">TELEFONO</label>
													<div class="col-sm-3">
														<input type="text" id="in_daemlo_telefono" name="daemlo_telefono" class="form-control" value="<?= $datos_empresa_local->daemlo_telefono ?>" placeholder="Telefono">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">TELEFONO 2</label>
													<div class="col-sm-3">
														<input type="text" id="in_daemlo_telefono2" name="daemlo_telefono2" class="form-control" value="<?= $datos_empresa_local->daemlo_telefono2 ?>" placeholder="Telefono 2">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">TELEFONO 3</label>
													<div class="col-sm-3">
														<input type="text" id="in_daemlo_telefono3" name="daemlo_telefono3" class="form-control" value="<?= $datos_empresa_local->daemlo_telefono3 ?>" placeholder="Telefono 3">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">TELEFONO 4</label>
													<div class="col-sm-3">
														<input type="text" id="in_daemlo_telefono4" name="daemlo_telefono4" class="form-control" value="<?= $datos_empresa_local->daemlo_telefono4 ?>" placeholder="Telefono 4">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">WEB</label>
													<div class="col-sm-3">
														<input type="text" id="in_daemlo_web" name="daemlo_web" class="form-control" value="<?= $datos_empresa_local->daemlo_web ?>" placeholder="Web">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">FACEBOOK</label>
													<div class="col-sm-3">
														<input type="text" id="in_daemlo_facebook" name="daemlo_facebook" class="form-control" value="<?= $datos_empresa_local->daemlo_facebook ?>" placeholder="Facebook">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">INSTAGRAM</label>
													<div class="col-sm-3">
														<input type="text" id="in_daemlo_instagram" name="daemlo_instagram" class="form-control" value="<?= $datos_empresa_local->daemlo_instagram ?>" placeholder="Instagram">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">TWITTER</label>
													<div class="col-sm-3">
														<input type="text" id="in_daemlo_twitter" name="daemlo_twitter" class="form-control" value="<?= $datos_empresa_local->daemlo_twitter ?>" placeholder="Twitter">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">YOUTUBE</label>
													<div class="col-sm-3">
														<input type="text" id="in_daemlo_youtube" name="daemlo_youtube" class="form-control" value="<?= $datos_empresa_local->daemlo_youtube ?>" placeholder="Youtube">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">OTROS</label>
													<div class="col-sm-3">
														<input type="text" id="in_daemlo_otros" name="daemlo_otros" class="form-control" value="<?= $datos_empresa_local->daemlo_otros ?>" placeholder="Otros">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">&nbsp;&nbsp;&nbsp;</label>
													<div class="col-sm-3">
														<input type="hidden" id="in_daemlo_id_datos_empresa_local" name="daemlo_id_datos_empresa_local" value="<?= $datos_empresa_local->daemlo_id_datos_empresa_local ?>">
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
			function init_datos_empresa_local() {
			}
			function guardar() {
				var data = {};
				data.daemlo_ruc = $("#in_daemlo_ruc").val();
				data.daemlo_nombre_empresa_juridica = $("#in_daemlo_nombre_empresa_juridica").val();
				data.daemlo_nombre_empresa_fantasia = $("#in_daemlo_nombre_empresa_fantasia").val();
				data.daemlo_codigo_postal = $("#in_daemlo_codigo_postal").val();
				data.daemlo_direccion = $("#in_daemlo_direccion").val();
				data.daemlo_ciudad = $("#in_daemlo_ciudad").val();
				data.daemlo_estado = $("#in_daemlo_estado").val();
				data.daemlo_telefono = $("#in_daemlo_telefono").val();
				data.daemlo_telefono2 = $("#in_daemlo_telefono2").val();
				data.daemlo_telefono3 = $("#in_daemlo_telefono3").val();
				data.daemlo_telefono4 = $("#in_daemlo_telefono4").val();
				data.daemlo_contacto = $("#in_daemlo_contacto").val();
				data.daemlo_web = $("#in_daemlo_web").val();
				data.daemlo_facebook = $("#in_daemlo_facebook").val();
				data.daemlo_instagram = $("#in_daemlo_instagram").val();
				data.daemlo_twitter = $("#in_daemlo_twitter").val();
				data.daemlo_youtube = $("#in_daemlo_youtube").val();
				data.daemlo_otros = $("#in_daemlo_otros").val();
				data.daemlo_id_datos_empresa_local = $("#in_daemlo_id_datos_empresa_local").val();
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "mantenimiento/datos_empresa_local/actualizar",
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							add_mensaje(null, '<i class="fa fa-check"></i> ', "Cambios guardados.", 'success ');
						}
						else {
							add_mensaje(null, '<i class="fa fa-warning"></i> ', "ERROR!!!", 'warning ');
						}
					}
				});
			}
			</script>
