<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<h1>
						Registro de Producto<small></small>
					</h1>
					<ol class="breadcrumb">
						<li>
							<a href="<?= base_url() ?>bienvenida"><i class="fa fa-home"></i> Home</a>
						</li>
						<li class="active">Mant Producto.</li>
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
									<li class="pull-left header"><i class="fa fa-atlas"></i> Productos.</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="dv_reporte">
										<div class="row">
											<div class="col-sm-12 box-body table-responsive">
												<p></p>
												<table class="table table-bordered table-hover" id="tb_producto">
													<thead>
														<tr>
															<th>CODIGO</th>
															<th>NOMBRE</th>
															<th>IMAGEN</th>
															<th>CLASE</th>
															<th>SUB-CLASE</th>
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
											<form class="form-horizontal" id="fm_producto">
												<div class="col-sm-6">
													<div class="form-group">
														<label for="" class="col-sm-4 control-label">NOMBRE <span class="text-danger">(R)</span></label>
														<div class="col-sm-6">
															<input type="text" id="in_pro_nombre" name="pro_nombre" class="form-control" value="" placeholder="Nombre">
														</div>
													</div>
													<div class="form-group">
														<label for="" class="col-sm-4 control-label">CODIGO <span class="text-danger">(R)</span></label>
														<div class="col-sm-6">
															<input type="text" id="in_pro_codigo" name="pro_codigo" class="form-control" value="" placeholder="Codigo">
															<p></p>
														</div>
														<div class="form-check col-sm-2">
																<input class="form-check-input" type="checkbox" name="aux__generar" id="in_aux__generar">
																<label class="form-check-label" for="in_aux__generar">Auto</label>
															</div>
													</div>
													<div class="form-group">
														<label for="" class="col-sm-4 control-label">CANTIDAD <span class="text-danger">(R)</span></label>
														<div class="col-sm-6">
															<input type="number" id="in_pro_cantidad" name="pro_cantidad" class="form-control" value="0.00" placeholder="Cantidad">
														</div>
													</div>
													<div class="form-group">
														<label for="" class="col-sm-4 control-label">CANTIDAD MIN <span class="text-danger">(R)</span></label>
														<div class="col-sm-6">
															<input type="number" id="in_pro_cantidad_min" name="pro_cantidad_min" class="form-control" value="0.00" placeholder="Cantidad-minima">
														</div>
													</div>
													<div class="form-group">
														<label for="" class="col-sm-4 control-label">VALOR COMPRA<span class="text-danger">(R)</span></label>
														<div class="col-sm-6">
															<input type="number" id="in_pro_val_compra" name="pro_val_compra" class="form-control" value="0.00" placeholder="Val-compra">
														</div>
													</div>
													<div class="form-group">
														<label for="" class="col-sm-4 control-label">VALOR VENTA <span class="text-danger">(R)</span></label>
														<div class="col-sm-6">
															<input type="number" id="in_pro_val_venta" name="pro_val_venta" class="form-control" value="0.00" placeholder="Val-venta">
														</div>
													</div>
													<div class="form-group">
														<label for="" class="col-sm-4 control-label">VALOR OFERTA</label>
														<div class="col-sm-6">
															<input type="number" id="in_pro_val_oferta" name="pro_val_oferta" class="form-control" value="0.00" placeholder="Val-oferta">
														</div>
													</div>
												</div>
												
												<div class="col-sm-6">
													<div class="form-group">
														<label for="" class="col-sm-4 control-label">ESTADO</label>
														<div class="col-sm-6">
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
													<div class="form-group">
														<label for="" class="col-sm-4 control-label">PERECIBLE</label>
														<div class="col-sm-6">
															<select class="form-control" id="in_pro_perecible">
																
																<option value="SI">SI</option>
																<option value="NO">NO</option>
															</select>
														</div>
													</div>
													<div class="form-group">
														<label for="" class="col-sm-4 control-label">CLASE <span class="text-danger">(R)</span></label>
														<div class="col-sm-6">
															<select id="in_cla_clase" name="cla_clase" class="form-control" onchange="func_clase_change(null)">
															</select>
														</div>
													</div>
													<div class="form-group">
														<label for="" class="col-sm-4 control-label">SUBCLASE <span class="text-danger">(R)</span></label>
														<div class="col-sm-6">
															<select id="in_cla_subclase" name="cla_subclase" class="form-control">
															</select>
														</div>
													</div>
													<div class="form-group">
														<label for="" class="col-sm-4 control-label">UNI. MEDIDA <span class="text-danger">(R)</span></label>
														<div class="col-sm-6">
															<select class="form-control" id="in_unm_id_unidad_medida">
															</select>
														</div>
													</div>
													<div class="form-group">
														<label for="" class="col-sm-4 control-label">SUBIR IMAGEN:</label>
														<input type="hidden" class="form-control" name="pro_foto" id="in_pro_foto" placeholder="Imagen ...">
														<div class="col-sm-6">
															<button type="button" class="btn btn-primary" onclick="$('#in_foto').click();"><i class="fa fa-image"></i> Subir</button>
															<span id="span_foto">...</span>
															<input type="file" style="display: none;" id="in_foto" name="foto"/>
															<p></p>
															<div class="pull-left image">
																<img src="" class="img-circle" alt="User Image" style="max-width: 100px; height: 100px;" id="img_foto">
															</div>
															
														</div>
													</div>
												</div>
												<p><label class="control-label">VALORES POR MAYOR(precio se activa al superar la cantidad.)</label></p>
												<hr>
												<div class="form-group">
													<label for="in_pro_xm_cantidad1" class="col-sm-2 control-label">CANTIDAD 1</label>
													<div class="col-sm-3">
														<input type="number" id="in_pro_xm_cantidad1" name="pro_xm_cantidad1" class="form-control" value="0.00" placeholder="Cantidad">
													</div>
													
													<label for="in_pro_xm_valor1" class="col-sm-2 control-label">VALOR 1</label>
													<div class="col-sm-3">
														<input type="number" id="in_pro_xm_valor1" name="pro_xm_valor1" class="form-control" value="0.00" placeholder="Valor">
													</div>
												</div>
												<div class="form-group">
													<label for="in_pro_xm_cantidad2" class="col-sm-2 control-label">CANTIDAD 2</label>
													<div class="col-sm-3">
														<input type="number" id="in_pro_xm_cantidad2" name="pro_xm_cantidad2" class="form-control" value="0.00" placeholder="Cantidad">
													</div>
													
													<label for="in_pro_xm_valor2" class="col-sm-2 control-label">VALOR 2</label>
													<div class="col-sm-3">
														<input type="number" id="in_pro_xm_valor2" name="pro_xm_valor2" class="form-control" value="0.00" placeholder="Valor">
													</div>
												</div>
												<div class="form-group">
													<label for="in_pro_xm_cantidad3" class="col-sm-2 control-label">CANTIDAD 3</label>
													<div class="col-sm-3">
														<input type="number" id="in_pro_xm_cantidad3" name="pro_xm_cantidad3" class="form-control" value="0.00" placeholder="Cantidad">
													</div>
													
													<label for="in_pro_xm_valor3" class="col-sm-2 control-label">VALOR 3</label>
													<div class="col-sm-3">
														<input type="number" id="in_pro_xm_valor3" name="pro_xm_valor3" class="form-control" value="0.00" placeholder="Valor">
													</div>
												</div>
												<hr>
												<div class="form-group">
													<label for="" class="col-sm-2 control-label">&nbsp;&nbsp;&nbsp;</label>
													<div class="col-sm-3">
														<input type="hidden" name="pro_id_producto" id="in_pro_id_producto" value="">
														<button type="button" class="btn btn-primary" onclick="guardar();" id="btn-altas"><i class="fa fa-check-circle"></i> Guardar Producto</button>
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
			function get_codigo_generado() {
				var texto = '';
				var fecha = new Date();
				var anho = fecha.getFullYear().toString().substr(-2);
				var mes = ("0" + (fecha.getMonth() + 1)).slice(-2);
				var dia = ("0" + fecha.getDate()).slice(-2);
				var hora = ("0" + fecha.getHours()).slice(-2);
				var minuto = ("0" + fecha.getMinutes()).slice(-2);
				var segundo = ("0" + fecha.getSeconds()).slice(-2);
				texto = anho+mes+dia+hora+minuto+segundo;
				return texto;
			}
			function init_producto() {
				$('#in_aux__generar').change(function() {
					if($(this).is(":checked")) {
						$('#in_pro_codigo').prop('disabled', true);
						$('#in_pro_codigo').val(get_codigo_generado());
					}
					else {
						$("#in_pro_codigo").prop('disabled',false);
					}
				});
				
				preparar_subida_archivo(
					'in_foto',
					'img_foto',
					'in_pro_foto',
					'span_foto',
					"<?php echo base_url(); ?>util/archivo/subir_imagen",
					"<?php echo base_url(); ?>",
					"<?php echo base_url(); ?>../resources/sy_file_repository/img_vacio.png"
				);
				
				$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
					var target = $(e.target).attr("href");
					if(target === '#dv_registro') {
						$('#in_pro_id_producto').val('');
						$('#in_pro_cantidad').prop('disabled', false);
						func_reload(null, null, null);
						$('#span_foto').empty();
						$('#span_foto').append('...');
						$('#img_foto').attr("src", '');
						$('#fm_producto')[0].reset();
					}
					else if(target === '#dv_reporte') {
						$('#tb_producto').DataTable().ajax.reload();
					}
				});
				
				var id_tabla = "tb_producto";
				var url = "<?php echo base_url(); ?>mantenimiento/producto/buscar_xll";
				var data = [];
				var columns = [
					{data: "pro_codigo"},
					{data: "pro_nombre"},
					{
						data: null,
						"render": function ( data, type, full, meta ) {
							return '<div class="pull-left image">'+
								'<img src="'+BASE_URL+'../resources/sy_file_repository/'+full.pro_foto+'" class="img-circle zoom" alt="Producto Imagen" style="max-width: 50px; height: auto;" onerror="func_img_error(event);">'+
								'</div>';
						}
					},
					{data: "clase_nombre"},
					{data: "subclase_nombre"},
					{data: "est_nombre"},
					{
						data: null,
						"render": function ( data, type, full, meta ) {
							return '<button  type="button" class="btn btn-warning btn-xs boton_hhh" onclick="mostrar(event)"><span class="glyphicon glyphicon-edit span_hhh" aria-hidden="true"> Editar</span></button>'+
								'<input type="hidden" name="pro_codigo" value="'+full.pro_codigo+'">'+
								'<input type="hidden" name="cla_clase" value="'+full.cla_clase+'">'+
								'<input type="hidden" name="cla_subclase" value="'+full.cla_subclase+'">'+
								'<input type="hidden" name="pro_nombre" value="'+full.pro_nombre+'">'+
								'<input type="hidden" name="pro_val_compra" value="'+full.pro_val_compra+'">'+
								'<input type="hidden" name="pro_val_venta" value="'+full.pro_val_venta+'">'+
								'<input type="hidden" name="pro_cantidad" value="'+full.pro_cantidad+'">'+
								'<input type="hidden" name="pro_cantidad_min" value="'+full.pro_cantidad_min+'">'+
								'<input type="hidden" name="unm_id_unidad_medida" value="'+full.unm_id_unidad_medida+'">'+
								'<input type="hidden" name="pro_foto" value="'+full.pro_foto+'">'+
								'<input type="hidden" name="pro_perecible" value="'+full.pro_perecible+'">'+
								'<input type="hidden" name="est_id_estado" value="'+full.est_id_estado+'">'+
								'<input type="hidden" name="pro_xm_cantidad1" value="'+full.pro_xm_cantidad1+'">'+
								'<input type="hidden" name="pro_xm_valor1" value="'+full.pro_xm_valor1+'">'+
								'<input type="hidden" name="pro_xm_cantidad2" value="'+full.pro_xm_cantidad2+'">'+
								'<input type="hidden" name="pro_xm_valor2" value="'+full.pro_xm_valor2+'">'+
								'<input type="hidden" name="pro_xm_cantidad3" value="'+full.pro_xm_cantidad3+'">'+
								'<input type="hidden" name="pro_xm_valor3" value="'+full.pro_xm_valor3+'">'+
								'<input type="hidden" name="pro_val_oferta" value="'+full.pro_val_oferta+'">'+
								'<input type="hidden" name="pro_id_producto" value="'+full.pro_id_producto+'">';
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
			function func_img_error(e) {
				var img = $(e.target);
				var ruta_foto = "<?php echo base_url(); ?>../resources/sy_file_repository/img_vacio.png";
				img.attr( "src",  ruta_foto);
			}
			function mostrar(e) {
				var tr = $(e.target).closest('tr');
				$('#a_registro').tab('show');
				var pro_codigo = tr.find('input[name="pro_codigo"]').val();
				var cla_clase = tr.find('input[name="cla_clase"]').val();
				var cla_subclase = tr.find('input[name="cla_subclase"]').val();
				var unm_id_unidad_medida = tr.find('input[name="unm_id_unidad_medida"]').val();
				func_reload(cla_clase, cla_subclase, unm_id_unidad_medida);
				var pro_nombre = tr.find('input[name="pro_nombre"]').val();
				var pro_val_compra = tr.find('input[name="pro_val_compra"]').val();
				var pro_val_venta = tr.find('input[name="pro_val_venta"]').val();
				var pro_cantidad = tr.find('input[name="pro_cantidad"]').val();
				var pro_cantidad_min = tr.find('input[name="pro_cantidad_min"]').val();
				var pro_foto = tr.find('input[name="pro_foto"]').val();
				var pro_perecible = tr.find('input[name="pro_perecible"]').val();
				var est_id_estado = tr.find('input[name="est_id_estado"]').val();
				var pro_xm_cantidad1 = tr.find('input[name="pro_xm_cantidad1"]').val();
				var pro_xm_valor1 = tr.find('input[name="pro_xm_valor1"]').val();
				var pro_xm_cantidad2 = tr.find('input[name="pro_xm_cantidad2"]').val();
				var pro_xm_valor2 = tr.find('input[name="pro_xm_valor2"]').val();
				var pro_xm_cantidad3 = tr.find('input[name="pro_xm_cantidad3"]').val();
				var pro_xm_valor3 = tr.find('input[name="pro_xm_valor3"]').val();
				var pro_val_oferta = tr.find('input[name="pro_val_oferta"]').val();
				var pro_id_producto = tr.find('input[name="pro_id_producto"]').val();
				$("#in_pro_codigo").val(pro_codigo);
				$("#in_pro_nombre").val(pro_nombre);
				$("#in_pro_val_compra").val(pro_val_compra);
				$("#in_pro_val_venta").val(pro_val_venta);
				$("#in_pro_cantidad").prop('disabled', true);
				$("#in_pro_cantidad").val(pro_cantidad);
				$("#in_pro_cantidad_min").val(pro_cantidad_min);
				$("#in_pro_foto").val(pro_foto);
				$('#img_foto').attr("src", BASE_URL+'../resources/sy_file_repository/'+pro_foto);
				$('#in_pro_perecible').val(pro_perecible);
				$("#in_est_id_estado").val(est_id_estado);
				$("#in_pro_xm_cantidad1").val(pro_xm_cantidad1);
				$("#in_pro_xm_valor1").val(pro_xm_valor1);
				$("#in_pro_xm_cantidad2").val(pro_xm_cantidad2);
				$("#in_pro_xm_valor2").val(pro_xm_valor2);
				$("#in_pro_xm_cantidad3").val(pro_xm_cantidad3);
				$("#in_pro_xm_valor3").val(pro_xm_valor3);
				$("#in_pro_val_oferta").val(pro_val_oferta);
				$("#in_pro_id_producto").val(pro_id_producto);
			}
			function eliminar(e) {
				var tr = $(e.target).closest('tr');
				var pro_id_producto = tr.find('input[name="pro_id_producto"]').val();
				var data = {};
				data.pro_id_producto = pro_id_producto;
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>mantenimiento/producto/eliminar",
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							$('#tb_producto').DataTable().ajax.reload();
							add_mensaje(null, " Correcto. ", ' eliminado.', "success");
						}
					}
				});
			}
			function guardar() {
				var msj = "";
				msj = isvoid_mensaje("in_pro_codigo", "codigo");
				msj += isvoid_mensaje("in_pro_nombre", "nombre");
				msj += isvoid_mensaje("in_pro_val_compra", "valor compra");
				msj += isvoid_mensaje("in_pro_val_venta", "valor venta");
				msj += isvoid_mensaje("in_pro_cantidad", "cantidad");
				msj += isvoid_mensaje("in_pro_cantidad_min", "cantidad minima");
				msj += isvoid_mensaje("in_unm_id_unidad_medida", "unidad de medida");
				if(msj != '') {
					add_mensaje(null,
						'<i class="fa fa-warning"></i> ',
						msj,
						'warning ');
					return;
				}
				var pro_id_producto = $("#in_pro_id_producto").val();
				var accion = "actualizar";
				if(pro_id_producto == '') {
					accion = "registrar";
				}
				var data = {};
				data.pro_codigo = $("#in_pro_codigo").val();
				data.cla_clase = $("#in_cla_clase").val();
				data.cla_subclase = $("#in_cla_subclase").val();
				data.pro_nombre = $("#in_pro_nombre").val();
				data.pro_val_compra = $("#in_pro_val_compra").val();
				data.pro_val_venta = $("#in_pro_val_venta").val();
				data.pro_cantidad = $("#in_pro_cantidad").val();
				data.pro_cantidad_min = $("#in_pro_cantidad_min").val();
				data.unm_id_unidad_medida = $("#in_unm_id_unidad_medida").val();
				data.pro_foto = $("#in_pro_foto").val();
				data.pro_perecible = $("#in_pro_perecible").val();
				data.est_id_estado = $("#in_est_id_estado").val();
				data.pro_xm_cantidad1 = $("#in_pro_xm_cantidad1").val();
				data.pro_xm_valor1 = $("#in_pro_xm_valor1").val();
				data.pro_xm_cantidad2 = $("#in_pro_xm_cantidad2").val();
				data.pro_xm_valor2 = $("#in_pro_xm_valor2").val();
				data.pro_xm_cantidad3 = $("#in_pro_xm_cantidad3").val();
				data.pro_xm_valor3 = $("#in_pro_xm_valor3").val();
				data.pro_val_oferta = $("#in_pro_val_oferta").val();
				data.pro_id_producto = pro_id_producto;
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>mantenimiento/producto/"+accion,
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							$('#a_reporte').tab('show');
							add_mensaje(null, " Correcto. ", ' datos guardados.', "success");
						}
					}
				});
			}
			
			function func_reload(cla_clase, cla_subclase, unm_id_unidad_medida) {
				if(cla_clase == null) {
					cla_clase = '';
				}
				if(unm_id_unidad_medida == null) {
					unm_id_unidad_medida = '';
				}
				
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>mantenimiento/clase/buscar_xll_habilitados",
					dataType: 'json',
					success: function(datos) {
						if(datos.hecho == 'SI') {
							var select = $('#in_cla_clase');
							select.empty();
							vlista_clases = [];
							datos.list_clase.forEach(function(clase) {
								var selected = '';
								if(cla_clase == clase.cla_id_clase) {
									selected = 'selected';
								}
								if(clase.cla_id_clase_superior == '') {
									select.append('<option value="'+clase.cla_id_clase+'" '+selected+'>'+clase.cla_nombre+'</option>');
								}
								else {
									vlista_clases.push({cla_id_clase: clase.cla_id_clase, 
										cla_nombre: clase.cla_nombre,
										cla_id_clase_superior: clase.cla_id_clase_superior
									});
								}
							});
							func_clase_change(cla_subclase);
						}
					}
				});
				
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>mantenimiento/unidad_medida/buscar_xll_habilitados",
					dataType: 'json',
					success: function(datos) {
						if(datos.hecho == 'SI') {
							var select = $('#in_unm_id_unidad_medida');
							select.empty();
							datos.list_unidad_medida.forEach(function(unidad_medida) {
								var selected = '';
								if(unm_id_unidad_medida == unidad_medida.unm_id_unidad_medida) {
									selected = 'selected';
								}
								select.append('<option value="'+unidad_medida.unm_id_unidad_medida+'" '+selected+'>'+unidad_medida.unm_nombre_corto+'</option>');
							});
						}
					}
				});
			}
			function func_clase_change(cla_subclase) {
				if(cla_subclase == null) {
					cla_subclase = '';
				}
				var cla_clase = $('#in_cla_clase').val();
				var select = $('#in_cla_subclase');
				select.empty();
				vlista_clases.forEach(function(clase) {
					var selected = '';
					if(cla_subclase == clase.cla_id_clase) {
						selected = 'selected';
					}
					if(cla_clase == clase.cla_id_clase_superior) {
						select.append('<option value="'+clase.cla_id_clase+'" '+selected+'>'+clase.cla_nombre+'</option>');
					}
				});
			}
			var vlista_clases = [];
			</script>
