<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estado_model extends CI_Model {
	function buscar_x_tabla($est_tabla) {
		$list = array();
		$query = $this->db->query("SELECT est_id_estado, 
			  est_nombre, 
			  est_orden 
			FROM estado 
			WHERE est_tabla='".$est_tabla."' 
			ORDER BY est_orden");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
}
?>