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

function descripcion_vacio()
{
	if ( $('#descripcion').val() == '' )
	{
		$('#error_descripcion').html('Ingresa una descripción del servicio solicitado.').show();
		return true;
	}
	else
	{
		$('#error_descripcion').html('').hide();
		return false;
	}
}

//-----------------------------------------------------------------------------

$(document).ready(function()
{
	jQuery('div.cuerpo_menu ul #'+jQuery('#opcion_seleccionada').val()).addClass('selected');

	if ( $('#cuadro_notificaciones').not(':hidden') )
	{
		$('#cuadro_notificaciones').hide().slideDown('slow');
		//$('#cuadro_notificaciones').fadeTo(10000, 0.9).fadeOut(7000);
	}
	
	//-----------------------------------------------------------------------------
	
	// Validamos los datos del formulario.
	$('#solicitud_reparacion').submit(function()
	{
		// Validamos los datos requeridos.
		$('#lugar').val(jQuery.trim($('#lugar').val()));
		$('#solicitante').val(jQuery.trim($('#solicitante').val()));
		$('#email_solicitante').val(jQuery.trim($('#email_solicitante').val()));
		$('#descripcion').val(jQuery.trim($('#descripcion').val()));
		$('#proceso').val(jQuery.trim($('#proceso').val()));
		lv = lugar_vacio();
		sv = solicitante_vacio();
		ecl = email_con_logica();
		dv = descripcion_vacio();
		
		// Si pasa todas las validaciones hacemos el Submit.
		if ( lv==false && sv==false && dv==false && ecl==true )
		{
			return true;
		}
		else
		{
			return false;
		}
	});
});
