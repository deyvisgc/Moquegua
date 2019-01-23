<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rol_model extends CI_Model {
	function registrar($data) {
		$this->db->insert('rol', $data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	function update_datos($rol_id_rol, $data) {
		$this->db->where('rol_id_rol', $rol_id_rol);
        return $this->db->update('rol', $data);
	}
	function buscar_habilitado() {
		$list = array();
		$query = $this->db->query("SELECT rol_id_rol, 
			  rol_nombre 
			FROM rol 
			WHERE est_id_estado=11 
			ORDER BY rol_id_rol");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
	function buscar_x_nombre($texto) {
		$list = array();
		$query = $this->db->query("select 
			  rol_id_rol, 
			  rol_nombre, 
			  est_id_estado, 
			  (select est_nombre from estado e where e.est_id_estado=c.est_id_estado) est_nombre 
			from rol c 
			where rol_nombre like '%".$texto."%' ");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
}
?>