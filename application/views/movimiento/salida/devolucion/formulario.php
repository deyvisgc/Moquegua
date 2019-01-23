		<div class="container" >
		</div>
		<div class="container" style="position: absolute; margin-top: 250px;" id="dv_marco_salida_cliente">
			
			<h3>INGRESO CLIENTE</h3>
			<hr>
			<div class="form-group">
				<label for="in_pcl_id_cliente">Cliente</label>
				<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
				<a href="javascript: mostrar_marco_cliente()" >Registrar</a>
				<select id="in_pcl_id_cliente" name="pcl_id_cliente" class="form-control" onchange="func_cliente_change(event)">
					<?php
					foreach ($list_pcliente as $valor) {
						$opcion = "";
						if($valor->pcl_id_pcliente == $salida->pcl_id_cliente) {
							$opcion = "selected";
						}
					?>
					<option value="<?= $valor->pcl_id_pcliente ?>" <?= $opcion ?>>
						<?= $valor->emp_razon_social ?>
					</option>
					<?php
					}
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="">RUC</label>
				<span class="form-control" id="sp_emp_ruc"><?= $salida->emp_ruc ?></span>
			</div>
			<div class="form-group">
				<label for="in_sal_fecha_doc_cliente">Fecha(2000/12/31 - aaaa-mm-dd)</label>
				<input type="text" id="in_sal_fecha_doc_cliente" name="sal_fecha_doc_cliente" class="form-control" value="<?= $salida->sal_fecha_doc_cliente ?>" placeholder="Fecha">
			</div>
			<div class="form-group">
				<label for="in_tdo_id_tipo_documento">Tipo Documento</label>
				<select id="in_tdo_id_tipo_documento" name="tdo_id_tipo_documento" class="form-control">
					<?php
					foreach ($list_tipo_documento as $valor) {
						$opcion = "";
						if($valor->tdo_id_tipo_documento == $salida->tdo_id_tipo_documento) {
							$opcion = "selected";
						}
					?>
					<option value="<?= $valor->tdo_id_tipo_documento ?>" <?= $opcion ?>>
						<?= $valor->tdo_nombre ?>
					</option>
					<?php
					}
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="in_sal_numero_doc_cliente">Numero Documento</label>
				<input type="text" id="in_sal_numero_doc_cliente" name="sal_numero_doc_cliente" class="form-control" value="<?= $salida->sal_numero_doc_cliente ?>" placeholder="Numero Documento">
			</div>
			<div class="form-group">
				<label for="in_sal_descuento">Descuento</label>
				<input type="text" id="in_sal_descuento" name="sal_descuento" class="form-control" value="<?= $salida->sal_descuento ?>" placeholder="Descuento">
			</div>
			<div class="form-group">
				<label for="in_sal_motivo">Motivo</label>
				<input type="text" id="in_sal_motivo" name="sal_motivo" class="form-control" value="<?= $salida->sal_motivo ?>" placeholder="Motivo">
			</div>
			<div class="form-group">
				<label for="sp_sal_valor">Monto Total</label>
				<span class="form-control" id="sp_sal_valor"><?= $salida->sal_valor ?></span>
			</div>
			<input type="hidden" id="in_sal_id_salida" name="sal_id_salida" value="<?= $salida->sal_id_salida ?>" >
			<button class="btn btn-primary" type="button" onclick="func_salida_guardar_cambios(event)">Guardar cambios</button>
			<br>
			<br>
			
			<table class="table table-bordered" id="tb_salida_detalle">
				<thead>
					<tr>
						<th>#</th>
						<th>Producto</th>
						<th>U.M.</th>
						<th>Cantidad</th>
						<th>Valor</th>
						<th>Total</th>
						<th>
							<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
							<!-- <a href="javascript: mostrar_marco_producto()" >Registrar</a> -->
						</th>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<!-- <td><input type="text" class="form-control" id="in_ind_numero_lote"></td> -->
						<td>
							<select id="in_pro_id_producto" name="pro_id_producto" class="form-control" onchange="func_producto_change(event)">
								<?php
								foreach ($list_producto as $valor) {
									
								?>
								<option value="<?= $valor->pro_id_producto ?>"><?= $valor->pro_nombre ?></option>
								<?php
								}
								?>
							</select>
						</td>
						<td>
							<span id="sp_unidad_medida">Unidad</span>
						</td>
						<td>
							<input type="text" class="form-control" id="in_sad_cantidad">
						</td>
						<td>
							<!-- <input type="text" class="form-control" id="in_sad_valor"> -->
							<span style="text-align: right;" class="form-control" id="sp_sad_valor">0.00</span>
						</td>
						<td>
							<!-- <input type="text" class="form-control" id="in_sad_valor_total"> -->
							<!-- <span class="form-control" id="sp_sad_valor_total">.</span> -->
							<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
						</td>
						<td><button class="btn btn-success" type="button" onclick="func_salida_detalle_registrar(event)">Agregar</button></td>
					</tr>
				</thead>
				<tbody>
					<?php
					$nro = 0;
					foreach ($list_salida_detalle as $valor) {
						$nro++;
					?>
					<tr>
						<td><?= $nro ?></td>
						<td><?= $valor->pro_nombre ?></td>
						<td align="center"><?= $valor->unm_nombre_corto ?></td>
						<td align="right"><?= $valor->sad_cantidad ?></td>
						<td align="right"><?= $valor->sad_valor ?></td>
						<td align="right">
							<span><?= number_format((float)$valor->sad_valor_total, 2, '.', '') ?></span>
						</td>
						<td>
							<button class="btn btn-danger" type="button" onclick="func_salida_detalle_quitar(event)">Quitar</button>
							<input type="hidden" name="sad_id_salida_detalle" value="<?= $valor->sad_id_salida_detalle ?>">
							<input type="hidden" name="pro_id_producto" value="<?= $valor->pro_id_producto ?>">
						</td>
					</tr>
					<?php
					}
					?>
				</tbody>
			</table>
			<br><br>
			<button class="btn btn-primary" type="button" onclick="func_terminar(event)">Finalizar</button>
			<br><br>
		</div>
		<script>
			function func_salida_guardar_cambios(e) {
				var data = {};
				data.sal_id_salida = $("#in_sal_id_salida").val();
				data.pcl_id_cliente = $("#in_pcl_id_cliente").val();
				data.sal_fecha_doc_cliente = $("#in_sal_fecha_doc_cliente").val();
				data.tdo_id_tipo_documento = $("#in_tdo_id_tipo_documento").val();
				data.sal_numero_doc_cliente = $("#in_sal_numero_doc_cliente").val();
				// data.sal_valor = $("#in_sal_valor").val();
				data.sal_descuento = $("#in_sal_descuento").val();
				data.sal_motivo = $("#in_sal_motivo").val();
				
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "salida/cliente/guardar_cambios",
					dataType: 'json',
					data: data,
					success: function(datos) {
						// $('#sp_emp_ruc').text(datos.);
						alert('datos guarddos!');
						$('#sp_sal_valor').text(datos.sal_valor);
					}
				});
			}
			function func_salida_detalle_registrar(e) {
				var data = {};
				
				data.pro_id_producto = $("#in_pro_id_producto").val();
				
				var si_existe = false;
				$('#tb_salida_detalle > tbody  > tr').each(function(tr) {
					var pro_id_producto = $(this).find('input[name="pro_id_producto"]').val();
					if(pro_id_producto == data.pro_id_producto) {
						si_existe = true;
						return false;
					}
				});
				if(si_existe) {
					alert( 'Ya agrego '+$("#in_pro_id_producto option:selected").text() );
					return ;
				}
				
				data.sad_cantidad = $("#in_sad_cantidad").val();
				// data.sad_valor = $("#sp_sad_valor").val();
				// data.ind_numero_lote = $("#in_ind_numero_lote").val();
				// data.ind_valor_total = $("#in_ind_valor_total").val();
				
				if(data.sad_cantidad == '' ||
					data.sad_valor == '') {
					alert('Ingrese todos los campos');
					return ;
				}
				// data.ind_numero_lote == '' ||
				// data.ind_valor_total == ''
				
				data.sal_id_salida = $("#in_sal_id_salida").val();
				
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "salida/detalle/registrar",
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							mostrar_marco_salida_cliente();
							
							func_agregar_fila( // $("#in_ind_numero_lote").val(),
								$("#in_pro_id_producto option:selected").text(),
								$("#in_sad_cantidad").val(),
								$("#sp_sad_valor").text(), // $("#in_sad_valor").val(),
								datos.sad_valor_total,// $("#in_ind_valor_total").val(),
								datos.sad_id_salida_detalle,
								$("#in_pro_id_producto").val());
							func_numerar_fila();
							
							$('#sp_sal_valor').text(datos.sal_valor);
							
							$("#in_sad_cantidad").val('');
							$("#in_sad_valor").val('');
							// $("#in_ind_numero_lote").val('');
							// $("#in_ind_valor_total").val('');
						}
						else if(datos.hecho == 'NO') {
							alert(datos.msj);
						}
					}
				});
			}
			function func_salida_detalle_quitar(e) {
				var tr = $(e.target).closest('tr');
				var sad_id_salida_detalle = $(e.target).siblings('input[name="sad_id_salida_detalle"]').val();
				
				var data = {};
				data.sad_id_salida_detalle = sad_id_salida_detalle;
				data.sal_id_salida = $("#in_sal_id_salida").val();
				
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "salida/detalle/quitar",
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							tr.remove();
							
							$('#sp_sal_valor').text(datos.sal_valor);
							
						}
					}
				});
			}
			function func_cliente_registrar(e) {
				var data = {};
				data.emp_ruc = $("#in_emp_ruc").val();
				data.emp_razon_social = $("#in_emp_razon_social").val();
				data.emp_direccion = $("#in_emp_direccion").val();
				data.emp_telefono = $("#in_emp_telefono").val();
				data.emp_nombre_contacto = $("#in_emp_nombre_contacto").val();
				
				data.sal_id_salida = $("#in_sal_id_salida").val();
				
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "salida/cliente/cliente_registrar",
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							mostrar_marco_salida_cliente();
							// alert(datos.pcl_id_pcliente+' '+data.emp_razon_social+' '+data.emp_ruc);
							vlista_pclientes.push({pcl_id_pcliente: datos.pcl_id_pcliente,
								emp_razon_social: data.emp_razon_social,
								emp_ruc: data.emp_ruc});
							
							$('#in_pcl_id_cliente').append('<option value="'+datos.pcl_id_pcliente+'" selected="selected">'+data.emp_razon_social+'</option>');
							$('#sp_emp_ruc').text(data.emp_ruc);
						}
					}
				});
			}
			/* function func_producto_registrar(e) {
				var data = {};
				data.pro_codigo = $("#in_pro_codigo").val();
				data.pro_clase = $("#in_pro_clase").val();
				data.pro_subclase = $("#in_pro_subclase").val();
				data.pro_nombre = $("#in_pro_nombre").val();
				data.pro_val_compra = $("#in_pro_val_compra").val();
				data.pro_val_venta = $("#in_pro_val_venta").val();
				data.pro_cantidad = $("#in_pro_cantidad").val();
				data.pro_cantidad_min = $("#in_pro_cantidad_min").val();
				data.unm_id_unidad_medida = parseInt($("#in_unm_id_unidad_medida").val());
				
				data.ing_id_ingreso = $("#in_ing_id_ingreso").val();
				data.ind_numero_lote = $("#in2_ind_numero_lote").val();
				data.ind_valor_total = $("#in2_ind_valor_total").val();
				
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "ingreso/detalle/producto_registrar",
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							mostrar_marco_ingreso_proveedor();
							
							vlista_productos.push({pro_id_producto: datos.pro_id_producto,
								pro_nombre: $("#in_pro_nombre").val(),
								unm_id_unidad_medida: data.unm_id_unidad_medida});
			
							func_agregar_fila($("#in2_ind_numero_lote").val(),
								$("#in_pro_nombre").val(),
								$("#in_pro_cantidad").val(),
								$("#in_pro_val_compra").val(),
								$("#in2_ind_valor_total").val(),
								datos.ind_id_ingreso_detalle,
								datos.pro_id_producto);
							func_numerar_fila();
							
						}
					}
				});
			} */
			function func_agregar_fila(
					pro_nombre, 
					sad_cantidad, 
					sad_valor, 
					sad_valor_total, 
					sad_id_salida_detalle, 
					pro_id_producto) {
				
				var vpro_id_producto = parseInt(pro_id_producto);
				var unm_id_unidad_medida = vlista_productos.find(x => x.pro_id_producto === vpro_id_producto).unm_id_unidad_medida;
				var unm_nombre_corto = vlista_unidad_medidas.find(x => x.unm_id_unidad_medida === unm_id_unidad_medida).unm_nombre_corto;
				$('#tb_salida_detalle tbody').prepend('<tr>'+
					'<td></td>'+
					// '<td>'+ind_numero_lote+'</td>'+
					'<td>'+pro_nombre+'</td>'+
					'<td align="center">'+unm_nombre_corto+'</td>'+
					'<td align="right">'+sad_cantidad+'</td>'+
					'<td align="right">'+sad_valor+'</td>'+
					'<td align="right">'+sad_valor_total+'</td>'+
					'<td>'+
					'<button class="btn btn-danger" type="button" onclick="func_salida_detalle_quitar(event)">Quitar</button>'+
					'<input type="hidden" name="sad_id_salida_detalle" value="'+sad_id_salida_detalle+'">'+
					'<input type="hidden" name="pro_id_producto" value="'+pro_id_producto+'">'+
					'</td>'+
					'</tr>');
			}
			function func_numerar_fila() {
				var i = 0;
				$('#tb_salida_detalle > tbody  > tr').each(function(tr) {
					i++;
					$(this).find('td').eq(0).text(i);
				});
			}
			function func_cliente_change(e) {
				var numpcl_id_cliente = parseInt($('#in_pcl_id_cliente').val());
				var emp_ruc = vlista_pclientes.find(x => x.pcl_id_pcliente === numpcl_id_cliente).emp_ruc;
				$('#sp_emp_ruc').text(emp_ruc);
			}
			function func_producto_change(e) {
				var vpro_id_producto = parseInt($('#in_pro_id_producto').val());
				var unm_id_unidad_medida = vlista_productos.find(x => x.pro_id_producto === vpro_id_producto).unm_id_unidad_medida;
				var unm_nombre_corto = vlista_unidad_medidas.find(x => x.unm_id_unidad_medida === unm_id_unidad_medida).unm_nombre_corto;
				
				var pro_cantidad = vlista_productos.find(x => x.pro_id_producto === vpro_id_producto).pro_cantidad;
				
				$('#sp_unidad_medida').text(unm_nombre_corto+' '+pro_cantidad+'=>');
				// var unm_nombre_corto = vlista_unidad_medidas.find(x => x.unm_id_unidad_medida === unm_id_unidad_medida).pro_val_venta;
				var pro_val_venta = vlista_productos.find(x => x.pro_id_producto === vpro_id_producto).pro_val_venta;
				$('#sp_sad_valor').text(pro_val_venta);
			}
			function mostrar_marco_cliente() {
				$("#in_emp_ruc").val('');
				$("#in_emp_razon_social").val('');
				$("#in_emp_direccion").val('');
				$("#in_emp_telefono").val('');
				$("#in_emp_nombre_contacto").val('');
				
				$('#dv_marco_cliente').show();
				$('#dv_marco_salida_cliente').hide();
			}
			/* function mostrar_marco_producto() {
				$("#in_pro_codigo").val('');
				$("#in_pro_clase").val('');
				$("#in_pro_subclase").val('');
				$("#in_pro_nombre").val('');
				$("#in_pro_val_compra").val('');
				$("#in_pro_val_venta").val('');
				$("#in_pro_cantidad").val('');
				$("#in_pro_cantidad_min").val('');
				
				$("#in2_ind_numero_lote").val('');
				$("#in2_ind_valor_total").val('');
				
				$('#dv_marco_producto').show();
				$('#dv_marco_ingreso_proveedor').hide();
				
				$('#in2_ind_numero_lote').focus();
			} */
			function mostrar_marco_salida_cliente() {
				$('#dv_marco_salida_cliente').show();
				$('#dv_marco_cliente').hide();
				// $('#dv_marco_producto').hide();
			}
			
			
			function func_terminar(e) {
				var data = {};
				data.sal_id_salida = $("#in_sal_id_salida").val();
				
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "salida/cliente/terminar",
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							alert("Se guardo correctamente.");
							window.location.href = "<?php echo base_url(); ?>" + "salida/cliente/index";
						}
					}
				});
			}
			
			var vlista_productos = [];
			<?php
			foreach ($list_producto as $valor) {
			?>vlista_productos.push({pro_id_producto: <?= $valor->pro_id_producto ?>,
			pro_nombre: '<?= $valor->pro_nombre ?>',
			unm_id_unidad_medida: <?= $valor->unm_id_unidad_medida ?>,
			pro_val_venta: <?= $valor->pro_val_venta ?>,
			pro_cantidad: <?= $valor->pro_cantidad ?>});
			<?php
			}
			?>
			
			var vlista_unidad_medidas = [];
			<?php
			foreach ($list_unidad_medida as $valor) {
			?>vlista_unidad_medidas.push({unm_id_unidad_medida: <?= $valor->unm_id_unidad_medida ?>, unm_nombre_corto: '<?= $valor->unm_nombre_corto ?>'});
			<?php
			}
			?>
			
			var vlista_pclientes = [];
			<?php
			foreach ($list_pcliente as $valor) {
			?>vlista_pclientes.push({pcl_id_pcliente: <?= $valor->pcl_id_pcliente ?>,
			emp_razon_social: '<?= $valor->emp_razon_social ?>',
			emp_ruc: '<?= $valor->emp_ruc ?>'});
			<?php
			}
			?>
			
			$(function(){
				// $('#bt_ingreso_guardar_cambios').click(func_ingreso_guardar_cambios);
				
				$('#in_pcl_id_cliente').change();	// cargar
				$('#in_pro_id_producto').change();	// cargar
			});
			
		</script>
		<!-- MARCO CLIENTE -->
		<div class="container" id="dv_marco_cliente" style="position: absolute; margin-top: 30px; display: none;">
			
			<h3>CLIENTE</h3>
			<hr>
			<div class="form-group">
				<label for="">RUC</label>
				<input type="text" id="in_emp_ruc" name="emp_ruc" class="form-control" value="" placeholder="RUC">
			</div>
			<div class="form-group">
				<label for="">RAZON SOCIAL</label>
				<input type="text" id="in_emp_razon_social" name="emp_razon_social" class="form-control" value="" placeholder="RAZON SOCIAL">
			</div>
			<div class="form-group">
				<label for="">DIRECCION</label>
				<input type="text" id="in_emp_direccion" name="emp_direccion" class="form-control" value="" placeholder="DIRECCION">
			</div>
			<div class="form-group">
				<label for="">TELEFONO</label>
				<input type="text" id="in_emp_telefono" name="emp_telefono" class="form-control" value="" placeholder="TELEFONO">
			</div>
			<div class="form-group">
				<label for="">CONTACTO</label>
				<input type="text" id="in_emp_nombre_contacto" name="emp_nombre_contacto" class="form-control" value="" placeholder="CONTACTO">
			</div>
			<br>
			<br>
			<button class="btn btn-primary" type="button" onclick="func_cliente_registrar(event)">Guardar Cliente</button>
			<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
			<a href="javascript: mostrar_marco_salida_cliente()" >Cancelar</a>
		</div>
