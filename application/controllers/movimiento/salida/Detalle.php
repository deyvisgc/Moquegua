<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detalle extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		
		$this->load->database();
		$this->load->model('temp_salida_model');
		
		$this->load->helper('seguridad');
		$this->load->helper('util');
		$this->load->helper('url');
	}
	public function buscar_productos_elejidos() {
		is_logged_in_or_exit($this);
		
		$usuario = get_usuario($this);
		$list = $this->temp_salida_model->mbuscar_productos_elejidos($usuario['usu_id_usuario']);
		$tventa = $this->temp_salida_model->msum_count_productos_elejidos($usuario['usu_id_usuario']);
		
		$data = array('hecho' => 'SI', 'data' => $list, 'tventa' => $tventa);
		echo json_encode($data);
	}
	public function buscar_productos_x_descripcion() {
		is_logged_in_or_exit($this);
		
		$descripcion = $this->input->post('descripcion');
		$usuario = get_usuario($this);
		$list_producto = $this->temp_salida_model->mbuscar_s_productos_x_descripcion($usuario['usu_id_usuario'], $descripcion);
		
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
			'cantidad' => $this->input->post('cantidad'),
			'precio' => $this->input->post('precio'),
			'totalganancia' => $this->input->post('totalganancia'),
			'n_orden' => $this->input->post('n_orden'));
		$result = $this->temp_salida_model->magregar($data);
		
		echo json_encode($result);
		
	}
	public function quitar_producto()
	{
		is_logged_in_or_exit($this);
		
		$usuario = get_usuario($this);
		$data = array(
			'usu_id_usuario' => $usuario['usu_id_usuario'],
			'pro_id_producto' => $this->input->post('pro_id_producto'),
			'n_orden' => $this->input->post('n_orden')
			);
		$result = $this->temp_salida_model->mquitar($data);
		
		echo json_encode($result);
	}
	public function reload_salcombo() {
		is_logged_in_or_exit($this);
		
		$list_documento = $this->temp_salida_model->mdocumento_salida();
		
		$data = array('hecho' => 'SI', 'list_documento' => $list_documento);
		echo json_encode($data);
	}
	public function get_nro_documento() {
		is_logged_in_or_exit($this);
		
		$tdo_id_tipo_documento = $this->input->post('tdo_id_tipo_documento');
		$row = $this->temp_salida_model->mgetsal_nro_documento($tdo_id_tipo_documento);
		
		$data = array('hecho' => 'SI', 'row' => $row);
		echo json_encode($data);
	}
	public function buscar_cliente() {
		is_logged_in_or_exit($this);
		
		$texto = $this->input->post('texto');
		$list_cliente = $this->temp_salida_model->mbuscar_cliente($texto);
		
		$data = array('hecho' => 'SI', 'list_cliente' => $list_cliente);
		echo json_encode($data);
	}
	public function cargarAnonimo(){
        is_logged_in_or_exit($this);
        $usuario = get_usuario($this);
        $result = $this->temp_salida_model->mbuscar_clientes();
        echo json_encode($result);
    }
}
