function tiempo_estimado_vacio()
{
	$('#tiempo_estimado').val(jQuery.trim($('#tiempo_estimado').val()));
	if ( $('#tiempo_estimado').val() == '' )
	{
		$('#error_tiempo_estimado').html('Escribe la cantidad de horas estimadas para la reparación.').show();
		return true;
	}
	else if ( !es_numero($('#tiempo_estimado').val()) )
	{
		$('#error_tiempo_estimado').html('La cantidad debe ser un valor numérico y sin puntos ni comas.').show();
		return true;
	}
	else
	{
		$('#error_tiempo_estimado').html('').hide();
		return false;
	}
}

//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------

jQuery(document).ready(function()
{
	// Configuración inicial
	jQuery('div.cuerpo_menu ul #'+jQuery('#opcion_seleccionada').val()).addClass('selected');
	if ( jQuery('#cuadro_notificaciones').not(':hidden') )
	{
		jQuery('#cuadro_notificaciones').hide().slideDown('slow');
		jQuery('#cuadro_notificaciones').fadeTo(10000, 0.9).fadeOut(7000);
	}
	
	if (jQuery('#estado').html() == 'p' )
	{
		// Activamos los TextAreas e Inputs.
		jQuery('#id_funcionario').attr('name', 'data[ReparacionSolicitud][id_funcionario]');
		jQuery('#div_encargado_servicio').hide();
		jQuery('#div_encargado_servicio_input').show();
		
		jQuery('#tiempo_estimado').attr('name', 'data[ReparacionSolicitud][tiempo_estimado]');
		jQuery('#div_tiempo_estimado').hide();
		jQuery('#div_tiempo_estimado_input').show();
		
		jQuery('#observaciones_solucion').attr('name', 'data[ReparacionSolicitud][observaciones_solucion]');
		jQuery('#div_observaciones_solucion').hide();
		jQuery('#div_observaciones_solucion_input').show();
		
		jQuery('#estado').html('Pendiente').attr('style', 'color:red').show();
	}
	else if (jQuery('#estado').html() == 'a' )
	{
		jQuery('#div_encargado_servicio').html(jQuery('#nombre_encargado_servicio').val());
		jQuery('#div_observaciones_solucion').html(jQuery('#observaciones_solucion_reparacion').val());
		
		horas = ' horas.';
		if ( jQuery('#tiempo_estimado_reparacion').val() == 1 )
		{
			horas = ' hora.';
		}
		jQuery('#div_tiempo_estimado').html(jQuery('#tiempo_estimado_reparacion').val()+horas);
		jQuery('#estado').html('Archivada').attr('style', 'color:green').show();
	}
	
	jQuery('#boton_archivar').click(function()
	{
		tev = tiempo_estimado_vacio();
		
		// Si pasa todas las validaciones hacemos el Submit.
		if ( tev==false )
		{
			if ( confirm('¿Está seguro de querer archivar esta solicitud?') )
			{
				jQuery('#solucion').attr('action', '/reparacion_solicitudes/archivar/'+jQuery('#id_solicitud').val()).submit();
			}
		}
	});
	
	//--------------------------------------------------------------------------
});
