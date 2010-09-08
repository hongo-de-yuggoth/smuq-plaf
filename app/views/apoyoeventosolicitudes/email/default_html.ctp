<?php  ?>
<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
	<tr align="left">
		<td colspan='4'>
			<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
				<tr align="left">
					<td></td>
					<td colspan='3' align='right' style='font-size:13px; font-weight:bold;'>UNIVERSIDAD DEL QUINDIO<BR>SISTEMA INTEGRADO DE GESTIÓN</td>
				</tr>
				<tr align="right">
					<td></td>
					<td><b>Código:</b> A.AC-01.00.03.F.01</td>
					<td><b>Versión:</b> 3</td>
					<td><b>Fecha:</b> 2010/5/12</td>
				</tr>
			</tbody></table>
		</td>
	</tr>
	<tr><td height="20" colspan="4"/></tr>
	<tr align="left">
		<td width='240'><b>Número de solicitud:</b></td>
		<td colspan="3"><?php echo $solicitud['ApoyoEventoSolicitud']['id']; ?></td>
	</tr>
	
	<tr><td height="10" colspan="4"/></tr>
	<tr align="left">
		<td width='240'><b>Fecha de la solicitud:</b></td>
		<td colspan="3"><?php echo $solicitud['ApoyoEventoSolicitud']['fecha_solicitud']; ?></td>
	</tr>
	<tr><td height="10" colspan="4"/></tr>
	<tr align="left">
		<td ><b>Oficina que solicita el apoyo:</b></td>
		<td colspan="3"><?php echo $solicitud['ApoyoEventoSolicitud']['proceso']; ?></td>
	</tr>
	
	<tr><td height="10" colspan="4"/></tr>
	<tr align="left">
		<td><b>Nombre del evento:</b></td>
		<td colspan="3"><?php echo $solicitud['ApoyoEventoSolicitud']['nombre']; ?></td>
	</tr>

	<tr><td height="10" colspan="4"/></tr>
	<tr align="left">
		<td><b>Fecha del evento:</b></td>
		<td colspan="3"><?php echo $solicitud['ApoyoEventoSolicitud']['fecha_evento']; ?></td>
	</tr>
	
	<tr><td height="10" colspan="4"/></tr>
	
	<tr align="left">
		<td width='90'><b>Lugar del evento:</b></td>
		<td colspan="3"><?php echo $solicitud['ApoyoEventoSolicitud']['lugar']; ?></td>
	</tr>
	
	<tr><td height="10" colspan="4"/></tr>
	
	<tr align="left">
		<td width='90'><b>Solicitante:</b></td>
		<td colspan="3"><?php echo $solicitud['ApoyoEventoSolicitud']['solicitante']; ?></td>
	</tr>
	
	<tr><td height="10" colspan="4"/></tr>
	
	<tr align="left">
		<td width='90'><b>No. de Asistentes al evento:</b></td>
		<td colspan="3"><?php echo $solicitud['ApoyoEventoSolicitud']['num_asistentes']; ?></td>
	</tr>
	
	<tr><td height="10" colspan="4"/></tr>
	
	<tr align="left">
		<td width='50' valign="top"><b>Insumos:</b></td>
		<td colspan="3" width="210"><?php echo $insumos; ?></td>
	</tr>
	<tr><td height="10" colspan="4"/></tr>
	<tr><td height="1" class="linea" colspan="4"/></tr>
	<tr><td height="10" colspan="4"/></tr>
	<tr align="left">
		<td width='50' valign="top"><b>Observaciones:</b></td>
		<td colspan="3" width="210"><div class="div_solucion"><?php echo $solicitud['ApoyoEventoSolicitud']['observaciones']; ?></div></td>
	</tr>
</tbody></table>
