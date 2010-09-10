<?php
class PagesController extends AppController
{
	var $name = 'Pages';
	var $helpers = array('Html');
	var $uses = array();
	var $id_grupo = '*';
	
	//---------------------------------------------------------------------------
	
	function beforeFilter()
	{
		$this->disableCache();
		$opciones_menu = '';
		
		if ( $this->Session->check('Usuario.id_grupo') )
		{
			$this->set('display_contexto', 'block');
			$this->set('contexto', 'Bienvenido, '.$this->Session->read('Usuario.nombre'));
			if ( $this->Session->read('Usuario.id_grupo') == '1' )
			{
				$opciones_menu = $this->requestAction('/adm_principal/get_opciones_menu');
			}
			else if ( $this->Session->read('Usuario.id_grupo') == '2' )
			{
				$opciones_menu = $this->requestAction('/usr_cenco/get_opciones_menu');
			}
			
			// Seleccionamos la primera opción.
			$opciones_menu = str_replace('<li id="inicio">', '<li id="inicio" class="selected">', $opciones_menu);
		}
		else
		{
			$this->set('display_contexto', 'none');
			$this->set('contexto', '');
			$opciones_menu = '<li id="inicio" class="selected"><a href="/">Inicio</a></li>
			<li id="apoyo_eventos"><a href="/usr_cenco/crear_solicitud_apoyo_evento">Solicitar Apoyo para un Evento</a></li>
			<li id="reparaciones"><a href="/usr_cenco/crear_solicitud_reparacion">Solicitar una Reparación</a></li>
			<li id="acerca_de"><a href="/acerca_de">Acerca de SICMUQ</a></li>';
		}
		
		$this->set('opciones_menu', $opciones_menu);
	}
	
	//---------------------------------------------------------------------------
	
	/**
	* Displays a view
	*
	* @param mixed What page to display
	* @access public
	*/
	function display()
	{
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title'));
		$this->render(join('/', $path));
	}
}
?>
