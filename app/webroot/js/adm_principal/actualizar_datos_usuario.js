//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------

$(document).ready(function()
{
	jQuery('div.cuerpo_menu ul #'+jQuery('#opcion_seleccionada').val()).addClass('selected');
	
	if ( $('#cuadro_notificaciones').not(':hidden') )
	{
		$('#cuadro_notificaciones').hide().slideDown('slow');
		$('#cuadro_notificaciones').fadeTo(10000, 0.9).fadeOut(7000);
	}
	
	//--------------------------------------------------------------------------
	// Programamos los diferentes EVENTOS.
	
	// Validamos los datos del formulario.
	$('#usuario').submit(function()
	{
		$('#login').val(jQuery.trim($('#login').val()));
		$('#email').val(jQuery.trim($('#email').val()));
		
		// Validamos los datos requeridos.
		lcl = login_con_logica('h_login', 'login');
		clv = claves_correctas();
		ecl = email_con_logica();
		
		// Si pasa todas las validaciones hacemos el Submit.
		if ( lcl==true && clv==true && ecl==true )
		{
			// Si hay una clave nueva, activamos variable data[][].
			if ( $('#clave').val() != '' )
			{
				$('#clave').attr('name', 'data[Usuario][clave]');
			}
			
			$('#usuario').attr('action', '/smuqplaf/usuarios/modificar');
			return true;
		}
		else
		{
			return false;
		}
	});
});
