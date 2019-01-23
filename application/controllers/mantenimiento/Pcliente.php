<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pcliente extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		
		$this->load->database();
		$this->load->model('pcliente_model');
		$this->load->model('empresa_model');
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
		$data_header['pri_grupo'] = 'MANTENIMIENTO';
		$data_header['pri_nombre'] = 'Cliente';
		$data_header['usuario'] = get_usuario($this);
		$data_header['title'] = "CLIENTE";
		
		$list_estado = $this->estado_model->buscar_x_tabla("ACCESO");
		$data_body['list_estado'] = $list_estado;
		
		$data_footer['inits_function'] = array("init_pcliente");
		
		$this->load->view('header', $data_header);
		$this->load->view('mantenimiento/pcliente/index', $data_body);
		$this->load->view('footer', $data_footer);
	}
	public function buscar_x_rz_o_ruc()
	{
		is_logged_in_or_exit($this);
		
		$texto = $this->input->post('texto');
		$list_pcliente = $this->pcliente_model->buscar_x_razon_social_o_ruc($texto);
		
		$data = array('hecho' => 'SI', 'data' => $list_pcliente);
		echo json_encode($data);
	}
	public function registrar()
	{
		is_logged_in_or_exit($this);
		
		$data = array('emp_ruc' => $this->input->post('emp_ruc'),
				'emp_razon_social' => $this->input->post('emp_razon_social'),
				'emp_direccion' => $this->input->post('emp_direccion'),
				'emp_telefono' => $this->input->post('emp_telefono'),
				'emp_nombre_contacto' => $this->input->post('emp_nombre_contacto'));
		$emp_id_empresa = $this->empresa_model->registrar($data);
		
		$data_pcliente = array('emp_id_empresa' => $emp_id_empresa,
				'est_id_estado' => $this->input->post('est_id_estado'),
				'pcl_eliminado' => 'NO',
				'pcl_tipo' => $this->input->post('pcl_tipo'));
		$pcl_id_pcliente = $this->pcliente_model->mregistrar($data_pcliente);
		
		$data = array('hecho' => 'SI');
		echo json_encode($data);
	}
	public function actualizar()
	{
		is_logged_in_or_exit($this);
		
		$emp_id_empresa = $this->input->post('emp_id_empresa');
		$data = array('emp_ruc' => $this->input->post('emp_ruc'),
				'emp_razon_social' => $this->input->post('emp_razon_social'),
				'emp_direccion' => $this->input->post('emp_direccion'),
				'emp_telefono' => $this->input->post('emp_telefono'),
				'emp_nombre_contacto' => $this->input->post('emp_nombre_contacto'));
		$result = $this->empresa_model->update_datos($emp_id_empresa, $data);
		
		$pcl_id_pcliente = $this->input->post('pcl_id_pcliente');
		$data_pcliente = array('pcl_id_pcliente' => $pcl_id_pcliente,
				'est_id_estado' => $this->input->post('est_id_estado'),
				'pcl_tipo' => $this->input->post('pcl_tipo'));
		$result = $this->pcliente_model->mactualizar($pcl_id_pcliente, $data_pcliente);
		
		$data = array('hecho' => 'SI');
		echo json_encode($data);
	}
	public function eliminar()
	{
		is_logged_in_or_exit($this);
		
		$pcl_id_pcliente = $this->input->post('pcl_id_pcliente');
		$data = array('pcl_eliminado' => 'SI');
		$result = $this->pcliente_model->mactualizar($pcl_id_pcliente, $data);
		
		$data = array('hecho' => 'SI');
		echo json_encode($data);
	}
}
