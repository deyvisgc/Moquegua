<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<h1>
						Reporte Stock<small></small>
					</h1>
					<ol class="breadcrumb">
						<li>
							<a href="<?= base_url() ?>bienvenida"><i class="fa fa-home"></i> Home</a>
						</li>
						<li class="active">Reporte Stock.</li>
					</ol>
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Your Page Content Here -->
					<div class="row">
						<div class="col-md-12">
							<div class="nav-tabs-custom">
								<ul class="nav nav-tabs pull-right">
									<li><a href="#dv_minimo" data-toggle="tab" id="a_minimo">Stock Minimo</a></li>
									<li class="active"><a href="#dv_general" data-toggle="tab" id="a_general">Stock General</a></li>
									<li class="pull-left header"><i class="fa fa-calculator"></i> Reporte Stock.</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="dv_general">
										<div class="row">
											<div class="col-sm-12 box-body table-responsive">
												<p></p>
												<table class="table table-bordered" id="tb_general">
													<thead>
														<tr>
															<th>CLASE</th>
															<th>SUBCLASE</th>
															<th>CODIGO</th>
															<th>DESCRIPCION</th>
															<th>STOCK</th>
															<th>S/. COMPRA</th>
															<th>S/. VENTA</th>
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									
									<div class="tab-pane" id="dv_minimo">
										<div class="row">
											<div class="col-sm-12 box-body table-responsive">
												<p></p>
												<table class="table table-bordered" id="tb_minimo">
													<thead>
														<tr>
															<th>CLASE</th>
															<th>SUBCLASE</th>
															<th>CODIGO</th>
															<th>DESCRIPCION</th>
															<th>UNI. MEDIDA</th>
															<th>STOCK</th>
															<th>STOCK MIN.</th>
															<th>S/. COMPRA</th>
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section><!-- /.content -->
			</div><!-- /.content-wrapper -->
			
			<script>
			function init_stock() {
				$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
					var target = $(e.target).attr("href");
					if(target === '#dv_minimo') {
						$('#tb_minimo').DataTable().ajax.reload();
					}
					else if(target === '#dv_general') {
						$('#tb_general').DataTable().ajax.reload();
					}
				});
				
				var general_id_tabla = "tb_general";
				var general_url = "<?php echo base_url(); ?>reporte/stock/bstock_general";
				var general_data = [];
				var general_columns = [
					{data: "clase_nombre"},
					{data: "subclase_nombre"},
					{data: "pro_codigo"},
					{data: "pro_nombre"},
					{data: "pro_cantidad", className: "alinear_derecha"},
					{data: "pro_val_compra", className: "alinear_derecha"},
					{data: "pro_val_venta", className: "alinear_derecha"}
				];
				
				var minimo_id_tabla = "tb_minimo";
				var minimo_url = "<?php echo base_url(); ?>reporte/stock/bstock_minimo";
				var minimo_data = [];
				var minimo_columns = [
					{data: "clase_nombre"},
					{data: "subclase_nombre"},
					{data: "pro_codigo"},
					{data: "pro_nombre"},
					{data: "unm_nombre_corto"},
					{data: "pro_cantidad", className: "alinear_derecha"},
					{data: "pro_cantidad_min", className: "alinear_derecha"},
					{data: "pro_val_compra", className: "alinear_derecha"}
				];
				
				generar_tabla(general_id_tabla, general_url, general_data, general_columns);
				generar_tabla(minimo_id_tabla, minimo_url, minimo_data, minimo_columns);
			}
			</script>
