<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
			<!-- Main Footer -->
			<footer class="main-footer">
				<!-- To the right -->
				<div class="pull-right hidden-xs">GRUPOSYSTEM V&V.</div>
				<!-- Default to the left -->
				<strong>Copyright &copy; 2018 | <a href=''></a></strong> Derechos reservados.
			</footer>
			<!-- Add the sidebar's background. This div must be placed
			immediately after the control sidebar -->
			<div class="control-sidebar-bg"></div>
		</div><!-- ./wrapper -->
		
		<div class="MsjAjaxForm"></div>
		<!-- jQuery 3.1.1 -->
		<script src="<?= base_url() ?>../resources/js/jquery-3.1.1.min.js"></script>
		<!-- <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script> -->
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="<?= base_url() ?>../resources/js/bootstrap.min.js"></script>
		<!-- Script AjaxForms-->
		<!-- <script src="<?= base_url() ?>../resources/js/AjaxForms.js"></script> -->
		<!-- Sweet Alert 2-->
		<script src="<?= base_url() ?>../resources/js/sweetalert2.min.js"></script>
		<!-- AdminLTE App -->
		<script src="<?= base_url() ?>../resources/dist/js/app.js"></script>
		<!-- Script main-->
		<!-- <script src="<?= base_url() ?>../resources/js/main.js"></script> -->
		<script src="<?= base_url() ?>../resources/plugins/morris/morris.min.js"></script>
		<script src="<?= base_url() ?>../resources/plugins/morris/raphael-min.js"></script>
		<script src="<?= base_url() ?>../resources/dist/js/source_init.js"></script>
		<!--  PRUEBAS -->
		<script src="<?= base_url() ?>../resources/plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="<?= base_url() ?>../resources/plugins/datatables/dataTables.bootstrap.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

		<script src="<?= base_url() ?>../resources/js/syscript.js"></script>

		<!-- <script src="<?= base_url() ?>../js/escritura.js"></script> -->
		
		<!--  -->
		<script>
		BASE_URL = '<?php echo base_url(); ?>';
		<?php
		if(isset($inits_function)) {
			foreach ($inits_function as $valor) {
				// $valor = $valor * 2;
		?><?= $valor ?>();
		<?php
		/* <script src="<?= base_url() ?>../resources/plugins/morris/morris.min.js"></script> */
			}
		}
		/* else {
			echo '<script>alert("SI FUNCIONA.");</script>';
		} */
		?>
		
		</script>
		
	</body>
</html>
