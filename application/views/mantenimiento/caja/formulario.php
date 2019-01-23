<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<h1>
						Registro de Caja<small></small>
					</h1>
					<ol class="breadcrumb">
						<li>
							<a href="<?= base_url() ?>bienvenida"><i class="fa fa-home"></i> Home</a>
						</li>
						<li class="active">Admi Caja.</li>
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
									<li class="pull-left header"><i class="fa fa-money"></i> Cajas.</li>
								</ul>
								<div class="css_global_mensajes" id="dv_mensajes"></div>
								<div class="tab-content">
									<div class="tab-pane active" id="dv_reporte">
										<div class="row">
											<div class="col-sm-12 box-body table-responsive">
												<p></p>
												<table class="table table-bordered" id="tb_caja">
													<thead>
														<tr>
															<th>DESCRIPCION</th>
															<th>CODIGO</th>
															<th>ABIERTA</th>
															<th>USUARIO</th>
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
											<form class="form-horizontal" id="fm_caja">
												<div class="form-group">
													<label for="in_caj_descripcion" class="col-sm-2 control-label">DESCRIPCION</label>
													<div class="col-sm-3">
														<input type="text" id="in_caj_descripcion" name="caj_descripcion" class="form-control" value="" placeholder="Descripcion">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">CODIGO</label>
													<div class="col-sm-3">
														<input type="text" id="in_caj_codigo" name="caj_codigo" class="form-control" value="" disabled>
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">CAJA ABIERTA</label>
													<div class="col-sm-3">
														<input type="text" id="in_caj_abierta" name="caj_abierta" class="form-control" value="NO" disabled>
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">USUARIO</label>
													<div class="col-sm-3">
														<input type="text" id="in_usu_nombrecompleto" name="usu_nombrecompleto" class="form-control" value="" disabled>
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">ESTADO</label>
													<div class="col-sm-3">
														<select class="form-control" id="sl_est_id_estado">
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
														<input type="hidden" id="in_caj_id_caja" name="caj_id_caja" value="">
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
			function init_caja() {
				$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
					var target = $(e.target).attr("href");
					if(target === '#dv_registro') {
						$('#in_caj_id_caja').val('');
						$('#in_caj_abierta').val('NO');
						$('#fm_caja')[0].reset();
					}
					else if(target === '#dv_reporte') {
						$('#tb_caja').DataTable().ajax.reload();
					}
				});
				
				var id_tabla = "tb_caja";
				var url = "<?php echo base_url(); ?>mantenimiento/caja/buscar_xll";
				var data = [];
				var columns = [
					{data: "caj_descripcion"},
					{data: "caj_codigo"},
					{data: "caj_abierta"},
					{data: "usu_nombrecompleto"},
					{data: "est_nombre"},
					{
						data: null,
						"render": function ( data, type, full, meta ) {
							return '<button  type="button" class="btn btn-warning btn-xs boton_hhh" onclick="mostrar(event)"><span class="glyphicon glyphicon-edit span_hhh" aria-hidden="true"> Editar</span></button>'+
								'<input type="hidden" name="caj_descripcion" value="'+full.caj_descripcion+'">'+
								'<input type="hidden" name="caj_codigo" value="'+full.caj_codigo+'">'+
								'<input type="hidden" name="caj_abierta" value="'+full.caj_abierta+'">'+
								'<input type="hidden" name="usu_nombrecompleto" value="'+full.usu_nombrecompleto+'">'+
								'<input type="hidden" name="est_id_estado" value="'+full.est_id_estado+'">'+
								'<input type="hidden" name="caj_id_caja" value="'+full.caj_id_caja+'">';
						}
					}
				];
				generar_tabla(id_tabla, url, data, columns);
			}
			function mostrar(e) {
				var tr = $(e.target).closest('tr');
				$('#a_registro').tab('show');
				var caj_descripcion = tr.find('input[name="caj_descripcion"]').val();
				var caj_codigo = tr.find('input[name="caj_codigo"]').val();
				var caj_abierta = tr.find('input[name="caj_abierta"]').val();
				var usu_nombrecompleto = tr.find('input[name="usu_nombrecompleto"]').val();
				var est_id_estado = tr.find('input[name="est_id_estado"]').val();
				var caj_id_caja = tr.find('input[name="caj_id_caja"]').val();
				$("#in_caj_descripcion").val(caj_descripcion);
				$("#in_caj_codigo").val(caj_codigo);
				$("#in_caj_abierta").val(caj_abierta);
				$("#in_usu_nombrecompleto").val(usu_nombrecompleto);
				$("#sl_est_id_estado").val(est_id_estado);
				$("#in_caj_id_caja").val(caj_id_caja);
			}
			function guardar() {
				var data = {};
				data.caj_descripcion = $("#in_caj_descripcion").val();
				data.est_id_estado = $("#sl_est_id_estado").val();
				data.caj_id_caja = $("#in_caj_id_caja").val();
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>mantenimiento/caja/guardar",
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							$('#a_reporte').tab('show');
							add_mensaje(null, " Correcto. ", ' caja guardada.', "success");
						}
					}
				});
			}
			</script>
