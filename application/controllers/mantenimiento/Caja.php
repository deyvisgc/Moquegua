<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caja extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		
		$this->load->database();
		$this->load->model('caja_model');
		$this->load->model('usuario_model');
		$this->load->model('estado_model');
		$this->load->model('rol_has_privilegio_model');
		
		$this->load->helper('seguridad');
		$this->load->helper('util');
		$this->load->helper('url');
	}
	public function index()
	{
		is_logged_in_or_exit($this);
		$data_header['list_privilegio'] = get_privilegios($this);
		$data_header['pri_grupo'] = 'ADMINISTRACION';
		$data_header['pri_nombre'] = 'Caja';
		$data_header['usuario'] = get_usuario($this);
		$data_header['title'] = "CAJA";
		
		$list_estado = $this->estado_model->buscar_x_tabla('ACCESO');
		$data_body['list_estado'] = $list_estado;
		$list_usuario = $this->usuario_model->buscar_x_nombrecompleto('');
		$data_body['list_usuario'] = $list_usuario;
		
		$data_footer['inits_function'] = array("init_caja");
		
		$this->load->view('header', $data_header);
		$this->load->view('mantenimiento/caja/formulario', $data_body);
		$this->load->view('footer', $data_footer);
	}
	public function buscar_xll()
	{
		is_logged_in_or_exit($this);
		
		$list_caja = $this->caja_model->mbuscar_all();
		
		$data = array('hecho' => 'SI', 'data' => $list_caja);
		echo json_encode($data);
	}
	public function guardar()
	{
		is_logged_in_or_exit($this);
		
		$data_caja = array(
			'caj_descripcion' => $this->input->post('caj_descripcion'),
			'est_id_estado' => $this->input->post('est_id_estado'),
			'caj_id_caja' => $this->input->post('caj_id_caja'));
		$result = $this->caja_model->mguardar($data_caja);
		
		echo json_encode($result);
	}
}
