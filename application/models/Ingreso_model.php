<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ingreso_model extends CI_Model {
	function mregistrar($data) {
		$result = $this->db->query("call proc_ingreso_registrar( 
			@out_hecho, 
			@out_estado, 
			".$data['usu_id_usuario'].", 
			".$data['pcl_id_proveedor'].", 
			'".$data['ing_fecha_doc_proveedor']."', 
			".$data['tdo_id_tipo_documento'].", 
			'".$data['ing_numero_doc_proveedor']."', 
			".$data['ing_monto_efectivo'].", 
			".$data['ing_monto_tar_credito'].", 
			".$data['ing_monto_tar_debito'].",
			'".$data['in_tipo']."'
			)");
		$result = $this->db->query("SELECT @out_hecho as hecho, @out_estado as estado");
		
		return $result->row();
	}
	public function listarProveedores(){
        $consulta = "SELECT ing.ing_id_ingreso, em.emp_razon_social ,ing.ing_fecha_doc_proveedor,ing.ing_monto_efectivo,ing.pcl_id_proveedor FROM ingreso as ing, pcliente as cli, empresa as em WHERE cli.emp_id_empresa=em.emp_id_empresa AND cli.pcl_id_pcliente=ing.pcl_id_proveedor AND ing.in_tipo='deuda'";
        $datos = $this->db->query($consulta);
        return $datos->result_array();
    }

    public function editarDebt($ing_id_ingreso){
        $consulta ="UPDATE ingreso SET in_tipo = 'contado' WHERE ingreso.ing_id_ingreso = $ing_id_ingreso";
        $this->db->query($consulta);
    }
}
?>