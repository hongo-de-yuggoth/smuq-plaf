<?php
echo $html->css('menu_navegacion');
echo $html->css('vista');
echo $html->css('ver_solicitudes');
echo $javascript->link('jquery-1.3.2.min');
echo $javascript->link('solicitudes/ver_solicitudes_reparacion');
?>

<div id="menu_navegacion">
	<div class="cuerpo_menu">
		<ul>
			<?php echo $opciones_menu; ?>
		</ul>
	</div>
</div>

<div id="col_derecha">
	<div id="titulo_pagina" align="center">Ver las Solicitudes de Reparación</div>

	<div id="contenido_vista">
		<form action="#">
			<input type="hidden" value="<?php echo $opcion_seleccionada; ?>" id="opcion_seleccionada"/>
		</form>
		<div id="solicitudes"><?php echo $divs_solicitudes; ?></div>
	</div>
</div>
