<?php
echo $html->css('menu_navegacion');
echo $html->css('vista');
//echo $javascript->link('jquery-1.3.2.min');

?>

<div id="menu_navegacion">
	<div class="cuerpo_menu">
		<ul>
			<li id="inicio" class="selected"><a href="/">Inicio</a></li>
			<li id="apoyo_eventos"><a href="/usr_cenco/crear_solicitud_apoyo_evento">Solicitar Apoyo para un Evento</a></li>
			<li id="reparaciones"><a href="/usr_cenco/crear_solicitud_reparacion">Solicitar una Reparación</a></li>
			<li id="acerca_de"><a href="/acerca_de">Acerca de SICMUQ</a></li>
		</ul>
	</div>
</div>

<div id="col_derecha">
	<div id="titulo_pagina" align="center">SICMUQ<br>Sistema de Información del Centro Mantenimiento de la Universidad del Quindio</div>
	<div id="contenido_vista">
		<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
			<tr align="left"><td class='subtitulo'></td></tr>
			<tr align="left">
				<td align="center" height="300">
					<div id="login_box">
						<table>
							<tr>
								<td>
									<form id="login_usuario" name="login_usuario" method="post" action="/usuarios/login">
										<table>
											<tr>
												<td class="subtitulo">Login:</td>
												<td><input name="data[Usuario][login]" type="text" value="" id="login" /></td>
											</tr>
											<tr>
												<td class="subtitulo">Clave:</td>
												<td><input type="password" name="data[Usuario][clave]" value="" id="clave" /></td>
											</tr>
											<tr>
												<td colspan="2" align="center"><input type="submit" value="Entrar al Sistema" /></td>
											</tr>
										</table>
									</form>
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
		</tbody></table>
	</div>
</div>
