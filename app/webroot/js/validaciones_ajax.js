//-----------------------------------------------------------------------------

function existe_login(login)
{
	$.ajax(
	{
		type: "POST",
		url: '/smuqplaf/usuarios/existe_login/' + login,
		dataType: 'text',
		cache: false,
		async: false,
		success: function(resultado)
		{
			if ( resultado == 'false' )
			{
				res = false;
			}
			else if ( resultado == 'true' )
			{
				res = true;
			}
		}
	});
	
	return res;
}

//-----------------------------------------------------------------------------
