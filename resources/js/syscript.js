var BASE_URL = './';
/* var BASE_URL = 'http://www.foo.com/url-root/';

function getUrl(url) {
    return BASE_URL.concat(url);
}

$(function() {
    var BASE_URL2 = 'http://www.foo.com/url-root/';

    window.BASE_URL = function(url) {
        return BASE_URL2.concat(url);
    }
	
	alert(window.BASE_URL("siiii"));
	
	$('body').append('<button onclick="alert(window.BASE_URL('+"'siiii'"+'))">CLICK</button>');
});

alert(getUrl("siiii")); */
function getLanguageDefault() {
	var language = {
		"decimal": "",
		"emptyTable": "Tabla vacia.",
		"info": "Mostrando _START_ a _END_ de _TOTAL_ entradas.",
		"infoEmpty": "Mostrando 0 a 0 de 0 entradas.",
		"infoFiltered": "(filtrado de _MAX_ entradas totales)",
		"infoPostFix": "",
		"thousands": ",",
		"lengthMenu": "Mostrar _MENU_ entradas",
		"loadingRecords": "Cargando...",
		"processing": "Procesando...",
		"search": "Buscar",
		"zeroRecords": "No se encontraron registros coincidentes.",
		"paginate": {
			"first": "Primero",
			"last": "Final",
			"next": "Siguiente",
			"previous": "Anterior"
		},
		"aria": {
			"sortAscending": ": activar para ordenar la columna ascendente.",
			"sortDescending": ": activar para ordenar la columna descendente."
		}
	};
	return language;
}
function generar_data_table(id_tabla, objeto) {
	// if(true) return;
	/* var ajax = {
		url: objeto.ajax.url,
		type: objeto.ajax.type,
		data: objeto.ajax.data,
		dataSrc: objeto.ajax.dataSrc
	}; */
	// typeof foo.bar.myVal !== 'undefined'
	/* if (typeof objeto.ajax.url !== "undefined") {
		alert("AJAX NO EXISTE");
		return;
	} */
	// alert(objeto.ajax.url);
	if(!objeto.hasOwnProperty('ajax')) {
		add_mensaje(null, '!!! ', ' Error dat-table 1.', 'danger');
		return;
	}
	/* if(!objeto.ajax.hasOwnProperty('dataSrc')) {
		alert("dataSrc NO EXISTE");
		return;
	} */
	if(!objeto.hasOwnProperty('columns')) {
		add_mensaje(null, '!!! ', ' Error dat-table columns.', 'danger');
		return;
	}
	if(!objeto.hasOwnProperty('language')) {
		objeto.language = getLanguageDefault();
	}
	if(!objeto.hasOwnProperty('ordering')) {
		objeto.ordering = true;
	}
	if(!objeto.hasOwnProperty('searching')) {
		objeto.searching = true;
	}
	if(!objeto.hasOwnProperty('info')) {
		objeto.info = true;
	}
	if(!objeto.hasOwnProperty('paging')) {
		objeto.paging = true;
	}
	
	$('#'+id_tabla).DataTable(objeto);
}


function generar_tabla(id_tabla, url, data, columns) {
	$('#'+id_tabla).DataTable({
		ajax: {
			url: url,
			type: "POST",
			data: data
		},
		columns: columns,
		"language": {
			"decimal": "",
			"emptyTable": "Tabla vacia.",
			"info": "Mostrando _START_ a _END_ de _TOTAL_ entradas.",
			"infoEmpty": "Mostrando 0 a 0 de 0 entradas.",
			"infoFiltered": "(filtrado de _MAX_ entradas totales)",
			"infoPostFix": "",
			"thousands": ",",
			"lengthMenu": "Mostrar _MENU_ entradas",
			"loadingRecords": "Cargando...",
			"processing": "Procesando...",
			"search": "Buscar",
			"zeroRecords": "No se encontraron registros coincidentes.",
			"paginate": {
				"first": "Primero",
				"last": "Final",
				"next": "Siguiente",
				"previous": "Anterior"
			},
			"aria": {
				"sortAscending": ": activar para ordenar la columna ascendente.",
				"sortDescending": ": activar para ordenar la columna descendente."
			}
		}
		
	});
}
function generar_tabla_ajx(id_tabla, url, type, data, dataSrc, columns) {
	$('#'+id_tabla).DataTable({
		ajax: {
			url: url,
			type: type,
			data: data,
			dataSrc: dataSrc
		},
		columns: columns,
		"language": {
			"decimal": "",
			"emptyTable": "Tabla vacia.",
			"info": "Mostrando _START_ a _END_ de _TOTAL_ entradas.",
			"infoEmpty": "Mostrando 0 a 0 de 0 entradas.",
			"infoFiltered": "(filtrado de _MAX_ entradas totales)",
			"infoPostFix": "",
			"thousands": ",",
			"lengthMenu": "Mostrar _MENU_ entradas",
			"loadingRecords": "Cargando...",
			"processing": "Procesando...",
			"search": "Buscar",
			"zeroRecords": "No se encontraron registros coincidentes.",
			"paginate": {
				"first": "Primero",
				"last": "Final",
				"next": "Siguiente",
				"previous": "Anterior"
			},
			"aria": {
				"sortAscending": ": activar para ordenar la columna ascendente.",
				"sortDescending": ": activar para ordenar la columna descendente."
			}
		}
		
	});
}
function generar_tabla_infoff(id_tabla, url, data, columns) {
	$('#'+id_tabla).DataTable({
		ajax: {
			url: url,
			type: "POST",
			data: data
		},
		columns: columns,
		"language": {
			"decimal": "",
			"emptyTable": "Tabla vacia.",
			"info": "Mostrando _START_ a _END_ de _TOTAL_ entradas.",
			"infoEmpty": "Mostrando 0 a 0 de 0 entradas.",
			"infoFiltered": "(filtrado de _MAX_ entradas totales)",
			"infoPostFix": "",
			"thousands": ",",
			"lengthMenu": "Mostrar _MENU_ entradas",
			"loadingRecords": "Cargando...",
			"processing": "Procesando...",
			"search": "Buscar",
			"zeroRecords": "No se encontraron registros coincidentes.",
			"paginate": {
				"first": "Primero",
				"last": "Final",
				"next": "Siguiente",
				"previous": "Anterior"
			},
			"aria": {
				"sortAscending": ": activar para ordenar la columna ascendente.",
				"sortDescending": ": activar para ordenar la columna descendente."
			}
		},
		"ordering": false,
		"searching": false,
		"info": false,
		"paging": false
	});
}

function get_fhoy() {
	// FORMATO DE HTML5 input[date] >> 'aaaa-mm-dd'
	var texto = '';
	var fecha = new Date();
	var anho = fecha.getFullYear().toString();
	var mes = ("0" + (fecha.getMonth() + 1)).slice(-2);
	var dia = ("0" + fecha.getDate()).slice(-2);
	texto = anho+'-'+mes+'-'+dia;
	return texto;
}

function preparar_subida_archivo(id_file, id_img, id_input, id_span, url_repositorio, url_path, url_default) {
	$('#'+id_file).change(function(){
		if( $(this).val() != '') {
			subir_archivo_arepositorio(id_file, id_img, id_input, id_span, url_repositorio, url_path);
		}
	});
	/* $('#'+id_input).keyup(function(){
		if( $(this).val() != '') {
			$('#'+id_img).attr("src", $(this).val());
		}
	}); */
	$('#'+id_img).on("error", function () {
		$( this ).attr( "src",  url_default);
		// $('#'+id_input).val(url_default);
	});
}
function subir_archivo_arepositorio(id_file, id_img, id_input, id_span, url, path) {
	var formData = new FormData();
	formData.append('archivo', $('#'+id_file)[0].files[0]);
	
	var message = "";
	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'json',
		data: formData,
		cache: false,
		contentType: false,
		processData: false,
		beforeSend: function(){
			$('#'+id_span).empty();
			$('#'+id_span).append('Cargando.');
		},
		success: function(data){
			if(data.hecho == 'SI') {
				var url_full = path+"../resources/sy_file_repository/"+data.orig_name;
				
				$('#'+id_img).attr("src", url_full);
				$('#'+id_input).val(data.orig_name);
				
				$('#'+id_span).empty();
				$('#'+id_span).append('Correcto.');
				$('#'+id_file).val('');
				add_mensaje(null, " Correcto ", ' ', "success");
			}
			else {
				$('#'+id_span).empty();
				$('#'+id_span).append('No cargo.');
				// alert(data.error);
				$('#'+id_file).val('');
				add_mensaje(null, " ARCHIVO!!! ", ' '+data.error, "warning");
			}
		},
		error: function(){
			$('#'+id_span).empty();
			$('#'+id_span).append('ERROR!!!.');
			$('#'+id_file).val('');
			add_mensaje(null, " !!! ", ' Error.', "danger");
		}
	});
}

function get_generated_id() {
	return '_' + Math.random().toString(36).substr(2, 9);
}

function add_mensaje(id, titulo, mensaje, tipo) {
	if(id === null) {
		if($('#dv_idmsj_default').length == 0) {
			$('body').append('<div class="css_global_mensajes" id="dv_idmsj_default"></div>');
		}
		id = 'dv_idmsj_default';
	}
	var new_id = get_generated_id();
	
	$('#'+id).append('<div class="alert alert-'+tipo+' alert-dismissible" style="margin-bottom: 1px; padding-top: 8px; padding-bottom: 8px;" id="'+new_id+'">'+
		'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
		// '<i class="fa fa-warning"></i>'+
		'<strong>'+titulo+'</strong>'+
		'<span>'+mensaje+'</span>'+
		'</div>');
	// if(true) return;	// BORRAR
	setTimeout(remove_add_mensaje, 3000, new_id);
}
function remove_add_mensaje(id) {
	if( $('#'+id).length > 0) {
		$('#'+id).fadeOut(800, function() { $(this).remove(); });
	}
}
function isvoid_mensaje(id, nombre) {
	var texto = "";
	var valor = $("#"+id).val();
	if(valor == '') {
		texto = '<span style="display: block;text-align: left;">Ingrese '+nombre+'.</span>';
	}
	return texto;
}

/* ********************* */
$(function(){
	$(".clss_a_show_perfil").on("click", function(e){
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: BASE_URL+"bienvenida/mostrar_perfil",
			dataType: 'json',
			data: null,
			success: function(data) {
				if(data.hecho == 'SI') {
					// $('#a_reporte').tab('show');
					// add_mensaje(null, " Correcto. ", ' guardado.', "success");
					var texto = '<span class="css_ltr1_negrita">Nombre: <b>'+data.data.per_nombre+' '+data.data.per_apellido+'</b></span>'+
						'<p></p>'+
						'<span class="css_ltr1_negrita">'+data.data.tdo_nombre+': <b>'+data.data.per_numero_doc+'</b></span>'+
						'<p></p>'+
						'<span class="css_ltr1_negrita">Direccion: <b>'+data.data.per_direccion+'</b></span>'+
						'<p></p>'+
						'<span class="css_ltr1_negrita">Tel. Movil: <b>'+data.data.per_tel_movil+'</b></span>'+
						'<p></p>'+
						'<span class="css_ltr1_negrita">Tel. Fijo: <b>'+data.data.per_tel_fijo+'</b></span>'+
						'<p></p>'+
						'<img src="'+data.data.per_foto+'" class="img-circle" alt="User Image" style="max-width: 100px; height: 100px;" id="img_foto">';
					// var urlDir = $(this).attr("href");
					swal({
						title: '<span style="text-decoration: underline">DATOS DE PERFIL</span>',
						// text: "Quieres salir del sistema y finalizar la sesiÃ³n actual",
						text: texto,
						// type: 'warning',
						// showCancelButton: true,
						confirmButtonColor: '#3085d6',
						// cancelButtonColor: '#d33',
						confirmButtonText: 'Ocultar'
						// cancelButtonText: 'Cancelar'
					}).then(function () {
					  // window.location.href = urlDir;
					  // alert("OK");
					  add_mensaje(null, " Ok. ", ' datos de perfil.', "success");
					});
				}
				
			}
		});
		
	});
});
/* ********************* */

var _msj_system = [];
_msj_system['PE01'] = ' Periodo iniciado.';
_msj_system['PE02'] = ' NoN';
_msj_system['0041'] = ' No hay Periodo iniciado';
_msj_system['0061'] = ' Periodo iniciado.';
_msj_system['0065'] = ' Periodo finalizado.';
_msj_system['1000'] = ' Correcto.';
_msj_system['9000'] = ' Correcto...';

_msj_system['P105'] = ' Ya se registro';
_msj_system['0161'] = ' Grado agregado.';
_msj_system['0165'] = ' Se quito Grado.';
_msj_system['P108'] = ' Grado no existe';
_msj_system['P102'] = ' Se quito Grado.';

// _msj_system['P102'] = ' Se quito Grado.';
_msj_system['P211'] = ' Grado no iniciado.';
_msj_system['P213'] = ' Curso ya iniciado.';
_msj_system['P201'] = ' Curso iniciado.';

_msj_system['P222'] = ' Curso no inciado.';
_msj_system['P221'] = ' Se quito Curso.';


_msj_system['P109'] = ' Grado tiene cursos.';
_msj_system['P110'] = ' Grado tiene alumnos.';

_msj_system['P311'] = ' Grado no iniciado.';
_msj_system['P313'] = ' Alumno ya inicio.';
_msj_system['P301'] = ' Alumno inicio.';

_msj_system['P325'] = ' Alumno no inicio.';
_msj_system['P321'] = ' Se retiro Alumno.';

_msj_system['S1EXP001'] = ' Entidades cargadas.';
_msj_system['S1EXP005'] = ' No iniciado periodo.';

_msj_system['0CAJ0001'] = ' Aperture caja.';
_msj_system['0CAJ0002'] = ' No hay cajas libres.';
_msj_system['0CAJ0003'] = ' Caja aperturada.';
// *******************************************
_msj_system['CAJ0201'] = ' Caja perturada.';
_msj_system['CAJ0204'] = ' Ya aperturo Caja.';

_msj_system['0CAJ0101'] = ' Cierre Caja.';
_msj_system['0CAJ0102'] = ' No tiene Caja.';

_msj_system['CAJ0301'] = ' Cierre Correcto.';
_msj_system['CAJ0303'] = ' No aperturo caja.';

// alert("111");

// SALIDA
_msj_system['SAL0101'] = ' El producto no existe.';
_msj_system['SAL0102'] = ' Producto esta agregado.';
_msj_system['SAL0103'] = ' Cantidad mayor el STOCK total.';
_msj_system['SAL0104'] = ' Cantidad minima 0.01.';
_msj_system['SAL0105'] = ' El producto se agrego.';

_msj_system['SAL0201'] = ' El producto no existe.';
_msj_system['SAL0205'] = ' El producto se quito.';

_msj_system['SAL0301'] = ' No tiene productos.';
_msj_system['SAL0302'] = ' EL dinero no coincide.';
_msj_system['SAL0303'] = ' No abrio caja.';
_msj_system['SAL0304'] = ' Error de documentacion.';
_msj_system['SAL0305'] = ' Venta hecha.';

_msj_system['ING0101'] = ' Cantidad minima 0.01.';
_msj_system['ING0102'] = ' Producto esta agregado.';
_msj_system['ING0105'] = ' El producto se agrego.';

_msj_system['ING0201'] = ' El producto no existe.';
_msj_system['ING0205'] = ' El producto se quito.';

_msj_system['ING0301'] = ' No tiene productos.';
_msj_system['ING0302'] = ' EL dinero no coincide.';
_msj_system['ING0303'] = ' No abrio caja.';
_msj_system['ING0305'] = ' Compra hecha.';
