<?php
class ApoyoEventoSolicitud extends AppModel
{
	var $name = 'ApoyoEventoSolicitud';
	var $belongsTo = array
	(
		'CentroCosto' => array
		(
			'className' => 'CentroCosto',
			'foreignKey' => 'Cencos_id'
		)
	);
}
?>
