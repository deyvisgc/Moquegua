<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<h1>
						Registro de Proveedor-Cliente<small></small>
					</h1>
					<ol class="breadcrumb">
						<li>
							<a href="<?= base_url() ?>bienvenida"><i class="fa fa-home"></i> Home</a>
						</li>
						<li class="active">Mant Proveedor-Cliente.</li>
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
									<li class="pull-left header"><i class="fa fa-street-view"></i> Proveedor-Cliente.</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="dv_reporte">
										<div class="row">
											<div class="col-sm-12 box-body table-responsive">
												<p></p>
												<table class="table table-bordered" id="tb_pcliente">
													<thead>
														<tr>
															<th>RUC</th>
															<th>RAZON SOCIAL</th>
															<th>TELEFONO</th>
															<th>CONTACTO</th>
															<th>TIPO</th>
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
											<form class="form-horizontal" id="fm_pcliente">
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">RUC</label>
													<div class="col-sm-3">
														<input type="text" id="in_emp_ruc" name="emp_ruc" class="form-control" value="" maxlength="11" placeholder="RUC">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">RAZON SOCIAL</label>
													<div class="col-sm-3">
														<input type="text" id="in_emp_razon_social" name="emp_razon_social" class="form-control" value="" placeholder="RAZON SOCIAL">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">DIRECCION</label>
													<div class="col-sm-3">
														<input type="text" id="in_emp_direccion" name="emp_direccion" class="form-control" value="" placeholder="DIRECCION">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">TELEFONO</label>
													<div class="col-sm-3">
														<input type="text" id="in_emp_telefono" name="emp_telefono" class="form-control" value="" maxlength="15" placeholder="TELEFONO">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">CONTACTO</label>
													<div class="col-sm-3">
														<input type="text" id="in_emp_nombre_contacto" name="emp_nombre_contacto" class="form-control" value="" placeholder="CONTACTO">
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">TIPO</label>
													<div class="col-sm-3">
														<select class="form-control" id="sl_pcl_tipo">
															<option value="1">CLIENTE</option>
															<option value="2">PROVEEDOR</option>
															<option value="3">AMBOS</option>
														</select>
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
														<input type="hidden" id="in_pcl_id_pcliente" name="pcl_id_pcliente" value="">
														<input type="hidden" id="in_emp_id_empresa" name="emp_id_empresa" value="">
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
			function init_pcliente() {
				$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
					var target = $(e.target).attr("href");
					if(target === '#dv_registro') {
						$('#in_pcl_id_pcliente').val('');
						$('#emp_id_empresa').val('');
						$('#fm_pcliente')[0].reset();
					}
					else if(target === '#dv_reporte') {
						$('#tb_pcliente').DataTable().ajax.reload();
					}
				});
				
				var id_tabla = "tb_pcliente";
				var url = "<?php echo base_url(); ?>mantenimiento/pcliente/buscar_x_rz_o_ruc";
				var data = [];
				var columns = [
					{data: "emp_ruc"},
					{data: "emp_razon_social"},
					{data: "emp_telefono"},
					{data: "emp_nombre_contacto"},
					{data: "pcl_tipo_nombre"},
					{data: "est_nombre"},
					{
						data: null,
						"render": function ( data, type, full, meta ) {
							return '<button  type="button" class="btn btn-warning btn-xs boton_hhh" onclick="mostrar(event)"><span class="glyphicon glyphicon-edit span_hhh" aria-hidden="true"> Editar</span></button>'+
								'<input type="hidden" name="emp_ruc" value="'+full.emp_ruc+'">'+
								'<input type="hidden" name="emp_razon_social" value="'+full.emp_razon_social+'">'+
								'<input type="hidden" name="emp_direccion" value="'+full.emp_direccion+'">'+
								'<input type="hidden" name="emp_telefono" value="'+full.emp_telefono+'">'+
								'<input type="hidden" name="emp_nombre_contacto" value="'+full.emp_nombre_contacto+'">'+
								'<input type="hidden" name="est_id_estado" value="'+full.est_id_estado+'">'+
								'<input type="hidden" name="pcl_tipo" value="'+full.pcl_tipo+'">'+
								'<input type="hidden" name="pcl_id_pcliente" value="'+full.pcl_id_pcliente+'">'+
								'<input type="hidden" name="emp_id_empresa" value="'+full.emp_id_empresa+'">';
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
				var emp_ruc = tr.find('input[name="emp_ruc"]').val();
				var emp_razon_social = tr.find('input[name="emp_razon_social"]').val();
				var emp_telefono = tr.find('input[name="emp_telefono"]').val();
				var emp_nombre_contacto = tr.find('input[name="emp_nombre_contacto"]').val();
				var emp_direccion = tr.find('input[name="emp_direccion"]').val();
				var pcl_tipo = tr.find('input[name="pcl_tipo"]').val();
				var est_id_estado = tr.find('input[name="est_id_estado"]').val();
				var emp_id_empresa = tr.find('input[name="emp_id_empresa"]').val();
				var pcl_id_pcliente = tr.find('input[name="pcl_id_pcliente"]').val();
				$("#in_emp_ruc").val(emp_ruc);
				$("#in_emp_razon_social").val(emp_razon_social);
				$("#in_emp_direccion").val(emp_direccion);
				$("#in_emp_telefono").val(emp_telefono);
				$("#in_emp_nombre_contacto").val(emp_nombre_contacto);
				$("#sl_pcl_tipo").val(pcl_tipo);
				$("#sl_est_id_estado").val(est_id_estado);
				$("#in_pcl_id_pcliente").val(pcl_id_pcliente);
				$("#in_emp_id_empresa").val(emp_id_empresa);
			}
			function eliminar(e) {
				var tr = $(e.target).closest('tr');
				var pcl_id_pcliente = tr.find('input[name="pcl_id_pcliente"]').val();
				var data = {};
				data.pcl_id_pcliente = pcl_id_pcliente;
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>mantenimiento/pcliente/eliminar",
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							$('#tb_pcliente').DataTable().ajax.reload();
							add_mensaje(null, " Correcto. ", ' eliminado.', "success");
						}
					}
				});
			}
			function guardar() {
				var pcl_id_pcliente = $("#in_pcl_id_pcliente").val();
				var accion = "";
				if(pcl_id_pcliente == '') {
					accion = "registrar";
				}
				else {
					accion = "actualizar";
				}
				var data = {};
				data.emp_ruc = $("#in_emp_ruc").val();
				data.emp_razon_social = $("#in_emp_razon_social").val();
				data.emp_direccion = $("#in_emp_direccion").val();
				data.emp_telefono = $("#in_emp_telefono").val();
				data.emp_nombre_contacto = $("#in_emp_nombre_contacto").val();
				data.pcl_tipo = $("#sl_pcl_tipo").val();
				data.est_id_estado = $("#sl_est_id_estado").val();
				data.pcl_id_pcliente = $("#in_pcl_id_pcliente").val();
				data.emp_id_empresa = $("#in_emp_id_empresa").val();
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "mantenimiento/pcliente/"+accion,
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							$('#a_reporte').tab('show');
							add_mensaje(null, " Correcto. ", ' Se guardo.', "success");
						}
					}
				});
			}
			</script>
