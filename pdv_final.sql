-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 14-01-2019 a las 15:00:17
-- Versión del servidor: 5.6.39-cll-lve
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_punto_dventa`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE  PROCEDURE `MANAGE_SANGRIA` (IN `in_idusuario` INT(11), IN `in_monto` DOUBLE(15,2), IN `in_tipo_sangria` VARCHAR(150), IN `in_motivo` VARCHAR(250))  BEGIN
    DECLARE var_caj_id INT(15);
    --
    SELECT caj_id_caja 
      INTO 
      var_caj_id
    FROM
      caja
    WHERE
      usu_id_usuario=in_idusuario;
     --
     -- 
   	INSERT INTO sangria(
    	monto,
      fecha,
      tipo_sangria,
      san_motivo,  
      caj_id_caja,
     usu_id_usuario
    )
    VALUES(
        in_monto,
      	NOW(),
        in_tipo_sangria,
        in_motivo,
        var_caj_id,
        in_idusuario
    );
    --
END$$

CREATE PROCEDURE `proc_caja_aperturar` (OUT `out_hecho` VARCHAR(2), OUT `out_estado` VARCHAR(7), OUT `out_caj_codigo` VARCHAR(20), IN `in_usu_id_usuario` INT, IN `in_caj_id_caja` VARCHAR(4))  cuerpo: BEGIN
    -- 
    declare var_caj_codigo varchar(20);
    declare var_usu_id_usuario int;
    -- 
    select usu_id_usuario into var_usu_id_usuario
    from caja
    where usu_id_usuario=in_usu_id_usuario
      and caj_abierta='SI'
    limit 1;
    -- 
    if var_usu_id_usuario is not null THEN
        SET out_hecho = 'NO';
        SET out_estado = 'CAJ0204';
        SET out_caj_codigo = 'NoN';
        LEAVE cuerpo;
    end if;
    -- 
    set var_caj_codigo = DATE_FORMAT(NOW(),'%Y%m%d%h%i%s');
    -- 
    UPDATE caja SET
        caj_codigo=var_caj_codigo,
        caj_abierta='SI',
        usu_id_usuario=in_usu_id_usuario
    WHERE caj_id_caja=in_caj_id_caja;
    -- 
    SET out_hecho = 'SI';
    SET out_estado = 'CAJ0201';
    set out_caj_codigo = var_caj_codigo;
    
END$$

CREATE  PROCEDURE `proc_caja_cerrar` (OUT `out_hecho` VARCHAR(2), OUT `out_estado` VARCHAR(7), IN `in_usu_id_usuario` INT, IN `in_caj_id_caja` VARCHAR(4))  cuerpo: BEGIN
    -- 
    DECLARE var_usu_id_usuario INT;
    -- 
    SELECT usu_id_usuario INTO var_usu_id_usuario
    FROM caja
    WHERE usu_id_usuario=in_usu_id_usuario
      and caj_id_caja=in_caj_id_caja
      AND caj_abierta='SI';
    -- 
    IF var_usu_id_usuario IS NULL THEN
        SET out_hecho = 'NO';
        SET out_estado = 'CAJ0303';
        LEAVE cuerpo;
    END IF;
    -- 
    UPDATE caja SET
        caj_abierta='NO',
        usu_id_usuario=null
    WHERE caj_id_caja=in_caj_id_caja;
    -- 
    SET out_hecho = 'SI';
    SET out_estado = 'CAJ0301';
    
END$$

CREATE  PROCEDURE `proc_caja_guardar` (OUT `out_hecho` VARCHAR(2), OUT `out_estado` VARCHAR(7), OUT `out_caj_id_caja` VARCHAR(4), IN `in_caj_descripcion` VARCHAR(20), IN `in_est_id_estado` INT, IN `in_caj_id_caja` VARCHAR(4))  cuerpo: BEGIN
    DECLARE var_caj_id_caja VARCHAR(4);
    IF in_caj_id_caja = "" THEN
        SELECT MAX(caj_id_caja)+1 INTO var_caj_id_caja FROM caja;
        -- 
        IF(var_caj_id_caja IS NULL) THEN
            SET var_caj_id_caja = '1801';
        END IF;
        -- 
        INSERT INTO caja(
            caj_id_caja,
            caj_descripcion,
            caj_codigo,
            caj_abierta,
            usu_id_usuario,
            est_id_estado
        )
        VALUES (
            var_caj_id_caja,
            in_caj_descripcion,
            '',
            'NO',
            null,
            in_est_id_estado
        );
    ELSE
        SET var_caj_id_caja = in_caj_id_caja;
        -- 
        UPDATE caja SET
            caj_descripcion=in_caj_descripcion,
            est_id_estado=in_est_id_estado
        WHERE caj_id_caja=var_caj_id_caja;
    END IF;
    -- 
    SET out_hecho = 'SI';
    SET out_estado = 'CAJ0001';
    SET out_caj_id_caja = var_caj_id_caja;
    
END$$

CREATE  PROCEDURE `proc_ingreso_registrar` (OUT `out_hecho` VARCHAR(2), OUT `out_estado` VARCHAR(7), IN `in_usu_id_usuario` INT, IN `in_pcl_id_proveedor` INT, IN `in_ing_fecha_doc_proveedor` VARCHAR(30), IN `in_tdo_id_tipo_documento` INT, IN `in_ing_numero_doc_proveedor` VARCHAR(30), IN `in_ing_monto_efectivo` DOUBLE(15,2), IN `in_ing_monto_tar_credito` DOUBLE(15,2), IN `in_ing_monto_tar_debito` DOUBLE(15,2), IN `in_tipo_ingreso` VARCHAR(150))  cuerpo: BEGIN
    DECLARE var_count_productos DOUBLE(15,2);
    DECLARE var_sum_total DOUBLE(15,2);
    DECLARE var_sum_total_entrante DOUBLE(15,2);
    DECLARE var_caj_id_caja VARCHAR(4);
    DECLARE var_caj_codigo VARCHAR(20);
    DECLARE var_ing_id_ingreso INT;
    DECLARE var_pro_id_producto INT;
    DECLARE var_temp_cantidad DOUBLE(15,2);
    DECLARE var_temp_valor DOUBLE(15,2);
    DECLARE var_temp_numero_lote varchar(30);
    DECLARE var_temp_perecible varchar(2);
    DECLARE var_temp_fecha_vencimiento date;
    --
    DECLARE done INT DEFAULT FALSE;
    DECLARE cursor_temp CURSOR FOR
    SELECT pro_id_producto, temp_cantidad, temp_valor, temp_numero_lote, temp_perecible, temp_fecha_vencimiento
    FROM temp 
    WHERE
      usu_id_usuario=in_usu_id_usuario AND
      temp_tipo_movimiento='INGRESO';
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    --
    DECLARE EXIT HANDLER FOR 1062 SELECT 'Duplicate keys error encountered';
    DECLARE EXIT HANDLER FOR SQLEXCEPTION SELECT 'SQLException encountered';
    DECLARE EXIT HANDLER FOR SQLSTATE '23000' SELECT 'SQLSTATE 23000';
    --
    SELECT
      IFNULL(COUNT(usu_id_usuario),0) count_productos,
      IFNULL(SUM(temp_cantidad*temp_valor),0) sum_total
      INTO
      var_count_productos,
      var_sum_total
    FROM temp t
    WHERE
      usu_id_usuario=in_usu_id_usuario AND
      temp_tipo_movimiento='INGRESO';
    --
    IF var_count_productos=0 THEN
        SET out_hecho = 'NO';
        SET out_estado = 'ING0301';
        LEAVE cuerpo;
    END IF;
    --
    SET var_sum_total_entrante = in_ing_monto_efectivo+in_ing_monto_tar_credito+in_ing_monto_tar_debito;
    --
    IF var_sum_total <> var_sum_total_entrante THEN
        SET out_hecho = 'NO';
        SET out_estado = 'ING0302';
        LEAVE cuerpo;
    END IF;
    --
    SELECT caj_id_caja, caj_codigo 
      INTO 
      var_caj_id_caja, var_caj_codigo
    FROM
      caja
    WHERE
      usu_id_usuario=in_usu_id_usuario;
    --
    IF var_caj_id_caja IS NULL THEN
        SET out_hecho = 'NO';
        SET out_estado = 'ING0303';
        LEAVE cuerpo;
    END IF;
    --
    INSERT INTO ingreso (
        pcl_id_proveedor,
        tdo_id_tipo_documento,
        ing_fecha_doc_proveedor,
        ing_numero_doc_proveedor,
        ing_fecha_registro,
        ing_tipo,
        ing_monto_base,
        ing_monto,
        ing_monto_efectivo,
        ing_monto_tar_credito,
        ing_monto_tar_debito,
        usu_id_usuario,
        caj_id_caja,
        caj_codigo,
        est_id_estado,
        in_tipo
    )
    VALUES (
        in_pcl_id_proveedor,
        in_tdo_id_tipo_documento,
        in_ing_fecha_doc_proveedor,
        in_ing_numero_doc_proveedor,
        NOW(),
        'P',
        var_sum_total,
        var_sum_total,
        in_ing_monto_efectivo,
        in_ing_monto_tar_credito,
        in_ing_monto_tar_debito,
        in_usu_id_usuario,
        var_caj_id_caja,
        var_caj_codigo,
        1,
        in_tipo_ingreso
    );
    --
    SET var_ing_id_ingreso = LAST_INSERT_ID();
    -- -- -- -- 
    OPEN cursor_temp;
    read_loop: LOOP
        FETCH cursor_temp INTO var_pro_id_producto, var_temp_cantidad, var_temp_valor, var_temp_numero_lote, var_temp_perecible, var_temp_fecha_vencimiento;
        IF done THEN
            LEAVE read_loop;
        END IF;
        -- 
        INSERT INTO ingreso_detalle (pro_id_producto,
          ing_id_ingreso,
          ind_cantidad,
          ind_valor,
          ind_monto,
          ind_numero_lote,
          ind_perecible,
          ind_fecha_vencimiento,
          est_id_estado)
        VALUES
          (var_pro_id_producto,
          var_ing_id_ingreso,
          var_temp_cantidad,
          var_temp_valor,
          (var_temp_cantidad*var_temp_valor),
          var_temp_numero_lote,
          var_temp_perecible,
          var_temp_fecha_vencimiento,
          1);
        --
        CALL proc_movimiento_registrar(var_ing_id_ingreso, null, var_pro_id_producto, var_temp_cantidad, 1, 'INP', in_usu_id_usuario);
        --
    END LOOP;
    CLOSE cursor_temp;
    --
    UPDATE ingreso
    SET est_id_estado=2
    WHERE ing_id_ingreso=var_ing_id_ingreso;
    --
    DELETE FROM temp
    WHERE usu_id_usuario=in_usu_id_usuario AND
        temp_tipo_movimiento='INGRESO';
    --
    SET out_hecho = 'SI';
    SET out_estado = 'ING0305';
    
END$$

CREATE  PROCEDURE `proc_movimiento_registrar` (IN `in_ing_id_ingreso` INT, IN `in_sal_id_salida` INT, IN `in_pro_id_producto` INT, IN `in_sad_cantidad` DOUBLE(15,2), IN `in_operador_signo` INT, IN `in_mov_tipo` VARCHAR(3), IN `in_usu_id_usuario` INT)  cuerpo: BEGIN
    DECLARE var_mov_cantidad_actual DOUBLE(15,2);
    DECLARE var_mov_id_movimiento INT;
    --
    UPDATE producto 
    SET pro_cantidad=pro_cantidad+(in_sad_cantidad*in_operador_signo)
    WHERE pro_id_producto=in_pro_id_producto;
    --
    SELECT mov_cantidad_actual, mov_id_movimiento INTO var_mov_cantidad_actual, var_mov_id_movimiento
    FROM movimiento
    WHERE pro_id_producto=in_pro_id_producto
    ORDER BY mov_id_movimiento DESC
    LIMIT 1;
    --
    IF var_mov_cantidad_actual IS NULL THEN
        INSERT INTO movimiento (
        ing_id_ingreso,
        sal_id_salida, 
        mov_tipo, 
        mov_cantidad_anterior,
        mov_cantidad_entrante,
        mov_cantidad_actual,
        pro_id_producto,
        est_id_estado,
        usu_id_usuario
        )
        VALUES (
        in_ing_id_ingreso,
        in_sal_id_salida,
        in_mov_tipo,
        0,
        in_sad_cantidad,
        in_sad_cantidad,
        in_pro_id_producto,
        2,
        in_usu_id_usuario
        );
    ELSEIF var_mov_cantidad_actual < 0 THEN
        INSERT INTO movimiento (
        ing_id_ingreso,
        sal_id_salida, 
        mov_tipo, 
        mov_cantidad_anterior,
        mov_cantidad_entrante,
        mov_cantidad_actual,
        pro_id_producto,
        est_id_estado,
        usu_id_usuario
        )
        VALUES (
        in_ing_id_ingreso,
        in_sal_id_salida,
        in_mov_tipo,
        0,
        0,
        0,
        in_pro_id_producto,
        2,
        in_usu_id_usuario
        );
    ELSE
        INSERT INTO movimiento (
        ing_id_ingreso,
        sal_id_salida, 
        mov_tipo, 
        mov_cantidad_anterior,
        mov_cantidad_entrante,
        mov_cantidad_actual,
        pro_id_producto,
        est_id_estado,
        usu_id_usuario
        )
        VALUES (
        in_ing_id_ingreso,
        in_sal_id_salida,
        in_mov_tipo,
        var_mov_cantidad_actual,
        in_sad_cantidad,
        var_mov_cantidad_actual+(in_sad_cantidad*in_operador_signo),
        in_pro_id_producto,
        2,
        in_usu_id_usuario
        );
    END IF;
    
END$$

CREATE  PROCEDURE `proc_salida_registrar` (OUT `out_hecho` VARCHAR(2), OUT `out_estado` VARCHAR(7), OUT `out_sal_id_salida` INT, IN `in_usu_id_usuario` INT, IN `in_pcl_id_cliente` INT, IN `in_sal_fecha_doc_cliente` VARCHAR(30), IN `in_tdo_id_tipo_documento` INT, IN `in_sal_monto_efectivo` DOUBLE(15,2), IN `in_sal_monto_tar_credito` DOUBLE(15,2), IN `in_sal_monto_tar_debito` DOUBLE(15,2), IN `in_sal_descuento` DOUBLE(15,2), IN `in_sal_motivo` VARCHAR(60), IN `in_sal_vuelto` VARCHAR(60), IN `in_tipo_venta` VARCHAR(150))  cuerpo: BEGIN
    DECLARE var_count_productos DOUBLE(15,2);
    DECLARE var_sum_total DOUBLE(15,2);
    DECLARE var_sum_total_entrante DOUBLE(15,2);
    DECLARE var_caj_id_caja VARCHAR(4);
    DECLARE var_caj_codigo VARCHAR(20);
    DECLARE var_sal_numero_doc_cliente VARCHAR(30);
    declare var_sal_id_salida int;
    declare var_pro_id_producto int;
    declare var_temp_cantidad DOUBLE(15,2);
    DECLARE var_temp_ganancias DOUBLE(15,2);
    declare var_temp_valor double(15,2);
    --
    DECLARE done INT DEFAULT FALSE;
    DECLARE cursor_temp CURSOR FOR
    SELECT pro_id_producto, temp_cantidad, temp_valor,pro_ganancias
    FROM temp 
    WHERE
      usu_id_usuario=in_usu_id_usuario AND
      temp_tipo_movimiento='SALIDA';
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    --
    DECLARE EXIT HANDLER FOR 1062 SELECT 'Duplicate keys error encountered';
    DECLARE EXIT HANDLER FOR SQLEXCEPTION SELECT 'SQLException encountered';
    DECLARE EXIT HANDLER FOR SQLSTATE '23000' SELECT 'SQLSTATE 23000';
    --
    SELECT
      IFNULL(COUNT(usu_id_usuario),0) count_productos,
       IFNULL(SUM(temp_cantidad*temp_valor),0) sum_total
      INTO
      var_count_productos,
      var_sum_total
    FROM temp t
    WHERE
      usu_id_usuario=in_usu_id_usuario AND
      temp_tipo_movimiento='SALIDA';
    --
    IF var_count_productos=0 THEN
        SET out_hecho = 'NO';
        SET out_estado = 'SAL0301';
        set out_sal_id_salida = 0;
        LEAVE cuerpo;
    END IF;
    --
     --
       set var_sum_total_entrante = in_sal_monto_efectivo+in_sal_monto_tar_credito+in_sal_monto_tar_debito+in_sal_descuento+in_sal_vuelto;
    --
    IF var_sum_total > var_sum_total_entrante THEN
        SET out_hecho = 'NO';
        SET out_estado = 'SAL0302';
        SET out_sal_id_salida = 0;
        LEAVE cuerpo;
    END IF;
      --
    SELECT caj_id_caja, caj_codigo INTO var_caj_id_caja, var_caj_codigo
    FROM caja
    WHERE usu_id_usuario=in_usu_id_usuario;
    --
    IF var_caj_id_caja IS NULL THEN
        SET out_hecho = 'NO';
        SET out_estado = 'SAL0303';
        SET out_sal_id_salida = 0;
        LEAVE cuerpo;
    END IF;
    --
    SELECT
      CONCAT(REPEAT('0',(tdo_tamanho-LENGTH(numero))),numero) numero
      INTO
      var_sal_numero_doc_cliente
    FROM 
      (SELECT tdo.tdo_tamanho, tdo.tdo_valor1
        FROM tipo_documento tdo
        WHERE tdo.tdo_id_tipo_documento=in_tdo_id_tipo_documento ) t1
      ,
      (SELECT IFNULL(MAX(CAST(sal.sal_numero_doc_cliente AS UNSIGNED)),0)+1 numero
        FROM salida sal
        WHERE sal.tdo_id_tipo_documento=in_tdo_id_tipo_documento ) t2;
    --
    IF var_sal_numero_doc_cliente IS NULL THEN
        SET out_hecho = 'NO';
        SET out_estado = 'SAL0304';
        SET out_sal_id_salida = 0;
        LEAVE cuerpo;
    END IF;
    --
    INSERT INTO salida (
        pcl_id_cliente,
        tdo_id_tipo_documento,
        sal_fecha_doc_cliente,
        sal_numero_doc_cliente,
        sal_fecha_registro,
        sal_tipo,
        sal_monto_base,
        sal_monto,
        sal_monto_efectivo,
        sal_monto_tar_credito,
        sal_monto_tar_debito,
        sal_descuento,
        sal_motivo,
         sal_vuelto,
        usu_id_usuario,
        caj_id_caja,
        caj_codigo,
        est_id_estado,
        t_venta
    )
    VALUES (
        in_pcl_id_cliente,
        in_tdo_id_tipo_documento,
        in_sal_fecha_doc_cliente,
        var_sal_numero_doc_cliente,
        NOW(),
        'C',
        var_sum_total,
        (var_sum_total-in_sal_descuento),
        in_sal_monto_efectivo,
        in_sal_monto_tar_credito,
        in_sal_monto_tar_debito,
        in_sal_descuento,
        in_sal_motivo,
        in_sal_vuelto,
        in_usu_id_usuario,
        var_caj_id_caja,
        var_caj_codigo,
        1,
        in_tipo_venta
    );
    --
    SET var_sal_id_salida = LAST_INSERT_ID();
    -- -- -- -- 
    OPEN cursor_temp;
    read_loop: LOOP
        FETCH cursor_temp INTO var_pro_id_producto, var_temp_cantidad, var_temp_valor, var_temp_ganancias;
        IF done THEN
            LEAVE read_loop;
        END IF;
        -- 
        INSERT INTO salida_detalle (pro_id_producto,sal_id_salida,sad_cantidad,sad_ganancias,sad_valor,est_id_estado,sad_monto)
        values
        (var_pro_id_producto, var_sal_id_salida, var_temp_cantidad,var_temp_ganancias, var_temp_valor, 1, (var_temp_cantidad*var_temp_valor));
        --
        call proc_movimiento_registrar(null, var_sal_id_salida, var_pro_id_producto, var_temp_cantidad, -1, 'SAC', in_usu_id_usuario);
        --
    END LOOP;
    CLOSE cursor_temp;
    --
    update salida
    set est_id_estado=2
    where sal_id_salida=var_sal_id_salida;
    --
    DELETE FROM temp
    WHERE usu_id_usuario=in_usu_id_usuario AND
        temp_tipo_movimiento='SALIDA';
    --
    SET out_hecho = 'SI';
    SET out_estado = 'SAL0305';
    set out_sal_id_salida = var_sal_id_salida;
    
END$$

CREATE PROCEDURE `proc_stock_ajustar` (OUT `out_hecho` VARCHAR(2), OUT `out_estado` VARCHAR(7), IN `in_pro_id_producto` INT, IN `in_pro_cantidad` DOUBLE(15,2), IN `in_operador_signo` INT, IN `in_usu_id_usuario` INT)  cuerpo: BEGIN
    declare var_pro_cantidad DOUBLE(15,2);
    if in_operador_signo = -1 then
        SELECT
          -- pro_cantidad
          (pro_cantidad-(SELECT IFNULL(SUM(temp_cantidad),0) FROM temp t WHERE t.pro_id_producto=pro.pro_id_producto AND t.temp_tipo_movimiento='SALIDA'))
          INTO
          var_pro_cantidad
        FROM producto pro
        WHERE pro_id_producto=in_pro_id_producto;
        --
        if in_pro_cantidad > var_pro_cantidad then
            SET out_hecho = 'NO';
            SET out_estado = 'AJP0001';
            leave cuerpo;
        end if;
        --
        CALL proc_movimiento_registrar(NULL, NULL, in_pro_id_producto, in_pro_cantidad, -1, 'SAA', in_usu_id_usuario);
        SET out_hecho = 'SI';
        SET out_estado = 'AJP0011';
    elseif in_operador_signo = 1 THEN
        CALL proc_movimiento_registrar(NULL, NULL, in_pro_id_producto, in_pro_cantidad, 1, 'INA', in_usu_id_usuario);
        SET out_hecho = 'SI';
        SET out_estado = 'AJP0012';
    ELSE
        SET out_hecho = 'NO';
        SET out_estado = 'AJP0002';
    end if;
    --
END$$

CREATE  PROCEDURE `proc_temp_ingreso_agregar` (OUT `out_hecho` VARCHAR(2), OUT `out_estado` VARCHAR(7), IN `in_usu_id_usuario` INT, IN `in_pro_id_producto` INT, IN `in_valor` DOUBLE(15,2), IN `in_cantidad` DOUBLE(15,2), IN `in_numero_lote` VARCHAR(30), IN `in_fecha_vencimiento` VARCHAR(20))  cuerpo: BEGIN
    DECLARE var_pro_perecible varchar(2);
    DECLARE var_pro_id_producto INT;
    --
     IF IFNULL(in_cantidad,0)<0.01 THEN
        SET out_hecho = 'NO';
        SET out_estado = 'ING0101';
        LEAVE cuerpo;
    END IF;
    --
    SELECT
      pro_id_producto,
      (select pro_perecible from producto p where p.pro_id_producto=t.pro_id_producto)
      into
      var_pro_id_producto,
      var_pro_perecible
    FROM
      temp t
    WHERE
      t.pro_id_producto=in_pro_id_producto and
      t.temp_tipo_movimiento='INGRESO' and
      t.usu_id_usuario=in_usu_id_usuario;
    -- 
    IF var_pro_id_producto IS NOT NULL THEN
        SET out_hecho = 'NO';
        SET out_estado = 'ING0102';
        LEAVE cuerpo;
    END IF;
    -- 
    INSERT INTO temp(
        usu_id_usuario,
        pro_id_producto,
        temp_tipo_movimiento,
        temp_cantidad,
        temp_valor,
        temp_fecha_registro,
        temp_numero_lote,
        temp_perecible,
        temp_fecha_vencimiento
    )
    VALUES (
        in_usu_id_usuario,
        in_pro_id_producto,
        'INGRESO',
        in_cantidad,
        in_valor,
        NOW(),
        in_numero_lote,
        (SELECT pro_perecible FROM producto p WHERE p.pro_id_producto=in_pro_id_producto),
        in_fecha_vencimiento
    );
    -- 
    SET out_hecho = 'SI';
    SET out_estado = 'ING0105';
    -- 
END$$

CREATE PROCEDURE `proc_temp_ingreso_quitar` (OUT `out_hecho` VARCHAR(2), OUT `out_estado` VARCHAR(7), IN `in_usu_id_usuario` INT, IN `in_pro_id_producto` INT)  cuerpo: BEGIN
    DECLARE var_pro_id_producto INT;
    --
    SELECT
        pro_id_producto
        INTO
        var_pro_id_producto
    FROM
        temp
    WHERE
        usu_id_usuario=in_usu_id_usuario AND
        pro_id_producto=in_pro_id_producto AND
        temp_tipo_movimiento='INGRESO';
    -- 
    IF var_pro_id_producto IS NULL THEN
        SET out_hecho = 'NO';
        SET out_estado = 'ING0201';
        LEAVE cuerpo;
    END IF;
    -- 
    DELETE FROM temp
    WHERE 
        usu_id_usuario=in_usu_id_usuario AND
        pro_id_producto=in_pro_id_producto AND
        temp_tipo_movimiento='INGRESO';
    -- 
    SET out_hecho = 'SI';
    SET out_estado = 'ING0205';
    -- 
END$$

CREATE  PROCEDURE `proc_temp_salida_agregar` (OUT `out_hecho` VARCHAR(2), OUT `out_estado` VARCHAR(7), IN `in_usu_id_usuario` INT, IN `in_pro_id_producto` INT, IN `in_cantidad` DOUBLE(15,2), IN `in_precio` DOUBLE(15,3), IN `in_orden` INT, IN `in_ganancias` DOUBLE(15,2))  cuerpo: BEGIN
    DECLARE var_pro_cantidad DOUBLE(15,2);
    DECLARE var_pro_val_venta double(15,3);
    DECLARE var_sum_cantidad DOUBLE(15,2);
    DECLARE var_pro_id_producto INT;
    --
     IF ifnull(in_cantidad,0)<0.01 THEN
        SET out_hecho = 'NO';
        SET out_estado = 'SAL0104';
        LEAVE cuerpo;
    END IF;
    --
   select
        pro_cantidad,
        -- pro_val_venta,
        IF(pro_val_oferta>0, pro_val_oferta, 
           
          IF(pro_xm_cantidad3<=in_cantidad AND pro_xm_cantidad3>0, pro_xm_valor3, 
             
            IF(pro_xm_cantidad2<=in_cantidad AND pro_xm_cantidad2>0, pro_xm_valor2,
               
              IF(pro_xm_cantidad1<=in_cantidad AND pro_xm_cantidad1>0, pro_xm_valor1, in_precio
              )
            )
          )
        ),
        (select ifnull(sum(temp_cantidad),0) from temp t where t.pro_id_producto=pro.pro_id_producto and t.temp_tipo_movimiento='SALIDA'),
        (select pro_id_producto from temp t where t.pro_id_producto=pro.pro_id_producto AND t.temp_tipo_movimiento='SALIDA' and t.usu_id_usuario=in_usu_id_usuario)
        into 
        var_pro_cantidad,
        var_pro_val_venta,
        var_sum_cantidad,
        var_pro_id_producto
    from
        producto pro
    where
        pro_id_producto=in_pro_id_producto and
        est_id_estado=11;
    -- 
    if var_pro_cantidad is null then
        SET out_hecho = 'NO';
        SET out_estado = 'SAL0101';
        leave cuerpo;
    end if;
    -- 
   
    -- 
    IF var_pro_cantidad<(var_sum_cantidad+in_cantidad) THEN
        SET out_hecho = 'NO';
        SET out_estado = 'SAL0103';
        LEAVE cuerpo;
    END IF;
    -- 
    INSERT INTO temp(
        usu_id_usuario,
        pro_id_producto,
        temp_tipo_movimiento,
        temp_cantidad,
        temp_valor,
        pro_ganancias,
        temp_fecha_registro,
        tem_orden
        
       
    )
    VALUES (
        in_usu_id_usuario,
        in_pro_id_producto,
        'SALIDA',
        in_cantidad,
        var_pro_val_venta,
        in_ganancias,
        NOW(),
        in_orden
    );
    -- 
    SET out_hecho = 'SI';
    SET out_estado = 'SAL0105';
    -- 
END$$

CREATE  PROCEDURE `proc_temp_salida_quitar` (OUT `out_hecho` VARCHAR(2), OUT `out_estado` VARCHAR(7), IN `in_usu_id_usuario` INT, IN `in_pro_id_producto` INT, IN `in_orden` INT)  cuerpo: BEGIN
    DECLARE var_pro_id_producto INT;
    --
    select
        pro_id_producto
        into
        var_pro_id_producto
    from
        temp
    where
        usu_id_usuario=in_usu_id_usuario AND
        pro_id_producto=in_pro_id_producto AND
        tem_orden=in_orden AND
        temp_tipo_movimiento='SALIDA';
    -- 
    IF var_pro_id_producto IS NULL THEN
        SET out_hecho = 'NO';
        SET out_estado = 'SAL0201';
        LEAVE cuerpo;
    END IF;
    -- 
    delete from temp
    where 
        usu_id_usuario=in_usu_id_usuario and
        pro_id_producto=in_pro_id_producto  AND tem_orden=in_orden and
        temp_tipo_movimiento='SALIDA';
    -- 
    SET out_hecho = 'SI';
    SET out_estado = 'SAL0205';
    -- 
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `caj_id_caja` varchar(4) NOT NULL,
  `caj_descripcion` varchar(20) DEFAULT NULL,
  `caj_codigo` varchar(20) DEFAULT NULL,
  `caj_abierta` varchar(2) DEFAULT NULL,
  `usu_id_usuario` int(10) DEFAULT NULL,
  `est_id_estado` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`caj_id_caja`, `caj_descripcion`, `caj_codigo`, `caj_abierta`, `usu_id_usuario`, `est_id_estado`) VALUES
('1801', 'CAJA1', '20190110032444', 'SI', 22, 11),
('1802', 'CAJA2', '20181210102513', 'SI', 2, 11),
('1803', 'CAJA3', '20181205062952', 'SI', 20, 11),
('1804', 'CAJA4', '20190110080137', 'SI', 23, 11),
('1805', 'CAJA5', '20190108073738', 'NO', NULL, 11),
('1806', 'CAJA6', '20190105030736', 'SI', 18, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clase`
--

CREATE TABLE `clase` (
  `cla_id_clase` int(10) UNSIGNED NOT NULL,
  `cla_nombre` varchar(60) DEFAULT NULL,
  `cla_id_clase_superior` int(10) UNSIGNED DEFAULT NULL,
  `est_id_estado` int(10) UNSIGNED DEFAULT NULL,
  `cla_eliminado` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_empresa_local`
--

CREATE TABLE `datos_empresa_local` (
  `daemlo_id_datos_empresa_local` int(10) UNSIGNED NOT NULL,
  `daemlo_ruc` varchar(20) DEFAULT NULL,
  `daemlo_nombre_empresa_juridica` varchar(100) DEFAULT NULL,
  `daemlo_nombre_empresa_fantasia` varchar(100) DEFAULT NULL,
  `daemlo_codigo_postal` varchar(50) DEFAULT NULL,
  `daemlo_direccion` varchar(100) DEFAULT NULL,
  `daemlo_ciudad` varchar(100) DEFAULT NULL,
  `daemlo_estado` varchar(100) DEFAULT NULL,
  `daemlo_telefono` varchar(50) DEFAULT NULL,
  `daemlo_telefono2` varchar(50) DEFAULT NULL,
  `daemlo_telefono3` varchar(50) DEFAULT NULL,
  `daemlo_telefono4` varchar(50) DEFAULT NULL,
  `daemlo_contacto` varchar(100) DEFAULT NULL,
  `daemlo_web` varchar(100) DEFAULT NULL,
  `daemlo_facebook` varchar(100) DEFAULT NULL,
  `daemlo_instagram` varchar(100) DEFAULT NULL,
  `daemlo_twitter` varchar(100) DEFAULT NULL,
  `daemlo_youtube` varchar(100) DEFAULT NULL,
  `daemlo_otros` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `datos_empresa_local`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `emp_id_empresa` int(10) UNSIGNED NOT NULL,
  `emp_ruc` varchar(11) DEFAULT NULL,
  `emp_razon_social` varchar(100) DEFAULT NULL,
  `emp_direccion` varchar(100) DEFAULT NULL,
  `emp_telefono` varchar(20) DEFAULT NULL,
  `emp_nombre_contacto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empresa`
--



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `est_id_estado` int(10) UNSIGNED NOT NULL,
  `est_nombre` varchar(100) DEFAULT NULL,
  `est_tabla` varchar(100) DEFAULT NULL,
  `est_orden` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`est_id_estado`, `est_nombre`, `est_tabla`, `est_orden`) VALUES
(1, 'CREADO', 'INGRESO', 1),
(2, 'FINALIZADO', 'INGRESO', 2),
(11, 'HABILITADO', 'ACCESO', 1),
(12, 'DESHABILITADO', 'ACCESO', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso`
--

CREATE TABLE `ingreso` (
  `ing_id_ingreso` int(10) UNSIGNED NOT NULL,
  `pcl_id_cliente` int(10) UNSIGNED DEFAULT NULL,
  `pcl_id_proveedor` int(10) UNSIGNED DEFAULT NULL,
  `ing_fecha_doc_proveedor` date DEFAULT NULL,
  `tdo_id_tipo_documento` int(10) UNSIGNED DEFAULT NULL,
  `ing_numero_doc_proveedor` varchar(30) DEFAULT NULL,
  `ing_fecha_registro` datetime DEFAULT NULL,
  `ing_tipo` varchar(2) DEFAULT NULL,
  `ing_monto` double(15,2) DEFAULT NULL,
  `ing_monto_base` double(15,2) DEFAULT NULL,
  `ing_monto_efectivo` double(15,2) DEFAULT NULL,
  `ing_monto_tar_credito` double(15,2) DEFAULT NULL,
  `ing_monto_tar_debito` double(15,2) DEFAULT NULL,
  `caj_id_caja` varchar(4) DEFAULT NULL,
  `caj_codigo` varchar(20) DEFAULT NULL,
  `usu_id_usuario` int(11) DEFAULT NULL,
  `est_id_estado` int(10) UNSIGNED DEFAULT NULL,
  `in_tipo` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ingreso`
--



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso_detalle`
--

CREATE TABLE `ingreso_detalle` (
  `ind_id_ingreso_detalle` int(10) UNSIGNED NOT NULL,
  `pro_id_producto` int(10) UNSIGNED NOT NULL,
  `ing_id_ingreso` int(10) UNSIGNED NOT NULL,
  `ind_cantidad` double(15,2) UNSIGNED DEFAULT NULL,
  `ind_valor` double(15,2) DEFAULT NULL,
  `ind_monto` double(15,2) DEFAULT NULL,
  `ind_numero_lote` varchar(30) DEFAULT NULL,
  `ind_perecible` varchar(2) DEFAULT NULL,
  `ind_fecha_vencimiento` date DEFAULT NULL,
  `est_id_estado` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ingreso_detalle`
--



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento`
--

CREATE TABLE `movimiento` (
  `mov_id_movimiento` int(10) UNSIGNED NOT NULL,
  `ind_id_ingreso_detalle` int(10) UNSIGNED DEFAULT NULL,
  `sad_id_salida_detalle` int(10) UNSIGNED DEFAULT NULL,
  `ing_id_ingreso` int(10) UNSIGNED DEFAULT NULL,
  `sal_id_salida` int(10) UNSIGNED DEFAULT NULL,
  `mov_tipo` varchar(3) DEFAULT NULL,
  `mov_cantidad_anterior` double(15,2) DEFAULT NULL,
  `mov_cantidad_entrante` double(15,2) DEFAULT NULL,
  `mov_cantidad_actual` double(15,2) DEFAULT NULL,
  `pro_id_producto` int(10) UNSIGNED DEFAULT NULL,
  `est_id_estado` int(10) UNSIGNED DEFAULT NULL,
  `usu_id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pcliente`
--

CREATE TABLE `pcliente` (
  `pcl_id_pcliente` int(10) UNSIGNED NOT NULL,
  `per_id_persona` int(11) DEFAULT NULL,
  `emp_id_empresa` int(10) UNSIGNED DEFAULT NULL,
  `pcl_tipo` varchar(2) DEFAULT NULL,
  `est_id_estado` int(10) UNSIGNED DEFAULT NULL,
  `pcl_eliminado` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pcliente`
--

INSERT INTO `pcliente` (`pcl_id_pcliente`, `per_id_persona`, `emp_id_empresa`, `pcl_tipo`, `est_id_estado`, `pcl_eliminado`) VALUES
(1, NULL, 1, '1', 11, 'NO'),
(2, 21, 1, '2', 1, 'NO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `per_id_persona` int(11) NOT NULL,
  `per_nombre` varchar(100) DEFAULT NULL,
  `per_apellido` varchar(100) DEFAULT NULL,
  `tdo_id_tipo_documento` int(10) UNSIGNED NOT NULL,
  `per_numero_doc` varchar(30) DEFAULT NULL,
  `per_direccion` varchar(100) DEFAULT NULL,
  `per_tel_movil` varchar(30) DEFAULT NULL,
  `per_tel_fijo` varchar(30) DEFAULT NULL,
  `per_foto` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`per_id_persona`, `per_nombre`, `per_apellido`, `tdo_id_tipo_documento`, `per_numero_doc`, `per_direccion`, `per_tel_movil`, `per_tel_fijo`, `per_foto`) VALUES
(1, 'Panel', 'Control', 1, '00000001', 'Admin', '967898394', '967898394', '9ySmFJLkXVIBM0lrw7R2.jpg'),
(2, 'Area', 'Venta', 1, '44332233', 'X', '9985847558', '5455455', 'V4Gwtn1chdFNAEPvyQeI.jpg'),
(3, 'kris nathalia', 'ramos ramos', 2, '25997272', 'ilo', '937170084', '12354567', 'lLRaEFSHqxNmUbAp1J2O.jpg'),
(18, 'kattiusca milagros', 'neira canales', 1, '73901257', 'ilo', '985272090', '000000000', 'K6xtOreD8ny9AIfp7Vu4.jpg'),
(19, 'Diego Leoncio', 'Cari Chara', 1, '71717490', 'moquegua', '9', '000000000', 'TDvRC1dkYMeogQ0bFpfU.jpg'),
(20, 'ESTEFANNY ', 'MAMANI MAQUERA', 1, '77150978', 'ILO', '929061390', '000000000', 'TDvRC1dkYMeogQ0bFpfU.jpg'),
(21, 'anonimo', 'anonimo', 1, '86659566', 'betania', '484515', '8151', ''),
(22, 'LUIS DAVID ', 'SANTOS PEREZ', 1, '61001941', 'MIRAMAR PARTE PRIMA', '922922060', '00000000', ''),
(23, 'KRIS', 'RAMOS', 1, '', '', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `privilegio`
--

CREATE TABLE `privilegio` (
  `pri_id_privilegio` int(10) UNSIGNED NOT NULL,
  `pri_nombre` varchar(100) DEFAULT NULL,
  `pri_acceso` varchar(100) DEFAULT NULL,
  `pri_grupo` varchar(20) DEFAULT NULL,
  `pri_orden` int(11) DEFAULT NULL,
  `est_id_estado` int(10) UNSIGNED DEFAULT NULL,
  `pri_ico` varchar(20) DEFAULT NULL,
  `pri_ico_grupo` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `privilegio`
--

INSERT INTO `privilegio` (`pri_id_privilegio`, `pri_nombre`, `pri_acceso`, `pri_grupo`, `pri_orden`, `est_id_estado`, `pri_ico`, `pri_ico_grupo`) VALUES
(1, 'Usuario', 'mantenimiento/usuario', 'ADMINISTRACION', 1, 1, 'user-cog', 'cog'),
(2, 'Cliente', 'mantenimiento/pcliente', 'MANTENIMIENTO', 12, 1, 'street-view', 'pencil-square-o'),
(3, 'Producto', 'mantenimiento/producto', 'MANTENIMIENTO', 3, 1, 'atlas', 'server'),
(4, 'Uni. Medida', 'mantenimiento/unidad_medida', 'MANTENIMIENTO', 4, 1, 'balance-scale', 'server'),
(5, 'Clase', 'mantenimiento/clase', 'MANTENIMIENTO', 5, 1, 'bezier-curve', 'server'),
(6, 'Rol', 'mantenimiento/rol', 'ADMINISTRACION', 6, 1, 'id-card', 'cog'),
(7, 'Compra', 'movimiento/ingreso/proveedor', 'MOVIMIENTO', 7, 1, 'cart-plus', 'shopping-cart'),
(8, 'Venta', 'movimiento/salida/cliente', 'MOVIMIENTO', 8, 1, 'cart-arrow-down', 'shopping-cart'),
(9, 'Datos Empresa Local', 'mantenimiento/datos_empresa_local', 'ADMINISTRACION', 9, 1, 'building', 'cog'),
(10, 'Stock', 'reporte/stock', 'REPORTE', 10, 1, 'calculator', 'table'),
(11, 'Movimiento', 'reporte/movimiento', 'REPORTE', 11, 1, 'chart-line', 'table'),
(12, 'Proveedor', 'mantenimiento/pcliente', 'MANTENIMIENTO', 13, 1, 'street-view', 'pencil-square-o'),
(13, 'Caja', 'mantenimiento/caja', 'ADMINISTRACION', 14, 1, 'money', 'cog'),
(14, 'Apertura Caja', 'movimiento/caja/apertura', 'MOVIMIENTO', 15, 1, 'lock-open', 'shopping-cart'),
(15, 'Cierre Caja', 'movimiento/caja/cierre', 'MOVIMIENTO', 16, 1, 'lock', 'shopping-cart'),
(16, 'Cambiar clave', 'administracion/usuario_cambio_clave', 'ADMINISTRACION', 17, 1, 'user-lock', 'cog'),
(17, 'Reset clave', 'administracion/usuario_reset_clave', 'ADMINISTRACION', 18, 1, 'user-lock', 'cog'),
(18, 'Ajuste stock', 'movimiento/ajuste/stock', 'MOVIMIENTO', 19, 1, 'atlas', 'shopping-cart'),
(19, 'Ventas del dia', 'reporte/ventas', 'REPORTE', 41, 1, 'money', 'cog'),
(20, 'Cuentas por Cobrar', 'movimiento/salida/cobrar', 'MOVIMIENTO', 41, 1, 'lock', 'shopping-cart'),
(21, 'Cuentas por Pagar', 'movimiento/ingreso/pagar', 'MOVIMIENTO', 42, 1, 'money', 'cog'),
(22, 'Ganancias', 'reporte/ganancias', 'REPORTE', 22, 1, 'chart-line	', 'cog'),
(23, 'Sangria', 'movimiento/sangria', 'MOVIMIENTO', 24, 1, 'fire', 'cog'),
(24, 'Registrar Sangria', 'movimiento/sangrias', 'MOVIMIENTO', 25, 1, 'fire', 'cog'),
(25, 'Mis ventas', 'reporte/miventa', 'REPORTE', 50, 1, 'money', 'cog');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `pro_id_producto` int(10) UNSIGNED NOT NULL,
  `pro_codigo` varchar(20) DEFAULT NULL,
  `cla_clase` int(10) UNSIGNED DEFAULT NULL,
  `cla_subclase` int(10) UNSIGNED DEFAULT NULL,
  `pro_nombre` varchar(100) DEFAULT NULL,
  `pro_val_compra` double(15,2) DEFAULT '0.00',
  `pro_val_venta` double(15,2) DEFAULT '0.00',
  `pro_cantidad` double(15,2) DEFAULT '0.00',
  `pro_cantidad_min` double(15,2) DEFAULT '0.00',
  `unm_id_unidad_medida` int(11) NOT NULL,
  `pro_foto` varchar(200) DEFAULT NULL,
  `pro_perecible` varchar(2) DEFAULT NULL,
  `pro_fecha_vencimiento` date DEFAULT NULL,
  `pro_xm_cantidad1` double(15,2) DEFAULT '0.00',
  `pro_xm_valor1` varchar(50) DEFAULT '0.00',
  `pro_xm_cantidad2` varchar(50) DEFAULT '0.00',
  `pro_xm_valor2` varchar(50) DEFAULT '0.00',
  `pro_xm_cantidad3` double(15,3) DEFAULT '0.000',
  `pro_xm_valor3` double(15,3) DEFAULT '0.000',
  `pro_val_oferta` double(15,3) DEFAULT NULL,
  `est_id_estado` int(10) UNSIGNED DEFAULT NULL,
  `pro_eliminado` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto`
--



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `rol_id_rol` int(10) UNSIGNED NOT NULL,
  `rol_nombre` varchar(100) DEFAULT NULL,
  `est_id_estado` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`rol_id_rol`, `rol_nombre`, `est_id_estado`) VALUES
(1, 'ADMIN', 11),
(2, 'VENDEDOR', 11),
(3, 'SOPORTE', 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_has_privilegio`
--

CREATE TABLE `rol_has_privilegio` (
  `rol_id_rol` int(10) UNSIGNED NOT NULL,
  `pri_id_privilegio` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rol_has_privilegio`
--

INSERT INTO `rol_has_privilegio` (`rol_id_rol`, `pri_id_privilegio`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 7),
(2, 8),
(2, 9),
(2, 10),
(2, 12),
(2, 13),
(2, 14),
(2, 15),
(2, 16),
(2, 24),
(2, 25),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(3, 6),
(3, 7),
(3, 8),
(3, 9),
(3, 10),
(3, 11),
(3, 12),
(3, 13),
(3, 14),
(3, 15),
(3, 16),
(3, 17),
(3, 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salida`
--

CREATE TABLE `salida` (
  `sal_id_salida` int(10) UNSIGNED NOT NULL,
  `pcl_id_proveedor` int(10) UNSIGNED DEFAULT NULL,
  `pcl_id_cliente` int(10) UNSIGNED DEFAULT NULL,
  `tdo_id_tipo_documento` int(10) UNSIGNED DEFAULT NULL,
  `sal_fecha_doc_cliente` date DEFAULT NULL,
  `sal_numero_doc_cliente` varchar(30) DEFAULT NULL,
  `sal_fecha_registro` datetime DEFAULT NULL,
  `sal_tipo` varchar(2) DEFAULT NULL,
  `sal_monto_base` double(15,2) DEFAULT NULL,
  `sal_monto` double(15,2) DEFAULT NULL,
  `sal_monto_efectivo` double(15,2) DEFAULT NULL,
  `sal_monto_tar_credito` double(15,2) DEFAULT NULL,
  `sal_monto_tar_debito` double(15,2) DEFAULT NULL,
  `sal_descuento` double(15,2) DEFAULT NULL,
  `sal_motivo` varchar(60) DEFAULT NULL,
  `sal_vuelto` varchar(60) DEFAULT NULL,
  `caj_id_caja` varchar(4) DEFAULT NULL,
  `caj_codigo` varchar(20) DEFAULT NULL,
  `usu_id_usuario` int(11) DEFAULT NULL,
  `est_id_estado` int(10) UNSIGNED DEFAULT NULL,
  `t_venta` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `salida`

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salida_detalle`
--

CREATE TABLE `salida_detalle` (
  `sad_id_salida_detalle` int(10) UNSIGNED NOT NULL,
  `pro_id_producto` int(10) UNSIGNED NOT NULL,
  `sal_id_salida` int(10) UNSIGNED NOT NULL,
  `sad_cantidad` double(15,2) UNSIGNED DEFAULT NULL,
  `sad_ganancias` double(15,2) NOT NULL,
  `sad_valor` double(15,2) DEFAULT NULL,
  `sad_monto` double(15,2) DEFAULT NULL,
  `est_id_estado` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `salida_detalle`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sangria`
--

CREATE TABLE `sangria` (
  `id_sangria` int(11) NOT NULL,
  `monto` double NOT NULL,
  `fecha` date NOT NULL,
  `tipo_sangria` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `san_motivo` varchar(250) NOT NULL,
  `san_informacion` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `caj_id_caja` int(11) NOT NULL,
  `usu_id_usuario` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sangria`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temp`
--

CREATE TABLE `temp` (
  `usu_id_usuario` int(10) NOT NULL,
  `pro_id_producto` int(10) NOT NULL,
  `temp_tipo_movimiento` varchar(20) NOT NULL,
  `temp_cantidad` double(15,2) DEFAULT NULL,
  `temp_valor` double(15,3) DEFAULT NULL,
  `temp_numero_lote` varchar(30) DEFAULT NULL,
  `temp_perecible` varchar(2) DEFAULT NULL,
  `temp_fecha_vencimiento` date DEFAULT NULL,
  `temp_fecha_registro` datetime DEFAULT NULL,
  `pro_ganancias` double(15,2) DEFAULT NULL,
  `tem_orden` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `tdo_id_tipo_documento` int(10) UNSIGNED NOT NULL,
  `tdo_nombre` varchar(100) DEFAULT NULL,
  `tdo_tabla` varchar(100) DEFAULT NULL,
  `tdo_tamanho` int(10) UNSIGNED DEFAULT NULL,
  `tdo_orden` int(10) UNSIGNED DEFAULT NULL,
  `est_id_estado` int(10) UNSIGNED DEFAULT NULL,
  `tdo_valor1` double(15,2) DEFAULT NULL,
  `tdo_valor2` double(15,2) DEFAULT NULL,
  `tdo_valor3` double(15,2) DEFAULT NULL,
  `tdo_valor4` double(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`tdo_id_tipo_documento`, `tdo_nombre`, `tdo_tabla`, `tdo_tamanho`, `tdo_orden`, `est_id_estado`, `tdo_valor1`, `tdo_valor2`, `tdo_valor3`, `tdo_valor4`) VALUES
(1, 'DNI', 'PERSONA', 8, 1, 11, NULL, NULL, NULL, NULL),
(2, 'LE', 'PERSONA', 8, 2, 11, NULL, NULL, NULL, NULL),
(11, 'FACTURA', 'INGRESO', 30, 5, 11, NULL, NULL, NULL, NULL),
(12, 'BOLETA', 'INGRESO', 30, 2, 11, NULL, NULL, NULL, NULL),
(13, 'GUIA DE REMISION', 'INGRESO', 30, 3, 11, NULL, NULL, NULL, NULL),
(14, 'DEVOLUCION', 'INGRESO', 30, 4, 11, NULL, NULL, NULL, NULL),
(15, 'NOTA DE PEDIDO', 'INGRESO', 30, 1, 11, NULL, NULL, NULL, NULL),
(1821, 'FACTURA', 'SALIDA', 7, 2, 11, 18.00, NULL, 0.00, NULL),
(1822, 'BOLETA', 'SALIDA', 7, 3, 11, 0.00, NULL, 0.00, NULL),
(1823, 'NOTA DE PEDIDO', 'SALIDA', 7, 1, 11, 0.00, NULL, 0.00, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad_medida`
--

CREATE TABLE `unidad_medida` (
  `unm_id_unidad_medida` int(11) NOT NULL,
  `unm_nombre` varchar(60) DEFAULT NULL,
  `unm_nombre_corto` varchar(10) DEFAULT NULL,
  `est_id_estado` int(10) UNSIGNED DEFAULT NULL,
  `unm_eliminado` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `unidad_medida`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usu_id_usuario` int(11) NOT NULL,
  `usu_nombre` varchar(20) DEFAULT NULL,
  `usu_clave` varchar(255) DEFAULT NULL,
  `rol_id_rol` int(10) UNSIGNED NOT NULL,
  `est_id_estado` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usu_id_usuario`, `usu_nombre`, `usu_clave`, `rol_id_rol`, `est_id_estado`) VALUES
(1, 'admin', '$2y$12$.5eVZRxrEzu6NYFD3CkrI.vMy1ASiQja2/8.fcf3SdwZini3lCWi.', 3, 12),
(2, 'vendedor', '$2y$12$NhXs9ExLJl07rze8g4Apn.oB7wNyC1c7Eaputk4xgGRQg5oLEPZzm', 2, 11),
(3, 'caja1', '$2y$12$Ca5bmRc4kzkQTa9o1DdzmObxCHGjqTWqmnH389CDiWkJ7gkqUqmxC', 2, 11),
(18, 'caja3', '$2y$12$/ZOF19psHkTYIeWl481OeumxYdTb2xb0bxBKgSYfij8QipIxdk.yO', 2, 11),
(19, 'diego', '$2y$12$vwqdVYH71Tn6U5JAnIXpdOspjpA6DQjMYgVk3mhu3sAd5iuy8sGqe', 1, 11),
(20, 'LATEFA', '$2y$12$sMbvo/iOOPPBJvZ8ZW5ovebX.R5bjL5RHXY1NHQLQcLCvHCLBdbvO', 2, 11),
(21, 'provedor', '$2y$12$qjChg0Eki2zLPgkIcU2/PeH66r.9Yj82Wzbwc/kWQ4QlEZ/MHKRIm', 2, 11),
(22, 'LUIS', '$2y$12$MZvYNx32/ZbKGFyTCHrzmu/6wrAjSBIB8.5bTzQOf.BskOlsMEykW', 2, 11),
(23, 'KRIS', '$2y$12$Rm7oT1fQhIjAWjQRSflkZ.zsBMp1pKapFJaGjFgO0ma8Id1.ejQ5.', 2, 11);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`caj_id_caja`),
  ADD UNIQUE KEY `caja_un_codigo` (`caj_codigo`);

--
-- Indices de la tabla `clase`
--
ALTER TABLE `clase`
  ADD PRIMARY KEY (`cla_id_clase`);

--
-- Indices de la tabla `datos_empresa_local`
--
ALTER TABLE `datos_empresa_local`
  ADD PRIMARY KEY (`daemlo_id_datos_empresa_local`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`emp_id_empresa`),
  ADD UNIQUE KEY `empresa_un_ruc` (`emp_ruc`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`est_id_estado`);

--
-- Indices de la tabla `ingreso`
--
ALTER TABLE `ingreso`
  ADD PRIMARY KEY (`ing_id_ingreso`),
  ADD KEY `ingreso_fk_tip_doc` (`tdo_id_tipo_documento`),
  ADD KEY `ingreso_fk_pcliente` (`pcl_id_proveedor`),
  ADD KEY `ingreso_fk_pcliente2` (`pcl_id_cliente`);

--
-- Indices de la tabla `ingreso_detalle`
--
ALTER TABLE `ingreso_detalle`
  ADD PRIMARY KEY (`ind_id_ingreso_detalle`),
  ADD KEY `ingreso_detalle_fk_ingreso` (`ing_id_ingreso`),
  ADD KEY `ingreso_detalle_fk_producto` (`pro_id_producto`);

--
-- Indices de la tabla `movimiento`
--
ALTER TABLE `movimiento`
  ADD PRIMARY KEY (`mov_id_movimiento`),
  ADD KEY `movimiento_fk_ingreso_detalle` (`ind_id_ingreso_detalle`),
  ADD KEY `movimiento_fk_salida_detalle` (`sad_id_salida_detalle`);

--
-- Indices de la tabla `pcliente`
--
ALTER TABLE `pcliente`
  ADD PRIMARY KEY (`pcl_id_pcliente`),
  ADD KEY `pcliente_fk_empresa` (`emp_id_empresa`),
  ADD KEY `pcliente_fk_persona` (`per_id_persona`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`per_id_persona`),
  ADD UNIQUE KEY `persona_un_tipdoc_numerodoc` (`tdo_id_tipo_documento`,`per_numero_doc`),
  ADD KEY `persona_fk_tip_doc` (`tdo_id_tipo_documento`);

--
-- Indices de la tabla `privilegio`
--
ALTER TABLE `privilegio`
  ADD PRIMARY KEY (`pri_id_privilegio`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`pro_id_producto`),
  ADD UNIQUE KEY `producto_un_codigo` (`pro_codigo`),
  ADD KEY `producto_fk_uni_med` (`unm_id_unidad_medida`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`rol_id_rol`),
  ADD KEY `rol_fk_estado` (`est_id_estado`);

--
-- Indices de la tabla `rol_has_privilegio`
--
ALTER TABLE `rol_has_privilegio`
  ADD PRIMARY KEY (`rol_id_rol`,`pri_id_privilegio`),
  ADD KEY `rol_has_privilegio_fk_rol` (`rol_id_rol`),
  ADD KEY `rol_has_privilegio_fk_privilegio` (`pri_id_privilegio`);

--
-- Indices de la tabla `salida`
--
ALTER TABLE `salida`
  ADD PRIMARY KEY (`sal_id_salida`),
  ADD KEY `salida_fk_tip_doc` (`tdo_id_tipo_documento`),
  ADD KEY `salida_fk_pcliente` (`pcl_id_cliente`),
  ADD KEY `salida_fk_pcliente2` (`pcl_id_proveedor`),
  ADD KEY `r_salida_fk_caja` (`caj_id_caja`);

--
-- Indices de la tabla `salida_detalle`
--
ALTER TABLE `salida_detalle`
  ADD PRIMARY KEY (`sad_id_salida_detalle`),
  ADD KEY `salida_detalle_fk_salida` (`sal_id_salida`),
  ADD KEY `salida_detalle_fk_producto` (`pro_id_producto`);

--
-- Indices de la tabla `sangria`
--
ALTER TABLE `sangria`
  ADD PRIMARY KEY (`id_sangria`),
  ADD KEY `caj_id_caja` (`caj_id_caja`),
  ADD KEY `usu_id_usuario` (`usu_id_usuario`);

--
-- Indices de la tabla `temp`
--
ALTER TABLE `temp`
  ADD KEY `usu_id_usuario` (`usu_id_usuario`) USING BTREE;

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`tdo_id_tipo_documento`);

--
-- Indices de la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
  ADD PRIMARY KEY (`unm_id_unidad_medida`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usu_id_usuario`),
  ADD UNIQUE KEY `usuario_un_nombre` (`usu_nombre`),
  ADD KEY `usuario_fk_estado` (`est_id_estado`),
  ADD KEY `usuario_fk_rol` (`rol_id_rol`),
  ADD KEY `usuario_fk_persona` (`usu_id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clase`
--
ALTER TABLE `clase`
  MODIFY `cla_id_clase` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `emp_id_empresa` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ingreso`
--
ALTER TABLE `ingreso`
  MODIFY `ing_id_ingreso` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ingreso_detalle`
--
ALTER TABLE `ingreso_detalle`
  MODIFY `ind_id_ingreso_detalle` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `movimiento`
--
ALTER TABLE `movimiento`
  MODIFY `mov_id_movimiento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2935;

--
-- AUTO_INCREMENT de la tabla `pcliente`
--
ALTER TABLE `pcliente`
  MODIFY `pcl_id_pcliente` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `per_id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `privilegio`
--
ALTER TABLE `privilegio`
  MODIFY `pri_id_privilegio` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `pro_id_producto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=478;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `rol_id_rol` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `salida`
--
ALTER TABLE `salida`
  MODIFY `sal_id_salida` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1620;

--
-- AUTO_INCREMENT de la tabla `salida_detalle`
--
ALTER TABLE `salida_detalle`
  MODIFY `sad_id_salida_detalle` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2455;

--
-- AUTO_INCREMENT de la tabla `sangria`
--
ALTER TABLE `sangria`
  MODIFY `id_sangria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
  MODIFY `unm_id_unidad_medida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ingreso`
--
ALTER TABLE `ingreso`
  ADD CONSTRAINT `ingreso_ibfk_1` FOREIGN KEY (`tdo_id_tipo_documento`) REFERENCES `tipo_documento` (`tdo_id_tipo_documento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ingreso_ibfk_2` FOREIGN KEY (`pcl_id_proveedor`) REFERENCES `pcliente` (`pcl_id_pcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ingreso_ibfk_3` FOREIGN KEY (`pcl_id_cliente`) REFERENCES `pcliente` (`pcl_id_pcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ingreso_detalle`
--
ALTER TABLE `ingreso_detalle`
  ADD CONSTRAINT `ingreso_detalle_ibfk_1` FOREIGN KEY (`ing_id_ingreso`) REFERENCES `ingreso` (`ing_id_ingreso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ingreso_detalle_ibfk_2` FOREIGN KEY (`pro_id_producto`) REFERENCES `producto` (`pro_id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `movimiento`
--
ALTER TABLE `movimiento`
  ADD CONSTRAINT `movimiento_ibfk_1` FOREIGN KEY (`ind_id_ingreso_detalle`) REFERENCES `ingreso_detalle` (`ind_id_ingreso_detalle`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `movimiento_ibfk_2` FOREIGN KEY (`sad_id_salida_detalle`) REFERENCES `salida_detalle` (`sad_id_salida_detalle`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pcliente`
--
ALTER TABLE `pcliente`
  ADD CONSTRAINT `pcliente_ibfk_1` FOREIGN KEY (`emp_id_empresa`) REFERENCES `empresa` (`emp_id_empresa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `pcliente_ibfk_2` FOREIGN KEY (`per_id_persona`) REFERENCES `persona` (`per_id_persona`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`tdo_id_tipo_documento`) REFERENCES `tipo_documento` (`tdo_id_tipo_documento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`unm_id_unidad_medida`) REFERENCES `unidad_medida` (`unm_id_unidad_medida`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `rol`
--
ALTER TABLE `rol`
  ADD CONSTRAINT `rol_ibfk_1` FOREIGN KEY (`est_id_estado`) REFERENCES `estado` (`est_id_estado`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `rol_has_privilegio`
--
ALTER TABLE `rol_has_privilegio`
  ADD CONSTRAINT `rol_has_privilegio_ibfk_1` FOREIGN KEY (`rol_id_rol`) REFERENCES `rol` (`rol_id_rol`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `rol_has_privilegio_ibfk_2` FOREIGN KEY (`pri_id_privilegio`) REFERENCES `privilegio` (`pri_id_privilegio`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `salida`
--
ALTER TABLE `salida`
  ADD CONSTRAINT `salida_fk_caja` FOREIGN KEY (`caj_id_caja`) REFERENCES `caja` (`caj_id_caja`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `salida_ibfk_1` FOREIGN KEY (`tdo_id_tipo_documento`) REFERENCES `tipo_documento` (`tdo_id_tipo_documento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `salida_ibfk_2` FOREIGN KEY (`pcl_id_cliente`) REFERENCES `pcliente` (`pcl_id_pcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `salida_ibfk_3` FOREIGN KEY (`pcl_id_proveedor`) REFERENCES `pcliente` (`pcl_id_pcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `salida_detalle`
--
ALTER TABLE `salida_detalle`
  ADD CONSTRAINT `salida_detalle_ibfk_1` FOREIGN KEY (`sal_id_salida`) REFERENCES `salida` (`sal_id_salida`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `salida_detalle_ibfk_2` FOREIGN KEY (`pro_id_producto`) REFERENCES `producto` (`pro_id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `temp`
--
ALTER TABLE `temp`
  ADD CONSTRAINT `usu_id_usuario` FOREIGN KEY (`usu_id_usuario`) REFERENCES `usuario` (`usu_id_usuario`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`est_id_estado`) REFERENCES `estado` (`est_id_estado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`rol_id_rol`) REFERENCES `rol` (`rol_id_rol`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `usuario_ibfk_3` FOREIGN KEY (`usu_id_usuario`) REFERENCES `persona` (`per_id_persona`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
