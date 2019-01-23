<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Reporte Stock<small></small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?= base_url() ?>bienvenida"><i class="fa fa-home"></i> Home</a>
            </li>
            <li class="active">Reporte Stock.</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Your Page Content Here -->
        <div class="row">

            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs pull-right">
                        <li class="active"><a href="#dv_general" data-toggle="tab" id="a_general">Reporte</a></li>
                        <li class="pull-left header"><i class="fa fa-calculator"></i> Reporte de Ventas por caja</li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="dv_general">
                            <div class="row">
                                <div class="input-group col-sm-4" style="padding-left: 20px;">
                                    <span class="input-group-addon bg-gray "><i class="fa fa-search"></i> Buscar caja:</span>
                                    <input type="text" class="form-control col-sm-4" name="search_caja" autofocus id="search_caja">
                                </div>
                                <div class="col-sm-12 box-body table-responsive">
                                    <p></p>
                                    <table class="table table-bordered" id="tb_ventas">
                                        <thead>
                                        <tr>
                                            <th>CAJA</th>
                                            <th>PRODUCTO</th>
                                            <th>CANTIDAD VENDIDA</th>
                                            <th>PRECIO VENTA</th>
                                            <th>TOTAL VENTA</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script>
    var table;
    var caja;
    function init_salida() {
        $(document).ready(function () {
            $("#search_caja").autocomplete({
                source:function (request,response) {
                    $.ajax({
                        url:BASE_URL+'reporte/Ventas/listarCajas',
                        dataType: 'json',
                        type: 'POST',
                        data:{
                            texto:request.term
                        },
                        success:function(data){
                            response(data.list_ventas);
                        }
                    });
                },
                delay:300,
                minLength:1,
                select:function(event,ui){
                    $('#search_caja').val(ui.item.caj_descripcion);

                    var caja=$('#search_caja').val();
                    console.log(caja);

                    table = $('#tb_ventas').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            {
                                extend: 'print',
                                text: 'Imprimir'
                            }
                        ],
                        'ajax':{
                            url: BASE_URL + 'reporte/Ventas/listarProductosVendidos/'+caja,
                            type:'POST'
                        },
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
                    return false;
                }
            });


        });
    }
/*
    function cargarVentas(){
        caja =$('#search_caja').val();

        table = $('#tb_ventas').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    text: 'Imprimir'
                }
            ],
            'ajax':{
               url: BASE_URL + 'reporte/Ventas/listarVentas'+,
            },

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
            }
        });
    }*/
</script>