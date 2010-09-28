<?php
class UsrCencoController extends AppController
{
	var $name = 'UsrCenco';
	var $helpers = array('Html', 'Javascript');
	var $components = array('Tiempo');
	var $uses = array('Usuario', 'CentroCosto');
	var $id_grupo = '2';
	var $opciones_menu = array
	(
		array('titulo' => 'Inicio',
				'link' => '/',
				'id' => 'inicio'),
		array('titulo' => 'Solicitar Apoyo para un Evento',
				'link' => '/usr_cenco/crear_solicitud_apoyo_evento',
				'id' => 'crear_solicitud_apoyo_evento'),
		array('titulo' => 'Solicitar una Reparación',
				'link' => '/usr_cenco/crear_solicitud_reparacion',
				'id' => 'crear_solicitud_reparacion'),
		array('titulo' => 'Ver las Solicitudes de Apoyo a Eventos',
				'link' => '/usr_cenco/ver_solicitudes_apoyo_evento',
				'id' => 'ver_solicitudes_apoyo_evento'),
		array('titulo' => 'Ver las Solicitudes de Reparación',
				'link' => '/usr_cenco/ver_solicitudes_reparacion',
				'id' => 'ver_solicitudes_reparacion'),
		array('titulo' => 'Actualizar Datos de Usuario',
				'link' => '/usr_cenco/actualizar_datos_usuario',
				'id' => 'actualizar_datos_usuario'),
		array('titulo' => 'Ayuda / Manual',
				'link' => '/ayuda/',
				'id' => 'ayuda'),
		array('titulo' => 'Cerrar Sesión',
				'link' => '/logout',
				'id' => 'cerrar')
	);

	//--------------------------------------------------------------------------

	function beforeRender()
	{
		$this->set('opciones_menu', $this->_crear_menu());
	}

	//--------------------------------------------------------------------------

	function get_opciones_menu()
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		return $this->_crear_menu();
	}

	//--------------------------------------------------------------------------

	function _crear_menu()
	{
		$opciones_menu = '';
		foreach ( $this->opciones_menu as $opcion )
		{
			$opciones_menu = $opciones_menu.'<li id="'.$opcion['id'].'"><a href="'.$opcion['link'].'">'.$opcion['titulo'].'</a></li>';
		}
		return $opciones_menu;
	}

	//--------------------------------------------------------------------------

	function index(){}

	//--------------------------------------------------------------------------

	function crear_solicitud_apoyo_evento()
	{
		$this->set('fecha_hoy', $this->Tiempo->fecha_espaniol(date('Y-n-j-N')));
		$this->set('opcion_seleccionada', 'crear_solicitud_apoyo_evento');

		$id_usuario = $this->Session->read('Usuario.id');
		$usuario = $this->Usuario->find('first', array
		(
			'fields' => array('Usuario.Cencos_id'),
			'conditions' => array('Usuario.id'=>$id_usuario)
		));
		$cenco = $this->CentroCosto->findByCencosId($usuario['Usuario']['Cencos_id']);
		$this->set('oficina', mb_convert_case($cenco['CentroCosto']['Cencos_nombre'], MB_CASE_TITLE, "UTF-8"));
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

		$id_usuario = $this->Session->read('Usuario.id');
		$usuario = $this->Usuario->find('first', array
		(
			'fields' => array('Usuario.Cencos_id'),
			'conditions' => array('Usuario.id'=>$id_usuario)
		));
		$cenco = $this->CentroCosto->findByCencosId($usuario['Usuario']['Cencos_id']);
		$this->set('oficina', mb_convert_case($cenco['CentroCosto']['Cencos_nombre'], MB_CASE_TITLE, "UTF-8"));
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

	function ver_solicitudes_apoyo_evento()
	{
		$this->set('opcion_seleccionada', 'ver_solicitudes_apoyo_evento');
		$id_usuario = $this->Session->read('Usuario.id');
		$usuario = $this->Usuario->find('first', array
		(
			'fields' => array('Usuario.Cencos_id'),
			'conditions' => array('Usuario.id'=>$id_usuario)
		));
		$solicitudes = $this->requestAction('/apoyo_evento_solicitudes/ultimas_solicitudes/'.$usuario['Usuario']['Cencos_id']);
		if ( !empty($solicitudes) )
		{
			$divs_solicitudes = '';
			foreach ( $solicitudes as $solicitud )
			{
				$formato_solicitud =
				'<div class="div_solicitud">
					<table width="100%%">
						<tr><td width="100%%" class="subtitulo_ver" colspan="2">Solicitud No.%s</td></tr>
						<tr><td width="100%%" class="fecha" align="left" colspan="2">Servicio solicitado el %s</td></tr>
						<tr>
							<td width="60" align="center"><a href="/apoyo_evento_solicitudes/exportar_pdf/%s"><img border="0" title="Guardar el archivo PDF de esta solicitud." alt="Guardar el archivo PDF de esta solicitud." src="/img/pdf.gif" /></a></td>
							<td width="300">
								<table width="100%%" valign="top" align="left">
									<tr>
										<td width="115" class="" valign="top"><b>Evento:</b></td>
										<td>%s</td>
									</tr>
									<tr>
										<td width="115" class="" valign="top"><b>Fecha del Evento:</b></td>
										<td>%s</td>
									</tr>
									<tr>
										<td width="115" class="" valign="top"><b>Solicitante:</b></td>
										<td>%s</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>';
				$nombre_evento = mb_convert_case($solicitud['ApoyoEventoSolicitud']['nombre'], MB_CASE_TITLE, "UTF-8");
				$solicitud['ApoyoEventoSolicitud']['nombre'] = $nombre_evento;
				$tmp = split(' ', $solicitud['ApoyoEventoSolicitud']['created']);
				$fecha = $tmp[0];
				list($anio, $mes, $dia) = split('-', $fecha);
				$solicitud['ApoyoEventoSolicitud']['created'] = $this->Tiempo->fecha_espaniol(date('Y-n-j-N', mktime(0,0,0,$mes, $dia, $anio)));
				list($anio, $mes, $dia) = split('-', $solicitud['ApoyoEventoSolicitud']['fecha_evento']);
				$solicitud['ApoyoEventoSolicitud']['fecha_evento'] = $this->Tiempo->fecha_espaniol(date('Y-n-j-N', mktime(0,0,0,$mes, $dia, $anio)));
				$div_solicitud = sprintf
				(
					$formato_solicitud,
					$solicitud['ApoyoEventoSolicitud']['id'],
					$solicitud['ApoyoEventoSolicitud']['created'],
					$solicitud['ApoyoEventoSolicitud']['id'],
					$solicitud['ApoyoEventoSolicitud']['nombre'],
					$solicitud['ApoyoEventoSolicitud']['fecha_evento'],
					$solicitud['ApoyoEventoSolicitud']['solicitante']
				);
				$divs_solicitudes .= $div_solicitud;
			}
		}
		else
		{
			$divs_solicitudes = '<div class="clean-error" style="margin-top:33px;">No se han realizado solicitudes de servicio.</div>';
		}
		$this->set('divs_solicitudes', $divs_solicitudes);
	}

	//--------------------------------------------------------------------------

	function ver_solicitudes_reparacion()
	{
		$this->set('opcion_seleccionada', 'ver_solicitudes_reparacion');
		$id_usuario = $this->Session->read('Usuario.id');
		$usuario = $this->Usuario->find('first', array
		(
			'fields' => array('Usuario.Cencos_id'),
			'conditions' => array('Usuario.id'=>$id_usuario)
		));
		$solicitudes = $this->requestAction('/reparacion_solicitudes/ultimas_solicitudes/'.$usuario['Usuario']['Cencos_id']);
		if ( !empty($solicitudes) )
		{
			$divs_solicitudes = '';
			foreach ( $solicitudes as $solicitud )
			{
				$formato_solicitud =
				'<div class="div_solicitud">
					<table width="100%%">
						<tr><td width="100%%" class="subtitulo_ver" colspan="2">Solicitud No.%s</td></tr>
						<tr><td width="100%%" class="fecha" align="left" colspan="2">Servicio solicitado el %s</td></tr>
						<tr>
							<td width="60" align="center"><a href="/reparacion_solicitudes/exportar_pdf/%s"><img border="0" title="Guardar el archivo PDF de esta solicitud." alt="Guardar el archivo PDF de esta solicitud." src="/img/pdf.gif" /></a></td>
							<td width="300">
								<table width="100%%" valign="top" align="left">
									<tr>
										<td width="115" class="" valign="top"><b>Lugar:</b></td>
										<td>%s</td>
									</tr>
									<tr>
										<td width="115" class="" valign="top"><b>Tipo de Servicio:</b></td>
										<td>%s</td>
									</tr>
									<tr>
										<td width="115" class="" valign="top"><b>Descripción:</b></td>
										<td>%s</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>';
				$tmp = split(' ', $solicitud['ReparacionSolicitud']['created']);
				$fecha = $tmp[0];
				list($anio, $mes, $dia) = split('-', $fecha);
				$solicitud['ReparacionSolicitud']['created'] = $this->Tiempo->fecha_espaniol(date('Y-n-j-N', mktime(0,0,0,$mes, $dia, $anio)));
				$div_solicitud = sprintf
				(
					$formato_solicitud,
					$solicitud['ReparacionSolicitud']['id'],
					$solicitud['ReparacionSolicitud']['created'],
					$solicitud['ReparacionSolicitud']['id'],
					$solicitud['ReparacionSolicitud']['lugar'],
					$solicitud['TipoServicio']['name'],
					$solicitud['ReparacionSolicitud']['descripcion']
				);
				$divs_solicitudes .= $div_solicitud;
			}
		}
		else
		{
			$divs_solicitudes = '<div class="clean-error" style="margin-top:33px;">No se han realizado solicitudes de servicio.</div>';
		}
		$this->set('divs_solicitudes', $divs_solicitudes);
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

	//--------------------------------------------------------------------------
}
?>
