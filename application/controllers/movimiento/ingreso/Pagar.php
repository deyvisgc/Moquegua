<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pagar extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');

        $this->load->database();
        $this->load->model('ingreso_model');
        $this->load->model('rol_has_privilegio_model');

        $this->load->helper('seguridad');
        $this->load->helper('util');
        $this->load->helper('url');
    }
    public function index(){
        is_logged_in_or_exit($this);
        $data_header['list_privilegio'] = get_privilegios($this);
        $data_header['pri_grupo'] = 'MOVIMIENTO';
        $data_header['pri_nombre'] = 'Cuentas por Pagar';
        $data_header['usuario'] = get_usuario($this);
        $data_header['title'] = "Cuentas Por Pagar";

        $data_footer['inits_function'] = array("init_ingreso");

        $this->load->view('header', $data_header);
        $this->load->view('movimiento/ingreso/pagar/index');
        $this->load->view('footer', $data_footer);
    }

    public function listarProveedores(){
        $result = array('data'=>array());
        $data= $this->ingreso_model->listarProveedores();
        foreach($data as $key => $value){
            $cliente = $value['emp_razon_social'];
            $fecha =$value['ing_fecha_doc_proveedor'];
            $deuda =$value['ing_monto_efectivo'];
            $buttons = '
			<button type="button" onclick="editarDeuda('.$value['ing_id_ingreso'].')" data-toggle="modal" data-target="#editarDatos"
			class="btn btn-outline-warning btn-fw btn-primary">
			<i class="mdi mdi-pencil"></i>Marcar como Pagado</button>';
            $result['data'][$key] = array(
                $cliente,$fecha,$deuda,
                $buttons
            );
        }
        echo json_encode($result);
    }

    public function editarDeuda($ing_id_ingreso){
        $data=$this->ingreso_model->editarDebt($ing_id_ingreso);
        echo json_encode($data);
    }
}