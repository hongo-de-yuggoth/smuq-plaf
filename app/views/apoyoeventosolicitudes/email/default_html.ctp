<?php ?>
<table border="0" width="100%" cellspacing="0" cellpadding="2"><tbody>
	<tr align="left">
		<td>Estimado usuario, se le informa que la solicitud de apoyo al evento #<?php echo $solicitud['ApoyoEventoSolicitud']['id']; ?>
		ya ha sido recibida. A continuación se adjunta el formato de la solicitud de apoyo al evento.</td>
	</tr>

	<tr><td height="30"></td></tr>

	<tr align="left">
		<td><?php echo $encabezado_pdf; ?></td>
	</tr>

	<tr><td height="30"></td></tr>

	<tr align="left">
		<td width="*"><div>
			<table width="100%" cellspacing="0" cellpadding="5" border="1"><tbody>
				<tr align="left">
					<td width='160'><b>Solicitud No:</b></td>
					<td width="*" ><?php echo $solicitud['ApoyoEventoSolicitud']['id']; ?></td>
				</tr>
				<tr align="left">
					<td width='160'><b>Fecha de la solicitud:</b></td>
					<td width="*" ><?php echo $solicitud['ApoyoEventoSolicitud']['fecha_solicitud']; ?></td>
				</tr>
				<tr align="left">
					<td width='160'><b>Estado de la solicitud:</b></td>
					<td width="*" ><?php echo $solicitud['ApoyoEventoSolicitud']['estado']; ?></td>
				</tr>
				<tr align="left">
					<td ><b>Oficina que solicita el apoyo:</b></td>
					<td width="*" ><?php echo $solicitud['CentroCosto']['Cencos_nombre']; ?></td>
				</tr>
			</tbody></table>
		</div></td>
	</tr>

	<tr><td height="30"></td></tr>

	<tr align="left">
		<td width="*"><div>
			<table width="100%" cellspacing="0" cellpadding="5" border="1"><tbody>
				<tr align="left">
					<td width='160'><b>Nombre del evento:</b></td>
					<td width="*" ><?php echo $solicitud['ApoyoEventoSolicitud']['nombre']; ?></td>
				</tr>
				<tr align="left">
					<td width='160'><b>Fecha del evento:</b></td>
					<td width="*" ><?php echo $solicitud['ApoyoEventoSolicitud']['fecha_evento']; ?></td>
				</tr>
				<tr align="left">
					<td width='160'><b>Lugar del evento:</b></td>
					<td width="*" ><?php echo $solicitud['ApoyoEventoSolicitud']['lugar']; ?></td>
				</tr>
				<tr align="left">
					<td width='160'><b>Solicitante:</b></td>
					<td width="*" ><?php echo $solicitud['ApoyoEventoSolicitud']['solicitante']; ?></td>
				</tr>
				<tr align="left">
					<td width='160'><b>No. de Asistentes al evento:</b></td>
					<td width="*" ><?php echo $solicitud['ApoyoEventoSolicitud']['num_asistentes']; ?></td>
				</tr>
				<tr align="left">
					<td width='160' valign="top"><b>Insumos:</b></td>
					<td width="*" ><?php echo $insumos; ?></td>
				</tr>
				<tr align="left">
					<td width='160' valign="top"><b>Observaciones:</b></td>
					<td width="*" ><div class="div_solucion"><?php echo $solicitud['ApoyoEventoSolicitud']['observaciones']; ?></div></td>
				</tr>
			</tbody></table>
		</div></td>
	</tr>

	<tr><td height="30"></td></tr>

	<tr align="left">
		<td width="*"><div>
			<table width="100%" cellspacing="0" cellpadding="5" border="1"><tbody>
				<tr align="left"><td width="*" align="center" colspan="2"><b>Solución a la Solicitud</b></td></tr>
				<tr align="left">
					<td width="160" valign="top"><b>La solicitud fué:</b></td>
					<td width="*"><?php echo $solicitud['ApoyoEventoSolicitud']['ejecutada']; ?></td>
				</tr>
				<tr align="left">
					<td width="160" valign="top"><b>Observaciones a la solución:</b></td>
					<td width="*"><?php echo $solicitud['ApoyoEventoSolicitud']['observaciones_solucion']; ?></td>
				</tr>
			</tbody></table>
		</div></td>
	</tr>
</tbody></table>
