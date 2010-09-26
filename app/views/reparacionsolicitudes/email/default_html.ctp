<?php ?>
<table border="0" width="100%" cellspacing="0" cellpadding="2"><tbody>
	<tr align="left">
		<td>Estimado usuario, se le informa que la solicitud de reparación #<?php echo $solicitud['ReparacionSolicitud']['id']; ?>
		ya ha sido recibida. A continuación se adjunta el formato de la solicitud de reparación.</td>
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
					<td width='170'><b>Número de solicitud:</b></td>
					<td width="*"><?php echo $solicitud['ReparacionSolicitud']['id']; ?></td>
				</tr>
				<tr align="left">
					<td width='170'><b>Fecha de la solicitud:</b></td>
					<td width="*"><?php echo $solicitud['ReparacionSolicitud']['fecha_solicitud']; ?></td>
				</tr>
				<tr align="left">
					<td width='170'><b>Estado de la solicitud:</b></td>
					<td width="*"><?php echo $solicitud['ReparacionSolicitud']['estado']; ?></td>
				</tr>
				<tr align="left">
					<td width="170"><b>Oficina que solicita el servicio:</b></td>
					<td width="*"><?php echo $solicitud['CentroCosto']['Cencos_nombre']; ?></td>
				</tr>
			</tbody></table>
		</div></td>
	</tr>

	<tr><td height="30"></td></tr>

	<tr align="left">
		<td width="*"><div>
			<table width="100%" cellspacing="0" cellpadding="5" border="1"><tbody>
				<tr align="left">
					<td width='120'><b>Lugar:</b></td>
					<td width="*"><?php echo $solicitud['ReparacionSolicitud']['lugar']; ?></td>
				</tr>
				<tr align="left">
					<td width='120'><b>Solicitante:</b></td>
					<td width="*"><?php echo $solicitud['ReparacionSolicitud']['solicitante']; ?></td>
				</tr>
				<tr align="left">
					<td width='120'><b>Tipo de servicio:</b></td>
					<td width="*"><?php echo $solicitud['TipoServicio']['name']; ?></td>
				</tr>
				<tr align="left">
					<td width='120' valign="top"><b>Descripción:</b></td>
					<td width="*"><?php echo $solicitud['ReparacionSolicitud']['descripcion']; ?></td>
				</tr>
				<tr align="left">
					<td width='120' valign="top"><b>Observaciones:</b></td>
					<td width="*"><?php echo $solicitud['ReparacionSolicitud']['observaciones']; ?></td>
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
					<td width="230" valign="top"><b>La solicitud fué:</b></td>
					<td width="*"><?php echo $solicitud['ReparacionSolicitud']['ejecutada']; ?></td>
				</tr>
				<tr align="left">
					<td width="230" valign="top"><b>Funcionario que realizó el servicio:</b></td>
					<td width="*"><?php echo $solicitud['Funcionario']['nombre']; ?></td>
				</tr>
				<tr align="left">
					<td width="230" valign="top"><b>Tiempo estimado en la reparación:</b></td>
					<td width="*"><?php echo $solicitud['ReparacionSolicitud']['tiempo_estimado'].' hora(s)'; ?></td>
				</tr>
				<tr align="left">
					<td width="230" valign="top"><b>Observaciones a la solución:</b></td>
					<td width="*"><?php echo $solicitud['ReparacionSolicitud']['observaciones_solucion']; ?></td>
				</tr>
			</tbody></table>
		</div></td>
	</tr>
</tbody></table>
