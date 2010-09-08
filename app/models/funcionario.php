<?php
class Funcionario extends AppModel
{
	var $name = "Funcionario";
	var $hasMany = array
	(
		'ReparacionSolicitud' => array
		(
			'className' => 'ReparacionSolicitud',
			'foreignKey' => 'id'
		)
	);
	
	//--------------------------------------------------------------------------
} 
?>
