<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {
	function registrar($data) {
		$result = $this->db->insert('usuario', $data);
		return  $result;
	}
	function update_datos($usu_id_usuario, $data) {
		$this->db->where('usu_id_usuario', $usu_id_usuario);
        return $this->db->update('usuario', $data);
	}
	function mvalidar_acceso($usu_nombre, $usu_clave) {
		$query = $this->db->query("SELECT usu_id_usuario, 
				  usu_nombre, 
				  per_nombre, 
				  per_apellido, 
				  per_foto, 
				  rol_id_rol, 
				  usu_clave 
				FROM usuario u 
				INNER JOIN persona p 
				ON u.usu_id_usuario=p.per_id_persona 
				WHERE usu_nombre='$usu_nombre' 
				  AND est_id_estado=11");
		foreach ($query->result() as $row)
		{
			if(password_verify($usu_clave, $row->usu_clave)){
				return $row;
			}
			else {
				return false;
			}
		}
		return false;
	}
	function buscar_x_nombre_o_documento($texto) {
		$list = array();
		$query = $this->db->query("SELECT u.usu_id_usuario, 
				  u.usu_nombre, 
				  u.rol_id_rol, 
				  r.rol_nombre, 
				  u.est_id_estado, 
				  e.est_nombre, 
				  p.per_nombre, 
				  p.per_apellido, 
				  p.tdo_id_tipo_documento, 
				  td.tdo_nombre, 
				  p.per_numero_doc, 
				  p.per_direccion, 
				  p.per_tel_movil, 
				  p.per_tel_fijo, 
				  p.per_foto 
				FROM usuario u 
				INNER JOIN persona p 
				ON u.usu_id_usuario=p.per_id_persona 
				INNER JOIN rol r 
				ON u.rol_id_rol=r.rol_id_rol 
				INNER JOIN estado e 
				ON u.est_id_estado=e.est_id_estado 
				INNER JOIN tipo_documento td 
				ON p.tdo_id_tipo_documento=td.tdo_id_tipo_documento 
				WHERE u.est_id_estado=11") ;
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
	function usersEnabled(){
        $list = array();
        $query = $this->db->query("SELECT u.usu_id_usuario, 
				  u.usu_nombre, 
				  u.rol_id_rol, 
				  r.rol_nombre, 
				  u.est_id_estado, 
				  e.est_nombre, 
				  p.per_nombre, 
				  p.per_apellido, 
				  p.tdo_id_tipo_documento, 
				  td.tdo_nombre, 
				  p.per_numero_doc, 
				  p.per_direccion, 
				  p.per_tel_movil, 
				  p.per_tel_fijo, 
				  p.per_foto 
				FROM usuario u 
				INNER JOIN persona p 
				ON u.usu_id_usuario=p.per_id_persona 
				INNER JOIN rol r 
				ON u.rol_id_rol=r.rol_id_rol 
				INNER JOIN estado e 
				ON u.est_id_estado=e.est_id_estado 
				INNER JOIN tipo_documento td 
				ON p.tdo_id_tipo_documento=td.tdo_id_tipo_documento 
				WHERE u.est_id_estado=12") ;
        foreach ($query->result() as $row)
        {
            $list[] = $row;
        }
        return $list;
    }
	// CONTROL-CAJA -> METODO-INDEX
	function buscar_x_nombrecompleto($texto) {
		$list = array();
		$query = $this->db->query("SELECT 
				  u.usu_id_usuario, 
				  p.per_nombre, 
				  p.per_apellido, 
				  p.per_foto 
				FROM usuario u 
				  INNER JOIN persona p 
				  ON u.usu_id_usuario=p.per_id_persona 
				WHERE concat(p.per_nombre, ' ', p.per_apellido) like '%".$texto."%' 
				order by p.per_nombre, p.per_apellido ");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
}
?>