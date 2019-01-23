/*******************************************************************/
function procesa_lineas(){
          var linea=$("#linea").val();
          var grupo=$("#grupo").val();
          var descripcion=$("#descripcion").val();
          if(linea==""||linea=="0"||grupo==""){
            alert("Ingresa un numero de linea, no debe de ser 0 y en grupo no debe estar vacio...")
            $("#linea").select();
            $("#linea").focus();
            return false;
          }
         $.ajax({
         beforeSend: function(){
            $('#btn-altas').prop('disabled', true);
            $('#btn-altas').html("Procesando...");
          },
         url: 'procesa_lineas_alta.php',
         type: 'POST',
         data: 'linea='+linea+'&grupo='+grupo+'&descripcion='+descripcion,
         success: function(respuesta){
           if(respuesta=="PROCESADO"){
             alert("Se registro la linea correctamente...")
            $("#linea").html('');
            $("#grupo").html('');
            $("#descripcion").html('');
            $("#btn-altas").html("<i class='fa fa-check-circle'></i>Registrar linea.");
            $('#btn-altas').prop('disabled', false);
            pone_lista_lineas();
           }
           if(respuesta=="ERROR"){
             alert("Ocurrio un error al realizar el registro de lineas, por favor consulte a Soporte inmediatamente...!");
           }
           if(respuesta=="EXISTE"){
              alert("La linea y/o grupo ingresados, ya se encuentran registrados...!");
            $("#btn-altas").html("<i class='fa fa-check-circle'></i>Registrar linea.");
            $('#btn-altas').prop('disabled', false);
           }
          },
         error: function(jqXHR,estado,error){
          }
        });
       }
/********************************************************************/
function busca_linea(){
        var linea_a_buscar=$("#linea_baja").val();
        $.ajax({
         beforeSend: function(){
          $("#linea_baja_descripcion").html('Buscando la linea');
          },
         url: 'busca_linea.php',
         type: 'POST',
         data: "linea="+linea_a_buscar,
         success: function(r){
           if(r=="0"){
             $("#linea_baja_descripcion").html("No existe el numero de Linea...");
             $("#linea_baja").select();
             $("#linea_baja").focus();
           }else{
             $("#linea_baja_descripcion").html("<button class='btn btn-success' disabled>"+r+"</button>");
             $("#grupo_baja").removeAttr("disabled");
             $("#grupo_baja").focus();
           }
          },
         error: function(jqXHR,estado,error){
          }
        });
      }
/******************************************************************/
function busca_grupo(){
        var grupo_a_buscar=$("#grupo_baja").val();
        if(grupo_a_buscar==""){
           alert("El grupo no puede estar vacio...");
           $("#grupo_baja").focus();
        }
        $.ajax({
         beforeSend: function(){
          $("#grupo_baja_descripcion").html('Buscando el Grupo...');
          },
         url: 'busca_grupos.php',
         type: 'POST',
         data: "linea="+$("#linea_baja").val()+"&grupo="+grupo_a_buscar,
         success: function(re){
           if(re=="0"){
             $("#grupo_baja_descripcion").html("No existe el numero de Grupo...");
             $("#btn-bajas").prop("disabled", true);
             $("#grupo_baja").select();
             $("#grupo_baja").focus();
             return false;
           }else{
             $("#grupo_baja_descripcion").html("<button class='btn btn-success' disabled>"+re+"</button>");
             $("#btn-bajas").removeAttr("disabled");
           }
          },
         error: function(jqXHR,estado,error){
          }
        });
      }
/**********************************************************************************/
function procesa_lineas_baja(){
          var linea=$("#linea_baja").val();
          var grupo=$("#grupo_baja").val();
         $.ajax({
         beforeSend: function(){
            $('#btn-bajas').prop('disabled', true);
            $('#btn-bajas').html("Procesando...");
          },
         url: 'procesa_lineas_baja.php',
         type: 'POST',
         data: 'linea='+linea+"&grupo="+grupo,
         success: function(res){
            if(res=="1"){
              alert("La linea no se pudo eliminar por que contiene grupos...!");
             $("#btn-bajas").html("<i class='fa fa-check-circle'></i> Eliminar.")
            return false;
            }

            if(res=="ELIMINADO"){
               alert("Se realizo la eliminacion correctamente...!");
               $("#grupo_baja_descripcion").empty();
               $("#linea_baja_descripcion").epmty();
               $("#grupo_baja").val("");
               $("#linea_baja").val("");
               $("#grupo_baja").attr('disabled', true);
               $("#linea_baja").focus();
              pone_lista_lineas();
             $("#btn-bajas").html("<i class='fa fa-check-circle'></i> Eliminar.")
            }
          },
         error: function(jqXHR,estado,error){
          }
        });
       }
/******************************************************************************************/
function busca_linea_cambia(){
        $.ajax({
         beforeSend: function(){
          $("#linea_cambia_descripcion").html('Buscando la linea...');
          },
         url: 'busca_linea_cambia.php',
         type: 'POST',
         data: "linea="+$("#linea_cambia").val(),
         success: function(rx){
            if(rx=="0"){
              $("#linea_cambia_descripcion").html("<button class='btn btn-danger' disabled>No existe la linea...</button>");
              $("#grupo_cambia").prop('disabled', true);
              $("#descripcion_cambia").prop('disabled', true);
              $("#linea_cambia").select();
              $("#linea_cambia").focus();
              return false;
            }else{
              $("#linea_cambia_descripcion").html("<button class='btn btn-success' disabled>"+rx+"</button>");
              $("#grupo_cambia").removeAttr("disabled");
              $("#grupo_cambia").focus();
            }
          },
         error: function(jqXHR,estado,error){
          }
        });
       }
 /**************************************************************************************/
 function busca_grupo_cambia(){
         if($("#grupo_cambia").val()==""){
            alert("Ingresa un nmero de grupo, puede ser 0, pero no debe de estar vacio...!");
            $("#grupo_cambia").focus();
            return false;
         }
        $.ajax({
         beforeSend: function(){
          $("#grupo_cambia_descripcion").html('Buscando el Grupo...');
          },
         url: 'busca_grupo_cambia.php',
         type: 'POST',
         data: "linea="+$("#linea_cambia").val()+"&grupo="+$("#grupo_cambia").val(),
         success: function(rxx){
            if(rxx=="0"){
              $("#grupo_cambia_descripcion").html("<button class='btn btn-danger' disabled>No existe el grupo...</button>");
              $("#descripcion_cambia").prop('disabled', true);
              $("#btn-actualiza").prop('disabled', true);
              $("#grupo_cambia").select();
              $("#grupo_cambia").focus();
              return false;
            }else{
              $("#descripcion_cambia").removeAttr("disabled");
              $("#grupo_cambia_descripcion").html("<button class='btn btn-success' disabled>"+rxx+"</button>");
              $("#descripcion_cambia").val(rxx);
              $("#btn-actualiza").removeAttr('disabled');
              $("#descripcion_cambia").select();
              $("#descripcion_cambia").focus();
            }
          },
         error: function(jqXHR,estado,error){
          }
        });
       }
/******************************************************************************************/
function actualiza_lineas(){
        var lineax=$("#linea_cambia").val();
        var grupox=$("#grupo_cambia").val();
        var descripcionx=$("#descripcion_cambia").val();
        if(lineax==""||grupox==""||descripcionx==""){
          alert("No se puede continuar con campos vacios...!");
            return false;
        }
       $.ajax({
         beforeSend: function(){
          $("#btn-actualiza").html('Procesando...');
          },
         url: 'actualiza_lineas.php',
         type: 'POST',
         data: "linea="+lineax+"&grupo="+grupox+"&descripcion="+descripcionx,
         success: function(rxx){
           alert("Se actualizo la informacion de las lineas...");
           $("#btn-actualiza").prop('disabled', true);
           $("#btn-actualiza").html("<i class='fa fa-recycle'></i> Actualizar.");
           $("#grupo_cambia").val("");
           $("#linea_cambia").val("");
           $("#grupo_cambia").prop("disabled", true);
           $("#grupo_cambia_descripcion").empty();
           $("#linea_cambia_descripcion").empty();
           $("#descripcion_cambia").val("");
           $("#descripcion_cambia").prop("disabled", true);
           pone_lista_lineas();
          },
         error: function(jqXHR,estado,error){
          }
        });
      }
/******************************************************************************/
function pone_lista_lineas(){
        $.ajax({
         beforeSend: function(){
           $("#lista_lineas").html("Actualizando la lista de lineas...");
          },
         url: 'lista_lineas.php',
         type: 'POST',
         data: null,
         success: function(y){
           $("#lista_lineas").html(y);
           $(document).ready(function() {
                $('#tabla_de_lineas').DataTable();
                 });
           },
         error: function(jqXHR,estado,error){
          }
        });
      }
/*******************************************************************************/
function pone_lista_Caducar(){
        $.ajax({
         beforeSend: function(){
           $("#lista_Caducar").html("Actualizando la lista...");
          },
         url: 'lista_Caducar.php',
         type: 'POST',
         data: null,
         success: function(y){
           $("#lista_Caducar").html(y);
           $(document).ready(function() {
                $('#tabla_de_Caducar').DataTable();
                 });
           },
         error: function(jqXHR,estado,error){
          }
        });
      }
/*******************************************************************************/
