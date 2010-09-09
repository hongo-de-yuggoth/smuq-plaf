<?php
class AppController extends Controller
{
	var $id_grupo;

	//--------------------------------------------------------------------------
	
	function beforeFilter()
	{
		$this->disableCache();
		$this->set('display_contexto', 'none');//***
		
		if ( $this->Session->check('Usuario.id_grupo') )
		{
			if ( $this->Session->read('Usuario.id_grupo') != $this->id_grupo )
			{
				$this->Session->write('referer', $this->referer());
				$this->redirect(array('controller' => 'usuarios',
											'action' => 'denegado'));
			}
			$this->set('display_contexto', 'block');
			$this->set('contexto', 'Bienvenido, '.$this->Session->read('Usuario.nombre'));
		}
		else
		{
			$this->redirect(array('controller' => 'usuarios',
										'action' => 'login'));
		}
	}
}
?>
