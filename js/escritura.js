/* < MENSAJE-show-hide */
$(function(){
	$(".cerrar_alert").click(cerrar_alert);
});
function cerrar_alert(e) {
	var div_alert = $(e.target).closest('.alert');
	div_alert.hide();
}
function isvoid_mensaje(id, nombre) {
	var texto = "";
	var valor = $("#"+id).val();
	if(valor == '') {
		texto = '<span style="display: block;text-align: left;">Ingrese '+nombre+'.</span>';
	}
	return texto;
}
function show_mensaje(mensaje, titulo, id, tipo) {
	$('#'+id+' .st_alert_'+tipo).text(titulo);
	$('#'+id+' .dv_alert_'+tipo).empty();
	$('#'+id+' .dv_alert_'+tipo).append(mensaje);
	$('#'+id).show();
}
function hide_mensajes(ids) {
	ids.forEach(function(id) {
		$('#'+id).hide();
	});
}
/* MENSAJE-show-hide > */

/*
function show_mensaje_global() {
	if( $(".sy_mensaje_global").length === 0 ) {
		// alert("No existe.");
		$("body").append('<div class="position-fixed fixed-top sy_mensaje_global">HOLA COMO ESTAS</div>');
		alert("creado body");
	}
}


$(function(){
	show_mensaje_global();
});
*/

function add_mensaje___temp(id, titulo, mensaje, tipo) {
	/* $('#'+id+' .st_alert_'+tipo).text(titulo);
	$('#'+id+' .dv_alert_'+tipo).empty();
	$('#'+id+' .dv_alert_'+tipo).append(mensaje);
	$('#'+id).show(); */
	$('#'+id).append('<div class="alert alert-'+tipo+' alert-dismissible">'+
		'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
		'<strong>'+titulo+'</strong>'+
		'<span>'+mensaje+'</span>'+
		'</div>');
	
	/* setTimeout(function(){
			if ($('#divID').length > 0) {
				$('#divID').remove();
			}
		}, 5000
	); */
	setTimeout(remove_add_mensaje, 2000, id);
}
function remove_add_mensaje(id) {
	// $(this).find('div:first').remove();
	// children().first()
	if( $('#'+id).length > 0) {
		if( $('#'+id).children().length > 0) {
			$('#'+id).children().first().remove();
		}
	}
}
/* var test = function(a){
    var b = (a) ? a : "fail";
    alert(b);
};
setTimeout(test, 500, "works"); */