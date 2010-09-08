//-----------------------------------------------------------------------------

function limpiar()
{
	$('#equipo_confirmado').val('');
	$('#placa_equ').html('');
	$('#nombre_equ').html('');
	$('#modelo_equ').html('');
	$('#marca_equ').html('');
}

//-----------------------------------------------------------------------------

$(document).ready(function()
{
	// Configuración inicial
	var mp = 'Deficion Mantenimiento Preventivo';
	var mc = 'Deficion Mantenimiento Correctivo';
	var cc = 'Deficion Calibracion/Certificacion';
	
	// Cargamos dependencias iniciales según Edificio seleccionado por defecto.
	cargar_dependencias();
	
	$('#mp').attr('checked', 'true');
	$('#definicion').html(mp);
	
	if ( $('#cuadro_notificaciones').not(':hidden') )
	{
		$('#cuadro_notificaciones').hide().slideDown('slow');
		$('#cuadro_notificaciones').fadeTo(10000, 0.9).fadeOut(7000);
	}
	
	//--------------------------------------------------------------------------
	// Programamos los diferentes EVENTOS.
	$('#id_edificio').change(function()
	{
		cargar_dependencias();
		limpiar();
		
	});
	$('#id_dependencia').change(function()
	{
		cargar_usuarios();
		limpiar();
   });
	$('#id_usuario').change(function()
	{
		cargo();
		limpiar();
		$('#escondidos').html('<input id="encontro" type="hidden" value="false" /> <input id="equipo_confirmado" name="data[Solicitud][placa_inventario]" type="hidden" value="" />');
		$('#error_placa').html('').hide();
   });
	
	// Configuramos tipo de servicio
	$('#mp').change(function()
	{
		if ( $('#mp').attr('checked') )
		{
			$('#definicion').html(mp);
		}
	});
	
	$('#mc').change(function()
	{
		if ( $('#mc').attr('checked') )
		{
			$('#definicion').html(mc);
		}
	});
	
	$('#cc').change(function()
	{
		if ( $('#cc').attr('checked') )
		{
			$('#definicion').html(cc);
		}
	});
	
	
	// Configuramos el boton para buscar equipos.
	$('#boton_buscar_equipo').click(function()
	{
		// Validamos la casilla de Placa de Inventario.
		if ( $('#placa_inventario_1').val() == '' || $('#placa_inventario_2').val() == '' )
		{
			// Activamos mensaje de error.
			$('#error_placa').html('Escribe una placa de inventario por favor.').css('display', 'block');
		}
		else
		{
			// Eliminamos espacios blancos en los campos del formulario a enviar
			$('#placa_inventario_1').val(jQuery.trim($('#placa_inventario_1').val()));
			$('#placa_inventario_2').val(jQuery.trim($('#placa_inventario_2').val()));
			$('#escondidos').load(
				'/smuqlab/equipos/buscar_equipo_ajax/' + $('#placa_inventario_1').val()+ '-' + $('#placa_inventario_2').val() + '/' + $('#id_usuario').val(),
				function()
				{
					// Si Encontró el equipo
					if ( $('#encontro').val() == 'true' )
					{
						// Leemos datos de inputs hidden y ponemos info en las casillas.
						$('#nombre_equ').html($('#nombre_equipo').val());
						$('#marca_equ').html($('#marca_equipo').val());
						$('#modelo_equ').html($('#modelo_equipo').val());
						$('#placa_equ').html($('#equipo_confirmado').val());
						$('#error_placa').html('Placa de inventario encontrada.').css('display', 'block');
					}
					else if ( $('#encontro').val() == 'false' )
					{
						// Blanqueamos las casillas
						limpiar();
						$('#error_placa').html('Este usuario no tiene asignado un equipo con esa placa de inventario.').css('display', 'block');
					}
				}
			);
		}
	});
	
	$('#solicitud_mantenimiento').submit(function()
	{
		$ec = true;
		$desc = true;
		
		$('#descripcion').val(jQuery.trim($('#descripcion').val()));
		$('#observaciones').val(jQuery.trim($('#observaciones').val()));
		
		// Debemos revisar que haya un equipo confirmado, osea que se halla hecho la busqueda de algun equipo
		// y que lo haya encontrado. Este se almacena en el Hidden Input "equiop_confirmado".
		if ( $('#equipo_confirmado').val() == '' )
		{
			$('#error_placa').html('Debes buscar el equipo que requiere el servicio.').show();
			$ec = false;
		}
		else
		{
			$('#error_placa').html('').hide();
		}
		
		if ( $('#descripcion').val() == '' )
		{
			$('#error_descripcion').html('Debes proporcionar una descripción del servicio solicitado.').show();
			$desc = false;
		}
		else
		{
			$('#error_descripcion').html('').hide();
		}
		
		if ( $ec==true && $desc==true )
		{
			return true;
		}
		else
		{
			return false;
		}
	});
});
