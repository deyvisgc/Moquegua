<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('get_usuario'))
{
	function get_usuario($_this)
	{
		if($_this->session->userdata('usu_id_usuario')){
			// return $_this->session->userdata('usu_id_usuario');
			$data['usu_id_usuario'] = $_this->session->userdata('usu_id_usuario');
			$data['usu_nombre'] = $_this->session->userdata('usu_nombre');
			$data['per_nombre'] = $_this->session->userdata('per_nombre');
			$data['per_apellido'] = $_this->session->userdata('per_apellido');
			$data['per_foto'] = $_this->session->userdata('per_foto');
			$data['rol_id_rol'] = $_this->session->userdata('rol_id_rol');
			
			return $data;
		}
		else{
			return false;
		}
	}
}
/* if(!function_exists('get_id_usuario'))
{
	function get_id_usuario($_this)
	{
		if($_this->session->userdata('usu_id_usuario')){
			return $_this->session->userdata('usu_id_usuario');
		}
		else{
			return false;
		}
	}
} */
/* if(!function_exists('esta_conectado'))
{
	function esta_conectado($_this)
	{
		if($_this->session->userdata('per_nombre')){
			return true;
		}
		else{
			/ * $url_nueva = base_url();
			// echo "<script>alert('Inicie sesion.');</script>";
			redirect($url_nueva, 'refresh');
			die(); * /
			return false;
		}
	}
}

if(!function_exists('get_id_usuario'))
{
	function get_id_usuario($_this)
	{
		if($_this->session->userdata('usu_id_usuario')){
			return $_this->session->userdata('usu_id_usuario');
		}
		else{
			return false;
		}
	}
}

if(!function_exists('get_privilegios'))
{
	function get_privilegios($_this)
	{
		$usu_id_usuario = $_this->session->userdata('usu_id_usuario');
		$html = $_this->rol_has_privilegio_model->get_privilegios_html($usu_id_usuario);
		return $html;
	}
} */
if(!function_exists('get_privilegios'))
{
	function get_privilegios($_this)
	{
		$usu_id_usuario = $_this->session->userdata('usu_id_usuario');
		$list = $_this->rol_has_privilegio_model->buscar_habilitados_x_rol($usu_id_usuario);
		return $list;
	}
}

if(!function_exists('generar_cadena_dinamica'))
{
	function generar_cadena_dinamica($tamanho)
	{
		$caracteres = str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ");
		$cadena = substr($caracteres, 0, $tamanho);
		return $cadena;
	}
}

if(!function_exists('get_fecha_actual'))
{
	function get_fecha_actual()
	{
		date_default_timezone_set('America/Lima');
		
		$dias = array("Domingo",
			"Lunes",
			"Martes",
			"Miercoles",
			"Jueves",
			"Viernes",
			"Sábado");
		$meses = array("Enero",
			"Febrero",
			"Marzo",
			"Abril",
			"Mayo","Junio",
			"Julio",
			"Agosto",
			"Septiembre",
			"Octubre",
			"Noviembre",
			"Diciembre");
		return $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y');
	}
}

?>