//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------

$(document).ready(function()
{
	// Configuración inicial
	jQuery('div.cuerpo_menu ul #'+jQuery('#opcion_seleccionada').val()).addClass('selected');
	if ( $('#cuadro_notificaciones').not(':hidden') )
	{
		$('#cuadro_notificaciones').hide().slideDown('slow');
		$('#cuadro_notificaciones').fadeTo(10000, 0.9).fadeOut(7000);
	}
	
	if ($('#estado').html() == 'p' )
	{
		$('#estado').html('Pendiente').attr('style', 'color:red').show();
		jQuery('#observaciones_solucion').attr('name', 'data[ApoyoEventoSolicitud][observaciones_solucion]');
		jQuery('#div_observaciones_solucion').hide();
		jQuery('#div_observaciones_solucion_input').show();
	}
	else if ($('#estado').html() == 'a' )
	{
		$('#estado').html('Archivada').attr('style', 'color:green').show();
		jQuery('#div_observaciones_solucion').html(jQuery('#observaciones_solucion_apoyo').val());
	}
	
	$('#boton_archivar').click(function()
	{
		if ( confirm('¿Está seguro de querer archivar esta solicitud?') )
		{
			$('#solucion').attr('action', '/apoyo_evento_solicitudes/archivar/'+jQuery('#id_solicitud').val()).submit();
		}
	});
	
	//--------------------------------------------------------------------------
});
