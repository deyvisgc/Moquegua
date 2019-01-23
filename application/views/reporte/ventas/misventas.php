<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Ventas del dia <small></small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?= base_url() ?>bienvenida"><i class="fa fa-home"></i> Reporte</a>
            </li>
            <li class="active">Ventas del día</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Your Page Content Here -->
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs pull-right">
                        <li class="active"><a href="#dv_panel_eleccion" data-toggle="tab" id="a_panel_eleccion">Mis Ventas</a></li>
                        <li class="pull-left header"><i class="fa fa-area-chart"></i> <span id="sp_etiqueta">Mis Ventas</span></li>
                    </ul>
                    <div class="tab-content">
                        <!-- TAB ELECCION -->
                        <div class="tab-pane active" id="dv_panel_eleccion">
                            <div class="row">
                                <h4 class="text-uppercase" style="padding-left: 20px;">Seleccione las fechas para ver sus ventas:</h4>
                                <div class="form-group col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon bg-gray ">Desde: </span>
                                        <input type="date" id="in_fecha_ini3" name="fecha_ini3" class="form-control" value="" placeholder="Fecha inicio">
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="input-group" >
                                        <span class="input-group-addon bg-gray ">Hasta: </span>
                                        <input type="date" id="in_fecha_fin3" name="fecha_fin3" class="form-control" value="" placeholder="Fecha fin">
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="input-group" style="padding-left: 20px;">
                                        <span class="input-group-addon bg-gray">Caja: </span>
                                        <select class="form-control custom-select" required id="fcaja2" name="caja_form2">

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="input-group" style="padding-left: 20px;">
                                        <button class="btn btn-facebook" type="button" onclick="cargar_sangria_x_fecha_ventas();"> Consultar </button>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="button" class="btn btn-danger" onclick="calculartotal();"><i class="fa fa-circle"></i> Calcular Venta Neta</button>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="button" class="btn btn-facebook" onclick="imprimir();"><i class="fa fa-circle"></i> IMPRIMIR </button>
                                </div>
                            </div>
                            <div id="imprimir">
                                <table id="tb_sangria_cajas_ventas" class="table table-striped">
                                    <caption id="titulo" hidden>REPORTE DE SANGRIA POR CAJA Y TOTAL DE VENTA</caption><br><br>
                                    <thead>
                                    <tr >
                                        <th>CAJA</th>
                                        <th>FECHA</th>
                                        <th>CLIENTE</th>
                                        <th>DOC.</th>
                                        <th>NRO.</th>
                                        <th>S/. COMPRA</th>
                                    </tr>
                                    </thead>
                                    <tbody id="cabecera">
                                    </tbody>
                                    <tfoot id="pie">
                                    <tr>
                                        <td colspan="5" class="alinear_derecha">&nbsp;Total Sangría Ingreso:</td>
                                        <td id="a" class=" alinear_der echa"><span id="t_sangria_ingreso2">00.00</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="alinear_derecha">&nbsp;Total Sangría Salida:</td>
                                        <td id="b" class="alinear_derecha"><span id="t_sangria_salida2">00.00</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="alinear_derecha">&nbsp;Total Venta:</td>
                                        <td id="c" class="alinear_derecha"><span id="sp_total_salida2">00.00</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="alinear_derecha">&nbsp;Total Venta Neta:</td>
                                        <td id="d" class="alinear_derecha"><span id="sp_total_salida3">00.00</span></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script>
    function init_ingreso(){
        $(document).ready(function () {
            cargarDataAporte();
            cargarDataAporte2();

            var fecha_actual_hoy = get_fhoy();
            $('#in_fecha_ini3').val(fecha_actual_hoy);
            $('#in_fecha_fin3').val(fecha_actual_hoy);
            $('#in_fecha_ini2').val(fecha_actual_hoy);
            $('#in_fecha_fin2').val(fecha_actual_hoy);

        });
    }
    function cargarCaja(){

    }


    function cargarDataAporte(){
        $.ajax({
            url: BASE_URL+'reporte/Miventa/cargarCajas',
            type:'post',
            dataType:'json',
            success:function (response) {
                $.each(response,function (indice,value) {
                    $('#fcaja').append('<option value='+value.caj_descripcion+'>'+value.caj_descripcion+'</option>');
                });
            }
        });
    }
    function cargarDataAporte2(){
        $.ajax({
            url: BASE_URL+'reporte/Miventa/cargarCajas',
            type:'post',
            dataType:'json',
            success:function (response) {
                $.each(response,function (indice,value) {
                    $('#fcaja2').append('<option value='+value.caj_descripcion+'>'+value.caj_descripcion+'</option>');
                });
            }
        });
    }



    function cargar_sangria_x_fecha(){
        var fecha_ini = $('#in_fecha_ini2').val();
        var fecha_fin = $('#in_fecha_fin2').val();
        var caja = $('#fcaja').val();

        var tabla = "tb_sangria_cajas";
        var url ='<?php echo base_url(); ?>movimiento/sangria/sangrias_cajas_x_fecha';
        var datos = function () {
            var data = {};
            data.f_inicio = fecha_ini;
            data.f_fin = fecha_fin;
            data.caja = caja;
            return data;
        };
        var columns = [
            {data: "caj_descripcion"},
            {data: "monto"},
            {data: "fecha"},
            {data: "tipo_sangria"},
            {data: "usu_nombre"}
        ];

        generar_tablas(tabla,url,datos,columns);

    }

    function cargar_sangria_x_fecha_ventas(){
        var fecha_ini = $('#in_fecha_ini3').val();
        var fecha_fin = $('#in_fecha_fin3').val();
        var caja = $('#fcaja2').val();

        var tabla = "tb_sangria_cajas_ventas";
        var url ='<?php echo base_url(); ?>movimiento/sangria/sangrias_cajas_x_fecha_venta';
        var mov_diario_dataSrc2 = function(res){
            $('#sp_total_salida2').text(res.total_venta.sal_monto);
            $('#t_sangria_ingreso2').text(res.tsingreso.monto_ingreso);
            $('#t_sangria_salida2').text(res.tssalida.monto_retiro);
            return res.data;
        }
        var datos = function () {
            var data = {};
            data.f_inicio2 = fecha_ini;
            data.f_fin2 = fecha_fin;
            data.caja2 = caja;
            return data;
        };
        var columns = [
            {data: "caj_descripcion"},
            {data: "sal_fecha_registro"},
            {data: "emp_razon_social"},
            {data: "tdo_nombre"},
            {data: "sal_numero_doc_cliente"},
            {data: "sal_monto", className: "alinear_derecha"}
        ];

        generar_tabla_ajx2(tabla,url,datos,mov_diario_dataSrc2,columns);
    }

    function generar_tablas(id_tabla, url, data, columns) {
        $('#'+id_tabla).DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    text: 'Imprimir'
                }
            ],
            ajax: {
                url: url,
                type: "POST",
                data: data
            },
            columns: columns,
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Datos",
                "infoEmpty": "Mostrando 0 to 0 of 0 Datos",
                "infoFiltered": "(Filtrado de _MAX_ total datos)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "No se encontraron datos",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            destroy: true

        });
    }
    function generar_tabla_ajx2(id_tabla, url, data, dataSrc, columns) {
        $('#'+id_tabla).DataTable({
            ajax: {
                url: url,
                type: 'POST',
                data: data,
                dataSrc: dataSrc
            },
            columns: columns,
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Datos",
                "infoEmpty": "Mostrando 0 to 0 of 0 Datos",
                "infoFiltered": "(Filtrado de _MAX_ total datos)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "No se encontraron datos",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            destroy: true

        });
    }
    function calculartotal(){
        var totals= parseFloat($('#sp_total_salida2').html());
        var singreso= parseFloat($('#t_sangria_ingreso2').html());
        var ssalida= parseFloat($('#t_sangria_salida2').html());


        var calculado = (totals + singreso) - ssalida;

        $('#sp_total_salida3').html(calculado.toFixed(2));

    }

    function imprimir() {
        $('#titulo').show();
        $('#titulo').css({"margin-bottom":"10px"});
        $('#cabecera').css({"text-align": "center","align-content":"center"});
        $('#pie').css({"text-align": "right","align-content":"right","font-size":"20px","font-weight": "bold"});
        $('#a').css({"text-align": "center","align-content":"center","font-size":"20px","font-weight": "bold"});
        $('#b').css({"text-align": "center","align-content":"center","font-size":"20px","font-weight": "bold"});
        $('#c').css({"text-align": "center","align-content":"center","font-size":"20px","font-weight": "bold"});
        $('#d').css({"text-align": "center","align-content":"center","font-size":"20px","font-weight": "bold"});
        var printme= document.getElementById("tb_sangria_cajas_ventas");
        var wme= window.open();
        wme.document.write(printme.outerHTML);
        wme.document.close();
        wme.focus();
        wme.print();
        wme.close();
    }

</script>