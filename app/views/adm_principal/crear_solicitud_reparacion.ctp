<?php
echo $html->css('menu_navegacion');
echo $html->css('vista');
echo $javascript->link('jquery-1.3.2.min');
echo $javascript->link('validaciones');
echo $javascript->link('solicitudes/crear_solicitud_reparacion');
?>

<style type="text/css">
<!--
	.div_solucion{
		border: solid;
		border-width: 1px;
		padding: 5px;
	}
	
	.encabezado_formato{
		font-weight: bold;
		color: white;
	}
-->
</style>

<div id="menu_navegacion">
	<div class="cuerpo_menu">
		<ul>
			<?php echo $opciones_menu; ?>
		</ul>
	</div>
</div>

<div id="col_derecha">
	<div id="titulo_pagina" align="center">Crear Solicitud de Reparación</div>
	<div id="cuadro_notificaciones" class="<?php echo $clase_notificacion; ?>" style="display: <?php echo $display_notificacion; ?>;">
		<?php echo $mensaje_notificacion; ?>
	</div>
	<div id="contenido_vista">
		<form id="solicitud_reparacion" name="solicitud_reparacion" action="/reparacion_solicitudes/crear" method="post" >
			<input type="hidden" value="<?php echo $opcion_seleccionada; ?>" id="opcion_seleccionada"/>
			<input type="hidden" value="<?php echo $cencos_id_usuario; ?>" id="cencos_id_usuario" name="data[ReparacionSolicitud][Cencos_id]" />
			<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
				<tr><td height="20" colspan="4"/></tr>
				<tr align="left">
					<td colspan='4'>
						<?php include('encabezados/reparacion.php'); ?>
					</td>
				</tr>
				<tr><td height="20" colspan="4"/></tr>
				
				<tr align="left">
					<td class='subtitulo' width='90'>Fecha:</td>
					<td colspan="3"><?php echo $fecha_hoy; ?></td>
				</tr>
				
				<tr><td height="10" colspan="4"/></tr>
				
				<tr align="left">
					<td class='subtitulo' >Oficina que solicita el servicio:</td>
					<td colspan="3" valign="bottom"><div id="proceso"><?php echo $oficina; ?></div></td>
				</tr>
				
				<tr><td height="10" colspan="4"/></tr>
				
				<tr align="left">
					<td class='subtitulo' width='90'>Lugar:</td>
					<td colspan="3"><input id="lugar" name='data[ReparacionSolicitud][lugar]' type="text" value='' maxlength="80" size='50' /></td>
				</tr>
				<tr align="left">
					<td width='120'></td>
					<td width="100" colspan="3" class="textoError"><div id="error_lugar" style="display:none;"></td>
				</tr>
			
				<tr><td height="10" colspan="4"/></tr>
				
				<tr align="left">
					<td class='subtitulo' width='90'>Solicitante:</td>
					<td colspan="3"><input id="solicitante" name='data[ReparacionSolicitud][solicitante]' type="text" value='' maxlength="50" size='50' /></td>
				</tr>
				<tr align="left">
					<td width='120'></td>
					<td width="100" colspan="3" class="textoError"><div id="error_solicitante" style="display:none;"></td>
				</tr>
				
				<tr><td height="10" colspan="4"/></tr>
				
				<tr align="left">
					<td class='subtitulo' width='90'>Correo electrónico del solicitante:</td>
					<td colspan="3" valign="bottom"><input id="email_solicitante" name='data[ReparacionSolicitud][email_solicitante]' type="text" value='' maxlength="200" size='50' /></td>
				</tr>
				<tr align="left">
					<td width='120'></td>
					<td width="100" colspan="3" class="textoError"><div id="error_email_solicitante" style="display:none;"></td>
				</tr>
				
				<tr><td height="10" colspan="4"/></tr>
				<tr><td height="1" class="linea" colspan="4"/></tr>
				<tr><td height="10" colspan="4"/></tr>
				<tr><td colspan="4">Descripción del servicio:</td></tr>
				<tr><td height="10" colspan="4"/></tr>
				<tr align="left">
					<td class='subtitulo' width='50' valign="top">Tipo de servicio:</td>
					<td colspan="3" width="210"><select id='select_tipo_servicio' name='data[ReparacionSolicitud][tipo_servicio]'><?php echo $tipos_servicio; ?></select></td>
				</tr>
				<tr><td height="10" colspan="4"/></tr>
				
				<tr align="left">
					<td class='subtitulo' width='50' valign="top">Descripcion:</td>
					<td colspan="3" width="210"><textarea id="descripcion" name="data[ReparacionSolicitud][descripcion]" cols="50"></textarea></td>
				</tr>
				<tr align="left">
					<td width='120'></td>
					<td width="100" colspan="3" class="textoError"><div id="error_descripcion" style="display:none;"></td>
				</tr>
				<tr><td height="10" colspan="4"/></tr>
				<tr align="left">
					<td class='subtitulo' width='50' valign="top">Observaciones:</td>
					<td colspan="3" width="210"><textarea id="observaciones" name="data[ReparacionSolicitud][observaciones]" cols="50"></textarea></td>
				</tr>
				
				<tr><td height="15" colspan="4"/></tr>
				
				<tr align="left">
					<td width='100%' valign="top" align="center" colspan="4"><input type="submit" value="Enviar Solicitud"/></td>
				</tr>
				
				<tr><td height="25" colspan="4"/></tr>
				<tr align="left">
					<td width='100%' valign="top" align="left" colspan="4">
						<div class="div_solucion"><b>NOTA:</b> La solicitud se atenderá en la menor brevedad posible, de acuerdo a la prioridad de la reparación.</div>
					</td>
				</tr>
			</tbody></table>
		<?php echo $form->end(); ?>
	</div>
</div>
