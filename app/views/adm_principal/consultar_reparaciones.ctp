<?php
echo $html->css('menu_navegacion');
echo $html->css('vista');
echo $html->css('tabla_blue/style');
echo $html->css('pager/jquery.tablesorter.pager');
echo $html->css('calendario');
echo $javascript->link('jquery-1.3.2.min');
echo $javascript->link('jquery.tablesorter.min');
echo $javascript->link('jquery.tablesorter.pager');
echo $javascript->link('calendario');
echo $javascript->link('validaciones');
echo $javascript->link('adm_principal/consultar_reparaciones');
?>

<div id="menu_navegacion">
	<div class="cuerpo_menu">
		<ul>
			<?php echo $opciones_menu; ?>
		</ul>
	</div>
</div>

<div id="col_derecha">
	<div id="titulo_pagina" align="center">Consulta de Solicitudes de Reparaciones</div>
	<div id='subtitulo_pagina'></div>
	<div id="contenido_vista">
		<form id="reparaciones" name="reparaciones" action="#" method="post" >
			<!-- HIDDEN INPUTS -->
			<div id="escondidos"></div>
			<input type="hidden" value="<?php echo $opcion_seleccionada; ?>" id="opcion_seleccionada"/>
			
			<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
				<tr align="left">
					<td colspan="2">
						<!-- CRITERIOS -->
						<div>
							<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
								<tr><td colspan="2">Puedes realizar búsquedas de una palabra o frase en todos los campos:</td></tr>
								<tr><td height="10" /></tr>
								<tr align="left">
									<td class='subtitulo' width='140'>Buscar:</td>
									<td><input id='busqueda' name='busqueda' type='text' size="50" maxlength="50" /></td>
								</tr>
								<tr align="left">
									<td></td>
									<td class="textoError" valign="top"><div id="error_numero_solicitud" style="display:none; height:25px;" /></td>
								</tr>
								<tr align="left">
									<td class='subtitulo'>En el campo:</td>
									<td>
										<select id="select_campo">
											<option value="todos">Todos los campos</option>
											<option value="id">número de solicitud</option>
											<option value="lugar">lugar</option>
											<option value="solicitante">solicitante</option>
											<option value="descripcion">descripción</option>
											<option value="observaciones">observaciones</option>
											<option value="observaciones_solucion">observaciones de las solución</option>
										</select>
									</td>
								</tr>
								<tr align="left">
									<td class='subtitulo'>De la oficina:</td>
									<td valign="bottom"><select id="select_oficina"><?php echo $oficinas; ?></select></td>
								</tr>
								<tr align="left">
									<td class='subtitulo'>Tipo de Servicio:</td>
									<td>
										<select id="select_servicio">
											<?php echo $opciones_servicios; ?>
										</select>
									</td>
								</tr>
								<tr align="left">
									<td class='subtitulo'>Del funcionario:</td>
									<td>
										<select id="select_funcionario">
											<?php echo $funcionarios; ?>
										</select>
									</td>
								</tr>
								<tr align="left">
									<td class='subtitulo'>Mostrar las solicitudes:</td>
									<td valign="bottom">
										<select id="select_solicitudes">
											<option value="p">pendientes</option>
											<option value="a">archivadas</option>
											<option value="todas">Todas las solicitudes</option>
										</select>
									</td>
								</tr>
							</tbody></table>
						</div>
						
						<div id='criterio_fecha'>
							<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
								<tr><td height="10" /></tr>
								<tr align="left" ><td class='linea' height='1' colspan="5" ></td></tr>
								<tr><td height="10" /></tr>
								<tr align="left">
									<td class='subtitulo' width='110'>Fecha de solicitud:</td>
									<td width='22'><input id='r_anio_mes' name='opciones_fecha' checked="checked" type='radio' value='anio_mes' /></td>
									<td><label for='r_anio_mes'>Año y mes</label></td>
									<td width='22'><input id='r_rango_fecha' name='opciones_fecha' type='radio' value='rango_fecha' /></td>
									<td><label for='r_rango_fecha'>Rango de fechas</label></td>
								</tr>
								<tr><td height="10" /></tr>
								<tr align="left">
									<td />
									<td colspan="5">
										<div id="fecha_anio_mes" style="display:block" class='div_busqueda'>
											<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
												<tr align="left">
													<td class='subtitulo' width='70'>Año:</td>
													<td><select id="select_anio"><?php echo $opciones_años; ?></select></td>
												</tr>
												<tr><td height="10" colspan="4"/></tr>
												<tr align="left">
													<td class='subtitulo' width='70'>Mes:</td>
													<td><select id="select_mes" disabled="true"><?php echo $opciones_meses; ?></select></td>
												</tr>
											</tbody></table>
										</div>
										
										<div id="fecha_rango" style="display:none" class='div_busqueda'>
											<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
												<tr align="left">
													<td class='subtitulo' width='83'>Fecha inicial:</td>
													<td>
														<input id="fecha_inicial" type="text" readonly value='' maxlength="10" size='9' />
														<input id='boton_cal_1' type="button" value="Seleccionar fecha" />
													</td>
												</tr>
												<tr align="left">
													<td></td>
													<td class="textoError"><div id="error_fecha_inicial" style="display:none;" /></td>
												</tr>
												
												<tr><td height="10" colspan="2"/></tr>
												<tr align="left">
													<td class='subtitulo'>Fecha final:</td>
													<td>
														<input id="fecha_final" type="text" readonly value='' maxlength="10" size='9' />
														<input id='boton_cal_2' type="button" value="Seleccionar fecha" />
													</td>
												</tr>
												<tr align="left">
													<td></td>
													<td class="textoError"><div id="error_fecha_final" style="display:none;" /></td>
												</tr>
											</tbody></table>
										</div>
									</td>
								</tr>
								<tr><td height="10" /></tr>
								<tr align="left" ><td class='linea' height='1' colspan="5" ></td></tr>
							</tbody></table>
						</div>
						
						<div id='div_boton_buscar' align='center' style='padding-top:25px'>
							<input id='boton_buscar_solicitudes' type='button' value='Buscar solicitudes' />
						</div>
					</td>
				</tr>
				
				<tr align="left">
					<td width="100%" class="textoError" colspan="2"><div id="error_consulta" style="display:none;" /></td>
				</tr>
				
				<tr><td height="10" /></tr>
				<tr align="left" ><td class='linea' height='1' colspan="2" ></td></tr>
				<tr><td height="10" /></tr>
				
				<tr align="left">
					<td width="50%"><div id="total_registros" style="display:none;" /></td>
					<td width="50%" align="right"><div id="archivo_xls" style="display:none;"><a href='#'><?php echo $html->image('excel.gif', array('border'=>0, 'alt'=>'Exportar a Excel', 'title'=>'Exportar a Excel')); ?></a></div></td>
				</tr>
				
				<tr align="left">
					<td colspan="2">
						<div id='resultados' style='display:none; overflow:auto; width:580px;'>
							<table id='tabla_resultados' class='tablesorter'>
								<thead>
									<tr>
									    <th>Número<br>Solicitud&nbsp;&nbsp;&nbsp;&nbsp;</th> 
									    <th>Oficina</th>
										 <th>Solicitante</th>
										 <th>Lugar</th>
										 <th>Tipo de<br>Servicio</th>
									    <th>Fecha<br>Solicitud</th>
										 <th>Estado&nbsp;&nbsp;&nbsp;&nbsp;</th>
									</tr>
								</thead> 
								<tbody></tbody>
							</table>
							<div class="pager" id="pager" align='center' style='position: relative;'>
								<form>
									<img class="first" src="/img/pager/first.png"/>
									<img class="prev" src="/img/pager/prev.png"/>
									<input type="text" class="pagedisplay" size='10' style="text-align:center;" />
									<img class="next" src="/img/pager/next.png"/>
									<img class="last" src="/img/pager/last.png"/>
									<select class="pagesize">
										<option value="10" selected="selected">10</option>
										<option value="20">20</option>
										<option value="30">30</option>
										<option value="40">40</option>
									</select>
								</form>
							</div>
						</div>
					</td>
				</tr>
			</tbody></table>
		<?php echo $form->end(); ?>
	</div>
</div>