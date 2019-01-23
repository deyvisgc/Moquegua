<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unidad_medida extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		
		$this->load->database();
		$this->load->model('unidad_medida_model');
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
		$data_header['pri_nombre'] = 'Uni. Medida';
		$data_header['usuario'] = get_usuario($this);
		$data_header['title'] = "UNIDAD DE MEDIDA";
		
		$list_estado = $this->estado_model->buscar_x_tabla('ACCESO');
		$data_body['list_estado'] = $list_estado;
		
		$data_footer['inits_function'] = array("init_unidad_medida");
		
		$this->load->view('header', $data_header);
		$this->load->view('mantenimiento/unidad_medida/formulario', $data_body);
		$this->load->view('footer', $data_footer);
	}
	public function buscar_x_nombre_o_corto()
	{
		is_logged_in_or_exit($this);
		
		$texto = $this->input->post('texto');
		$list_unidad_medida = $this->unidad_medida_model->buscar_x_nombre_o_corto($texto);
		
		$data = array('hecho' => 'SI', 'data' => $list_unidad_medida);
		echo json_encode($data);
	}
	public function registrar()
	{
		is_logged_in_or_exit($this);
		
		$data = array('unm_nombre' => $this->input->post('unm_nombre'),
				'unm_nombre_corto' => $this->input->post('unm_nombre_corto'),
				'est_id_estado' => $this->input->post('est_id_estado'),
				'unm_eliminado' => 'NO');
		$unm_id_unidad_medida = $this->unidad_medida_model->registrar($data);
		
		$data = array('hecho' => 'SI');
		echo json_encode($data);
	}
	public function actualizar()
	{
		is_logged_in_or_exit($this);
		
		$unm_id_unidad_medida = $this->input->post('unm_id_unidad_medida');
		$data = array('unm_nombre' => $this->input->post('unm_nombre'),
				'unm_nombre_corto' => $this->input->post('unm_nombre_corto'),
				'est_id_estado' => $this->input->post('est_id_estado'));
		$result = $this->unidad_medida_model->update_datos($unm_id_unidad_medida, $data);
		
		$data = array('hecho' => 'SI');
		echo json_encode($data);
	}
	public function eliminar()
	{
		is_logged_in_or_exit($this);
		
		$unm_id_unidad_medida = $this->input->post('unm_id_unidad_medida');
		$data = array('unm_eliminado' => 'SI');
		$result = $this->unidad_medida_model->update_datos($unm_id_unidad_medida, $data);
		
		$data = array('hecho' => 'SI');
		echo json_encode($data);
	}
	// OTROS
	// CALL: VISTA-PRODUCTO-INDEX
	public function buscar_xll_habilitados()
	{
		is_logged_in_or_exit($this);
		
		$list_unidad_medida = $this->unidad_medida_model->buscar_all_habilitados();
		
		$data = array('hecho' => 'SI', 'list_unidad_medida' => $list_unidad_medida);
		echo json_encode($data);
	}
}
