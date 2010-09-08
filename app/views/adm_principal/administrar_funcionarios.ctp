<?php
echo $html->css('menu_navegacion');
echo $html->css('menu_adm_equipo');
echo $html->css('vista');
echo $javascript->link('jquery-1.3.2.min');
echo $javascript->link('adm_principal/administrar_funcionarios');
?>

<div id="menu_navegacion">
	<div class="cuerpo_menu">
		<ul>
			<?php echo $opciones_menu; ?>
		</ul>
	</div>
</div>

<div id="col_derecha">
	<div id="titulo_pagina" align="center">Administración de Funcionarios</div>
	<div id="contenido_vista">
		<form id="funcionario" name="funcionario" action="#" method="post" >
			<!-- HIDDEN INPUTS -->
			<div id="escondidos"></div>
			<input type="hidden" value="<?php echo $opcion_seleccionada; ?>" id="opcion_seleccionada"/>
			<input type="hidden" value="0" id="temp_estado"/>
			
			<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
				<tr><td height="1" class="linea" /></tr>
				<tr><td height="10" /></tr>
				
				<tr align="left">
					<td>
						<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
							<tr align="left">
								<td style='font-size:14px;' colspan='3'>Crear un Funcionario<td>
							</tr>
							<tr><td height="10" /></tr>
							<tr align="left">
								<td class='subtitulo' width='120'>Nombre:</td>
								<td width="150"><input id="nombre_funcionario_crear" maxlength="60" size='30' /></td>
								<td style="padding-left: 5px;"><input id='boton_crear_funcionario' type="button" value="Crear funcionario"></td>
							</tr>
							<tr align="left">
								<td width='120'></td>
								<td width="100" colspan="2" class="textoError"><div id="error_funcionario_crear" style="display:none;"></td>
							</tr>
						</table>
					</td>
				</tr>
				
				<tr><td height="10" /></tr>
				<tr><td height="1" class="linea" /></tr>
				<tr><td height="10" /></tr>
				
				<tr align='left'>
					<td >
						<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
							<tr align="left">
								<td style='font-size:14px;' colspan='3'>Modificar un Funcionario<td>
							</tr>
							<tr><td height="10" /></tr>
							<tr align="left">
								<td class='subtitulo' width='120'>Funcionario:</td>
								<td width="150" colspan='2'><select id="id_funcionario_modificar"></select></td>
							</tr>
							<tr><td height="20" /></tr>
							<tr align="left">
								<td class='subtitulo'>Nuevo nombre:</td>
								<td width='150'><input id="nombre_funcionario_modificar" maxlength="70" size='30' /></td>
								<td style="padding-left: 5px;"><input id='boton_modificar_funcionario' type="button" value="Modificar funcionario"></td>
							</tr>
							<tr align="left">
								<td></td>
								<td colspan="2" class="textoError"><div id="error_funcionario_modificar" style="display:none;"></td>
							</tr>
							<tr align="left">
								<td class='subtitulo'>Estado:</td>
								<td width='150' colspan="2"><select id="select_estado">
									<option value="1">Activado</option>
									<option value="0">Desactivado</option>
								</select></td>
								
							</tr>
						</tbody></table>
					</td>
				</tr>
				
				<tr><td height="10" /></tr>
				<tr><td height="1" class="linea" /></tr>
				<tr><td height="10" /></tr>
				
				<tr align='left'>
					<td >
						<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
							<tr align="left">
								<td style='font-size:14px;' colspan='3'>Eliminar un Funcionario<td>
							</tr>
							<tr><td height="10" /></tr>
							<tr align="left">
								<td class='subtitulo' width='120'>Funcionario:</td>
								<td width="150"><select id="id_funcionario_eliminar"></select></td>
								<td style="padding-left: 5px;"><input id='boton_eliminar_funcionario' type="button" value="Eliminar funcionario"></td>
							</tr>
							
							<tr align="left">
								<td width='120'></td>
								<td width="100" colspan="2" class="textoError"><div id="error_funcionario_eliminar" style="display:none;"></td>
							</tr>
						</tbody></table>
					</td>
				</tr>
			</tbody></table>
		<?php echo $form->end(); ?>
	</div>
</div>
