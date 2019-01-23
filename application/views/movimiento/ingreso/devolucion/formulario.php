		<div class="container" >
		</div>
		<div class="container" style="position: absolute; margin-top: 250px;" id="dv_marco_ingreso_proveedor">
			
			<h3>INGRESO PROVEEDOR</h3>
			<hr>
			<div class="form-group">
				<label for="in_pcl_id_proveedor">Proveedor</label>
				<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
				<a href="javascript: mostrar_marco_proveedor()" >Registrar</a>
				<select id="in_pcl_id_proveedor" name="pcl_id_proveedor" class="form-control" onchange="func_proveedor_change(event)">
					<?php
					foreach ($list_pcliente as $valor) {
						$opcion = "";
						if($valor->pcl_id_pcliente == $ingreso->pcl_id_proveedor) {
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
				<span class="form-control" id="sp_emp_ruc"><?= $ingreso->emp_ruc ?></span>
			</div>
			<div class="form-group">
				<label for="in_ing_fecha_doc_proveedor">Fecha(2000/12/31 - aaaa-mm-dd)</label>
				<input type="text" id="in_ing_fecha_doc_proveedor" name="ing_fecha_doc_proveedor" class="form-control" value="<?= $ingreso->ing_fecha_doc_proveedor ?>" placeholder="Fecha">
			</div>
			<div class="form-group">
				<label for="in_tdo_id_tipo_documento">Tipo Documento</label>
				<select id="in_tdo_id_tipo_documento" name="tdo_id_tipo_documento" class="form-control">
					<?php
					foreach ($list_tipo_documento as $valor) {
						$opcion = "";
						if($valor->tdo_id_tipo_documento == $ingreso->tdo_id_tipo_documento) {
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
				<label for="in_ing_numero_doc_proveedor">Numero Documento</label>
				<input type="text" id="in_ing_numero_doc_proveedor" name="ing_numero_doc_proveedor" class="form-control" value="<?= $ingreso->ing_numero_doc_proveedor ?>" placeholder="Numero Documento">
			</div>
			<div class="form-group">
				<label for="in_ing_valor">Monto Total</label>
				<input type="text" id="in_ing_valor" name="ing_valor" class="form-control" value="<?= $ingreso->ing_valor ?>" placeholder="Monto Total">
			</div>
			<input type="hidden" id="in_ing_id_ingreso" name="ing_id_ingreso" value="<?= $ingreso->ing_id_ingreso ?>" >
			<button class="btn btn-primary" type="button" id="bt_ingreso_guardar_cambios">Guardar cambios</button>
			<br>
			<br>
			<table class="table table-bordered" id="tb_ingreso_detalle">
				<thead>
					<tr>
						<th>#</th>
						<th>Numero lote</th>
						<th>Producto</th>
						<th>U.M.</th>
						<th>Cantidad</th>
						<th>Valor</th>
						<th>Total</th>
						<th>
							<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
							<a href="javascript: mostrar_marco_producto()" >Registrar</a>
						</th>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><input type="text" class="form-control" id="in_ind_numero_lote"></td>
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
							<span id="sp_unidad_medida">x</span>
						</td>
						<td>
							<input type="text" class="form-control" id="in_ind_cantidad">
						</td>
						<td>
							<input type="text" class="form-control" id="in_ind_valor">
						</td>
						<td>
							<input type="text" class="form-control" id="in_ind_valor_total">
						</td>
						<td><button class="btn btn-success" type="button" onclick="func_ingreso_detalle_registrar(event)">Agregar</button></td>
					</tr>
				</thead>
				<tbody>
					<?php
					$nro = 0;
					foreach ($list_ingreso_detalle as $valor) {
						$nro++;
					?>
					<tr>
						<td><?= $nro ?></td>
						<td><?= $valor->ind_numero_lote ?></td>
						<td><?= $valor->pro_nombre ?></td>
						<td align="center"><?= $valor->unm_nombre_corto ?></td>
						<td align="right"><?= $valor->ind_cantidad ?></td>
						<td align="right"><?= $valor->ind_valor ?></td>
						<td align="right">
							<span id="sp_valor_total"><?= number_format((float)$valor->ind_valor_total, 2, '.', '') ?></span>
						</td>
						<td>
							<button class="btn btn-danger" type="button" onclick="func_ingreso_detalle_quitar(event)">Quitar</button>
							<input type="hidden" name="ind_id_ingreso_detalle" value="<?= $valor->ind_id_ingreso_detalle ?>">
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
			function func_ingreso_guardar_cambios() {
				var data = {};
				data.ing_id_ingreso = $("#in_ing_id_ingreso").val();
				data.ing_fecha_doc_proveedor = $("#in_ing_fecha_doc_proveedor").val();
				data.tdo_id_tipo_documento = $("#in_tdo_id_tipo_documento").val();
				data.ing_numero_doc_proveedor = $("#in_ing_numero_doc_proveedor").val();
				data.ing_valor = $("#in_ing_valor").val();
				
				data.pcl_id_proveedor = $("#in_pcl_id_proveedor").val();
				
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "ingreso/proveedor/ingreso_guardar_cambios",
					dataType: 'json',
					data: data,
					success: function(res) {
						// $('#sp_emp_ruc').text('');
						alert('datos guarddos!');
					}
				});
			}
			function func_ingreso_detalle_registrar(e) {
				var data = {};
				
				data.pro_id_producto = $("#in_pro_id_producto").val();
				
				var si_existe = false;
				$('#tb_ingreso_detalle > tbody  > tr').each(function(tr) {
					
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
				
				data.ind_cantidad = $("#in_ind_cantidad").val();
				data.ind_valor = $("#in_ind_valor").val();
				data.ind_numero_lote = $("#in_ind_numero_lote").val();
				data.ind_valor_total = $("#in_ind_valor_total").val();
				
				if(data.ind_cantidad == '' ||
					data.ind_valor == '' ||
					data.ind_numero_lote == '' ||
					data.ind_valor_total == '') {
					alert('Ingrese todos los campos');
					return ;
				}
				
				data.ing_id_ingreso = $("#in_ing_id_ingreso").val();
				
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "ingreso/detalle/registrar",
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							mostrar_marco_ingreso_proveedor();
							
							func_agregar_fila($("#in_ind_numero_lote").val(),
								$("#in_pro_id_producto option:selected").text(),
								$("#in_ind_cantidad").val(),
								$("#in_ind_valor").val(),
								$("#in_ind_valor_total").val(),
								datos.ind_id_ingreso_detalle,
								$("#in_pro_id_producto").val());
							func_numerar_fila();
							
							$("#in_ind_cantidad").val('');
							$("#in_ind_valor").val('');
							$("#in_ind_numero_lote").val('');
							$("#in_ind_valor_total").val('');
							
						}
					}
				});
			}
			function func_ingreso_detalle_quitar(e) {
				var tr = $(e.target).closest('tr');
				var ind_id_ingreso_detalle = $(e.target).siblings('input[name="ind_id_ingreso_detalle"]').val();
				
				var data = {};
				data.ind_id_ingreso_detalle = ind_id_ingreso_detalle;
				
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "ingreso/detalle/quitar",
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							tr.remove();
						}
					}
				});
			}
			function func_proveedor_registrar(e) {
				var data = {};
				data.emp_ruc = $("#in_emp_ruc").val();
				data.emp_razon_social = $("#in_emp_razon_social").val();
				data.emp_direccion = $("#in_emp_direccion").val();
				data.emp_telefono = $("#in_emp_telefono").val();
				data.emp_nombre_contacto = $("#in_emp_nombre_contacto").val();
				
				data.ing_id_ingreso = $("#in_ing_id_ingreso").val();
				
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "ingreso/proveedor/proveedor_registrar",
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							mostrar_marco_ingreso_proveedor();
							
							vlista_pclientes.push({pcl_id_pcliente: datos.pcl_id_cliente,
								emp_razon_social: data.emp_razon_social,
								emp_ruc: data.emp_ruc});
							
							$('#in_pcl_id_proveedor').append('<option value="'+datos.pcl_id_cliente+'" selected="selected">'+data.emp_razon_social+'</option>');
							$('#sp_emp_ruc').text(data.emp_ruc);
						}
					}
				});
			}
			function func_producto_registrar(e) {
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
			}
			function func_agregar_fila(ind_numero_lote, 
					pro_nombre, 
					ind_cantidad, 
					ind_valor, 
					ind_valor_total, 
					ind_id_ingreso_detalle, 
					pro_id_producto) {
				
				var vpro_id_producto = parseInt(pro_id_producto);
				var unm_id_unidad_medida = vlista_productos.find(x => x.pro_id_producto === vpro_id_producto).unm_id_unidad_medida;
				var unm_nombre_corto = vlista_unidad_medidas.find(x => x.unm_id_unidad_medida === unm_id_unidad_medida).unm_nombre_corto;
				$('#tb_ingreso_detalle tbody').prepend('<tr>'+
					'<td></td>'+
					'<td>'+ind_numero_lote+'</td>'+
					'<td>'+pro_nombre+'</td>'+
					'<td align="center">'+unm_nombre_corto+'</td>'+
					'<td align="right">'+ind_cantidad+'</td>'+
					'<td align="right">'+ind_valor+'</td>'+
					'<td align="right">'+ind_valor_total+'</td>'+
					'<td>'+
					'<button class="btn btn-danger" type="button" onclick="func_ingreso_detalle_quitar(event)">Quitar</button>'+
					'<input type="hidden" name="ind_id_ingreso_detalle" value="'+ind_id_ingreso_detalle+'">'+
					'<input type="hidden" name="pro_id_producto" value="'+pro_id_producto+'">'+
					'</td>'+
					'</tr>');
			}
			function func_numerar_fila() {
				var i = 0;
				$('#tb_ingreso_detalle > tbody  > tr').each(function(tr) {
					i++;
					$(this).find('td').eq(0).text(i);
				});
			}
			function func_proveedor_change(e) {
				var numpcl_id_proveedor = parseInt($('#in_pcl_id_proveedor').val());
				var emp_ruc = vlista_pclientes.find(x => x.pcl_id_pcliente === numpcl_id_proveedor).emp_ruc;
				$('#sp_emp_ruc').text(emp_ruc);
			}
			function func_producto_change(e) {
				var vpro_id_producto = parseInt($('#in_pro_id_producto').val());
				var unm_id_unidad_medida = vlista_productos.find(x => x.pro_id_producto === vpro_id_producto).unm_id_unidad_medida;
				var unm_nombre_corto = vlista_unidad_medidas.find(x => x.unm_id_unidad_medida === unm_id_unidad_medida).unm_nombre_corto;
				$('#sp_unidad_medida').text(unm_nombre_corto);
			}
			function mostrar_marco_proveedor() {
				$("#in_emp_ruc").val('');
				$("#in_emp_razon_social").val('');
				$("#in_emp_direccion").val('');
				$("#in_emp_telefono").val('');
				$("#in_emp_nombre_contacto").val('');
				
				$('#dv_marco_proveedor').show();
				$('#dv_marco_ingreso_proveedor').hide();
			}
			function mostrar_marco_producto() {
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
			}
			function mostrar_marco_ingreso_proveedor() {
				$('#dv_marco_ingreso_proveedor').show();
				$('#dv_marco_proveedor').hide();
				$('#dv_marco_producto').hide();
			}
			
			
			function func_terminar(e) {
				var data = {};
				data.ing_id_ingreso = $("#in_ing_id_ingreso").val();
				
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "ingreso/proveedor/terminar",
					dataType: 'json',
					data: data,
					success: function(datos) {
						if(datos.hecho == 'SI') {
							alert("Se guardo correctamente.");
							window.location.href = "<?php echo base_url(); ?>" + "ingreso/proveedor/index";
						}
					}
				});
			}
			
			var vlista_productos = [];
			<?php
			foreach ($list_producto as $valor) {
			?>vlista_productos.push({pro_id_producto: <?= $valor->pro_id_producto ?>,
			pro_nombre: '<?= $valor->pro_nombre ?>',
			unm_id_unidad_medida: <?= $valor->unm_id_unidad_medida ?>});
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
				$('#bt_ingreso_guardar_cambios').click(func_ingreso_guardar_cambios);
				
				$('#in_pcl_id_proveedor').change();	// cargar
				$('#in_pro_id_producto').change();	// cargar
			});
			
		</script>
		
		<!-- MARCO PROVEEDOR -->
		<div class="container" id="dv_marco_proveedor" style="position: absolute; margin-top: 30px; display: none;">
			
			<h3>PROVEEDOR</h3>
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
			<button class="btn btn-primary" type="button" onclick="func_proveedor_registrar(event)">Guardar Proveedor</button>
			<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
			<a href="javascript: mostrar_marco_ingreso_proveedor()" >Cancelar</a>
		</div>
		
		<!-- MARCO PRODUCTO -->
		<div class="container" id="dv_marco_producto" style="position: absolute; margin-top: 250px; display: none;">
			
			<h3>INGRESO PRODUCTO</h3>
			<hr>
			<div class="form-group">
				<label for="in2_ind_numero_lote">Numero lote</label>
				<input type="text" id="in2_ind_numero_lote" name="ind_numero_lote" class="form-control" value="" placeholder="Numero lote">
			</div>
			<div class="form-group">
				<label for="in_pro_codigo">Codigo</label>
				<input type="text" id="in_pro_codigo" name="pro_codigo" class="form-control" value="" placeholder="Codigo">
			</div>
			<div class="form-group">
				<label for="in_pro_clase">Clase</label>
				<input type="text" id="in_pro_clase" name="pro_clase" class="form-control" value="" placeholder="Clase">
			</div>
			<div class="form-group">
				<label for="in_pro_subclase">SubClase</label>
				<input type="text" id="in_pro_subclase" name="pro_subclase" class="form-control" value="" placeholder="SubClase">
			</div>
			<div class="form-group">
				<label for="in_pro_nombre">Nombre</label>
				<input type="text" id="in_pro_nombre" name="pro_nombre" class="form-control" value="" placeholder="Nombre">
			</div>
			<div class="form-group">
				<label for="in_pro_val_compra">Val. Compra</label>
				<input type="text" id="in_pro_val_compra" name="pro_val_compra" class="form-control" value="" placeholder="Val. Compra">
			</div>
			<div class="form-group">
				<label for="in_pro_val_venta">Val. Venta</label>
				<input type="text" id="in_pro_val_venta" name="pro_val_venta" class="form-control" value="" placeholder="Val. Venta">
			</div>
			<div class="form-group">
				<label for="in_pro_cantidad">Cantidad</label>
				<input type="text" id="in_pro_cantidad" name="pro_cantidad" class="form-control" value="" placeholder="Cantidad">
			</div>
			<div class="form-group">
				<label for="in_pro_cantidad_min">Cantidad Minima</label>
				<input type="text" id="in_pro_cantidad_min" name="pro_cantidad_min" class="form-control" value="" placeholder="Cantidad Minima">
			</div>
			<div class="form-group">
				<label for="">UNIDAD MEDIDA</label>
				
				<select id="in_unm_id_unidad_medida" name="unm_id_unidad_medida" class="form-control">
					<?php
					foreach ($list_unidad_medida as $valor) {
						$opcion = "";
						
					?>
					<option value="<?= $valor->unm_id_unidad_medida ?>" <?= $opcion ?>>
						<?= $valor->unm_nombre_corto ?>
					</option>
					<?php
					}
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="in2_ind_valor_total">Valor Total</label>
				<input type="text" id="in2_ind_valor_total" name="ind_valor_total" class="form-control" value="" placeholder="Valor Total">
			</div>
			
			<button class="btn btn-primary" type="button" onclick="func_producto_registrar(event)">Guardar Producto</button>
			<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
			<a href="javascript: mostrar_marco_ingreso_proveedor()" >Cancelar</a>
		</div>
