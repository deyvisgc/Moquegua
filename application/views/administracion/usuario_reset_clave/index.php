<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<h1>
						Reset de clave<small></small>
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
									<li class="active"><a href="#dv_reporte" data-toggle="tab" id="a_reporte">Reset</a></li>
									<li class="pull-left header"><i class="fa fa-user-lock"></i> Datos.</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="dv_reporte">
										<div class="row">
											<p></p>
											<form class="form-horizontal" id="fm_usuario">
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">USUARIO</label>
													<div class="col-sm-3">
														<select class="form-control" id="sl_usu_id_usuario">
															<?php
															foreach ($list_usuario as $valor) {
															?>
															<option value="<?= $valor->usu_id_usuario ?>">
																<?= $valor->per_nombre.' '.$valor->per_apellido?>
															</option>
															<?php
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label for="in_usu_clave_nueva" class="col-sm-2 control-label">CLAVE NUEVA</label>
													<div class="col-sm-3">
														<input type="password" id="in_usu_clave_nueva" name="usu_clave_nueva" class="form-control" value="" placeholder="Clave nueva">
													</div>
												</div>
												<div class="form-group">
													<label for="in_usu_clave_nueva_r" class="col-sm-2 control-label">RE-CLAVE NUEVA</label>
													<div class="col-sm-3">
														<input type="password" id="in_usu_clave_nueva_r" name="usu_clave_nueva_r" class="form-control" value="" placeholder="Re-Clave nueva">
													</div>
												</div>
												<hr>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">&nbsp;&nbsp;&nbsp;</label>
													<div class="col-sm-3">
														<button type="button" class="btn btn-primary" onclick="func_reset_clave(event);" id="btn-altas"><i class="fa fa-check-circle"></i> Reset clave</button>
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
				add_mensaje(null, " reset clave. ", ' ingrese datos.', "info");
			}
			function func_reset_clave(e) {
				var usu_id_usuario = $("#sl_usu_id_usuario").val();
				var usu_clave_nueva = $("#in_usu_clave_nueva").val();
				var usu_clave_nueva_r = $("#in_usu_clave_nueva_r").val();
				if(usu_clave_nueva !== usu_clave_nueva_r) {
					add_mensaje(null, " Claves. ", ' no coinciden.', "info");
					return;
				}
				var data = {};
				data.usu_id_usuario = usu_id_usuario;
				data.usu_clave_nueva = usu_clave_nueva;
				
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>administracion/usuario_reset_clave/cambiar_clave",
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							add_mensaje(null, " Correcto. ", ' reseteo de clave.', "success");
							$('#in_usu_clave_nueva').val('');
							$('#in_usu_clave_nueva_r').val('');
						}
						else {
							add_mensaje(null, " !!! ", datos.msj, "warning");
						}
					}
				});
			}
			</script>
