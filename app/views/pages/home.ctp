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
	<div id="titulo_pagina" align="center">SICMUQ<br>Sistema de Información del Centro de Mantenimiento de la Universidad del Quindio</div>
	<div id="contenido_vista">
		<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
			<tr align="left"><td class='subtitulo'></td></tr>
			<tr align="left">
				<td>
					<img align="right" border="0" alt="" src="/img/bg_plaf.jpg">
				</td>
			</tr>
		</tbody></table>
	</div>
</div>
