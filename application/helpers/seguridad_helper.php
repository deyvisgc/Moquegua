<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('esta_conectado'))
{
	function esta_conectado($_this)
	{
		if($_this->session->userdata('per_nombre')){
			return true;
		}
		else{
			$url_nueva = base_url().'logueo/index';
			echo "<script>alert('Inicie sesion.');</script>";
			
			redirect($url_nueva, 'refresh');
			die();
		}
	}
}

if(!function_exists('is_logged_in'))
{
	function is_logged_in($_this)
	{
		if($_this->session->userdata('per_nombre')){
			return true;
		}
		else{
			return false;
		}
	}
}

if(!function_exists('is_logged_in_or_exit'))
{
	function is_logged_in_or_exit($_this)
	{
		if($_this->session->userdata('per_nombre')){
			return true;
		}
		else{
			$url_nueva = base_url();
			redirect($url_nueva, 'refresh');
			die();
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

?>