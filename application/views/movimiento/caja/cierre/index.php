<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<h1>
						Movimiento de caja<small></small>
					</h1>
					<ol class="breadcrumb">
						<li>
							<a href="<?= base_url() ?>bienvenida"><i class="fa fa-home"></i> Home</a>
						</li>
						<li class="active">Cierre.</li>
					</ol>
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Your Page Content Here -->
					<div class="row">
						<div class="col-md-12">
							<div class="nav-tabs-custom">
								<ul class="nav nav-tabs pull-right">
									<li class="active"><a href="#dv_cierre" data-toggle="tab" id="a_cierre">Cierre</a></li>
									<li class="pull-left header"><i class="fa fa-lock"></i> Cierre Caja.</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="dv_cierre">
										<div class="row">
											<p></p>
											<form class="form-horizontal" id="fm_cierre">
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">CAJA APERTURADA</label>
													<div class="col-sm-3">
														<span id="sp_caj_descripcion" class="form-control" disabled>&nbsp;</span>
														<input type="hidden" id="in_caj_id_caja" name="caj_id_caja" value="">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">CODIGO</label>
													<div class="col-sm-3">
														<span id="sp_caj_codigo" class="form-control" disabled>&nbsp;</span>
													</div>
												</div>
												<hr>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">&nbsp;&nbsp;&nbsp;</label>
													<div class="col-sm-3">
														<button type="button" class="btn btn-primary" onclick="cerrar();" id="bt_cerrar"><i class="fa fa-check-circle"></i> Cerrar Caja </button>
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
			function init_cierre() {
				reload();
			}
			function reload() {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>movimiento/caja/cierre/reload",
					dataType: 'json',
					success: function(datos) {
						if(datos.hecho === 'SI') {
							$("#in_caj_id_caja").val(datos.caja.caj_id_caja);
							$("#sp_caj_descripcion").text(datos.caja.caj_descripcion);
							$("#sp_caj_codigo").text(datos.caja.caj_codigo);
							add_mensaje(null, '<i class="fa fa-check"></i> ', _msj_system['0CAJ0101'], 'info');
						}
						else if(datos.hecho === 'NO') {
							$("#bt_cerrar").prop('disabled', true);
							add_mensaje(null, '<i class="fa fa-warning"></i> ', _msj_system['0CAJ0102'], 'warning');
						}
					}
				});
			}
			function cerrar() {
				var data = {};
				data.caj_id_caja = $("#in_caj_id_caja").val();
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>movimiento/caja/cierre/cerrar",
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							$("#bt_cerrar").attr('disabled', 'disabled');
							add_mensaje(null, '<i class="fa fa-check"></i> Exito', _msj_system[datos.estado], 'success');
						}
						else {
							add_mensaje(null, '<i class="fa fa-warning"></i> Error', _msj_system[datos.estado], 'danger');
						}
					}
				});
			}
			</script>
