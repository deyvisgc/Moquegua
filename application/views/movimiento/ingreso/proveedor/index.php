<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<h1>
						Registro de Compra<small></small>
					</h1>
					<ol class="breadcrumb">
						<li>
							<a href="<?= base_url() ?>bienvenida"><i class="fa fa-home"></i> Home</a>
						</li>
						<li class="active">Mov. Compra.</li>
					</ol>
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Your Page Content Here -->
					<div class="row">
						<div class="col-md-12">
							<div class="nav-tabs-custom">
								<ul class="nav nav-tabs pull-right">
									<li><a href="#dv_panel_pago" data-toggle="tab" id="a_panel_pago">Pago productos</a></li>
									<li class="active"><a href="#dv_panel_eleccion" data-toggle="tab" id="a_panel_eleccion">Eleccion productos</a></li>
									<li class="pull-left header"><i class="fa fa-cart-arrow-down"></i> <span id="sp_etiqueta">Eleccion de productos.</span></li>
								</ul>
								<div class="tab-content">
									<!-- TAB ELECCION -->
									<div class="tab-pane active" id="dv_panel_eleccion">
										<div class="row">
											<div class="row">
												<div class="col-md-4">
													<div class="box box-primary">
														<div class="box-header with-border">
															<h3 class="box-title"><b>Ingresa descripcion:</b></h3>
														</div>
														<div class="box-body">
															<div class="input-group">
																<div class="input-group-btn">
																	<button type="button" class="btn btn-success" id="bt_descripcion" disabled=""><i class="fa fa-search"></i></button>
																</div>
																<input type="text" class="form-control" id="in_descripcion" placeholder="Descripcion..." style="font-size:20px; text-align:center; color: blue; font-weight: bold;" disabled="">
															</div>
															<p></p>
															<div class="input-group">
																<span class="input-group-addon bg-gray">Precio <i class="fa fa-money"></i></span>
																<input type="number" class="form-control precios" id="in_valor" style="font-size: 20px; text-align: right; color: blue; font-weight: bold;" data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" disabled="">
															</div>
															<p></p>
															<div class="input-group">
																<span class="input-group-addon bg-gray">Cant:</span>
																<input type="number" class="form-control cantidades" id="in_cantidad" style="font-size: 20px; text-align: right; color: blue; font-weight: bold;" data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" disabled="">
															</div>
															<p></p>
															<div class="input-group">
																<span class="input-group-addon bg-gray">#Lote:</span>
																<input type="text" class="form-control cantidades" id="in_numero_lote" style="font-size: 20px; text-align: right; color: blue; font-weight: bold;" data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" disabled="">
															</div>
															<p></p>
															<div class="input-group">
																<span class="input-group-addon bg-gray">Cad<i class="fa fa-calendar"></i></span>
																<input type="date" class="form-control cantidades" id="in_fecha_vencimiento" style="font-size: 20px; text-align: right; color: blue; font-weight: bold;" data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" disabled="">
															</div>
															<br>
															<input type="hidden" id="in_pro_id_producto" value="">
															<button class="btn btn-success btn-lg" id="bt_agregar_producto" disabled=""><i class="fa fa fa-edit"></i> Agregar</button>
															<button class="btn btn-default btn-lg" id="bt_cancelar_producto" disabled=""><i class="fa fa-times"></i> Cancelar</button>
														</div>
													</div>
												</div>
												
												<div class="col-md-4">
													<!-- Widget: user widget style 1 -->
													<div class="box box-widget widget-user">
														<!-- Add the bg color to the header using any of the bg-* classes -->
														<div class="widget-user-header bg-aqua-active">
															<h3 class="widget-user-username"></h3>
															<h5 class="widget-user-desc"></h5>
														</div>
														<div class="widget-user-image">
															<img id="img_foto" class="img-circle" src="<?php echo base_url(); ?>../resources/sy_file_repository/img_vacio.png" alt="Imagen del Producto">
														</div>
														<div class="box-footer">
															<div class="row">
																<div class="col-sm-4 border-right">
																	<div class="description-block">
																		<h5 class="description-header preciol"><span id="sp_precio_unitario">0.00</span></h5>
																		<span class="description-text">PRECIO U.</span>
																	</div><!-- /.description-block -->
																</div><!-- /.col -->
																<div class="col-sm-4 border-right">
																	<div class="description-block">
																		<h5 class="description-header medida"><span id="sp_uni_med_nombre">...</span></h5>
																		<span class="description-text">UNI MED</span>
																	</div><!-- /.description-block -->
																</div><!-- /.col -->
																<div class="col-sm-4">
																	<div class="description-block">
																		<h5 class="description-header exis"><span id="sp_stock">0.00</span></h5>
																		<span class="description-text">STOCK.</span>
																	</div><!-- /.description-block -->
																</div><!-- /.col -->
															</div><!-- /.row -->
														</div>
													</div><!-- /.widget-user -->
												</div><!-- /.col -->
												
												<div class="col-md-4">
													<!-- small box -->
													<div class="small-box bg-aqua">
														<div class="inner">
															<h3><div>S/. <span class="sp_sum_total">0.00</span></div></h3>
															<p>Total</p>
														</div>
														<div class="icon">
															<i class="fa fa-shopping-cart"></i>
														</div>
														<a href="#" class="small-box-footer">
															<div id="num_ticket">Caja: <span class="sp_caja_nombre"></span> </div>
														</a>
														<a href="#" class="small-box-footer">
															<div id="total_articulos">Total de Productos: <span class="sp_count_productos">0.00</span></div>
														</a>
													</div>
													<div class="btn-group">
														<button class="btn  btn-success" id="bt_show_pago" disabled=""><i class="fa fa-money"></i> Pagar</button>
													</div>
												</div><!-- ./col -->
											</div>
											
											<div class="row">
												<div class="col-md-12">
													<div class="box box-primary">
														<div class="box-header">
															<h3 class="box-title">Lista de Productos</h3>
														</div>
														<div class="box-body table-responsive">
															<table id="tb_ingreso_detalle" class="table table-hover">
																<thead>
																	<tr>
																		<th>Codigo</th>
																		<th>Descripcion</th>
																		<th>#Lote</th>
																		<th>Fecha V.</th>
																		<th>U. M.</th>
																		<th>Cant.</th>
																		<th>Precio U.</th>
																		<th>Monto</th>
																		<th>Operacion</th>
																	</tr>
																</thead>
																<tbody>
																</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
											<br>
										</div>
									</div>
									
									<!-- PAGO -->
									<div class="tab-pane" id="dv_panel_pago">
										<div class="row">
											<div class="row">
												<div class="col-md-4">
													<div class="box box-primary">
														<div class="box-body">
															<div class="input-group">
																<span class="input-group-addon bg-gray">Proveedor <i class="fa fa-search"></i></span>
																<input type="text" class="form-control cliente" id="in_texto_proveedor" style="font-size: 20px; text-align: right; color: blue; font-weight: bold;" data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" disabled="">
																<input type="hidden" id="in_pcl_id_proveedor" value="">
															</div>
															<p></p>
															<div class="input-group">
																<span class="input-group-addon bg-gray">RUC <i class="fa fa-search"></i></span>
																<input type="text" class="form-control ruc" id="in_texto_ruc" style="font-size: 20px; text-align: right; color: blue; font-weight: bold;" data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" disabled="">
															</div>
															<p></p>
															<div class="input-group">
																<span class="input-group-addon bg-gray">Fecha <i class="fa fa-calendar"></i></span>
																<input type="date" class="form-control fecha" id="in_ing_fecha_doc_proveedor" style="font-size: 20px; text-align: right; color: blue; font-weight: bold;" data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" disabled="">
															</div>
															<p></p>
															<div class="input-group">
																<span class="input-group-addon bg-gray">Documento <i class="fa fa-file"></i></span>
																<select class="form-control custom-select" id="sl_tdo_id_tipo_documento" disabled=""></select>
															</div>
															<p></p>
															<div class="input-group">
																<span class="input-group-addon bg-gray">Numero <i class="fa fa-barcode"></i></span>
																<input type="text" class="form-control numero" id="in_ing_numero_doc_proveedor" style="font-size: 20px; text-align: right; color: blue; font-weight: bold;" data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" disabled="">
															</div>
															<br>
														</div>
													</div>
												</div>
												
												<div class="col-md-4">
													<div class="box box-primary">
														<div class="box-body">
															<div class="input-group">
																<span class="input-group-addon bg-gray">Efectivo  S/. <i class="fa fa-money"></i></span>
																<input type="number" class="form-control descuento" id="in_ing_monto_efectivo" style="font-size: 20px; text-align: right; color: blue; font-weight: bold;" data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" value="" placeholder="0.00" disabled="">
															</div>
															<p></p>
															<div class="input-group">
																<span class="input-group-addon bg-gray">Debito  S/. <i class="fa fa-credit-card"></i></span>
																<input type="number" class="form-control descuento" id="in_ing_monto_tar_credito" style="font-size: 20px; text-align: right; color: blue; font-weight: bold;" data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" value="" placeholder="0.00" disabled="">
															</div>
															<p></p>
															<div class="input-group">
																<span class="input-group-addon bg-gray">Credito  S/. <i class="fa fa-credit-card"></i></span>
																<input type="number" class="form-control descuento" id="in_ing_monto_tar_debito" style="font-size: 20px; text-align: right; color: blue; font-weight: bold;" data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" value="" placeholder="0.00" disabled="">
															</div>
                                                            <p></p>
                                                            <div class="input-group">
                                                                <span class="input-group-addon bg-gray">Tipo de Compra </span>
                                                                <select class="form-control custom-select" id="in_tipo" name="in_tipo">
                                                                    <option value="contado">Al contado</option>
                                                                    <option value="deuda">Por pagar</option>
                                                                </select>
                                                            </div>
															<br>
														</div>
													</div>
												</div>
												
												<div class="col-md-4">
													<!-- small box -->
													<div class="small-box bg-aqua">
														<div class="inner">
															<h3><div>S/. <span class="sp_sum_total">0.00</span></div></h3>
															<p>Total</p>
														</div>
														<div class="icon">
															<i class="fa fa-shopping-cart"></i>
														</div>
														<a href="#" class="small-box-footer">
															<div id="num_ticket">Caja: <span class="sp_caja_nombre"></span> </div>
														</a>
														<a href="#" class="small-box-footer">
															<div id="total_articulos">Total de Productos: <span class="sp_count_productos">0.00</span></div>
														</a>
													</div>
													<div class="btn-group">
														<button class="btn  btn-success btn-lg" id="bt_pagar_productos" disabled=""><i class="fa fa-money"></i> Pagar</button>
													</div>
												</div><!-- ./col -->
											</div>
											<br>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section><!-- /.content -->
			</div><!-- /.content-wrapper -->
			
			<script>
			function init_ingreso() {
				$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
					var target = $(e.target).attr("href");
					if(target === '#dv_panel_pago') {
						$('#sp_etiqueta').text('Pago de productos.');
					}
					else if(target === '#dv_panel_eleccion') {
						$('#sp_etiqueta').text('Eleccion de productos.');
					}
				});
				$('#bt_agregar_producto').prop('disabled', false);
				$('#bt_cancelar_producto').prop('disabled', false);
				$('#bt_descripcion').prop('disabled', false);
				$('#in_descripcion').prop('disabled', false);
				$('#bt_show_pago').prop('disabled', false);
				$('#bt_pagar_productos').prop('disabled', false);
				$('#in_texto_proveedor').prop('disabled', false);
				$('#in_texto_ruc').prop('disabled', false);
				$('#in_ing_fecha_doc_proveedor').prop('disabled', false);
				$('#in_ing_fecha_doc_proveedor').val(get_fhoy());
				$('#sl_tdo_id_tipo_documento').prop('disabled', false);
				$('#in_ing_numero_doc_proveedor').prop('disabled', false);
				$('#in_ing_monto_efectivo').prop('disabled', false);
				$('#in_ing_monto_tar_credito').prop('disabled', false);
				$('#in_ing_monto_tar_debito').prop('disabled', false);
				$( "#in_descripcion" ).autocomplete({
					source: function( request, response ) {
						$.ajax( {
							url: BASE_URL+'movimiento/ingreso/detalle/buscar_productos_x_descripcion',
							dataType: "json",
							type: "POST",
							data: {
								descripcion: request.term
							},
							success: function( data ) {
								if(data.list_producto.length === 0) {
									add_mensaje(null, " Productos. ", ' 0 encontrados.', "info");
								}
								response( data.list_producto );
							}
						} );
					},
					delay: 900,
					minLength: 1,
					select: function( event, ui ) {
						$('#in_valor').prop('disabled', false);
						$('#in_valor').val('');
						$('#in_cantidad').prop('disabled', false);
						$('#in_cantidad').val('');
						$('#in_pro_id_producto').val(ui.item.pro_id_producto);
						$('#in_numero_lote').prop('disabled', false);
						$('#in_numero_lote').val('');
						if(ui.item.pro_perecible === 'SI') {
							$('#in_fecha_vencimiento').prop('disabled', false);
							$('#in_fecha_vencimiento').val(get_fhoy());
						}
						$('#img_foto').attr("src", ui.item.pro_foto);
						$('#sp_precio_unitario').text(ui.item.pro_val_compra);
						$('#sp_uni_med_nombre').text(ui.item.unm_nombre_corto);
						$('#sp_stock').text(ui.item.pro_cantidad);
					}
				});
				
				$( "#in_texto_proveedor, #in_texto_ruc" ).autocomplete({
					source: function( request, response ) {
						$.ajax( {
							url: BASE_URL+'movimiento/ingreso/detalle/buscar_proveedor',
							dataType: "json",
							type: "POST",
							data: {
								texto: request.term
							},
							success: function( data ) {
								response( data.list_proveedor );
							}
						} );
					},
					delay: 900,
					minLength: 1,
					select: function( event, ui ) {
						$('#in_texto_proveedor').val(ui.item.emp_razon_social);
						$('#in_texto_ruc').val(ui.item.emp_ruc);
						$('#in_pcl_id_proveedor').val(ui.item.pcl_id_pcliente);
						return false;
					}
				});
				
				var objeto = {
					ajax : {
						url: BASE_URL+'movimiento/ingreso/detalle/buscar_productos_elejidos',
						type: 'POST',
						data: {},
						"dataSrc": function ( json ) {
							$('.sp_count_productos').text(json.tcompra.count_productos);
							$('.sp_sum_total').text(json.tcompra.sum_total);
							return json.data;
						}
					},
					columns : [
						{data: "codigo"},
						{data: "descripcion"},
						{data: "numero_lote"},
						{data: "fecha_vencimiento"},
						{data: "uni_med"},
						{data: "cantidad"},
						{data: "precio"},
						{data: "total"},
						{
							data: null,
							"render": function ( data, type, full, meta ) {
								return '<button class="btn btn-danger  btn-sm" type="button" onclick="func_quitar_producto(event)"><i class="fa fa-times" aria-hidden="true"></i> Quitar</button>'+
									'<input type="hidden" name="pro_id_producto" value="'+full.pro_id_producto+'">';
							}
						}
					],
					ordering: false,
					searching: false,
					info: false,
					paging: false
				};
				generar_data_table('tb_ingreso_detalle', objeto);
				
				$('#bt_cancelar_producto').click(func_cancelar_producto);
				$('#bt_agregar_producto').click(func_agregar_producto);
				$('#bt_show_pago').click(func_show_pago);
				$('#bt_pagar_productos').click(func_pagar_productos);
				add_mensaje(null, 'OK ', ' Ingrese sus productos.', 'info');
				func_reload_salcombo();
			}
			
			function func_reload_salcombo() {
				$.ajax({
					type: "POST",
					url: BASE_URL+"movimiento/ingreso/detalle/reload_salcombo",
					dataType: 'json',
					data: null,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							var select = $('#sl_tdo_id_tipo_documento');
							select.empty();
							datos.list_documento.forEach(function(documento) {
								select.append('<option value="'+documento.tdo_id_tipo_documento+'" >'+documento.tdo_nombre+'</option>');
							});
						}
					}
				});
			}
			
			function func_cancelar_producto(e) {
				$('#in_descripcion').val('');
				$('#in_valor').prop('disabled', true);
				$('#in_valor').val('');
				$('#in_cantidad').prop('disabled', true);
				$('#in_cantidad').val('');
				$('#in_numero_lote').prop('disabled', true);
				$('#in_numero_lote').val('');
				$('#in_fecha_vencimiento').prop('disabled', true);
				$('#in_fecha_vencimiento').val('');
				$('#in_pro_id_producto').val('');
				$('#img_foto').attr("src", BASE_URL+'../resources/sy_file_repository/img_vacio.png');
				$('#sp_precio_unitario').text('0.00');
				$('#sp_uni_med_nombre').text('...');
				$('#sp_stock').text('0.00');
			}
			function func_cancelar_todo(e) {
				func_cancelar_producto(null);
				$('#in_texto_proveedor').val('');
				$('#in_pcl_id_proveedor').val('');
				$('#in_texto_ruc').val('');
				$('#in_ing_fecha_doc_proveedor').val(get_fhoy());
				$('#in_ing_numero_doc_proveedor').val('');
				$('#in_ing_monto_efectivo').val('');
				$('#in_ing_monto_tar_credito').val('');
				$('#in_ing_monto_tar_debito').val('');
			}
			function func_agregar_producto(e) {
				var pro_id_producto = $('#in_pro_id_producto').val();
				if(pro_id_producto == '') {
					add_mensaje(null, '!!! ', ' Ingrese producto.', 'warning');
					return;
				}
				var valor = $('#in_valor').val();
				if(valor == '') {
					add_mensaje(null, '!!! ', ' Ingrese precio.', 'warning');
					return;
				}
				var cantidad = $('#in_cantidad').val();
				if(cantidad == '') {
					add_mensaje(null, '!!! ', ' Ingrese cantidad.', 'warning');
					return;
				}
				var numero_lote = $('#in_numero_lote').val();
				if(numero_lote == '') {
					add_mensaje(null, '!!! ', ' Ingrese #Lote.', 'warning');
					return;
				}
				var fecha_vencimiento = $('#in_fecha_vencimiento').val();
				if( !$('#in_fecha_vencimiento').prop('disabled') ) {
					if(fecha_vencimiento == '') {
						add_mensaje(null, '!!! ', ' Ingrese fecha de vencimiento.', 'warning');
						return;
					}
				}
				var data = {};
				data.pro_id_producto = pro_id_producto;
				data.valor = valor;
				data.cantidad = cantidad;
				data.numero_lote = numero_lote;
				data.fecha_vencimiento = fecha_vencimiento;
				$.ajax({
					type: "POST",
					url: BASE_URL+"movimiento/ingreso/detalle/agregar_producto",
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							add_mensaje(null, " Correcto. ", _msj_system[datos.estado], "success");
							func_cancelar_producto(null);
							$('#tb_ingreso_detalle').DataTable().ajax.reload();
						}
						else {
							add_mensaje(null, " Alerta. ", _msj_system[datos.estado], "warning");
						}
					}
				});
			}
			function func_quitar_producto(e) {
				var tr = $(e.target).closest('tr');
				var pro_id_producto = tr.find('input[name="pro_id_producto"]').val();
				var data = {};
				data.pro_id_producto = pro_id_producto;
				$.ajax({
					type: "POST",
					url: BASE_URL+"movimiento/ingreso/detalle/quitar_producto",
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							add_mensaje(null, " Correcto. ", _msj_system[datos.estado], "success");
							$('#tb_ingreso_detalle').DataTable().ajax.reload();
						}
						else {
							add_mensaje(null, " Alerta. ", _msj_system[datos.estado], "warning");
						}
					}
				});
			}
			
			function func_show_pago(e) {
				$('#a_panel_pago').tab('show');
			}
			function func_show_eleccion(e) {
				$('#a_panel_eleccion').tab('show');
			}
			
			function func_pagar_productos(e) {
				var pcl_id_proveedor = $('#in_pcl_id_proveedor').val();
				if(pcl_id_proveedor == '') {
					add_mensaje(null, '!!! ', ' Ingrese proveedor.', 'warning');
					return;
				}
				var ing_fecha_doc_proveedor = $('#in_ing_fecha_doc_proveedor').val();
				if(ing_fecha_doc_proveedor == '') {
					add_mensaje(null, '!!! ', ' Ingrese fecha.', 'warning');
					return;
				}
				var ing_numero_doc_proveedor = $('#in_ing_numero_doc_proveedor').val();
				if(ing_numero_doc_proveedor == '') {
					add_mensaje(null, '!!! ', ' Ingrese numero.', 'warning');
					return;
				}
				var data = {};
				data.pcl_id_proveedor = pcl_id_proveedor;
				data.ing_fecha_doc_proveedor = ing_fecha_doc_proveedor;
				data.tdo_id_tipo_documento = $('#sl_tdo_id_tipo_documento').val();
				data.ing_numero_doc_proveedor = ing_numero_doc_proveedor;
				data.ing_monto_efectivo = $('#in_ing_monto_efectivo').val();
				data.in_tipo = $('#in_tipo').val();
				if(data.ing_monto_efectivo == '') {
					data.ing_monto_efectivo = '0.00';
				}
				data.ing_monto_tar_credito = $('#in_ing_monto_tar_credito').val();
				if(data.ing_monto_tar_credito == '') {
					data.ing_monto_tar_credito = '0.00';
				}
				data.ing_monto_tar_debito = $('#in_ing_monto_tar_debito').val();
				if(data.ing_monto_tar_debito == '') {
					data.ing_monto_tar_debito = '0.00';
				}
				$.ajax({
					type: "POST",
					url: BASE_URL+"movimiento/ingreso/proveedor/registrar",
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							add_mensaje(null, " Correcto. ", _msj_system[datos.estado], "success");
							func_cancelar_todo(null);
							$('#tb_ingreso_detalle').DataTable().ajax.reload();
							func_show_eleccion(null);
						}
						else {
							add_mensaje(null, " Alerta. ", _msj_system[datos.estado], "warning");
						}
					}
				});
			}
			</script>
