<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rol extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		
		$this->load->database();
		$this->load->model('rol_model');
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
		$data_header['pri_nombre'] = 'Rol';
		$data_header['usuario'] = get_usuario($this);
		$data_header['title'] = "ROL";
		
		$list_estado = $this->estado_model->buscar_x_tabla('ACCESO');
		$data_body['list_estado'] = $list_estado;
		
		$data_footer['inits_function'] = array("init_rol");
		
		$this->load->view('header', $data_header);
		$this->load->view('mantenimiento/rol/formulario', $data_body);
		$this->load->view('footer', $data_footer);
	}
	public function buscar_x_nombre()
	{
		is_logged_in_or_exit($this);
		
		$list_rol = $this->rol_model->buscar_x_nombre('');
		
		$data = array('hecho' => 'SI', 'data' => $list_rol);
		echo json_encode($data);
	}
	public function buscar_privilegio_x_rol()
	{
		is_logged_in_or_exit($this);
		
		$rol_id_rol = $this->input->post('rol_id_rol');
		$list_rol_has_privilegio = $this->rol_has_privilegio_model->buscar_x_rol($rol_id_rol);
		
		$data = array('hecho' => 'SI', 'list_rol_has_privilegio' => $list_rol_has_privilegio);
		echo json_encode($data);
	}
	public function agregar_privilegio()
	{
		is_logged_in_or_exit($this);
		
		$data = array('rol_id_rol' => $this->input->post('rol_id_rol'),
				'pri_id_privilegio' => $this->input->post('pri_id_privilegio'));
		$result = $this->rol_has_privilegio_model->registrar($data);
		
		$data = array('hecho' => 'SI');
		echo json_encode($data);
	}
	public function quitar_privilegio()
	{
		is_logged_in_or_exit($this);
		
		$data = array('rol_id_rol' => $this->input->post('rol_id_rol'),
				'pri_id_privilegio' => $this->input->post('pri_id_privilegio'));
		$result = $this->rol_has_privilegio_model->quitar($data);
		
		$data = array('hecho' => 'SI');
		echo json_encode($data);
	}
	public function registrar()
	{
		is_logged_in_or_exit($this);
		
		$data = array('rol_nombre' => $this->input->post('rol_nombre'),
				'est_id_estado' => $this->input->post('est_id_estado'));
		$rol_id_rol = $this->rol_model->registrar($data);
		
		$data = array('hecho' => 'SI');
		echo json_encode($data);
	}
	public function actualizar()
	{
		is_logged_in_or_exit($this);
		
		$rol_id_rol = $this->input->post('rol_id_rol');
		$data = array('rol_nombre' => $this->input->post('rol_nombre'),
				'est_id_estado' => $this->input->post('est_id_estado'));
		$result = $this->rol_model->update_datos($rol_id_rol, $data);
		
		$data = array('hecho' => 'SI');
		echo json_encode($data);
	}
}
