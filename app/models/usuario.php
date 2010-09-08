<?php
class Usuario extends AppModel
{
	var $name = "Usuario";
	
	//--------------------------------------------------------------------------
	
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
