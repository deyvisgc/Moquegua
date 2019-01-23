<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipo_documento_model extends CI_Model {
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
	function buscar_ingreso_x_tablax1($sal_id_salida) {
		$list = array();
		$query = $this->db->query("select tdo_id_tipo_documento, 
			  tdo_nombre, 
			  tdo_tamanho, 
			  tdo_orden, 
			  CONCAT( REPEAT('0',(8-LENGTH(numero))) ,numero) numero 
			from (
			    SELECT tdo_id_tipo_documento, 
			      tdo_nombre, 
			      tdo_tamanho, 
			      tdo_orden, 
			      (SELECT IFNULL(MAX( CAST(sal_numero_doc_cliente AS UNSIGNED) ),0)+1  
			        FROM salida s 
			        WHERE s.tdo_id_tipo_documento=td.tdo_id_tipo_documento 
			          and sal_id_salida!=".$sal_id_salida.") numero 
			    FROM tipo_documento td 
			    WHERE tdo_tabla='INGRESO'
			  ) t 
			ORDER BY tdo_orden");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
	function buscar_x_tabla($tdo_tabla) {
		$list = array();
		$query = $this->db->query("SELECT tdo_id_tipo_documento, 
			  tdo_nombre, 
			  tdo_tamanho, 
			  tdo_orden 
			FROM tipo_documento 
			WHERE tdo_tabla='".$tdo_tabla."' 
			ORDER BY tdo_orden");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
}
?>