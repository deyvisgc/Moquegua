<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		
		$this->load->database();
		$this->load->model('tipo_documento_model');
		$this->load->model('rol_model');
		$this->load->model('estado_model');
		$this->load->model('usuario_model');
		$this->load->model('persona_model');
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
		$data_header['pri_nombre'] = 'Usuario';
		$data_header['usuario'] = get_usuario($this);
		$data_header['title'] = "USUARIO";
		
		$list_tipo_documento = $this->tipo_documento_model->buscar_x_tabla('PERSONA');
		$data_body['list_tipo_documento'] = $list_tipo_documento;
		
		$list_rol = $this->rol_model->buscar_habilitado();
		$data_body['list_rol'] = $list_rol;
		
		$list_estado = $this->estado_model->buscar_x_tabla('ACCESO');
		$data_body['list_estado'] = $list_estado;
		
		$data_footer['inits_function'] = array("init_usuario");
		
		$this->load->view('header', $data_header);
		$this->load->view('mantenimiento/usuario/formulario', $data_body);
		$this->load->view('footer', $data_footer);
	}
	public function buscar_x_nombre_o_documento()
	{
		is_logged_in_or_exit($this);
		
		$list_usuario = $this->usuario_model->buscar_x_nombre_o_documento('');
		
		$data = array('hecho' => 'SI', 'data' => $list_usuario);
		echo json_encode($data);
	}
	public function registrar()
	{
		is_logged_in_or_exit($this);
		
		$data = array('per_nombre' => $this->input->post('per_nombre'),
				'per_apellido' => $this->input->post('per_apellido'),
				'tdo_id_tipo_documento' => $this->input->post('tdo_id_tipo_documento'),
				'per_numero_doc' => $this->input->post('per_numero_doc'),
				'per_direccion' => $this->input->post('per_direccion'),
				'per_tel_movil' => $this->input->post('per_tel_movil'),
				'per_tel_fijo' => $this->input->post('per_tel_fijo'),
				'per_foto' => $this->input->post('per_foto'));
		$per_id_persona = $this->persona_model->registrar($data);
		
		$opt = array("cost" => 12);
		$usu_clave_ph = password_hash($this->input->post('usu_clave'), PASSWORD_BCRYPT, $opt);
		$data_usuario = array(
				'usu_nombre' => $this->input->post('usu_nombre'),
				'usu_clave' => $usu_clave_ph,
				'rol_id_rol' => $this->input->post('rol_id_rol'),
				'est_id_estado' => $this->input->post('est_id_estado'),
				'usu_id_usuario' => $per_id_persona );
		$result = $this->usuario_model->registrar($data_usuario);
		
		$data = array('hecho' => 'SI');
		echo json_encode($data);
	}
	public function actualizar()
	{
		is_logged_in_or_exit($this);
		
		$usu_id_usuario = $this->input->post('usu_id_usuario');
		$data = array('per_nombre' => $this->input->post('per_nombre'),
				'per_apellido' => $this->input->post('per_apellido'),
				'tdo_id_tipo_documento' => $this->input->post('tdo_id_tipo_documento'),
				'per_numero_doc' => $this->input->post('per_numero_doc'),
				'per_direccion' => $this->input->post('per_direccion'),
				'per_tel_movil' => $this->input->post('per_tel_movil'),
				'per_tel_fijo' => $this->input->post('per_tel_fijo'),
				'per_foto' => $this->input->post('per_foto'));
		$result = $this->persona_model->update_datos($usu_id_usuario, $data);
		
		$opt = array("cost" => 12);
		$usu_clave_ph = password_hash($this->input->post('usu_clave'), PASSWORD_BCRYPT, $opt);
		$data_usuario = array(
				'usu_nombre' => $this->input->post('usu_nombre'),
				'rol_id_rol' => $this->input->post('rol_id_rol'),
				'est_id_estado' => $this->input->post('est_id_estado'));
		$result = $this->usuario_model->update_datos($usu_id_usuario, $data_usuario);
		
		$data = array('hecho' => 'SI');
		echo json_encode($data);
	}
	
}
