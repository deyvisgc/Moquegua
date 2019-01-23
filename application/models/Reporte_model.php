<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte_model extends CI_Model {
	function mstock_general() {
		$list = array();
		$query = $this->db->query("SELECT 
			  IFNULL(cla_clase,'') cla_clase, 
			  IFNULL((SELECT cc.cla_nombre FROM clase cc WHERE cc.cla_id_clase=p.cla_clase),'') clase_nombre, 
			  IFNULL(cla_subclase,'') cla_subclase, 
			  IFNULL((SELECT cc.cla_nombre FROM clase cc WHERE cc.cla_id_clase=p.cla_subclase),'') subclase_nombre, 
			  pro_codigo, 
			  pro_nombre, 
			  FORMAT(pro_cantidad, 0, 'de_DE') pro_cantidad, 
			  pro_val_compra pro_val_compra, 
			  pro_val_venta pro_val_venta, 
			  FORMAT(pro_cantidad_min, 0, 'de_DE') pro_cantidad_min 
			FROM producto p ");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
	function mstock_minimo() {
		$list = array();
		$query = $this->db->query("SELECT 
			  IFNULL(cla_clase,'') cla_clase, 
			  IFNULL((SELECT cc.cla_nombre FROM clase cc WHERE cc.cla_id_clase=p.cla_clase),'') clase_nombre, 
			  IFNULL(cla_subclase,'') cla_subclase, 
			  IFNULL((SELECT cc.cla_nombre FROM clase cc WHERE cc.cla_id_clase=p.cla_subclase),'') subclase_nombre, 
			  IFNULL((SELECT unm.unm_nombre_corto FROM unidad_medida unm WHERE unm.unm_id_unidad_medida=p.unm_id_unidad_medida),'') unm_nombre_corto, 
			  pro_codigo, 
			  pro_nombre, 
			  FORMAT(pro_cantidad, 0, 'de_DE') pro_cantidad, 
			  pro_val_compra pro_val_compra, 
			  pro_val_venta pro_val_venta, 
			  FORMAT(pro_cantidad_min, 0, 'de_DE') pro_cantidad_min 
			FROM producto p ");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
	
	function mmovimiento_diario_ingreso($fecha_ini, $fecha_fin) {
		$list = array();
		$query = $this->db->query("SELECT 
			  ing_fecha_doc_proveedor, 
			  ing_fecha_registro, 
			  tdo_id_tipo_documento, 
			  IFNULL((SELECT tdo.tdo_nombre FROM tipo_documento tdo WHERE tdo.tdo_id_tipo_documento=ing.tdo_id_tipo_documento),'') tdo_nombre, 
			  ing_numero_doc_proveedor, 
			  (SELECT emp.emp_razon_social FROM pcliente pcl INNER JOIN empresa emp ON pcl.emp_id_empresa=emp.emp_id_empresa WHERE pcl.pcl_id_pcliente=ing.pcl_id_proveedor) emp_razon_social, 
			  FORMAT(ing_monto, 2, 'de_DE') ing_monto 
			FROM ingreso ing 
			WHERE STR_TO_DATE(ing_fecha_doc_proveedor, '%Y-%m-%d') BETWEEN STR_TO_DATE('$fecha_ini', '%Y-%m-%d') AND STR_TO_DATE('$fecha_fin', '%Y-%m-%d') 
			ORDER BY ing_fecha_registro DESC ");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
	function mmovimiento_diario_totales_ingreso($fecha_ini, $fecha_fin) {
		$query = $this->db->query("SELECT 
			  FORMAT(IFNULL(ing_monto,0), 2, 'de_DE') ing_monto 
			FROM (SELECT
			  (SELECT 
			      SUM(ing_monto) 
			    FROM ingreso ing 
			    WHERE STR_TO_DATE(ing_fecha_doc_proveedor, '%Y-%m-%d') BETWEEN STR_TO_DATE('$fecha_ini', '%Y-%m-%d') AND STR_TO_DATE('$fecha_fin', '%Y-%m-%d') 
			  ) ing_monto 
			) tabla ");
		foreach ($query->result() as $row)
		{
			return $row;
		}
		return array('ing_monto' => '0.00');
	}
	
	function mmovimiento_diario_salida($fecha_ini, $fecha_fin) {
		$list = array();
		$query = $this->db->query("SELECT 
 sal_fecha_doc_cliente, sal_fecha_registro, tdo_id_tipo_documento, 
  IFNULL((SELECT tdo.tdo_nombre FROM tipo_documento tdo WHERE tdo.tdo_id_tipo_documento=sal.tdo_id_tipo_documento),'') tdo_nombre, 
			  sal_numero_doc_cliente, 
			  (SELECT emp.emp_razon_social FROM pcliente pcl INNER JOIN empresa emp ON pcl.emp_id_empresa=emp.emp_id_empresa WHERE pcl.pcl_id_pcliente=sal.pcl_id_cliente) emp_razon_social,FORMAT(sal_monto, 2, 'de_DE') sal_monto ,c.caj_descripcion
			FROM salida sal INNER JOIN caja as c ON sal.caj_id_caja=c.caj_id_caja
			WHERE STR_TO_DATE(sal_fecha_doc_cliente, '%Y-%m-%d') BETWEEN STR_TO_DATE('$fecha_ini', '%Y-%m-%d') AND STR_TO_DATE('$fecha_fin', '%Y-%m-%d') 
			ORDER BY sal_fecha_registro DESC");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
	function mmovimiento_diario_totales_salida($fecha_ini, $fecha_fin) {
		$query = $this->db->query("SELECT 
			  FORMAT(IFNULL(sal_monto,0), 2, 'de_DE') sal_monto 
			FROM (SELECT
			  (SELECT 
			      SUM(sal_monto) 
			    FROM salida sal 
			    WHERE STR_TO_DATE(sal_fecha_doc_cliente, '%Y-%m-%d') BETWEEN STR_TO_DATE('$fecha_ini', '%Y-%m-%d') AND STR_TO_DATE('$fecha_fin', '%Y-%m-%d') 
			  ) sal_monto 
			) tabla ");
		foreach ($query->result() as $row)
		{
			return $row;
		}
		return array('ing_valor' => '0.00',
			'sal_valor' => '0.00',
			'total' => '0.00');
	}
	
	function mestadisticos() {
		$query = $this->db->query("SELECT 
			(SELECT COUNT(1) FROM producto WHERE pro_cantidad<=pro_cantidad_min and pro_eliminado='NO') stock_minimo, 
			(SELECT COUNT(1) FROM salida WHERE DATE(sal_fecha_registro)=DATE(NOW())) ventas_del_dia, 
			(SELECT COUNT(1) FROM ingreso WHERE DATE(ing_fecha_registro)=DATE(NOW())) gastos_registrados, 
			(SELECT COUNT(1) FROM pcliente WHERE (pcl_tipo='1' OR pcl_tipo='3') and pcl_eliminado='NO') numero_clientes ");
		foreach ($query->result() as $row)
		{
			return $row;
		}
		return array('stock_minimo' => ' 0',
			'ventas_del_dia' => '0.00',
			'gastos_registrados' => '0.00',
			'numero_clientes' => ' 0');
	}
	
	function mmostrar_perfil($usu_id_usuario) {
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
			WHERE u.usu_id_usuario=".$usu_id_usuario);
		foreach ($query->result() as $row)
		{
			return $row;
		}
		return false;
	}
	function listar_cajas($texto){
	    $query="select c.caj_descripcion from caja as c";
	    $data=$this->db->query($query);
	    foreach ($data->result() as $row){
	        $row->value = $row->caj_descripcion;
	        $list[]=$row;
        }
	    return $list;
    }
	function listar_ventas_del_dia_por_caja($caja){
	    $query="SELECT c.caj_descripcion, p.pro_nombre, sd.sad_valor, 
        SUM(sd.sad_cantidad) as cantidad_vendida, SUM(sd.sad_monto) as venta_total 
        FROM salida as s, caja as c, producto as p, salida_detalle as sd
        WHERE p.pro_id_producto=sd.pro_id_producto 
        AND s.sal_id_salida=sd.sal_id_salida AND c.caj_id_caja=s.caj_id_caja 
        AND s.sal_fecha_doc_cliente=DATE_FORMAT(NOW(),'%Y-%m-%d') 
        AND c.caj_descripcion LIKE '%".$caja."%' GROUP BY sd.pro_id_producto";

	    $data=$this->db->query($query);
        return $data->result_array();
    }
    public function rporte_model_ganancias($fecha_ini, $fecha_fin){
		$lis=array();
		$query=$this->db->query("SELECT s.sal_fecha_doc_cliente,s.sal_fecha_registro,sd.sad_cantidad,sd.sad_valor,sd.pro_id_producto,
       producto.pro_nombre,sd.sad_ganancias,caja.caj_descripcion FROM salida_detalle as sd , salida as s , caja ,producto
WHERE sd.sal_id_salida=s.sal_id_salida and s.caj_id_caja=caja.caj_id_caja and sd.pro_id_producto=producto.pro_id_producto 
  and STR_TO_DATE(sal_fecha_doc_cliente, '%Y-%m-%d') BETWEEN STR_TO_DATE('$fecha_ini', '%Y-%m-%d') AND STR_TO_DATE('$fecha_fin', '%Y-%m-%d') ORDER BY sal_fecha_doc_cliente DESC");
	 foreach ($query->result() as $row){
	 	$lis[]=$row;
	 }
	 return $lis;
	}
	public function sumganancias($fecha_ini, $fecha_fin){
		$query = $this->db->query("SELECT FORMAT(ROUND(IFNULL(SUM(sd.sad_ganancias),0),1),2) as monto_final FROM  salida_detalle as sd , salida as s WHERE sd.sal_id_salida=s.sal_id_salida and STR_TO_DATE(sal_fecha_doc_cliente, '%Y-%m-%d') BETWEEN STR_TO_DATE('$fecha_ini', '%Y-%m-%d') AND STR_TO_DATE('$fecha_fin', '%Y-%m-%d') ORDER BY sal_fecha_doc_cliente DESC");
		foreach ($query->result() as $row)
		{
			return $row;
		}
		return array('ing_valor' => '0.00',
			'sal_valor' => '0.00',
			'total' => '0.00');
	}
	
	 function cargar_caja($data){
        $query="SELECT c.caj_descripcion  FROM caja as c WHERE c.usu_id_usuario=$data;";
        $data=$this->db->query($query);
        foreach ($data->result() as $row){
            $row->value = $row->caj_descripcion;
            $list[]=$row;
        }
        return $list;

    }
	
}
?>