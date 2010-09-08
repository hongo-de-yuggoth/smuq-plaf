<table>
	<tr>
		<td colspan='6'><b>REPORTE DE SOLICITUDES DE APOYO A EVENTOS<b></td>
	</tr>
	<tr>
		<td><b>Fecha:</b></td>
		<td colspan='5'><?php echo date("F j, Y, g:i a"); ?></td>
	</tr>
	<tr>
		<td style="text-align:left"><b>Total de Registros:</b></td>
		<td align="left" colspan='5'><?php echo $total_registros; ?></td>
	</tr>
	<tr>
		<td colspan='6'></td>
	</tr>
	<tr id="titles">
		<td><b>Num. Solicitud</b></td>
		<td><b>Oficina</b></td>
		<td><b>Solicitante</b></td>
		<td><b>Correo Electr&oacute;nico Solicitante</b></td>
		<td><b>Nombre del Evento</b></td>
		<td><b>Lugar del Evento</b></td>
		<td><b>N&uacute;mero de Asistentes</b></td>
		<td><b>Insumos</b></td>
		<td><b>Observaciones</b></td>
		<td><b>Fecha Evento</b></td>
		<td><b>Fecha Solicitud</b></td>
		<td><b>Estado</b></td>
		<td><b>Fecha Archivaci&oacute;n</b></td>
		<td><b>Observaciones Soluci&oacute;n</b></td>
		<td><b>Ejecuci&oacute;n</b></td>
	</tr>
	<?php
		echo $filas_tabla;
	?>
</table>
