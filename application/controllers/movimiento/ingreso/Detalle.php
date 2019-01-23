<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detalle extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		
		$this->load->database();
		$this->load->model('temp_ingreso_model');
		
		$this->load->helper('seguridad');
		$this->load->helper('util');
		$this->load->helper('url');
	}
	public function buscar_productos_elejidos() {
		is_logged_in_or_exit($this);
		$usuario = get_usuario($this);
		$list = $this->temp_ingreso_model->mbuscar_productos_elejidos($usuario['usu_id_usuario']);
		$tcompra = $this->temp_ingreso_model->msum_count_productos_elejidos($usuario['usu_id_usuario']);
		$data = array('hecho' => 'SI', 'data' => $list, 'tcompra' => $tcompra);
		echo json_encode($data);
	}
	public function buscar_productos_x_descripcion() {
		is_logged_in_or_exit($this);
		$descripcion = $this->input->post('descripcion');
		$usuario = get_usuario($this);
		$list_producto = $this->temp_ingreso_model->mbuscar_productos_x_descripcion($usuario['usu_id_usuario'], $descripcion);
		$data = array('hecho' => 'SI', 'list_producto' => $list_producto);
		echo json_encode($data);
	}
	public function agregar_producto()
	{
		is_logged_in_or_exit($this);
		$usuario = get_usuario($this);
		$data = array(
			'usu_id_usuario' => $usuario['usu_id_usuario'],
			'pro_id_producto' => $this->input->post('pro_id_producto'),
			'valor' => $this->input->post('valor'),
			'cantidad' => $this->input->post('cantidad'),
			'numero_lote' => $this->input->post('numero_lote'),
			'fecha_vencimiento' => $this->input->post('fecha_vencimiento'));
		$result = $this->temp_ingreso_model->magregar($data);
		echo json_encode($result);
	}
	public function quitar_producto()
	{
		is_logged_in_or_exit($this);
		$usuario = get_usuario($this);
		$data = array(
			'usu_id_usuario' => $usuario['usu_id_usuario'],
			'pro_id_producto' => $this->input->post('pro_id_producto'));
		$result = $this->temp_ingreso_model->mquitar($data);
		echo json_encode($result);
	}
	public function reload_salcombo() {
		is_logged_in_or_exit($this);
		$list_documento = $this->temp_ingreso_model->mdocumento_salida();
		$data = array('hecho' => 'SI', 'list_documento' => $list_documento);
		echo json_encode($data);
	}
	public function buscar_proveedor() {
		is_logged_in_or_exit($this);
		$texto = $this->input->post('texto');
		$list_proveedor = $this->temp_ingreso_model->mbuscar_proveedor($texto);
		$data = array('hecho' => 'SI', 'list_proveedor' => $list_proveedor);
		echo json_encode($data);
	}
}
