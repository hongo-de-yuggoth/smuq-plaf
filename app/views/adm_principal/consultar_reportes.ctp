<?php
echo $html->css('menu_navegacion');
echo $html->css('vista');
echo $javascript->link('jquery-1.3.2.min');
echo $javascript->link('adm_principal/consultar_reportes');
?>

<div id="menu_navegacion">
	<div class="cuerpo_menu">
		<ul>
			<?php echo $opciones_menu; ?>
		</ul>
	</div>
</div>

<div id="col_derecha">
	<div id="titulo_pagina" align="center">Consulta de Reportes</div>
	<div id='subtitulo_pagina'></div>
	<div id="contenido_vista">
		<form id="solicitudes" name="solicitudes" action="#" method="post" >
			<input type="hidden" value="<?php echo $opcion_seleccionada; ?>" id="opcion_seleccionada"/>
			<input type="hidden" value="<?php echo $listado_años_sae; ?>" id="listado_años_sae"/>
			<input type="hidden" value="<?php echo $listado_años_sr; ?>" id="listado_años_sr"/>
			<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
				<tr align="left">
					<td>
						<div id='menu_consulta'>
							<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
								<tr align="left" >
									<td height='25' valign='top' colspan='6'>Selecciona un reporte:</td>
								</tr>
								<tr align="left" >
									<td width='22'>
										<select id="select_reporte">
											<option value="solicitudes_apoyo_eventos_por_años">Solicitudes de apoyo a eventos por años</option>
											<option value="solicitudes_apoyo_eventos_por_meses">Solicitudes de apoyo a eventos por meses</option>
											<option value="solicitudes_apoyo_eventos_por_oficina">Solicitudes de apoyo a eventos por oficina</option>
											<option value="solicitudes_reparacion_por_años">Solicitudes de reparacion por años</option>
											<option value="solicitudes_reparacion_por_meses">Solicitudes de reparacion por meses</option>
											<option value="solicitudes_reparacion_por_oficina">Solicitudes de reparacion por oficina</option>
											<option value="solicitudes_reparacion_por_operario">Solicitudes de reparacion por operario</option>
										</select>
									</td>
									<td>
										<div id='div_boton_cargar' align='center'>
											<input id='boton_cargar_reporte' type='button' value='Cargar Reporte' />
										</div>
									</td>
								</tr>
								<tr align="left" >
									<td height='25' valign='bottom' colspan='6'>Configuración del reporte:</td>
								</tr>
								<tr align="left" >
									<td colspan="2">
										<div id="div_servicios_operario" style="display:none;">
											<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
												<tr><td height="10" colspan="4"/></tr>
												<tr align="left">
													<td width='33'> </td>
													<td width='90'>Del operario:</td>
													<td colspan="2">
														<select id="operarios"><?php echo $select_operarios; ?></select>
													</td>
												</tr>
											</tbody></table>
										</div>
										
										<div id="div_servicios_oficina" style="display:none;">
											<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
												<tr><td height="10" colspan="4"/></tr>
												<tr align="left">
													<td width='33'> </td>
													<td width='90'>De la oficina:</td>
													<td colspan="2">
														<div id="div_oficina_sae" style="display:none;">
															<select id="oficina_sae"><?php echo $select_oficina_sae ?></select>
														</div>
														<div id="div_oficina_sr" style="display:none;">
															<select id="oficina_sr"><?php echo $select_oficina_sr ?></select>
														</div>
													</td>
												</tr>
											</tbody></table>
										</div>
										
										<div id="div_servicios_años" style="display:block;">
											<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
												<tr><td height="10" colspan="4"/></tr>
												<tr align="left">
													<td width='33'> </td>
													<td width='133'><select id="param_años">
														<option value="todos">Todos los años</option>
														<option value="rango">Rango de años</option>
													</select></td>
													<td colspan="2"><div id="div_rango_años_sae" style="display:none;">
														del <select id="año_inicial_sae"><?php echo $select_año_inicial_sae ?></select> al
														<select id="año_final_sae"></select>
													</div>
													<div id="div_rango_años_sr" style="display:none;">
														del <select id="año_inicial_sr"><?php echo $select_año_inicial_sr ?></select> al
														<select id="año_final_sr"></select>
													</div></td>
												</tr>
											</tbody></table>
										</div>
										
										<div id="div_servicios_meses" style="display:none;">
											<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
												<tr><td height="10" colspan="4"/></tr>
												<tr align="left">
													<td width='33'> </td>
													<td width='60'>Del año:</td>
													<td colspan="2">
														<div id="div_meses_del_año_sae" style="display:none;">
															<select id="año_meses_sae"><?php echo $select_año_inicial_sae ?></select>
														</div>
														<div id="div_meses_del_año_sr" style="display:none;">
															<select id="año_meses_sr"><?php echo $select_año_inicial_sr ?></select>
														</div>
													</td>
												</tr>
											</tbody></table>
										</div>
									</td>
								</tr>
							</tbody></table>
						</div>
					</td>
				</tr>
				
				<tr align="left">
					<td>
						<div>
							<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
								<tr align="left" ><td height='15'></td></tr>
								<tr align="left" >
									<td height='1' width='100'></td>
									<td class='linea' height='1' ></td>
									<td height='1' width='100'></td>
								</tr>
								<tr align="left" ><td height='15'></td></tr>
							</tbody></table>
						</div>
					</td>
				</tr>
				
				<tr align="left">
					<td>
						<div id='reporte' style='display:block; overflow:auto; width:580px;'>
							<img id='img_reporte' src="" />
						</div>
					</td>
				</tr>
			</tbody></table>
		<?php echo $form->end(); ?>
	</div>
</div>
