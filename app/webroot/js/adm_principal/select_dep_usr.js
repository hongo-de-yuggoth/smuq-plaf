function cargo()
{
	$('#cargo').load(
		'/smuqlab/usuarios/cargo_ajax/' + $('#id_usuario').val(),
		function(){}
	);
}

//-----------------------------------------------------------------------------

function cargar_usuarios()
{
	$('#id_usuario').load(
		'/smuqlab/usuarios/cargar_select/' + $('#id_dependencia').val(),
		cargo
	);
}

//-----------------------------------------------------------------------------

function cargar_dependencias()
{
	$('#id_dependencia').load(
		'/smuqlab/dependencias/cargar_select_con_usuarios/' + $('#id_edificio').val(),
		cargar_usuarios
	);
}