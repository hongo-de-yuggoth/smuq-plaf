<?php
class ReparacionSolicitud extends AppModel
{
	var $name = 'ReparacionSolicitud';
	var $belongsTo = array
	(
		'TipoServicio' => array
		(
			'className' => 'TipoServicio',
			'foreignKey' => 'tipo_servicio'
		),
		'Funcionario' => array
		(
			'className' => 'Funcionario',
			'foreignKey' => 'id_funcionario'
		),
		'CentroCosto' => array
		(
			'className' => 'CentroCosto',
			'foreignKey' => 'Cencos_id'
		)
	);
}
?>
