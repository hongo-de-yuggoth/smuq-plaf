<?php
class TipoServicio extends AppModel
{
	var $name = 'TipoServicio';
	var $hasMany = array
	(
		'ReparacionSolicitud' => array
		(
			'className' => 'ReparacionSolicitud',
			'foreignKey' => 'id'
		)
	);
}
?>
