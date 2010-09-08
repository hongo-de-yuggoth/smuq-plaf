<?php
echo $html->css('menu_navegacion');
echo $html->css('vista');
echo $html->css('calendario');
echo $javascript->link('jquery-1.3.2.min');
echo $javascript->link('jquery.selectboxes.min');
echo $javascript->link('calendario');
echo $javascript->link('validaciones');
echo $javascript->link('solicitudes/crear_solicitud_apoyo_evento');
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
	<div id="titulo_pagina" align="center">Crear Solicitud de Apoyo a un Evento</div>
	<div id="cuadro_notificaciones" class="<?php echo $clase_notificacion; ?>" style="display: <?php echo $display_notificacion; ?>;">
		<?php echo $mensaje_notificacion; ?>
	</div>

	<div id="contenido_vista">
		<form id="solicitud_apoyo_evento" name="solicitud_apoyo_evento" action="/apoyo_evento_solicitudes/crear" method="post" >
			<input type="hidden" value="<?php echo $opcion_seleccionada; ?>" id="opcion_seleccionada"/>
			<input type="hidden" value="<?php echo $cencos_id_usuario; ?>" id="cencos_id_usuario" name="data[ApoyoEventoSolicitud][Cencos_id]" />
			<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
				<tr><td height="20" colspan="4"/></tr>
				<tr align="left">
					<td colspan='4'>
						<?php include('encabezados/apoyo_evento.php'); ?>
					</td>
				</tr>
				<tr><td height="20" colspan="4"/></tr>
				<tr align="left">
					<td class='subtitulo' width='120'>Fecha del evento:</td>
					<td colspan="3">
						<input id="fecha_evento" name='data[ApoyoEventoSolicitud][fecha_evento]' type="text" readonly value='' maxlength="10" size='9' />
						<input id='boton_cal_1' type="button" value="Seleccionar fecha" />
					</td>
				</tr>
				<tr align="left">
					<td width='120'></td>
					<td width="100" colspan="3" class="textoError"><div id="error_fecha" style="display:none;"></td>
				</tr>
				
				<tr><td height="10" colspan="4"/></tr>
				
				<tr align="left">
					<td class='subtitulo' >Oficina que solicita el apoyo:</td>
					<td colspan="3" valign="bottom"><?php echo $oficina; ?></td>
				</tr>
				<tr align="left">
					<td width='120'></td>
					<td width="100" colspan="3" class="textoError"><div id="error_proceso" style="display:none;"></td>
				</tr>
				
				<tr><td height="10" colspan="4"/></tr>
				
				<tr align="left">
					<td class='subtitulo' width='90'>Nombre del evento:</td>
					<td colspan="3"><input id="nombre" name='data[ApoyoEventoSolicitud][nombre]' type="text" value='' maxlength="150" size='50' /></td>
				</tr>
				<tr align="left">
					<td width='120'></td>
					<td width="100" colspan="3" class="textoError"><div id="error_nombre" style="display:none;"></td>
				</tr>
			
				<tr><td height="10" colspan="4"/></tr>
				
				<tr align="left">
					<td class='subtitulo' width='90'>Lugar del evento:</td>
					<td colspan="3"><input id="lugar" name='data[ApoyoEventoSolicitud][lugar]' type="text" value='' maxlength="80" size='50' /></td>
				</tr>
				<tr align="left">
					<td width='120'></td>
					<td width="100" colspan="3" class="textoError"><div id="error_lugar" style="display:none;"></td>
				</tr>
			
				<tr><td height="10" colspan="4"/></tr>
				
				<tr align="left">
					<td class='subtitulo' width='90'>Solicitante:</td>
					<td colspan="3"><input id="solicitante" name='data[ApoyoEventoSolicitud][solicitante]' type="text" value='' maxlength="50" size='50' /></td>
				</tr>
				<tr align="left">
					<td width='120'></td>
					<td width="100" colspan="3" class="textoError"><div id="error_solicitante" style="display:none;"></td>
				</tr>
				
				<tr><td height="10" colspan="4"/></tr>
				
				<tr align="left">
					<td class='subtitulo' width='90'>Correo electrónico del solicitante:</td>
					<td colspan="3" valign="bottom"><input id="email_solicitante" name='data[ApoyoEventoSolicitud][email_solicitante]' type="text" value='' maxlength="200" size='50' /></td>
				</tr>
				<tr align="left">
					<td width='120'></td>
					<td width="100" colspan="3" class="textoError"><div id="error_email_solicitante" style="display:none;"></td>
				</tr>
				
				<tr><td height="10" colspan="4"/></tr>
				<tr align="left">
					<td class='subtitulo' width='90'>No. de Asistentes al evento:</td>
					<td colspan="3" valign="bottom"><input id="num_asistentes" name='data[ApoyoEventoSolicitud][num_asistentes]' type="text" value='' maxlength="5" size='10' /></td>
				</tr>
				<tr align="left">
					<td width='120'></td>
					<td width="100" colspan="3" class="textoError"><div id="error_asistentes" style="display:none;"></td>
				</tr>
				
				<tr><td height="10" colspan="4"/></tr>
				<tr><td height="1" class="linea" colspan="4"/></tr>
				<tr><td height="10" colspan="4"/></tr>
				<tr><td colspan="4">Selecciona los insumos requeridos para la realización del evento:</td></tr>
				<tr><td height="10" colspan="4"/></tr>
				
				<tr align="left">
					<td class='subtitulo' width='50' valign="top">Insumos:</td>
					<td width="100"><input id='ins_agua' type="checkbox" name='data[insumos][]' value='1' /><label for='ins_agua'>Agua</label></td>
					<td colspan="2" width="110"><input id='ins_aromaticas' type="checkbox" name='data[insumos][]' value='2' /><label for='ins_aromaticas'>Aromaticas</label></td>
				</tr>
				<tr align="left">
					<td width='50'> </td>
					<td width="100"><input id='ins_azucar' type="checkbox" name='data[insumos][]' value='3' /><label for='ins_azucar'>Azucar</label></td>
					<td colspan="2" width="110"><input id='ins_cafe' type="checkbox" name='data[insumos][]' value='4' /><label for='ins_cafe'>Café</label></td>
				</tr>
				<tr align="left">
					<td width='50'> </td>
					<td colspan="3" width="100"><input id='ins_mescladores' type="checkbox" name='data[insumos][]' value='5' /><label for='ins_mescladores'>Mezcladores</label></td>
				</tr>
				<tr><td height="10" colspan="4"/></tr>
				<tr><td height="1" class="linea" colspan="4"/></tr>
				<tr><td height="10" colspan="4"/></tr>
				<tr align="left">
					<td class='subtitulo' width='50' valign="top">Observaciones:</td>
					<td colspan="3" width="210"><textarea id="observaciones" name="data[ApoyoEventoSolicitud][observaciones]" cols="50"></textarea></td>
				</tr>
				
				<tr><td height="15" colspan="4"/></tr>
				<tr align="left">
					<td width='100%' valign="top" align="center" colspan="4"><input type="submit" value="Enviar Solicitud"/></td>
				</tr>
				
				<tr><td height="25" colspan="4"/></tr>
				<tr align="left">
					<td width='100%' valign="top" align="left" colspan="4">
						<div class="div_solucion"><b>NOTA:</b> Se recomienda realizar este tipo de solicitudes con 5 días de anterioridad.</div>
					</td>
				</tr>
			</tbody></table>
		<?php echo $form->end(); ?>
	</div>
</div>
