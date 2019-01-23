<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Privilegio_model extends CI_Model {
	function buscar_ingreso_x_tabla() {
		$list = array();
		$query = $this->db->query("SELECT tdo_id_tipo_documento, 
			  tdo_nombre, 
			  tdo_tamanho, 
			  tdo_orden 
			FROM tipo_documento 
			WHERE tdo_tabla='INGRESO' 
			ORDER BY tdo_orden");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
}
?>