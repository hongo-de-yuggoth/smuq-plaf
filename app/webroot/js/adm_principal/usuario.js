//-----------------------------------------------------------------------------

function nombre_vacio()
{
	if ( $('#nombre').val() == '' )
	{
		$('#error_nombre').html('Escribe el nombre del usuario.').css('display', 'block');
		return true;
	}
	else
	{
		$('#error_nombre').css('display', 'none');
		return false;
	}
}

//-----------------------------------------------------------------------------

function cedula_con_logica(cedula_actual, cedula)
{
	// Primero revisamos que no esté vacia.
	if ( $('#'+cedula).val() == '' )
	{
		$('#error_cedula').html('Escribe la cédula del usuario.').css('display', 'block');
		return false;
	}
	else if ( $('#'+cedula_actual).val() != $('#'+cedula).val() )
	{
		// Ahora que sea numérico.
		if ( !es_numero($('#'+cedula).val()) )
		{
			$('#error_cedula').html('Debes escribir un valor numérico y sin puntos.').css('display', 'block');
			return false;
		}
		else if ( existe_cedula($('#'+cedula).val()) )
		{	
			// y Por último verificamos que no exista ya un usuario con esta misma cedula.
			$('#error_cedula').html('Esta cédula ya existe en el sistema.').css('display', 'block');
			return false;
		}
		else
		{
			$('#error_cedula').html('').css('display', 'none');
			return true;
		}
	}
	else
	{
		$('#error_cedula').html('').css('display', 'none');
		return true;
	}
}

//-----------------------------------------------------------------------------

function login_con_logica(login_actual, login)
{
	// Primero revisamos que no esté vacia.
	if ( $('#'+login).val() == '' )
	{
		$('#error_login').html('Escribe el login del usuario.').css('display', 'block');
		return false;
	}
	else if ( $('#'+login_actual).val() != $('#'+login).val() )
	{
		// y Por último verificamos que no exista ya un usuario con este mismo login.
		if ( existe_login($('#'+login).val()) )
		{
			$('#error_login').html('Este login ya está asignado a un usuario.').css('display', 'block');
			return false;
		}
		else
		{
			$('#error_login').html('').css('display', 'none');
			return true;
		}
	}
	else
	{
		$('#error_login').html('').css('display', 'none');
		return true;
	}
}

//-----------------------------------------------------------------------------

function claves_correctas()
{
	if ( $('#clave').val() == '' && $('#clave2').val() == '' )
	{
		$('#error_clave').html('').hide();
		$('#error_clave2').html('').hide();
		return true;
	}
	
	// Primero revisamos que no esté vacia.
	if ( $('#clave').val() == '' )
	{
		$('#error_clave').html('Escribe la clave del usuario.').show();
		$('#error_clave2').html('').hide();
		return false;
	}
	
	if ( $('#clave2').val() == '' )
	{
		$('#error_clave').html('').hide();
	  	$('#error_clave2').html('Debes escribir la misma clave anterior.').show();
		return false;
	}
	
	if ( $('#clave').val() != $('#clave2').val() )
	{
		$('#error_clave').html('').hide();
		$('#error_clave2').html('No concuerda con la primera clave, las dos claves deben ser iguales.').show();
		return false;
	}
	else
	{
		$('#error_clave').html('').hide();
		$('#error_clave2').html('').hide();
		return true;
	}
}

//-----------------------------------------------------------------------------

function email_con_logica()
{
	// Primero revisamos que no esté vacia.
	if ( $('#email').val() == '' )
	{
		$('#error_email').html('Escribe el email del usuario.').css('display', 'block');
		return false;
	}
	else if ( !es_email($('#email').val()) )
	{
		$('#error_email').html('Debes escribir un email válido.').css('display', 'block');
		return false;
	}
	else
	{
		$('#error_email').html('').css('display', 'none');
		return true;
	}
}

//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------