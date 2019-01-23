<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cobrar extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');

        $this->load->database();
        $this->load->model('salida_model');
        $this->load->model('salida_detalle_model');
        $this->load->model('datos_empresa_local_model');
        $this->load->model('rol_has_privilegio_model');

        $this->load->helper('seguridad');
        $this->load->helper('util');
        $this->load->helper('url');
    }

    public function index(){
        is_logged_in_or_exit($this);
        $data_header['list_privilegio'] = get_privilegios($this);
        $data_header['pri_grupo'] = 'MOVIMIENTO';
        $data_header['pri_nombre'] = 'Cuentas Por Cobrar';
        $data_header['usuario'] = get_usuario($this);
        $data_header['title'] = "Cuentas Por Cobrar";

        $data_body['datos_empresa_local'] = $this->datos_empresa_local_model->buscar_id_unico();

        $data_footer['inits_function'] = array("init_salida");

        $this->load->view('header', $data_header);
        $this->load->view('movimiento/salida/cobrar/index', $data_body);
        $this->load->view('footer', $data_footer);
    }

    public function listarClientes(){
        $result = array('data'=>array());
        $data= $this->salida_model->listarCliente();
        foreach($data as $key => $value){
            $cliente = $value['emp_razon_social'];
            $fecha =$value['sal_fecha_doc_cliente'];
            $deuda =$value['sal_monto_efectivo'];
            $buttons = '
			<button type="button" onclick="editarDeuda('.$value['sal_id_salida'].')" data-toggle="modal" data-target="#editarDatos"
			class="btn btn-outline-warning btn-fw btn-primary">
			<i class="mdi mdi-pencil"></i>Marcar como Pagado</button>';
            $result['data'][$key] = array(
                $cliente,$fecha,$deuda,
                $buttons
            );
        }
        echo json_encode($result);
    }

    public function editarDeuda($sal_id_salida){
        $data=$this->salida_model->editarDebt($sal_id_salida);
        echo json_encode($data);
    }
}
?>