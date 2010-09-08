function fecha_vacio()
{
	if ( $('#fecha_evento').val() == '' )
	{
		$('#error_fecha').html('Selecciona una fecha.').show();
		return true;
	}
	else
	{
		$('#error_fecha').html('').hide();
		return false;
	}
}

//-----------------------------------------------------------------------------

function nombre_vacio()
{
	if ( $('#nombre').val() == '' )
	{
		$('#error_nombre').html('Ingresa el nombre del evento.').show();
		return true;
	}
	else
	{
		$('#error_nombre').html('').hide();
		return false;
	}
}

//--------------------------------------------------------------------------

function lugar_vacio()
{
	if ( $('#lugar').val() == '' )
	{
		$('#error_lugar').html('Ingresa el lugar del evento.').show();
		return true;
	}
	else
	{
		$('#error_lugar').html('').hide();
		return false;
	}
}

//-----------------------------------------------------------------------------

function solicitante_vacio()
{
	if ( $('#solicitante').val() == '' )
	{
		$('#error_solicitante').html('Ingresa el nombre del solicitante del servicio.').show();
		return true;
	}
	else
	{
		$('#error_solicitante').html('').hide();
		return false;
	}
}

//-----------------------------------------------------------------------------

function insumos_vacio()
{
	if ( $('#insumos').val() == '' )
	{
		$('#error_insumos').html('Ingresa los insumos requeridos.').show();
		return true;
	}
	else
	{
		$('#error_insumos').html('').hide();
		return false;
	}
}

//-----------------------------------------------------------------------------

function numero_asistentes_vacio()
{
	if ( $('#num_asistentes').val() == '' )
	{
		$('#error_asistentes').html('Ingresa la cantidad de asistentes al evento.').show();
		return true;
	}
	else if ( !es_numero($('#num_asistentes').val()) )
	{
		$('#error_asistentes').html('Escribe un valor numérico sin puntos.').show();
		return true;
	}
	else
	{
		$('#error_asistentes').html('').hide();
		return false;
	}
}		

//-----------------------------------------------------------------------------

function email_con_logica()
{
	// Primero revisamos que no esté vacia.
	if ( $('#email_solicitante').val() == '' )
	{
		$('#error_email_solicitante').html('El email es necesario para enviar los detalles de la solicitud.').show();
		return false;
	}
	else if ( !es_email($('#email_solicitante').val()) )
	{
		$('#error_email_solicitante').html('Debes escribir un email válido.').show();
		return false;
	}
	else
	{
		$('#error_email_solicitante').html('').hide();
		return true;
	}
}

//--------------------------------------------------------------------------

$(document).ready(function()
{
	jQuery('div.cuerpo_menu ul #'+jQuery('#opcion_seleccionada').val()).addClass('selected');
	
	if ( $('#cuadro_notificaciones').not(':hidden') )
	{
		$('#cuadro_notificaciones').hide().slideDown('slow');
		//$('#cuadro_notificaciones').fadeTo(10000, 0.9).fadeOut(7000);
	}
	
	//-----------------------------------------------------------------------------
	
	jQuery('#boton_cal_1').click(function()
	{
		displayCalendar($('#fecha_evento').get(0),'yyyy-mm-dd',$('#boton_cal_1').get(0));
	});
	
	//-----------------------------------------------------------------------------
	
	// Validamos los datos del formulario.
	$('#solicitud_apoyo_evento').submit(function()
	{
		$('#nombre').val(jQuery.trim($('#nombre').val()));
		$('#lugar').val(jQuery.trim($('#lugar').val()));
		$('#solicitante').val(jQuery.trim($('#solicitante').val()));
		$('#email_solicitante').val(jQuery.trim($('#email_solicitante').val()));
		$('#insumos').val(jQuery.trim($('#insumos').val()));
		$('#num_asistentes').val(jQuery.trim($('#num_asistentes').val()));
		
		// Validamos los datos requeridos.
		fv = fecha_vacio();
		nv = nombre_vacio();
		lv = lugar_vacio();
		sv = solicitante_vacio();
		nav = numero_asistentes_vacio();
		iv = insumos_vacio();
		ecl = email_con_logica();
		
		// Si pasa todas las validaciones hacemos el Submit.
		if ( fv==false && nv==false && lv==false && sv==false && nav==false && iv==false && ecl==true )
		{
			return true;
		}
		else
		{
			return false;
		}
	});
});
