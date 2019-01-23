<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<h1>
						Ajuste de Stock(cantidad)<small></small>
					</h1>
					<ol class="breadcrumb">
						<li>
							<a href="<?= base_url() ?>bienvenida"><i class="fa fa-home"></i> Home</a>
						</li>
						<li class="active">Ajuste stock.</li>
					</ol>
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Your Page Content Here -->
					<div class="row">
						<div class="col-md-12">
							<div class="nav-tabs-custom">
								<ul class="nav nav-tabs pull-right">
									<li class="active"><a href="#dv_reporte" data-toggle="tab" id="a_reporte">Ajuste</a></li>
									<li class="pull-left header"><i class="fa fa-atlas"></i> Datos.</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="dv_reporte">
										<div class="row">
											<p></p>
											<form class="form-horizontal" id="fm_producto">
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">PRODUCTO <span class="text-danger">(R)</span></label>
													<div class="col-sm-3">
														<select class="form-control" id="sl_pro_id_producto">
														</select>
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">CODIGO <span class="text-info">(I)</span></label>
													<div class="col-sm-3">
														<span class="form-control" id="sp_codigo"></span>
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">STOCK ACTUAL <span class="text-info">(I)</span></label>
													<div class="col-sm-3">
														<span class="form-control" id="sp_cantidad"></span>
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">AJUSTE <span class="text-danger">(R)</span></label>
													<div class="col-sm-3">
														<select class="form-control" id="sl_operador">
															<option value="1">CANTIDAD POSITIVO</option>
															<option value="-1">CANTIDAD NEGATIVO</option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">CANTIDAD <span class="text-danger">(R)</span></label>
													<div class="col-sm-3">
														<input type="text" id="in_cantidad" name="cantidad" class="form-control" value="" placeholder="Cantidad ...">
													</div>
												</div>
												<hr>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">&nbsp;&nbsp;&nbsp;</label>
													<div class="col-sm-3">
														<button type="button" class="btn btn-primary" onclick="func_guardar(event);"><i class="fa fa-check-circle"></i> Ajustar stock</button>
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
			function init_ajuste_stock() {
				$('#sl_pro_id_producto').change(function(){
					var cantidad = $(this).find(':selected').data('cantidad');
					var codigo = $(this).find(':selected').data('codigo');
					$('#sp_codigo').text(codigo);
					$('#sp_cantidad').text(cantidad);
				});
				func_recargar_producto('');
				add_mensaje(null, " Ajuste de stock. ", ' ingrese datos.', "info");
			}
			function func_recargar_producto(id_producto) {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>movimiento/ajuste/stock/recargar_producto",
					dataType: 'json',
					success: function(datos) {
						if(datos.hecho == 'SI') {
							var select = $('#sl_pro_id_producto');
							select.empty();
							select.append('<option data-codigo="" data-cantidad="" value="" >Elejir</option>');
							datos.list_producto.forEach(function(producto) {
								var selected = '';
								if(id_producto == producto.pro_id_producto) {
									selected = 'selected';
								}
								select.append('<option data-codigo="'+producto.pro_codigo+'" data-cantidad="'+producto.pro_cantidad+'" value="'+producto.pro_id_producto+'" '+selected+'>'+producto.pro_nombre+'</option>');
							});
							$('#sl_pro_id_producto').change();
						}
					}
				});
			}
			function func_guardar(e) {
				var pro_id_producto = $("#sl_pro_id_producto").val();
				var operador = $("#sl_operador").val();
				var cantidad = $("#in_cantidad").val();
				if(pro_id_producto == '') {
					add_mensaje(null, " Producto. ", ' no seleccionado.', "info");
					return;
				}
				if(cantidad == '') {
					add_mensaje(null, " Cantidad. ", ' ingrese cantidad.', "info");
					return;
				}
				var data = {};
				data.pro_id_producto = pro_id_producto;
				data.operador = operador;
				data.cantidad = cantidad;
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>movimiento/ajuste/stock/guardar",
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							$("#fm_producto")[0].reset();
							func_recargar_producto(pro_id_producto);
							add_mensaje(null, " Correcto. ", ' ajuste hecho.', "success");
						}
						else {
							add_mensaje(null, " !!! ", datos.msj, "warning");
						}
					}
				});
			}
			</script>
