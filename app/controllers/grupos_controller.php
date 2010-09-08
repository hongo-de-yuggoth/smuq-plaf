<?php
class GruposController extends AppController
{
	//--------------------------------------------------------------------------
	
	function beforeFilter(){}
	
	//--------------------------------------------------------------------------
	
	function crear($nombre)
	{
		$this->Grupo->set('name', $nombre);
		$this->Grupo->save();
	}
	
	//--------------------------------------------------------------------------
	
}
?>
