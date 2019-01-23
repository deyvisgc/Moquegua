<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		
		$this->load->database();
		$this->load->model('producto_model');
		$this->load->model('rol_has_privilegio_model');
		
		$this->load->helper('seguridad');
		$this->load->helper('util');
		$this->load->helper('url');
	}
	public function index()
	{
		is_logged_in_or_exit($this);
		$data_header['list_privilegio'] = get_privilegios($this);
		$data_header['pri_grupo'] = 'MOVIMIENTO';
		$data_header['pri_nombre'] = 'Ajuste stock';
		$data_header['usuario'] = get_usuario($this);
		$data_header['title'] = "AJUSTE STOCK";
		$data_footer['inits_function'] = array("init_ajuste_stock");
		$this->load->view('header', $data_header);
		$this->load->view('movimiento/ajuste/stock/index');
		$this->load->view('footer', $data_footer);
	}
	public function recargar_producto()
	{
		is_logged_in_or_exit($this);
		$list_producto = $this->producto_model->mbuscar_all_habilitados();
		$data = array('hecho' => 'SI', 'list_producto' => $list_producto);
		echo json_encode($data);
	}
	public function guardar()
	{
		is_logged_in_or_exit($this);
		$usuario = get_usuario($this);
		$data_producto = array(
			'pro_id_producto' => $this->input->post('pro_id_producto'),
			'cantidad' => $this->input->post('cantidad'),
			'operador' => $this->input->post('operador'),
			'usu_id_usuario' => $usuario['usu_id_usuario']);
		$result = $this->producto_model->mstock_ajustar($data_producto);
		echo json_encode($result);
	}
}
