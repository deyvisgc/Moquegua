<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rol_has_privilegio_model extends CI_Model {
	function registrar($data) {
		$this->db->insert('rol_has_privilegio', $data);
	}
	function quitar($data) {
		$this->db->where('rol_id_rol', $data['rol_id_rol']);
		$this->db->where('pri_id_privilegio', $data['pri_id_privilegio']);
		$this->db->delete('rol_has_privilegio');
	}
	function buscar_x_rol($rol_id_rol) {
		$list = array();
		$query = $this->db->query("SELECT 
			  p.pri_id_privilegio, 
			  p.pri_nombre, 
			  p.pri_orden, 
			  IFNULL(rhp.pri_id_privilegio, -1) pri_id_privilegio2 
			FROM privilegio p 
			  LEFT JOIN 
			  (SELECT *  
			    FROM rol_has_privilegio rhp 
			    WHERE rol_id_rol=".$rol_id_rol.") rhp 
			  ON p.pri_id_privilegio=rhp.pri_id_privilegio 
			order by p.pri_orden ");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
	function buscar_habilitados_x_rol($usu_id_usuario) {
		$list = array();
		$query = $this->db->query("
			SELECT 
			  p.pri_id_privilegio, 
			  p.pri_nombre, 
			  p.pri_acceso, 
			  p.pri_grupo, 
			  p.pri_orden, 
			  p.pri_ico, 
			  p.pri_ico_grupo 
			FROM usuario u 
			  INNER JOIN 
			  rol r 
			  ON r.rol_id_rol=u.rol_id_rol 
			    AND u.est_id_estado=11 
			    AND r.est_id_estado=11 
			  INNER JOIN 
			  rol_has_privilegio rhp 
			  ON rhp.rol_id_rol=r.rol_id_rol 
			  INNER JOIN 
			  privilegio p 
			  ON p.pri_id_privilegio=rhp.pri_id_privilegio 
			    AND p.est_id_estado=1 
			WHERE u.usu_id_usuario='$usu_id_usuario' 
			ORDER BY p.pri_grupo, p.pri_orden");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
}
?>