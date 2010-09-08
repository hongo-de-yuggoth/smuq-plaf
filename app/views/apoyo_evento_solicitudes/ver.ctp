<?php
echo $html->css('menu_navegacion');
echo $html->css('vista');
echo $javascript->link('jquery-1.3.2.min');
echo $javascript->link('apoyo_evento_solicitudes/ver');
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
	<div id="titulo_pagina" align="center">Consulta de Solicitudes de Apoyo a Eventos</div>
	<div id="subtitulo_pagina" align="center"><br><br>Solicitud de Apoyo a Eventos #<?php echo $solicitud['ApoyoEventoSolicitud']['id']; ?></div>
	<div id="cuadro_notificaciones" class="<?php echo $clase_notificacion; ?>" style="display: <?php echo $display_notificacion; ?>;">
		<?php echo $mensaje_notificacion; ?>
	</div>
	<div id="contenido_vista" style='margin-top:15px;'>
		<form id="solucion" name="solucion" action="#" method="post" enctype="multipart/form-data" >
			<input id='id_solicitud' type='hidden' value='<?php echo $solicitud['ApoyoEventoSolicitud']['id']; ?>' />
			<input id='observaciones_solucion_apoyo' type='hidden' value='<?php echo $solicitud['ApoyoEventoSolicitud']['observaciones_solucion']; ?>' />
			<input type="hidden" value="<?php echo $opcion_seleccionada; ?>" id="opcion_seleccionada" />
			
			<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
				<tr align="left">
					<td colspan="4" width="100%" align="right"><div id='link_pdf' style='display:block;'><a href='/apoyo_evento_solicitudes/exportar_pdf/<?php echo $solicitud['ApoyoEventoSolicitud']['id']; ?>'><?php echo $html->image('pdf.gif', array('border'=>0, 'alt'=>'Exportar a PDF', 'title'=>'Exportar a PDF')); ?></a></div></td>
				</tr>
				<tr><td height="20" colspan="4"/></tr>
				<tr align="left">
					<td colspan='4'>
						<?php include('encabezados/apoyo_evento.php'); ?>
					</td>
				</tr>
				<tr><td height="20" colspan="4"/></tr>
				<tr align="left">
					<td class='subtitulo' width='110'>Solicitud No:</td>
					<td colspan="3"><?php echo $solicitud['ApoyoEventoSolicitud']['id']; ?></td>
				</tr>
				
				<tr><td height="10" colspan="4"/></tr>
				<tr align="left">
					<td class='subtitulo' width='100'>Fecha de la solicitud:</td>
					<td colspan="3"><?php echo $solicitud['ApoyoEventoSolicitud']['fecha_solicitud']; ?></td>
				</tr>
				
				<tr><td height="10" colspan="4"/></tr>
				<tr align="left">
					<td class='subtitulo' width='100'>Estado de la solicitud:</td>
					<td colspan="3"><div id='estado' style='display:none;'><?php echo $solicitud['ApoyoEventoSolicitud']['estado']; ?></div></td>
				</tr>
				
				<tr><td height="10" colspan="4"/></tr>
				<tr align="left">
					<td class='subtitulo'>Fecha del evento:</td>
					<td colspan="3"><?php echo $solicitud['ApoyoEventoSolicitud']['fecha_evento']; ?></td>
				</tr>
				
				<tr><td height="10" colspan="4"/></tr>
				
				<tr align="left">
					<td class='subtitulo' >Oficina que solicita el apoyo:</td>
					<td colspan="3" valign="bottom"><?php echo $solicitud['CentroCosto']['Cencos_nombre']; ?></td>
				</tr>
				
				<tr><td height="10" colspan="4"/></tr>
				
				<tr align="left">
					<td class='subtitulo' width='90'>Nombre del evento:</td>
					<td colspan="3"><?php echo $solicitud['ApoyoEventoSolicitud']['nombre']; ?></td>
				</tr>
				
				<tr><td height="10" colspan="4"/></tr>
				
				<tr align="left">
					<td class='subtitulo' width='90'>Lugar del evento:</td>
					<td colspan="3"><?php echo $solicitud['ApoyoEventoSolicitud']['lugar']; ?></td>
				</tr>
				
				<tr><td height="10" colspan="4"/></tr>
				
				<tr align="left">
					<td class='subtitulo' width='90'>Solicitante:</td>
					<td colspan="3"><?php echo $solicitud['ApoyoEventoSolicitud']['solicitante']; ?></td>
				</tr>
				
				<tr><td height="10" colspan="4"/></tr>
				
				<tr align="left">
					<td class='subtitulo' width='90'>No. de Asistentes<br> al evento:</td>
					<td colspan="3"><?php echo $solicitud['ApoyoEventoSolicitud']['num_asistentes']; ?></td>
				</tr>
				
				<tr><td height="10" colspan="4"/></tr>
				
				<tr align="left">
					<td class='subtitulo' width='50' valign="top">Insumos:</td>
					<td colspan="3" width="210"><?php echo $insumos; ?></td>
				</tr>
				<tr><td height="10" colspan="4"/></tr>
				<tr align="left">
					<td class='subtitulo' width='50' valign="top">Observaciones:</td>
					<td colspan="3" width="210"><div class="div_solucion"><?php echo $solicitud['ApoyoEventoSolicitud']['observaciones']; ?></div></td>
				</tr>
				<tr><td height="20" colspan="4"/></tr>
				<tr><td height="1" class="linea" colspan="4"/></tr>
				<tr><td height="10" colspan="4"/></tr>
				<tr align="left">
					<td width='100%' valign="top" align="center" colspan="4"><div align="center" id="subtitulo_pagina">Solución a la Solicitud</div></td>
				</tr>
				
				<tr align="left">
					<td class='subtitulo' width='50' valign="top">La solicitud fué:</td>
					<td colspan="3" width="210">
						<div id="select_ejecutada" style="display:<?php echo $display_select_ejecutada; ?>;"><select id="ejecutada" name="data[ApoyoEventoSolicitud][ejecutada]">
							<option value="1">Ejecutada</option>
							<option value="0">No ejecutada</option>
						</select></div>
						<div id="div_ejecutada" style="display:<?php echo $display_div_ejecutada; ?>;"><?php echo $ejecutada; ?></div>
					</td>
				</tr>
				
				<tr><td height="10" colspan="4"/></tr>
				<tr align="left">
					<td class='subtitulo' width='50' valign="top">Observaciones a la solución:</td>
					<td colspan="3" width="210">
						<div id='div_observaciones_solucion' class="div_solucion"></div>
						<div id='div_observaciones_solucion_input' style='display:none;'><textarea id="observaciones_solucion" cols="50" ></textarea></div>
					</td>
				</tr>
	
				<tr><td height="20" colspan="4"/></tr>
				
				<tr align="left">
					<td width='100%' valign="top" align="center" colspan="4"><div id='div_archivar' align="center" style="display:<?php echo $display_archivar; ?>;"><input id="boton_archivar" type="button" value="Archivar Solicitud"/></div></td>
				</tr>
			</tbody></table>
		</form>
	</div>
</div>
