<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producto extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		
		$this->load->database();
		$this->load->model('producto_model');
		$this->load->model('movimiento_model');
		$this->load->model('unidad_medida_model');
		$this->load->model('estado_model');
		$this->load->model('rol_has_privilegio_model');
		$this->load->model('clase_model');
		
		$this->load->helper('seguridad');
		$this->load->helper('util');
		$this->load->helper('url');
	}
	public function index()
	{
		is_logged_in_or_exit($this);
		$data_header['list_privilegio'] = get_privilegios($this);
		$data_header['pri_grupo'] = 'MANTENIMIENTO';
		$data_header['pri_nombre'] = 'Producto';
		$data_header['usuario'] = get_usuario($this);
		$data_header['title'] = "PRODUCTO";
		
		$list_estado = $this->estado_model->buscar_x_tabla("ACCESO");
		$data_body['list_estado'] = $list_estado;
		
		$data_footer['inits_function'] = array("init_producto");
		
		$this->load->view('header', $data_header);
		$this->load->view('mantenimiento/producto/index', $data_body);
		$this->load->view('footer', $data_footer);
	}
	public function buscar_xll()
	{
		is_logged_in_or_exit($this);
		
		$list_producto = $this->producto_model->buscar_all();
		
		$data = array('hecho' => 'SI', 'data' => $list_producto);
		echo json_encode($data);
	}
	public function registrar()
	{
		is_logged_in_or_exit($this);
		$usuario = get_usuario($this);
		$data = array('pro_codigo' => $this->input->post('pro_codigo'),
				'cla_clase' => $this->input->post('cla_clase'),
				'cla_subclase' => $this->input->post('cla_subclase'),
				'pro_nombre' => strtoupper($this->input->post('pro_nombre')),
				'pro_val_compra' => $this->input->post('pro_val_compra'),
				'pro_val_venta' => $this->input->post('pro_val_venta'),
				'pro_cantidad' => $this->input->post('pro_cantidad'),
				'pro_cantidad_min' => $this->input->post('pro_cantidad_min'),
				'unm_id_unidad_medida' => $this->input->post('unm_id_unidad_medida'),
				'pro_foto' => $this->input->post('pro_foto'),
				'pro_perecible' => $this->input->post('pro_perecible'),
				'pro_xm_cantidad1' => $this->input->post('pro_xm_cantidad1'),
				'pro_xm_valor1' => $this->input->post('pro_xm_valor1'),
				'pro_xm_cantidad2' => $this->input->post('pro_xm_cantidad2'),
				'pro_xm_valor2' => $this->input->post('pro_xm_valor2'),
				'pro_xm_cantidad3' => $this->input->post('pro_xm_cantidad3'),
				'pro_xm_valor3' => $this->input->post('pro_xm_valor3'),
				'pro_val_oferta' => $this->input->post('pro_val_oferta'),
				'est_id_estado' => $this->input->post('est_id_estado'),
				'pro_eliminado' => 'NO');
		$pro_id_producto = $this->producto_model->mregistrar($data);
		
		$data_movimiento = array(
				'mov_tipo' => 'IN1',
				'mov_cantidad_anterior' => 0,
				'mov_cantidad_entrante' => $data['pro_cantidad'],
				'mov_cantidad_actual' => $data['pro_cantidad'],
				'pro_id_producto' => $pro_id_producto,
				'est_id_estado' => 1,
				'usu_id_usuario' => $usuario['usu_id_usuario']);
		$mov_id_movimiento = $this->movimiento_model->mregistrar($data_movimiento);
		
		$data = array('hecho' => 'SI');
		echo json_encode($data);
	}
	public function actualizar()
	{
		is_logged_in_or_exit($this);
		
		$pro_id_producto = $this->input->post('pro_id_producto');
		$data = array('pro_codigo' => $this->input->post('pro_codigo'),
				'cla_clase' => $this->input->post('cla_clase'),
				'cla_subclase' => $this->input->post('cla_subclase'),
				'pro_nombre' => strtoupper($this->input->post('pro_nombre')),
				'pro_val_compra' => $this->input->post('pro_val_compra'),
				'pro_val_venta' => $this->input->post('pro_val_venta'),
				'pro_cantidad_min' => $this->input->post('pro_cantidad_min'),
				'unm_id_unidad_medida' => $this->input->post('unm_id_unidad_medida'),
				'pro_foto' => $this->input->post('pro_foto'),
				'pro_perecible' => $this->input->post('pro_perecible'),
				'pro_xm_cantidad1' => $this->input->post('pro_xm_cantidad1'),
				'pro_xm_valor1' => $this->input->post('pro_xm_valor1'),
				'pro_xm_cantidad2' => $this->input->post('pro_xm_cantidad2'),
				'pro_xm_valor2' => $this->input->post('pro_xm_valor2'),
				'pro_xm_cantidad3' => $this->input->post('pro_xm_cantidad3'),
				'pro_xm_valor3' => $this->input->post('pro_xm_valor3'),
				'pro_val_oferta' => $this->input->post('pro_val_oferta'),
				'est_id_estado' => $this->input->post('est_id_estado'));
		$result = $this->producto_model->mactualizar($pro_id_producto, $data);
		
		$data = array('hecho' => 'SI');
		echo json_encode($data);
	}
	public function eliminar()
	{
		is_logged_in_or_exit($this);
		
		$pro_id_producto = $this->input->post('pro_id_producto');
		$data = array('pro_eliminado' => 'SI');
		$result = $this->producto_model->mactualizar($pro_id_producto, $data);
		
		$data = array('hecho' => 'SI');
		echo json_encode($data);
	}
}
