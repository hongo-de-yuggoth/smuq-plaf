<?php
echo $html->css('menu_navegacion');
echo $html->css('vista');
echo $javascript->link('jquery-1.3.2.min');
echo $javascript->link('validaciones');
echo $javascript->link('validaciones_ajax');
echo $javascript->link('adm_principal/usuario');
echo $javascript->link('adm_principal/actualizar_datos_usuario');
?>

<div id="menu_navegacion">
	<div class="cuerpo_menu">
		<ul>
			<?php echo $opciones_menu; ?>
		</ul>
	</div>
</div>

<div id="col_derecha">
	<div id="titulo_pagina" align="center">Actualización de los Datos de Usuario</div>
	<div id="cuadro_notificaciones" class="<?php echo $clase_notificacion; ?>" style="display: <?php echo $display_notificacion; ?>;">
		<?php echo $mensaje_notificacion; ?>
	</div>
	<div id='subtitulo_pagina' style='margin-top:15px;'>Información del usuario</div>
	<div id="contenido_vista">
		<form id="usuario" name="usuario" action="#" method="post" >
			<div class="ajax_loading_image"></div>
			<!-- HIDDEN INPUTS -->
			<div id="escondidos">
				<input id='h_id' name='data[Usuario][id]' type='hidden' value='<?php echo $usuario_info["Usuario"]["id"];?>' />
				<input id='h_login' type='hidden' value='<?php echo $usuario_info["Usuario"]["login"];?>' />
			</div>
			<input type="hidden" value="<?php echo $opcion_seleccionada; ?>" id="opcion_seleccionada"/>
			
			<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
				<tr align='left'>
					<td colspan='4'>
						<div id='info_usuario'>
							<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
								<tr><td height="10" colspan="4"/></tr>
								<tr><td height="1" class="linea" colspan="4"/></tr>
								<tr><td height="10" colspan="4"/></tr>
								
								<tr align="left">
									<td class='subtitulo' width='120'>Login:</td>
									<td colspan="3" width="210"><input id="login" name='data[Usuario][login]' maxlength="15" size='15' value='<?php echo $usuario_info["Usuario"]["login"];?>' /></td>
								</tr>
								
								<tr align="left">
									<td width='120'></td>
									<td width="100" colspan="3" class="textoError"><div id="error_login" style="display:none;" /></td>
								</tr>
								
								<tr><td height="10" colspan="4"/></tr>
								
								<tr align="left">
									<td class='subtitulo' width='120'>Nueva clave:</td>
									<td colspan="3" width="210"><input id="clave" type='password' maxlength="15" size='15' /></td>
								</tr>
								
								<tr align="left">
									<td width='120'></td>
									<td width="100" colspan="3" class="textoError"><div id="error_clave" style="display:none;" /></td>
								</tr>
								
								<tr><td height="10" colspan="4"/></tr>
								
								<tr align="left">
									<td class='subtitulo' width='120'>Nueva clave (otra vez):</td>
									<td colspan="3" width="210"><input id="clave2" type='password' maxlength="15" size='15' /></td>
								</tr>
								
								<tr align="left">
									<td width='120'></td>
									<td width="100" colspan="3" class="textoError"><div id="error_clave2" style="display:none;" /></td>
								</tr>
								
								<tr><td height="10" colspan="4"/></tr>
								
								<tr align="left">
									<td class='subtitulo' width='120'>Email:</td>
									<td colspan="3" width="210"><input id="email" type='text' name='data[Usuario][email]' maxlength="100" size='45' value='<?php echo $usuario_info["Usuario"]["email"];?>' /></td>
								</tr>
								
								<tr align="left">
									<td width='120'></td>
									<td width="100" colspan="3" class="textoError"><div id="error_email" style="display:none;" /></td>
								</tr>
								
								<tr><td height="15" colspan="4"/></tr>
								<tr align="left">
									<td width='100%' valign="top" align="center" colspan="4"><input type="submit" value="Guardar cambios"/></td>
								</tr>
							</tbody></table>
						</div>
					</td>
				</tr>
			</tbody></table>
		<?php echo $form->end(); ?>
	</div>
</div>
