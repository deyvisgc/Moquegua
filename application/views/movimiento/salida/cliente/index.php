z<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<h1>
						Registro de Venta<small></small>
					</h1>
					<ol class="breadcrumb">
						<li>
							<a href="<?= base_url() ?>bienvenida"><i class="fa fa-home"></i> Home</a>
						</li>
						<li class="active">Mov. Venta.</li>
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
																<span class="input-group-addon bg-gray">Precio:</span>
																<input type="text" class="form-control precios" id="in_valor" style="font-size: 20px; text-align: right; color: blue; font-weight: bold;" data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 3, 'digitsOptional': false, 'placeholder': '0'">
															</div>
															<p></p>
															<div class="input-group">
																<span class="input-group-addon bg-gray">Cantidad:</span>
																<input type="number" class="form-control cantidades" id="in_cantidad" style="font-size: 20px; text-align: right; color: blue; font-weight: bold;" data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'">
															</div>
															<p></p>
															<div class="input-group">
																<span class="input-group-addon bg-gray">PRECIO COMPRA:</span>
																<input type="number" readonly="readonly" class="form-control cantidades" id="pre_compra" style="font-size: 20px; text-align: right; color: blue; font-weight: bold;" data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'">
																															<input type="hidden" hidden value="<?php echo mt_rand(400,1000000);?>" name="n_orden" id="n_orden"  class="form-control">

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
																		<h5 class="description-header preciol"><div id="sp_precio_unitario">0.00</div></h5>
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
															<h3><div>S/. <span id="total" class="sp_sum_total">0.00</span></div></h3>
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
														<button class="btn  btn-success" id="bt_show_pago" onclick="cargarAnonim();" disabled=""><i class="fa fa-money"></i> Pagar</button>
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
															<table id="tb_salida_detalle" class="table table-hover">
																<thead>
																	<tr>
																		<th>Codigo</th>
																		<th>Descripcion</th>
																		<th>U. M.</th>
																		<th>Cantidad</th>
																		<th>Precio</th>
																		<th>Monto</th>
																		<th>Ganancias</th>
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
																<span class="input-group-addon bg-gray">Cliente <i class="fa fa-search"></i></span>
																<input type="text" class="form-control cliente" id="in_texto_cliente" style="font-size: 20px; text-align: right; color: blue; font-weight: bold;" data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" disabled="">
																<input type="hidden" id="in_pcl_id_cliente" value="">
															</div>
															<p></p>
															<div class="input-group">
																<span class="input-group-addon bg-gray">RUC <i class="fa fa-search"></i></span>
																<input type="text" class="form-control ruc" id="in_texto_ruc" style="font-size: 20px; text-align: right; color: blue; font-weight: bold;" data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" disabled="">
															</div>
															<p></p>
															<div class="input-group">
																<span class="input-group-addon bg-gray">Fecha <i class="fa fa-calendar"></i></span>
																<input type="date" class="form-control fecha" id="in_sal_fecha_doc_cliente" style="font-size: 20px; text-align: right; color: blue; font-weight: bold;" data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" disabled="">
															</div>
															<p></p>
															<div class="input-group">
																<span class="input-group-addon bg-gray">Documento <i class="fa fa-file"></i></span>
																<select class="form-control custom-select" id="sl_tdo_id_tipo_documento" disabled=""></select>
															</div>
															<p></p>
															<div class="input-group">
																<span class="input-group-addon bg-gray">Numero <i class="fa fa-barcode"></i></span>
																<input type="text" class="form-control numero" id="in_sal_numero_doc_cliente" style="font-size: 20px; text-align: right; color: blue; font-weight: bold;" data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" disabled="">
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
																<input type="number" class="form-control descuento" id="in_sal_monto_efectivo" onkeyup="calcularvuelto();" style="font-size: 20px; text-align: right; color: blue; font-weight: bold;" data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" value="" placeholder="0.00" disabled="">
															</div>
															<p></p>
															<div class="input-group">
																<span class="input-group-addon bg-gray">Debito  S/. <i class="fa fa-credit-card"></i></span>
																<input type="number" class="form-control descuento" id="in_sal_monto_tar_credito" style="font-size: 20px; text-align: right; color: blue; font-weight: bold;" data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" value="" placeholder="0.00" disabled="">
															</div>
															<p></p>
															<div class="input-group">
																<span class="input-group-addon bg-gray">Credito  S/. <i class="fa fa-credit-card"></i></span>
																<input type="number" class="form-control descuento" id="in_sal_monto_tar_debito" style="font-size: 20px; text-align: right; color: blue; font-weight: bold;" data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" value="" placeholder="0.00" disabled="">
															</div>
															<p></p>
															<div class="input-group">
																<span class="input-group-addon bg-gray">Descuento S/. <i class="fa fa-money"></i></span>
																<input type="number" class="form-control descuento" id="in_sal_descuento" style="font-size: 20px; text-align: right; color: blue; font-weight: bold;" data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" value="" placeholder="0.00" disabled="">
															</div>
															<p></p>
															<div class="input-group">
																<span class="input-group-addon bg-gray">Motivo </span>
																<input type="text" class="form-control motivo" id="in_sal_motivo" style="font-size: 20px; text-align: right; color: blue; font-weight: bold;" data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" disabled="">
															</div>
                                                            <p></p>
															<div class="input-group">
																<span class="input-group-addon bg-gray">Vuelto</span>
																<input   type="number" class="form-control vuelto" id="vuelto" style="font-size: 20px; text-align: right; color: blue; font-weight: bold;" data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" placeholder="0.00" readonly="readonly">
															</div>
															<p></p>
                                                            <div class="input-group">
                                                                <span class="input-group-addon bg-gray">Tipo de Venta </span>
                                                                <select class="form-control custom-select" id="t_venta" name="t_venta">
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
					<div id="dv_contenedor_impresion" ></div>
				</section><!-- /.content -->
			</div><!-- /.content-wrapper -->
			
			<script>

				function calcularvuelto(){
					var pago=document.getElementById('in_sal_monto_efectivo').value;
					var vuelto=$('#total').html();
					var pagototal=parseFloat(pago)-parseFloat(vuelto);
					$('#vuelto').val(pagototal.toFixed(2));

				}
			function init_salida() {
				$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
					var target = $(e.target).attr("href");
					if(target === '#dv_panel_pago') {
						$('#sl_tdo_id_tipo_documento').change();
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
				$('#in_texto_cliente').prop('disabled', false);
				$('#in_texto_ruc').prop('disabled', false);
				$('#in_sal_fecha_doc_cliente').prop('disabled', false);
				$('#in_sal_fecha_doc_cliente').val(get_fhoy());
				$('#sl_tdo_id_tipo_documento').prop('disabled', false);
				$('#in_sal_monto_efectivo').prop('disabled', false);
				$('#in_sal_monto_tar_credito').prop('disabled', false);
				$('#in_sal_monto_tar_debito').prop('disabled', false);
				$('#in_sal_descuento').prop('disabled', false);
				$('#in_sal_motivo').prop('disabled', false);
				
				$( "#in_descripcion" ).autocomplete({
					source: function( request, response ) {
						$.ajax( {
							url: BASE_URL+'movimiento/salida/detalle/buscar_productos_x_descripcion',
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
						$('#in_valor').val(ui.item.pro_val_venta);
						$('#pre_compra').val(ui.item.pro_val_compra);
						$('#in_cantidad').prop('disabled', false);
						$('#in_cantidad').val('');
						$('#in_pro_id_producto').val(ui.item.pro_id_producto);
						var img_src = BASE_URL+'../resources/sy_file_repository/'+ui.item.pro_foto;
						$('#img_foto').attr("src", img_src);
						var texto_valor = '';
						if(ui.item.pro_val_oferta > 0) {
							texto_valor = ui.item.pro_val_oferta+' O';
						}
						else {
							texto_valor = ui.item.pro_val_venta;
							if(ui.item.pro_xm_cantidad1 > 0 && ui.item.pro_xm_valor1 > 0){
								texto_valor += '<br> '+ui.item.pro_xm_valor1+' #1';
							}
							if(ui.item.pro_xm_cantidad2 > 0 && ui.item.pro_xm_valor2 > 0){
								texto_valor += '<br> '+ui.item.pro_xm_valor2+' #2';
							}
							if(ui.item.pro_xm_cantidad3 > 0 && ui.item.pro_xm_valor3 > 0){
								texto_valor += '<br> '+ui.item.pro_xm_valor3+' #3';
							}
						}
						$('#sp_precio_unitario').empty();
						$('#sp_precio_unitario').append(texto_valor);
						$('#sp_uni_med_nombre').text(ui.item.unm_nombre_corto);
						$('#sp_stock').text(ui.item.pro_cantidad);
					}
				});
				
				$( "#in_texto_cliente, #in_texto_ruc" ).autocomplete({
					source: function( request, response ) {
						$.ajax( {
							url: BASE_URL+'movimiento/salida/detalle/buscar_cliente',
							dataType: "json",
							type: "POST",
							data: {
								texto: request.term
							},
							success: function( data ) {
								response( data.list_cliente );
							}
						} );
					},
					delay: 900,
					minLength: 1,
					select: function( event, ui ) {
						$('#in_texto_cliente').val(ui.item.emp_razon_social);
						$('#in_texto_ruc').val(ui.item.emp_ruc);
						$('#in_pcl_id_cliente').val(ui.item.pcl_id_pcliente);
						return false;
					}
				});
				
				var objeto = {
					ajax : {
						url: BASE_URL+'movimiento/salida/detalle/buscar_productos_elejidos',
						type: 'POST',
						data: {},
						"dataSrc": function ( json ) {
							$('.sp_count_productos').text(json.tventa.count_productos);
							$('.sp_sum_total').text(json.tventa.sum_total);
							return json.data;
						}
					},
					columns : [
						{data: "codigo"},
						{data: "descripcion"},
						{data: "uni_med"},
						{data: "cantidad"},
						{data: "precio"},
						{data: "total"},
						{data: "ganancias"},
						{
							data: null,
							"render": function ( data, type, full, meta ) {
								return '<button class="btn btn-danger  btn-sm" type="button" onclick="func_quitar_producto(event)"><i class="fa fa-times" aria-hidden="true"></i> Quitar</button>'+
		'<input type="hidden" name="pro_id_producto" value="'+full.pro_id_producto+'">'+'<input type="hidden" name="n_orden" value="'+full.n_orden+'">';
							}
						}
					],
					ordering: false,
					searching: false,
					info: false,
					paging: false
				};
				generar_data_table('tb_salida_detalle', objeto);
				
				$('#bt_cancelar_producto').click(func_cancelar_producto);
				$('#bt_agregar_producto').click(func_agregar_producto);
				$('#bt_show_pago').click(func_show_pago);
				$('#sl_tdo_id_tipo_documento').change(func_change_documento);
				$('#bt_pagar_productos').click(func_pagar_productos);
				add_mensaje(null, 'OK ', ' Ingrese sus productos.', 'info');
				func_reload_salcombo();
			}
			
			function func_reload_salcombo() {
				$.ajax({
					type: "POST",
					url: BASE_URL+"movimiento/salida/detalle/reload_salcombo",
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
			function func_change_documento(e) {
				var tdo_id_tipo_documento = $('#sl_tdo_id_tipo_documento').val();
				$.ajax({
					type: "POST",
					url: BASE_URL+"movimiento/salida/detalle/get_nro_documento",
					dataType: 'json',
					data: {tdo_id_tipo_documento: tdo_id_tipo_documento},
					success: function(datos) {
						if(datos.hecho == 'SI') {
							$('#in_sal_numero_doc_cliente').val(datos.row.numero);
						}
					}
				});
			}
			
			function func_cancelar_producto(e) {
				$('#in_descripcion').val('');
				$('#in_valor').val('');
				$('#pre_compra').val('');
				$('#in_cantidad').prop('disabled', false);
				$('#in_cantidad').val('');
				$('#in_pro_id_producto').val('');
				$('#img_foto').attr("src", BASE_URL+'../resources/sy_file_repository/img_vacio.png');
				$('#sp_precio_unitario').empty();
				$('#sp_precio_unitario').append('0.00');
				$('#sp_uni_med_nombre').text('...');
				$('#sp_stock').text('0.00');
			}
			function func_cancelar_todo(e) {
				func_cancelar_producto(null);
				$('#in_texto_cliente').val('');
				$('#in_pcl_id_cliente').val('');
				$('#in_texto_ruc').val('');
				$('#in_sal_fecha_doc_cliente').val(get_fhoy());
				$('#in_sal_monto_efectivo').val('');
				$('#in_sal_monto_tar_credito').val('');
				$('#in_sal_monto_tar_debito').val('');
				$('#in_sal_descuento').val('');
				$('#in_sal_motivo').val('');
			}
			function func_agregar_producto(e) {
				var pro_id_producto = $('#in_pro_id_producto').val();
				var cantidad = document.getElementById('in_cantidad').value;
				var precio = $('#in_valor').val();
				var pagventa=document.getElementById('in_valor').value;
				var pagcompra=document.getElementById('pre_compra').value;
				var ganancias=parseFloat(pagventa)-parseFloat(pagcompra);
				var ganancia1=parseFloat(ganancias)*cantidad;
			    var totalganancia= parseFloat(ganancia1).toFixed(2);
			    var n_orden =$('#n_orden').val();

				if(pro_id_producto == '') {
					add_mensaje(null, '!!! ', ' Ingrese producto.', 'warning');
					return;
				}
				if(cantidad == '') {
					add_mensaje(null, '!!! ', ' Ingrese cantidad.', 'warning');
					return;
				}
				if(precio == '') {
					add_mensaje(null, '!!! ', ' Ingrese cantidad.', 'warning');
					return;
				}
				var data = {};
				data.pro_id_producto = pro_id_producto;
				data.cantidad = cantidad;
				data.precio=precio;
				data.totalganancia=totalganancia;
				data.n_orden =n_orden;
				
				$.ajax({
					type: "POST",
					url: BASE_URL+"movimiento/salida/detalle/agregar_producto",
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
						var num_orden;
							num_orden = Math.round(Math.random()*100);
							$('#n_orden').val(num_orden);
							add_mensaje(null, " Correcto. ", _msj_system[datos.estado], "success");
							func_cancelar_producto(null);
							$('#tb_salida_detalle').DataTable().ajax.reload();
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
				var n_orden= tr.find('input[name="n_orden"]').val();
				var data = {};
				data.pro_id_producto = pro_id_producto;
				data.n_orden= n_orden;
				
				$.ajax({
					type: "POST",
					url: BASE_URL+"movimiento/salida/detalle/quitar_producto",
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							add_mensaje(null, " Correcto. ", ' producto quito.', "success");
							$('#tb_salida_detalle').DataTable().ajax.reload();
						}
						else {
							add_mensaje(null, " Alerta. ", ' error ocurrente.', "warning");
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
				var pcl_id_cliente = $('#in_pcl_id_cliente').val();
				var montotal=$('.sp_sum_total').html();
				var pagot=$('#in_sal_monto_efectivo').val();


				if(pcl_id_cliente == '') {
					add_mensaje(null, '!!! ', ' Ingrese cliente.', 'warning');
					return;
				}
				var sal_fecha_doc_cliente = $('#in_sal_fecha_doc_cliente').val();
				if(sal_fecha_doc_cliente == '') {
					add_mensaje(null, '!!! ', ' Ingrese cantidad.', 'warning');
					return;
				}
				

				var data = {};
				data.pcl_id_cliente = pcl_id_cliente;
				data.sal_fecha_doc_cliente = sal_fecha_doc_cliente;
				data.tdo_id_tipo_documento = $('#sl_tdo_id_tipo_documento').val();
				data.sal_monto_efectivo = $('#in_sal_monto_efectivo').val();
				data.t_venta = $('#t_venta').val();
				data.sal_vuelto=$('#vuelto').val();

				if(data.sal_monto_efectivo == '') {
					data.sal_monto_efectivo = '0.00';
				}
				data.sal_monto_tar_credito = $('#in_sal_monto_tar_credito').val();
				if(data.sal_monto_tar_credito == '') {
					data.sal_monto_tar_credito = '0.00';
				}
				data.sal_monto_tar_debito = $('#in_sal_monto_tar_debito').val();
				if(data.sal_monto_tar_debito == '') {
					data.sal_monto_tar_debito = '0.00';
				}
				data.sal_descuento = $('#in_sal_descuento').val();
				if(data.sal_descuento == '') {
					data.sal_descuento = '0.00';
				}
				data.sal_motivo = $('#in_sal_motivo').val();
				$.ajax({
					type: "POST",
					url: BASE_URL+"movimiento/salida/cliente/registrar",
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							add_mensaje(null, " Correcto. ", _msj_system[datos.estado], "success");
							func_cancelar_todo(null);
							$('#tb_salida_detalle').DataTable().ajax.reload();
							func_show_eleccion(null);
							func_mostrar_documento(datos.sal_id_salida);
						}
						else {
							add_mensaje(null, " Alerta. ", _msj_system[datos.estado], "warning");
						}
						$('#vuelto').val("");
					}
				});
			}

			function func_mostrar_documento(sal_id_salida) {
				var data = {};
				data.sal_id_salida = sal_id_salida;
				$.ajax({
					type: "POST",
					url: BASE_URL+"movimiento/salida/cliente/mostrar_documento",
					data: data,
					success: function(datos) {
						$('#dv_contenedor_impresion').empty();
						$('#dv_contenedor_impresion').append(datos);
						func_imprimir();
					}
				});
			}
			     function cargarAnonim(){
                $.ajax({
                    url: BASE_URL+"movimiento/salida/detalle/cargarAnonimo",
                    type: "POST",
                    dataType: 'json',
                    success: function(response) {
                        $.each(response,function (index,valor) {
                            $('#in_texto_cliente').val(valor.emp_razon_social);
                            $('#in_texto_ruc').val(valor.emp_ruc);
                            $('#in_pcl_id_cliente').val(valor.pcl_id_pcliente);
                        });
                    }
                });
            }


			function func_imprimir() {
				var divToPrint = document.getElementById('dv_contenedor_impresion');
				var newWin = window.open('','Print-Window');
				newWin.document.open();
				newWin.document.write('<ht'+'ml><bo'+'dy onload="window.print()">'+divToPrint.innerHTML+'</'+'bo'+'dy></'+'ht'+'ml>');
				newWin.document.close();
				setTimeout(function(){
					newWin.close();
				}, 10);
			}
			</script>
