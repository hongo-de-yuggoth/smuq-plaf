//--------------------------------------------------------------------------

function actualizar_estado(id_funcionario)
{
	if ( estado_funcionario(id_funcionario) == 1 )
	{
		// Estado set -> Activo
		$('#select_estado option[value=0]').removeAttr('selected');
		$('#select_estado option[value=1]').attr('selected', 'selected');
	}
	else
	{
		// Estado set -> InActivo
		$('#select_estado option[value=1]').removeAttr('selected');
		$('#select_estado option[value=0]').attr('selected', 'selected');
	}
}

//-----------------------------------------------------------------------------

function estado_funcionario(id_funcionario)
{
	var resultado;
	$.ajax(
	{
		type: "POST",
		url: '/funcionarios/estado_actual/'+id_funcionario,
		dataType: 'json',
		cache: false,
		async: false,
		success: function(json)
		{
			if ( json.resultado == true )
			{
				resultado = json.activo;
			}
			else
			{
				resultado = -1;
			}
		}
	});
	return resultado;
}

//--------------------------------------------------------------------------

function cargar_funcionarios()
{
	$.ajax(
	{
		type: "POST",
		url: '/funcionarios/cargar_select/',
		dataType: 'json',
		cache: false,
		async: false,
		success: function(json)
		{
			$('#id_funcionario_modificar').html(json.opciones);
			$('#id_funcionario_eliminar').html(json.opciones);
			var id_funcionario = $('#id_funcionario_modificar').val();
			$('#nombre_funcionario_modificar').val($('#id_funcionario_modificar option[value='+id_funcionario+']').html());
			if ( json.resultado == true )
			{
				jQuery('#nombre_funcionario_modificar').removeAttr('disabled');
				jQuery('#boton_modificar_funcionario').removeAttr('disabled');
				jQuery('#select_estado').removeAttr('disabled');
				jQuery('#id_funcionario_eliminar').removeAttr('disabled');
				jQuery('#boton_eliminar_funcionario').removeAttr('disabled');
				actualizar_estado(id_funcionario);
			}
			else
			{
				jQuery('#nombre_funcionario_modificar').attr('disabled', 'disabled');
				jQuery('#boton_modificar_funcionario').attr('disabled', 'disabled');
				jQuery('#select_estado').attr('disabled', 'disabled');
				jQuery('#id_funcionario_eliminar').attr('disabled', 'disabled');
				jQuery('#boton_eliminar_funcionario').attr('disabled', 'disabled');
			}
		}
	});
}

//--------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------

$(document).ready(function()
{
	jQuery('div.cuerpo_menu ul #'+jQuery('#opcion_seleccionada').val()).addClass('selected');
	cargar_funcionarios();
	jQuery('#temp_estado').val(jQuery('#select_estado').val());
	$('#nombre_funcionario_modificar').val($('#id_funcionario_modificar option[value='+$('#id_funcionario_modificar').val()+']').html());
	
	//--------------------------------------------------------------------------
	// Programamos los diferentes EVENTOS.
	
	$('#boton_crear_funcionario').click(function()
	{
		if ( $('#nombre_funcionario_crear').val() == '' )
		{
			// Activamos mensaje de error.
			$('#error_funcionario_crear').html('Escribe un nombre por favor.').show();
		}
		else
		{
			$('#nombre_funcionario_crear').val(jQuery.trim($('#nombre_funcionario_crear').val()));
			$.ajax(
			{
				type: "POST",
				url: '/funcionarios/existe_funcionario/' + $('#nombre_funcionario_crear').val(),
				dataType: 'json',
				cache: false,
				async: false,
				success: function(json)
				{
					if ( json.resultado == false )
					{
						// Si no existe -> creamos el funcionario.
						$.ajax(
						{
							type: "POST",
							url: '/funcionarios/crear/' + $('#nombre_funcionario_crear').val(),
							dataType: 'json',
							cache: false,
							async: false,
							success: function(d_json)
							{
								if ( d_json.resultado == true )
								{
									$('#error_funcionario_crear').html('El funcionario fué creado.').show();
									$('#nombre_funcionario_crear').val('');
									
									// se recarga los selects de funcionario.
									cargar_funcionarios();
								}
								else
								{
									$('#error_funcionario_crear').html('El funcionario no pudo ser creado.').show();
								}
								
								$('#error_funcionario_modificar').html('').hide();
								$('#error_funcionario_eliminar').html('').hide();
							}
						});
					}
					else if ( json.resultado == true )
					{
						$('#error_funcionario_crear').html('Este funcionario ya existe.').show();
					}
				}
			});
		}
	});
	
	//--------------------------------------------------------------------------
	
	$('#id_funcionario_modificar').change(function ()
	{
		var id_funcionario = $('#id_funcionario_modificar').val();
		$('#nombre_funcionario_modificar').val($('#id_funcionario_modificar option[value='+id_funcionario+']').html());
		$('#error_funcionario_modificar').html('').hide();
		actualizar_estado(id_funcionario);
		jQuery('#temp_estado').val(jQuery('#select_estado').val());
	});
	
	//--------------------------------------------------------------------------
	
	$('#boton_modificar_funcionario').click(function()
	{
		if ( $('#nombre_funcionario_modificar').val() == '' )
		{
			$('#error_funcionario_modificar').html('Escribe un nombre por favor.').show();
		}
		else
		{
			// Definimos 'nuevo_nombre'.
			var nuevo_nombre = 0;
			if ( $('#nombre_funcionario_modificar').val() != $('#id_funcionario_modificar option[value='+$('#id_funcionario_modificar').val()+']').html() )
			{
				$('#nombre_funcionario_modificar').val(jQuery.trim($('#nombre_funcionario_modificar').val()));
				
				// Si se cambió el nombre...
				// Verificamos que el nuevo no exista ya...
				$.ajax(
				{
					type: "POST",
					url: '/funcionarios/existe_funcionario/'+$('#nombre_funcionario_modificar').val(),
					dataType: 'json',
					cache: false,
					async: false,
					success: function(json)
					{
						if ( json.resultado == false )
						{
							nuevo_nombre = $('#nombre_funcionario_modificar').val();
						}
						else if ( json.resultado == true )
						{
							$('#error_funcionario_modificar').html('Este funcionario ya existe, elige otro nombre.').show();
						}
					}
				});
			}
			
			// Definimos 'nuevo_estado'.
			var cambio_estado = false;
			if ( jQuery('#temp_estado').val() != jQuery('#select_estado').val() )
			{
				cambio_estado = true;
			}
			var nuevo_estado = jQuery('#select_estado').val();
			
			if ( nuevo_nombre != 0 || cambio_estado == true )
			{
				$.ajax(
				{
					type: "POST",
					url: '/funcionarios/modificar/'+$('#id_funcionario_modificar').val()+'/'+nuevo_nombre+'/'+nuevo_estado+'/',
					dataType: 'json',
					cache: false,
					async: false,
					success: function(d_json)
					{
						if ( d_json.resultado == true )
						{
							$('#error_funcionario_modificar').html('El funcionario fué modificado.').show();
							//$('#nombre_funcionario_modificar').val('');
							
							// se recarga los selects de funcionario.
							cargar_funcionarios();
							$('#nombre_funcionario_modificar').val($('#id_funcionario_modificar option[value='+$('#id_funcionario_modificar').val()+']').html());
						}
						else if (  d_json.resultado == false )
						{
							$('#error_funcionario_modificar').html('El funcionario no pudo ser modificado.').show();
						}
						
						$('#error_funcionario_crear').html('').hide();
						$('#error_funcionario_eliminar').html('').hide();
					}
				});
			}
		}
	});

	//--------------------------------------------------------------------------
	
	$('#boton_eliminar_funcionario').click(function()
	{
		if ( confirm('¿Realmente desea eliminar este funcionario?') )
		{
			$.ajax(
			{
				type: "POST",
				url: '/funcionarios/eliminar/'+$('#id_funcionario_eliminar').val(),
				dataType: 'json',
				cache: false,
				async: false,
				success: function(json)
				{
					if ( json.resultado == true )
					{
						$('#error_funcionario_eliminar').html('Se ha eliminado el funcionario.').show();
						cargar_funcionarios();
					}
					else if ( json.resultado == false )
					{
						$('#error_funcionario_eliminar').html('No se pudo eliminar este funcionario.').show();
					}
					$('#error_funcionario_crear').html('').hide();
					$('#error_funcionario_modificar').html('').hide();
				}
			});
		}
	});
});
