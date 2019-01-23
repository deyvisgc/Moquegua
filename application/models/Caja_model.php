<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caja_model extends CI_Model {
	function mguardar($data) {
		$result = $this->db->query("call proc_caja_guardar(@out_hecho, 
			@out_estado, 
			@out_caj_id_caja, 
			'".$data['caj_descripcion']."', 
			".$data['est_id_estado'].", 
			'".$data['caj_id_caja']."' 
			)");
		$result = $this->db->query("SELECT @out_hecho as hecho, @out_estado as estado, @out_caj_id_caja as caj_id_caja");
		return $result->row();
	}
	function maperturar($data) {
		$result = $this->db->query("call proc_caja_aperturar(
			@out_hecho, 
			@out_estado, 
			@out_caj_codigo, 
			".$data['usu_id_usuario'].", 
			'".$data['caj_id_caja']."' 
			)");
		$result = $this->db->query("SELECT @out_hecho as hecho, @out_estado as estado, @out_caj_codigo as caj_codigo");
		return $result->row();
	}
	function mcerrar($data) {
		$result = $this->db->query("call proc_caja_cerrar(
			@out_hecho, 
			@out_estado, 
			".$data['usu_id_usuario'].", 
			'".$data['caj_id_caja']."' 
			)");
		$result = $this->db->query("SELECT @out_hecho as hecho, @out_estado as estado");
		return $result->row();
	}
	function mbuscar_all() {
		$list = array();
		$query = $this->db->query("select 
			  caj_id_caja, 
			  caj_descripcion, 
			  ifnull(caj_codigo,'') caj_codigo, 
			  caj_abierta, 
			  usu_id_usuario, 
			  ifnull((select concat(per_nombre, ' ', per_apellido) from persona p where p.per_id_persona=caj.usu_id_usuario), '') usu_nombrecompleto, 
			  est_id_estado, 
			  (select est_nombre from estado est where est.est_id_estado=caj.est_id_estado) est_nombre 
			from caja caj ");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
	function mbuscar_caja_libre() {
		$list = array();
		$query = $this->db->query("SELECT 
			  caj_id_caja, 
			  caj_descripcion 
			FROM caja 
			WHERE est_id_estado=11 AND 
			  usu_id_usuario IS NULL AND 
			  caj_abierta='NO' ");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
	function mbuscar_caja_x_usuario($usu_id_usuario) {
		$query = $this->db->query("SELECT 
			  caj_id_caja, 
			  caj_codigo, 
			  caj_descripcion 
			FROM caja 
			WHERE est_id_estado=11 AND 
			  usu_id_usuario=$usu_id_usuario and 
			  caj_abierta='SI' ");
		foreach ($query->result() as $row)
		{
			return $row;
		}
		return false;
	}
}
?>