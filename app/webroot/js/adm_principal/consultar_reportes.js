function actualizar_param_anios()
{
	var valor_select = jQuery('#param_años').val();
	if ( valor_select == 'todos' )
	{
		jQuery('#div_rango_años_sae').hide();
		jQuery('#div_rango_años_sr').hide();
	}
	else if ( valor_select == 'rango' )
	{
		var select_reporte = jQuery('#select_reporte').val();
		if ( select_reporte == 'solicitudes_apoyo_eventos_por_años' )
		{
			jQuery('#div_rango_años_sr').hide();
			jQuery('#div_rango_años_sae').show();
		}
		else if ( select_reporte == 'solicitudes_reparacion_por_años' )
		{
			jQuery('#div_rango_años_sae').hide();
			jQuery('#div_rango_años_sr').show();
		}
	}
}

//--------------------------------------------------------------------------

function indexOf(array, s)
{
	for ( var x=0; x < array.length; x++ )
	{
		if ( array[x] == s )
			return x;
	}
	return false;
}

//-----------------------------------------------------------------------------

function construir_select_anio_final(anio_inicial, solicitud)
{
	var temp = jQuery('#listado_años_'+solicitud).val();
	var anios = temp.split(',');
	var html = '';
	for ( var i = indexOf(anios, anio_inicial); i < anios.length; i++ )
	{
		html += '<option value="'+anios[i]+'">'+anios[i]+'</option>';
	}
	jQuery('#año_final_'+solicitud).html(html);
}

//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------

jQuery(document).ready(function()
{
	jQuery('div.cuerpo_menu ul #'+jQuery('#opcion_seleccionada').val()).addClass('selected');
	construir_select_anio_final(jQuery('#año_inicial_sae').val(), 'sae');
	construir_select_anio_final(jQuery('#año_inicial_sr').val(), 'sr');
	
	//--------------------------------------------------------------------------
	// Programamos los diferentes EVENTOS.
	
	jQuery('#boton_cargar_reporte').click(function()
	{
		var parametro = '/';
		var reporte_seleccionado = jQuery('#select_reporte').val();
		
		if ( reporte_seleccionado == 'solicitudes_apoyo_eventos_por_años' )
		{
			var param_anios = jQuery('#param_años').val();
			parametro = parametro+param_anios;
			if ( param_anios == 'rango' )
			{
				parametro = parametro+'/'+jQuery('#año_inicial_sae').val()+'/'+jQuery('#año_final_sae').val();
			}
		}
		else if ( reporte_seleccionado == 'solicitudes_reparacion_por_años' )
		{
			var param_anios = jQuery('#param_años').val();
			parametro = parametro+param_anios;
			if ( param_anios == 'rango' )
			{
				parametro = parametro+'/'+jQuery('#año_inicial_sr').val()+'/'+jQuery('#año_final_sr').val();
			}
		}
		else if ( reporte_seleccionado == 'solicitudes_apoyo_eventos_por_meses' )
		{
			parametro = parametro+jQuery('#año_meses_sae').val();
		}
		else if ( reporte_seleccionado == 'solicitudes_reparacion_por_meses' )
		{
			parametro = parametro+jQuery('#año_meses_sr').val();
		}
		else if ( reporte_seleccionado == 'solicitudes_reparacion_por_operario' )
		{
			parametro = parametro+jQuery('#operarios').val()+'/'+jQuery('#año_meses_sr').val();
		}
		else if ( reporte_seleccionado == 'solicitudes_apoyo_eventos_por_oficina' )
		{
			parametro = parametro+jQuery('#oficina_sae').val()+'/'+jQuery('#año_meses_sae').val();
		}
		else if ( reporte_seleccionado == 'solicitudes_reparacion_por_oficina' )
		{
			parametro = parametro+jQuery('#oficina_sr').val()+'/'+jQuery('#año_meses_sr').val();
		}
		
		jQuery('#img_reporte').attr('src', '/smuqplaf/reportes_estadisticos/'+reporte_seleccionado+parametro);
		jQuery('#reporte').show();
	});
	//--------------------------------------------------------------------------
	jQuery('#select_reporte').change(function()
	{
		var reporte_seleccionado = jQuery(this).val();
		if ( reporte_seleccionado == 'solicitudes_apoyo_eventos_por_años' ||
				reporte_seleccionado == 'solicitudes_reparacion_por_años' )
		{
			jQuery('#div_servicios_oficina').hide();
			jQuery('#div_servicios_operario').hide();
			jQuery('#div_servicios_meses').hide();
			jQuery('#div_servicios_años').show();
			actualizar_param_anios()
		}
		else if ( reporte_seleccionado == 'solicitudes_apoyo_eventos_por_meses' ||
					reporte_seleccionado == 'solicitudes_reparacion_por_meses' )
		{
			jQuery('#div_servicios_oficina').hide();
			jQuery('#div_servicios_operario').hide();
			jQuery('#div_servicios_años').hide();
			jQuery('#div_servicios_meses').show();
			if ( reporte_seleccionado == 'solicitudes_apoyo_eventos_por_meses' )
			{
				jQuery('#div_meses_del_año_sr').hide();
				jQuery('#div_meses_del_año_sae').show();
			}
			else if ( reporte_seleccionado == 'solicitudes_reparacion_por_meses' )
			{
				jQuery('#div_meses_del_año_sae').hide();
				jQuery('#div_meses_del_año_sr').show();
			}
		}
		else if ( reporte_seleccionado == 'solicitudes_reparacion_por_operario' )
		{
			jQuery('#div_servicios_operario').show();
			jQuery('#div_servicios_oficina').hide();
			jQuery('#div_servicios_años').hide();
			jQuery('#div_servicios_meses').show();
			jQuery('#div_meses_del_año_sr').show();
			jQuery('#div_meses_del_año_sae').hide();
			
		}
		else if ( reporte_seleccionado == 'solicitudes_apoyo_eventos_por_oficina' ||
					reporte_seleccionado == 'solicitudes_reparacion_por_oficina' )
		{
			jQuery('#div_servicios_operario').hide();
			jQuery('#div_servicios_años').hide();
			jQuery('#div_servicios_meses').show();
			jQuery('#div_servicios_oficina').show();
			if ( reporte_seleccionado == 'solicitudes_apoyo_eventos_por_oficina' )
			{
				jQuery('#div_oficina_sr').hide();
				jQuery('#div_oficina_sae').show();
				jQuery('#div_meses_del_año_sae').show();
				jQuery('#div_meses_del_año_sr').hide();
			}
			else if ( reporte_seleccionado == 'solicitudes_reparacion_por_oficina' )
			{
				jQuery('#div_oficina_sae').hide();
				jQuery('#div_oficina_sr').show();
				jQuery('#div_meses_del_año_sr').show();
				jQuery('#div_meses_del_año_sae').hide();
			}
		}
	});
	//--------------------------------------------------------------------------
	jQuery('#param_años').change(actualizar_param_anios);
	//--------------------------------------------------------------------------
	jQuery('#año_inicial_sae').change(function()
	{
		construir_select_anio_final(jQuery(this).val(), 'sae');
	});
	//--------------------------------------------------------------------------
	jQuery('#año_inicial_sr').change(function()
	{
		construir_select_anio_final(jQuery(this).val(), 'sr');
	});
	//--------------------------------------------------------------------------
});
