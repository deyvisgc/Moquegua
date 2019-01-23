<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datos_empresa_local extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		
		$this->load->database();
		$this->load->model('datos_empresa_local_model');
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
		$data_header['pri_nombre'] = 'Datos Empresa Local';
		$data_header['usuario'] = get_usuario($this);
		$data_header['title'] = "DATOS EMPRESA LOCAL";
		
		$texto = $this->input->post('texto');
		$data_body['datos_empresa_local'] = $this->datos_empresa_local_model->buscar_id_unico();
		
		$data_footer['inits_function'] = array("init_datos_empresa_local");
		
		$this->load->view('header', $data_header);
		$this->load->view('mantenimiento/datos_empresa_local/formulario', $data_body);
		$this->load->view('footer', $data_footer);
	}
	public function actualizar()
	{
		is_logged_in_or_exit($this);
		
		$daemlo_id_datos_empresa_local = $this->input->post('daemlo_id_datos_empresa_local');
		$data = array('daemlo_ruc' => $this->input->post('daemlo_ruc'),
				'daemlo_nombre_empresa_juridica' => $this->input->post('daemlo_nombre_empresa_juridica'),
				'daemlo_nombre_empresa_fantasia' => $this->input->post('daemlo_nombre_empresa_fantasia'),
				'daemlo_codigo_postal' => $this->input->post('daemlo_codigo_postal'),
				'daemlo_direccion' => $this->input->post('daemlo_direccion'),
				'daemlo_ciudad' => $this->input->post('daemlo_ciudad'),
				'daemlo_estado' => $this->input->post('daemlo_estado'),
				'daemlo_telefono' => $this->input->post('daemlo_telefono'),
				'daemlo_telefono2' => $this->input->post('daemlo_telefono2'),
				'daemlo_telefono3' => $this->input->post('daemlo_telefono3'),
				'daemlo_telefono4' => $this->input->post('daemlo_telefono4'),
				'daemlo_contacto' => $this->input->post('daemlo_contacto'),
				'daemlo_web' => $this->input->post('daemlo_web'),
				'daemlo_facebook' => $this->input->post('daemlo_facebook'),
				'daemlo_instagram' => $this->input->post('daemlo_instagram'),
				'daemlo_twitter' => $this->input->post('daemlo_twitter'),
				'daemlo_youtube' => $this->input->post('daemlo_youtube'),
				'daemlo_otros' => $this->input->post('daemlo_otros'));
		$result = $this->datos_empresa_local_model->update_datos($daemlo_id_datos_empresa_local, $data);
		
		$data = array('hecho' => 'SI');
		echo json_encode($data);
	}
}
