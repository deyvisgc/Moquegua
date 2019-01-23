<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datos_empresa_local_model extends CI_Model {
	function update_datos($daemlo_id_datos_empresa_local, $data) {
		$this->db->where('daemlo_id_datos_empresa_local', $daemlo_id_datos_empresa_local);
        return $this->db->update('datos_empresa_local', $data);
	}
	function buscar_id_unico() {
		$list = array();
		$query = $this->db->query("select 
			  daemlo_id_datos_empresa_local, 
			  daemlo_ruc, 
			  daemlo_nombre_empresa_juridica, 
			  daemlo_nombre_empresa_fantasia, 
			  daemlo_codigo_postal, 
			  daemlo_direccion, 
			  daemlo_ciudad, 
			  daemlo_estado, 
			  daemlo_telefono, 
			  daemlo_telefono2, 
			  daemlo_telefono3, 
			  daemlo_telefono4, 
			  daemlo_contacto, 
			  daemlo_web, 
			  daemlo_facebook, 
			  daemlo_instagram, 
			  daemlo_twitter, 
			  daemlo_youtube, 
			  daemlo_otros 
			from datos_empresa_local 
			where daemlo_id_datos_empresa_local=1");
		foreach ($query->result() as $row)
		{
			return $row;
		}
		return false;
	}
}
?>