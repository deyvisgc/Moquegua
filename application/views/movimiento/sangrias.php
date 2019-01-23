<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Registro de Sangrías de caja <small></small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?= base_url() ?>bienvenida"><i class="fa fa-home"></i> Movimiento</a>
            </li>
            <li class="active">Sangría de caja</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Your Page Content Here -->
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs pull-right">
                        <li class="active"><a href="#dv_panel_eleccion" data-toggle="tab" id="a_panel_eleccion">Sangría</a></li>
                        <li class="pull-left header"><i class="fa fa-area-chart"></i> <span id="sp_etiqueta">Sangría</span></li>
                    </ul>
                    <div class="tab-content">
                        <!-- TAB ELECCION -->
                        <div class="tab-pane active" id="dv_panel_eleccion">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <div class="input-group" style="padding-left: 20px;">
                                        <span class="input-group-addon bg-gray">Ingresar Cantidad: </span>
                                        <input type="text" class="form-control col-md-4" required name="monto_form" autofocus id="monto_form">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="input-group" style="padding-left: 20px;">
                                        <span class="input-group-addon bg-gray">Tipo de sangría: </span>
                                        <select class="form-control custom-select" required id="tsangria_form" name="tsangria_form">
                                            <option value="retiro">Retiro</option>
                                            <option value="ingreso">Ingreso</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <div class="input-group" style="padding-left: 20px;">
                                            <span class="input-group-addon bg-gray ">Escriba el Motivo: </span>
                                            <textarea rows="2" cols="50" class="form-control col-md-4" placeholder="Ingresar el motivo" required name="motivo" autofocus id="motivo"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <br><br>
                                        <button class="btn btn-danger btn-lg" onclick="Registrar_Sangria();"> PROCEDER </button>     <br><br>
                                    </div>
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
    function init_ingreso(){
        $(document).ready(function () {

        });
    }


    function Registrar_Sangria(){
        var motivo = $('#motivo').val();
        if (motivo==''){
            swal({
                title: "Ups...",
                text: "Al parecer no escribio el motivo de la sangria. Por favor escriba el motivo",
                icon: "warning",
                type:"warning",
                buttons: true,
                dangerMode: true,
            });
        }else {
            var monto_form = $('#monto_form').val();
            var tipo_form = $('#tsangria_form').val();
            var motivo=$('#motivo').val();

            var data ={};
            data.monto_form = monto_form;
            data.tsangria_form = tipo_form;
            data.s_motivo = motivo;

            $.ajax({
                type:'POST',
                url: BASE_URL+'movimiento/sangria/agregarSangria',
                dataType:'json',
                data:data,
                success:function(data){
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Sangría registrada correctamente...',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $('#monto_form').val('');
                    $('#motivo').val('');
                }
            });
        }
    }


</script>