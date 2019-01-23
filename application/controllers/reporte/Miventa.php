<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Miventa extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');

        $this->load->database();
        $this->load->model('reporte_model');
        $this->load->model('rol_has_privilegio_model');

        $this->load->helper('seguridad');
        $this->load->helper('util');
        $this->load->helper('url');
    }

    public function index()
    {
        is_logged_in_or_exit($this);
        $data_header['list_privilegio'] = get_privilegios($this);
        $data_header['pri_grupo'] = 'REPORTE';
        $data_header['pri_nombre'] = 'Mis ventas';
        $data_header['usuario'] = get_usuario($this);
        $data_header['title'] = "Ventas del día";

        $data_footer['inits_function'] = array("init_ingreso");

        $this->load->view('header',$data_header);
        $this->load->view('reporte/ventas/misventas');
        $this->load->view('footer',$data_footer);
    }

    public function cargarCajas(){
        is_logged_in_or_exit($this);

        $usuario = get_usuario($this);
        $data = $usuario['usu_id_usuario'];
        $result = $this->reporte_model->cargar_caja($data);

        echo json_encode($result);
    }
}