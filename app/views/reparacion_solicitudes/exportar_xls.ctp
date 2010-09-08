<table>
	<tr>
		<td colspan='6'><b>REPORTE DE SOLICITUDES DE REPARACIONES<b></td>
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
		<td><b>Correo Electrónico Solicitante</b></td>
		<td><b>Lugar</b></td>
		<td><b>Tipo de Servicio</b></td>
		<td><b>Descripci&oacute;n</b></td>
		<td><b>Observaciones</b></td>
		<td><b>Encargado del Servicio</b></td>
		<td><b>Tiempo Estimado<br>(Horas)</b></td>
		<td><b>Observaciones Solución</b></td>
		<td><b>Fecha Solicitud</b></td>
		<td><b>Fecha Archivación</b></td>
		<td><b>Ejecución</b></td>
		<td><b>Estado</b></td>
	</tr>
	<?php
		echo $filas_tabla;
	?>
</table>
