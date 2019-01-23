<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clase extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		
		$this->load->database();
		$this->load->model('clase_model');
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
		$data_header['pri_nombre'] = 'Clase';
		$data_header['usuario'] = get_usuario($this);
		$data_header['title'] = "CLASE";
		
		$list_estado = $this->estado_model->buscar_x_tabla('ACCESO');
		$data_body['list_estado'] = $list_estado;
		
		$data_footer['inits_function'] = array("init_clase");
		
		$this->load->view('header', $data_header);
		$this->load->view('mantenimiento/clase/formulario', $data_body);
		$this->load->view('footer', $data_footer);
	}
	public function buscar_x_nombre()
	{
		is_logged_in_or_exit($this);
		
		$texto = $this->input->post('texto');
		$list_clase = $this->clase_model->buscar_x_nombre($texto);
		
		$data = array('hecho' => 'SI', 'data' => $list_clase);
		echo json_encode($data);
	}
	public function registrar()
	{
		is_logged_in_or_exit($this);
		
		$cla_id_clase_superior = $this->input->post('cla_id_clase_superior');
		$data = array('cla_nombre' => $this->input->post('cla_nombre'),
				'est_id_estado' => $this->input->post('est_id_estado'));
		if($cla_id_clase_superior == '') {
			$data['cla_id_clase_superior'] = 'null';
		}
		else {
			$data['cla_id_clase_superior'] = $cla_id_clase_superior;
		}
		$cla_id_clase = $this->clase_model->registrar($data);
		
		$data = array('hecho' => 'SI');
		echo json_encode($data);
	}
	public function actualizar()
	{
		is_logged_in_or_exit($this);
		
		$cla_id_clase = $this->input->post('cla_id_clase');
		$cla_id_clase_superior = $this->input->post('cla_id_clase_superior');
		$data = array('cla_nombre' => $this->input->post('cla_nombre'),
				'est_id_estado' => $this->input->post('est_id_estado'));
		if($cla_id_clase_superior == '') {
			$data['cla_id_clase_superior'] = 'null';
		}
		else {
			$data['cla_id_clase_superior'] = $cla_id_clase_superior;
		}
		$result = $this->clase_model->update_datos($cla_id_clase, $data);
		
		$data = array('hecho' => 'SI');
		echo json_encode($data);
	}
	public function eliminar()
	{
		is_logged_in_or_exit($this);
		
		$cla_id_clase = $this->input->post('cla_id_clase');
		$data = array('cla_eliminado' => 'SI');
		$result = $this->clase_model->update_datos2($cla_id_clase, $data);
		
		$data = array('hecho' => 'SI');
		echo json_encode($data);
	}
	public function buscar_all_superior()
	{
		is_logged_in_or_exit($this);
		
		$list_clase = $this->clase_model->buscar_all_superior();
		
		$data = array('hecho' => 'SI', 'list_clase' => $list_clase);
		echo json_encode($data);
	}
	// OTROS
	// CALL: VISTA-PRODUCTO-INDEX
	// CALL: VISTA-INGRESO-PROVEEDOR-INDEX
	public function buscar_xll_habilitados()
	{
		is_logged_in_or_exit($this);
		
		$list_clase = $this->clase_model->buscar_all_habilitados();
		
		$data = array('hecho' => 'SI', 'list_clase' => $list_clase);
		echo json_encode($data);
	}
}
