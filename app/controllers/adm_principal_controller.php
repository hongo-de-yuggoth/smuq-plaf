<?php
class AdmPrincipalController extends AppController
{
	var $name = 'AdmPrincipal';
	var $uses = array('Usuario');
	var $components = array('Tiempo');
	var $helpers = array('Select', 'Javascript');
	var $id_grupo = '1';
	var $opciones_menu = array
	(
		array('titulo' => 'Inicio',
				'link' => '/smuqplaf/',
				'id' => 'inicio'),
		array('titulo' => 'Consultar Solicitudes de Apoyo a Eventos',
				'link' => '/smuqplaf/adm_principal/consultar_apoyo_eventos',
				'id' => 'consultar_apoyo_eventos'),
		array('titulo' => 'Consultar Solicitudes de Reparación',
				'link' => '/smuqplaf/adm_principal/consultar_reparaciones',
				'id' => 'consultar_reparaciones'),
		array('titulo' => 'Consultar Reportes Estadísticos',
				'link' => '/smuqplaf/adm_principal/consultar_reportes',
				'id' => 'consultar_reportes'),
		array('titulo' => 'Solicitar Apoyo para un Evento',
				'link' => '/smuqplaf/adm_principal/crear_solicitud_apoyo_evento',
				'id' => 'crear_solicitud_apoyo_evento'),
		array('titulo' => 'Solicitar una Reparación',
				'link' => '/smuqplaf/adm_principal/crear_solicitud_reparacion',
				'id' => 'crear_solicitud_reparacion'),
		array('titulo' => 'Administrar Funcionarios',
				'link' => '/smuqplaf/adm_principal/administrar_funcionarios',
				'id' => 'administrar_funcionarios'),
		array('titulo' => 'Actualizar Datos de Usuario',
				'link' => '/smuqplaf/adm_principal/actualizar_datos_usuario',
				'id' => 'actualizar_datos_usuario'),
		array('titulo' => 'Ayuda / Manual',
				'link' => '/smuqplaf/ayuda/',
				'id' => 'ayuda'),
		array('titulo' => 'Cerrar Sesión',
				'link' => '/smuqplaf/logout',
				'id' => 'cerrar')
	);
	var $meses = array
	(
		1=>'Enero',
		2=>'Febrero',
		3=>'Marzo',
		4=>'Abril',
		5=>'Mayo',
		6=>'Junio',
		7=>'Julio',
		8=>'Agosto',
		9=>'Septiembre',
		10=>'Octubre',
		11=>'Noviembre',
		12=>'Diciembre'
	);
	
	//--------------------------------------------------------------------------
	
	function beforeRender()
	{
		//$this->disableCache();
		$this->set('opciones_menu', $this->__crear_menu());
	}
	
	//--------------------------------------------------------------------------
	
	function __crear_menu()
	{
		$opciones_menu = '';
		foreach ( $this->opciones_menu as $opcion )
		{
			$opciones_menu = $opciones_menu.'<li id="'.$opcion['id'].'"><a href="'.$opcion['link'].'">'.$opcion['titulo'].'</a></li>';
		}
		
		return $opciones_menu;
	}
	
	//--------------------------------------------------------------------------
	
	function index()
	{
	}
	
	//--------------------------------------------------------------------------
	
	function get_opciones_menu()
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		return $this->__crear_menu();
	}
	
	//--------------------------------------------------------------------------
	
	function consultar_apoyo_eventos()
	{
		$this->loadModel('ApoyoEventoSolicitud');
		$opciones_años = '';
		$opciones_meses = '';
		$oficinas = '';
		
		// primero obtenemos los años existentes.
		$años = $this->ApoyoEventoSolicitud->query("SELECT YEAR(fecha_evento) AS year FROM apoyo_evento_solicitudes GROUP BY YEAR(fecha_evento)");
		if ( !empty($años) )
		{
			foreach ( $años as $año )
			{
				$opciones_años .= '<option value="'.$año[0]['year'].'">'.$año[0]['year'].'</option>';
			}
			$opciones_años = '<option value="0">Todos los años</option>'.$opciones_años;
		}
		
		foreach ( $this->meses as $num_mes => $mes )
		{
			$opciones_meses .= '<option value="'.$num_mes.'">'.$mes.'</option>';
		}
		$opciones_meses = '<option value="0">Todos los meses</option>'.$opciones_meses;
		
		$oficinas_eventos = '';
		$eventos = $this->ApoyoEventoSolicitud->find('all', array
		(
			'fields' => array('DISTINCT ApoyoEventoSolicitud.Cencos_id')
		));
		if ( !empty($eventos) )
		{
			$oficinas = array();
			foreach ( $eventos as $evento )
			{
				$oficinas[mb_convert_case($evento['CentroCosto']['Cencos_nombre'], MB_CASE_TITLE, "UTF-8")] = $evento['CentroCosto']['Cencos_id'];
			}
			ksort($oficinas);
			foreach ( $oficinas as $nombre_oficina => $id_oficina )
			{
				$oficinas_eventos .= '<option value="'.$id_oficina.'">'.$nombre_oficina.'</option>';
			}
		}
		$oficinas_eventos = '<option value="0">Todas las oficinas</option>'.$oficinas_eventos;
		
		$this->set('oficinas', $oficinas_eventos);
		$this->set('opciones_años', $opciones_años);
		$this->set('opciones_meses', $opciones_meses);
		$this->set('opcion_seleccionada', 'consultar_apoyo_eventos');
	}
	
	//--------------------------------------------------------------------------
	
	function consultar_reparaciones()
	{
		$this->loadModel('ReparacionSolicitud');
		$this->loadModel('TipoServicio');
		$this->loadModel('Funcionario');
		$oficinas = '';
		$opciones_funcionarios = '';
		$opciones_años = '';
		$opciones_meses = '';
		$opciones_servicios = '';
		
		// primero obtenemos los años existentes de las archivadas.
		$años = $this->ReparacionSolicitud->query("SELECT YEAR(created) AS year FROM reparacion_solicitudes GROUP BY YEAR(created)");
		if ( !empty($años) )
		{
			foreach ( $años as $año )
			{
				$opciones_años .= '<option value="'.$año[0]['year'].'">'.$año[0]['year'].'</option>';
			}
			$opciones_años = '<option value="0">Todos los años</option>'.$opciones_años;
		}
		
		foreach ( $this->meses as $num_mes => $mes )
		{
			$opciones_meses .= '<option value="'.$num_mes.'">'.$mes.'</option>';
		}
		$opciones_meses = '<option value="0">Todos los meses</option>'.$opciones_meses;
		
		$tipos_servicio = $this->TipoServicio->find('all');
		if ( !empty($tipos_servicio) )
		{
			foreach ( $tipos_servicio as $ts )
			{
				$opciones_servicios .= '<option value="'.$ts['TipoServicio']['id'].'">'.$ts['TipoServicio']['name'].'</option>';
			}
			$opciones_servicios = '<option value="0">Todos los servicios</option>'.$opciones_servicios;
		}
		
		// se obtienen los Cencos_id existentes 
		$oficinas_reparaciones = '';
		$reparaciones = $this->ReparacionSolicitud->find('all', array
		(
			'fields' => array('DISTINCT ReparacionSolicitud.Cencos_id')
		));
		if ( !empty($reparaciones) )
		{
			$oficinas = array();
			foreach ( $reparaciones as $reparacion )
			{
				$oficinas[mb_convert_case($reparacion['CentroCosto']['Cencos_nombre'], MB_CASE_TITLE, "UTF-8")] = $reparacion['CentroCosto']['Cencos_id'];
			}
			ksort($oficinas);
			foreach ( $oficinas as $nombre_oficina => $id_oficina )
			{
				$oficinas_reparaciones .= '<option value="'.$id_oficina.'">'.$nombre_oficina.'</option>';
			}
		}
		$oficinas_reparaciones = '<option value="0">Todas las oficinas</option>'.$oficinas_reparaciones;
		
		$funcionarios = $this->Funcionario->find('all', array
		(
			'fields' => array('id', 'nombre')
		));
		if ( !empty($funcionarios) )
		{
			foreach ( $funcionarios as $funcionario )
			{
				$opciones_funcionarios .= '<option value="'.$funcionario['Funcionario']['id'].'">'.$funcionario['Funcionario']['nombre'].'</option>';
			}
			$opciones_funcionarios = '<option value="0">Todos los funcionarios</option>'.$opciones_funcionarios;
		}
		
		$this->set('oficinas', $oficinas_reparaciones);
		$this->set('funcionarios', $opciones_funcionarios);
		$this->set('opciones_años', $opciones_años);
		$this->set('opciones_meses', $opciones_meses);
		$this->set('opciones_servicios', $opciones_servicios);
		$this->set('opcion_seleccionada', 'consultar_reparaciones');
	}
	
	//--------------------------------------------------------------------------
	
	function consultar_reportes()
	{
		// Obtenemos los años existentes de ApoyoEventoSolicitud.
		$this->loadModel('Funcionario');
		$this->loadModel('ApoyoEventoSolicitud');
		$this->loadModel('ReparacionSolicitud');
		$años = $this->ApoyoEventoSolicitud->query("SELECT YEAR(archivada) AS year FROM apoyo_evento_solicitudes WHERE estado='a' GROUP BY YEAR(archivada)");
		if ( !empty($años) )
		{
			$listado_años = '';
			$html = '';
			foreach ( $años as $año )
			{
				$listado_años .= $año[0]['year'].',';
				$html .= '<option value="'.$año[0]['year'].'">'.$año[0]['year'].'</option>';
			}
			$listado_años = substr($listado_años, 0, -1);
			$this->set('listado_años_sae', $listado_años);
			$this->set('select_año_inicial_sae', $html);
		}
		
		$operarios = $this->Funcionario->find('all', array
		(
			'fields' => array('Funcionario.id', 'Funcionario.nombre', 'Funcionario.activo'),
			'recursive' => 0,
			'order' => array('Funcionario.activo DESC', 'Funcionario.nombre')
		));
		if ( !empty($operarios) )
		{
			$html = '';
			foreach ( $operarios as $operario )
			{
				$html .= '<option value="'.$operario['Funcionario']['id'].'">'.$operario['Funcionario']['nombre'];
				if ( $operario['Funcionario']['activo'] )
				{
					$html .= '</option>';
				}
				else
				{
					$html .= ' (Inactivo)'.'</option>';
				}
			}
			$this->set('select_operarios', $html);
		}
		
		// se obtienen los Cencos_id existentes
		$oficinas_eventos = '';
		$eventos = $this->ApoyoEventoSolicitud->find('all', array
		(
			'fields' => array('DISTINCT ApoyoEventoSolicitud.Cencos_id')
		));
		if ( !empty($eventos) )
		{
			$oficinas = array();
			foreach ( $eventos as $evento )
			{
				$oficinas[mb_convert_case($evento['CentroCosto']['Cencos_nombre'], MB_CASE_TITLE, "UTF-8")] = $evento['CentroCosto']['Cencos_id'];
			}
			ksort($oficinas);
			foreach ( $oficinas as $nombre_oficina => $id_oficina )
			{
				$oficinas_eventos .= '<option value="'.$id_oficina.'">'.$nombre_oficina.'</option>';
			}
			$this->set('select_oficina_sae', $oficinas_eventos);
		}
		
		$oficinas_reparaciones = '';
		$reparaciones = $this->ReparacionSolicitud->find('all', array
		(
			'fields' => array('DISTINCT ReparacionSolicitud.Cencos_id')
		));
		if ( !empty($reparaciones) )
		{
			$oficinas = array();
			foreach ( $reparaciones as $reparacion )
			{
				$oficinas[mb_convert_case($reparacion['CentroCosto']['Cencos_nombre'], MB_CASE_TITLE, "UTF-8")] = $reparacion['CentroCosto']['Cencos_id'];
			}
			ksort($oficinas);
			foreach ( $oficinas as $nombre_oficina => $id_oficina )
			{
				$oficinas_reparaciones .= '<option value="'.$id_oficina.'">'.$nombre_oficina.'</option>';
			}
			$this->set('select_oficina_sr', $oficinas_reparaciones);
		}
		
		// Obtenemos los años existentes de ReparacionSolicitud.
		$this->loadModel('ReparacionSolicitud');
		$años = $this->ReparacionSolicitud->query("SELECT YEAR(archivada) AS year FROM reparacion_solicitudes WHERE estado='a' GROUP BY YEAR(archivada)");
		if ( !empty($años) )
		{
			$listado_años = '';
			$html = '';
			foreach ( $años as $año )
			{
				$listado_años .= $año[0]['year'].',';
				$html .= '<option value="'.$año[0]['year'].'">'.$año[0]['year'].'</option>';
			}
			$listado_años = substr($listado_años, 0, -1);
			$this->set('listado_años_sr', $listado_años);
			$this->set('select_año_inicial_sr', $html);
		}
		
		$this->set('opcion_seleccionada', 'consultar_reportes');
	}
	
	//--------------------------------------------------------------------------
	
	function crear_solicitud_apoyo_evento()
	{
		$this->loadModel('CentroCosto');
		$this->set('fecha_hoy', $this->Tiempo->fecha_espaniol(date('Y-n-j-N')));
		$this->set('opcion_seleccionada', 'crear_solicitud_apoyo_evento');
		
		$id_usuario = $this->Session->read('Usuario.id');
		$usuario = $this->Usuario->find('first', array
		(
			'fields' => array('Usuario.Cencos_id'),
			'conditions' => array('Usuario.id'=>$id_usuario)
		));
		$cenco = $this->CentroCosto->findByCencosId($usuario['Usuario']['Cencos_id']);
		$oficina = mb_convert_case($cenco['CentroCosto']['Cencos_nombre'], MB_CASE_TITLE, "UTF-8");
		
		$this->set('oficina', $oficina);
		$this->set('cencos_id_usuario', $usuario['Usuario']['Cencos_id']);
		
		// Revisamos variables de Session.
		if ( $this->Session->check('Controlador.resultado_guardar') && $this->Session->check('Controlador.resultado_email') )
		{
			if ( $this->Session->read('Controlador.resultado_guardar') == 'error' )
			{
				$this->set('display_notificacion', 'block');
				$this->set('clase_notificacion', 'clean-error');
				$this->set('mensaje_notificacion', 'La solicitud de apoyo a evento no pudo ser creada.');
			}
			else if ( $this->Session->read('Controlador.resultado_guardar') == 'exito' )
			{
				$this->set('display_notificacion', 'block');
				$this->set('clase_notificacion', 'clean-ok');
				if ( $this->Session->read('Controlador.resultado_email') == 'exito' )
				{
					$this->set('mensaje_notificacion', 'La solicitud de apoyo a evento fue creada con éxito, y se ha enviado un email con la información de la solicitud #'.$this->Session->read('Controlador.resultado_id'));
				}
				else
				{
					$this->set('mensaje_notificacion', 'La solicitud de apoyo a evento fue creada con éxito, pero el envío del email ha fallado.<BR>
								  Número de solicitud: '.$this->Session->read('Controlador.resultado_id'));
				}
			}
		}
		else
		{
			$this->set('display_notificacion', 'none');
			$this->set('clase_notificacion', '');
			$this->set('mensaje_notificacion', '');
		}
		$this->Session->write('Controlador.resultado_guardar', '');
	}
	
	//--------------------------------------------------------------------------
	
	function crear_solicitud_reparacion()
	{
		$this->loadModel('TipoServicio');
		$this->loadModel('CentroCosto');
		
		$id_usuario = $this->Session->read('Usuario.id');
		$usuario = $this->Usuario->find('first', array
		(
			'fields' => array('Usuario.Cencos_id'),
			'conditions' => array('Usuario.id'=>$id_usuario)
		));
		$cenco = $this->CentroCosto->findByCencosId($usuario['Usuario']['Cencos_id']);
		$oficina = mb_convert_case($cenco['CentroCosto']['Cencos_nombre'], MB_CASE_TITLE, "UTF-8");
		$this->set('oficina', $oficina);
		$this->set('cencos_id_usuario', $usuario['Usuario']['Cencos_id']);
		
		$tipos_servicio = $this->TipoServicio->find('all');
		if ( !empty($tipos_servicio) )
		{
			$opciones = '';
			foreach ( $tipos_servicio as $tipo )
			{
				$opciones .= '<option value="'.$tipo['TipoServicio']['id'].'">'.$tipo['TipoServicio']['name'].'</option>';
			}
		}
		$this->set('tipos_servicio', $opciones);
		$this->set('opcion_seleccionada', 'crear_solicitud_reparacion');
		$this->set('fecha_hoy', $this->Tiempo->fecha_espaniol(date('Y-n-j-N')));
		
		// Revisamos variables de Session.
		if ( $this->Session->check('Controlador.resultado_guardar') )
		{
			if ( $this->Session->read('Controlador.resultado_guardar') == 'exito' )
			{
				$this->set('display_notificacion', 'block');
				$this->set('clase_notificacion', 'clean-ok');
				$this->set('mensaje_notificacion', 'La solicitud de reparación fue creada con éxito.');
			}
			else if ( $this->Session->read('Controlador.resultado_guardar') == 'error' )
			{
				$this->set('display_notificacion', 'block');
				$this->set('clase_notificacion', 'clean-error');
				$this->set('mensaje_notificacion', 'La solicitud de reparación no pudo ser creada.');
			}
			else
			{
				$this->set('display_notificacion', 'none');
				$this->set('clase_notificacion', '');
				$this->set('mensaje_notificacion', '');
			}
		}
		else
		{
			$this->set('display_notificacion', 'none');
			$this->set('clase_notificacion', '');
			$this->set('mensaje_notificacion', '');
		}
		$this->Session->write('Controlador.resultado_guardar', '');
	}
	
	//--------------------------------------------------------------------------
	
	function administrar_funcionarios()
	{
		$this->set('opcion_seleccionada', 'administrar_funcionarios');
	}
	
	//--------------------------------------------------------------------------
	
	function actualizar_datos_usuario()
	{
		// Revisamos variables de Session.
		if ( $this->Session->check('Controlador.resultado_guardar') )
		{
			if ( $this->Session->read('Controlador.resultado_guardar') == 'exito' )
			{
				$this->set('display_notificacion', 'block');
				$this->set('clase_notificacion', 'clean-ok');
				$this->set('mensaje_notificacion', 'Los cambios fueron guardados.');
			}
			else if ( $this->Session->read('Controlador.resultado_guardar') == 'error' )
			{
				$this->set('display_notificacion', 'block');
				$this->set('clase_notificacion', 'clean-error');
				$this->set('mensaje_notificacion', 'No se pudo guardar los cambios.');
			}
			else
			{
				$this->set('display_notificacion', 'none');
				$this->set('clase_notificacion', '');
				$this->set('mensaje_notificacion', '');
			}
		}
		else
		{
			$this->set('display_notificacion', 'none');
			$this->set('clase_notificacion', '');
			$this->set('mensaje_notificacion', '');
		}
		
		$this->Session->write('Controlador.resultado_guardar', '');
		
		$this->loadModel('Usuario');
		$this->Usuario->recursive = 2;
		$this->Usuario->id = $this->Session->read('Usuario.id');
		
		$this->set('usuario_info', $this->Usuario->read());
		$this->set('opcion_seleccionada', 'actualizar_datos_usuario');
	}
}
?>
