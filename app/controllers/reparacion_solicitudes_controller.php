<?php
class ReparacionSolicitudesController extends AppController
{
	var $name = 'ReparacionSolicitudes';
	var $uses = array('ReparacionSolicitud');
	var $components = array('Tiempo', 'Email');
	var $helpers = array('Html', 'Javascript');
	var $estados = array
	(
		'a' => 'Archivada',
		'p' => 'Pendiente'
	);
	var $estados_solucion = array
	(
		0 => 'No ejecutada',
		1 => 'Ejecutada'
	);
	var $encabezado_reparacion_pdf =
	'<table width="100%" cellspacing="0" cellpadding="3" border="1"><tbody>
		<tr align="left">
			<td width="85"><img src="/app/webroot/img/logouq.gif" alt="" /></td>
			<td width="*" colspan="3" align="right"><br/><br/><b>UNIVERSIDAD DEL QUINDIO<br/>SISTEMA INTEGRADO DE GESTIÓN</b></td>
		</tr>
		<tr align="right">
			<td width="85"></td>
			<td width="160"><b>Código:</b> A.AC-01.00.02.F.01</td>
			<td width="160"><b>Versión:</b> 3</td>
			<td width="*"><b>Fecha:</b> 2010/5/12</td>
		</tr>
		<tr align="left"><td width="*" align="center"><b>FORMATO DE SOLICITUD DE REPARACIONES</b></td></tr>
	</tbody></table>';
	
	//--------------------------------------------------------------------------
	
	function beforeFilter(){}
	
	//--------------------------------------------------------------------------
	
	function exportar_pdf($id_solicitud)
	{
		// Sobrescribimos para que no aparezcan los resultados de debuggin
		// ya que sino daria un error al generar el pdf.
		Configure::write('debug',0);
		
		// Se obtienen los datos de la solicitud.
		$filas_tabla = $this->_info_solicitud_pdf($id_solicitud);
		$this->set('filas_tabla',$filas_tabla);
		$this->set('id_solicitud',$id_solicitud);
		$this->render('exportar_pdf','exportar_pdf');
	}
	
	//--------------------------------------------------------------------------
	
	function crear()
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		
		if ( !empty($this->data) )
		{
			$this->data['ReparacionSolicitud']['estado'] = 'p';
			if ( $this->ReparacionSolicitud->save($this->data) )
			{
				$this->Session->write('Email.id_solicitud', $this->ReparacionSolicitud->id);
				$this->Session->write('Email.email_solicitante', $this->data['ReparacionSolicitud']['email_solicitante']);
				if ( $this->requestAction('reparacion_solicitudes/email', array('return'=>'')) == 'true' )
				{
					$this->Session->write('Controlador.resultado_email', 'exito');
				}
				else
				{
					$this->Session->write('Controlador.resultado_email', 'error');
				}
				$this->Session->write('Controlador.resultado_guardar', 'exito');
				$this->Session->write('Controlador.resultado_id', $this->ReparacionSolicitud->id);
			}
			else
			{
				$this->Session->write('Controlador.resultado_guardar', 'error');
				$this->Session->write('Controlador.resultado_email', 'error');
			}
			$this->Session->del('Email.id_solicitud');
			$this->Session->del('Email.email_solicitante');
			$this->redirect($this->referer());
		}
	}

	//--------------------------------------------------------------------------
	
	function _info_solicitud_pdf($id)
	{
		$this->ReparacionSolicitud->recursive = 1;
		$solicitud_info = $this->ReparacionSolicitud->read(null, $id);
		if ( !empty($solicitud_info) )
		{
			$tmp = split(' ', $solicitud_info['ReparacionSolicitud']['created']);
			$fecha = $tmp[0];
			list($anio, $mes, $dia) = split('-', $fecha);
			$solicitud_info['ReparacionSolicitud']['fecha_solicitud'] = $this->Tiempo->fecha_espaniol(date('Y-n-j-N', mktime(0,0,0,$mes, $dia, $anio)));
			$nombre_oficina = mb_convert_case($solicitud_info['CentroCosto']['Cencos_nombre'], MB_CASE_TITLE, "UTF-8");
			
			$solucionada = '';
			if ( $solicitud_info['ReparacionSolicitud']['estado'] == 'a' )
			{
				$solucionada = '
				<tr align="left"><td width="*" align="center"><b>Solución a la Solicitud</b></td></tr>
				<tr align="left">
					<td width="187"><b>La solicitud fué:</b></td>
					<td width="*" colspan="2">'.$this->estados_solucion[$solicitud_info['ReparacionSolicitud']['ejecutada']].'</td>
				</tr>
				<tr align="left">
					<td width="187"><b>Funcionario que realizó el servicio:</b></td>
					<td width="*" colspan="2">'.$solicitud_info['Funcionario']['nombre'].'</td>
				</tr>
				<tr align="left">
					<td width="187"><b>Tiempo estimado en la reparación:</b></td>
					<td width="*" colspan="2">'.$solicitud_info['ReparacionSolicitud']['tiempo_estimado'].' hora(s)</td>
				</tr>
				<tr align="left">
					<td width="187"><b>Observaciones a la solución:</b></td>
					<td width="*" colspan="2">'.$solicitud_info['ReparacionSolicitud']['observaciones_solucion'].'</td>
				</tr>';
			}
			
			$filas_tabla =
			'<table width="100%" cellspacing="0" cellpadding="5"><tbody>
				<tr align="left">
					<td colspan="2">'.$this->encabezado_reparacion_pdf.'</td>
				</tr>
				
				<tr><td height="10" colspan="3"></td></tr>
				
				<tr align="left">
					<td colspan="2" width="*"><div>
						<table width="100%" cellspacing="0" cellpadding="5" border="1"><tbody>
							<tr align="left">
								<td width="125" border="1"><b>Solicitud No:</b></td>
								<td width="*" colspan="2">'.$solicitud_info['ReparacionSolicitud']['id'].'</td>
							</tr>
							<tr align="left">
								<td width="125"><b>Fecha de la solicitud:</b></td>
								<td width="*" colspan="2">'.$solicitud_info['ReparacionSolicitud']['fecha_solicitud'].'</td>
							</tr>
							<tr align="left">
								<td width="125"><b>Estado de la solicitud:</b></td>
								<td width="*" colspan="2">'.$this->estados[$solicitud_info['ReparacionSolicitud']['estado']].'</td>
							</tr>
							<tr align="left">
								<td width="125"><b>Oficina que solicita el servicio:</b></td>
								<td width="*" colspan="2">'.$nombre_oficina.'</td>
							</tr>
						</tbody></table>
					</div></td>
				</tr>
				
				<tr><td height="10" colspan="2"></td></tr>
				
				<tr align="left">
					<td colspan="2" width="*"><div>
						<table width="100%" cellspacing="0" cellpadding="5" border="1"><tbody>
							<tr align="left">
								<td width="125"><b>Lugar:</b></td>
								<td width="*" colspan="2">'.$solicitud_info['ReparacionSolicitud']['lugar'].'</td>
							</tr>
							<tr align="left">
								<td width="125"><b>Solicitante:</b></td>
								<td width="*" colspan="2">'.$solicitud_info['ReparacionSolicitud']['solicitante'].'</td>
							</tr>
							<tr align="left">
								<td width="125"><b>Tipo de servicio:</b></td>
								<td width="*" colspan="2">'.$solicitud_info['TipoServicio']['name'].'</td>
							</tr>
							<tr align="left">
								<td width="125"><b>Descripción:</b></td>
								<td width="*" colspan="2"><div class="div_solucion">'.$solicitud_info['ReparacionSolicitud']['descripcion'].'</div></td>
							</tr>
							<tr align="left">
								<td width="125"><b>Observaciones:</b></td>
								<td width="*" colspan="2"><div class="div_solucion">'.$solicitud_info['ReparacionSolicitud']['observaciones'].'</div></td>
							</tr>
						</tbody></table>
					</div></td>
				</tr>	
							
				<tr><td height="10" colspan="2"></td></tr>
				
				<tr align="left">
					<td colspan="2" width="*"><div>
						<table width="100%" cellspacing="0" cellpadding="5" border="1"><tbody>
							'.$solucionada.'
						</tbody></table>
					</div></td>
				</tr>
				<tr><td height="50" colspan="2"></td></tr>
				<tr align="left">
					<td width="270" align="left"><hr /></td>
					<td width="50"></td>
					<td width="*" align="center"><hr /></td>
				</tr>
				<tr align="left">
					<td width="270" align="left" valign="top"><b>LIDER PROCESO MANTENIMIENTO PLANTA FISICA</b></td>
					<td width="50"> </td>
					<td width="*" align="center"><b>FIRMA OPERARIO</b></td>
				</tr>
			</tbody></table>';
			
			return $filas_tabla;
		}
		return false;
	}
	
	//--------------------------------------------------------------------------
	
	function info_solicitud($id)
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		$solicitudes_info = $this->ReparacionSolicitud->find('all', array
		(
			'fields' => array
			(
				'ReparacionSolicitud.id',
				'ReparacionSolicitud.Cencos_id',
				'ReparacionSolicitud.solicitante',
				'ReparacionSolicitud.lugar',
				'tipo_servicio',
				'DATE(ReparacionSolicitud.created) AS created',
				'estado'
			),
			'conditions' => array('ReparacionSolicitud.id'=>$id)
		));
		$solicitudes_info[0]['ReparacionSolicitud']['created'] = $solicitudes_info[0][0]['created'];
		return json_encode($this->_crear_filas($solicitudes_info));
	}
	
	//--------------------------------------------------------------------------

	function ver($id)
	{
		$this->disableCache();
		if ( $this->Session->check('Usuario.id_grupo') )
		{
			if ( $this->Session->read('Usuario.id_grupo') != 1 )
			{
				$this->Session->write('referer', $this->referer());
				$this->redirect(array('controller' => 'usuarios',
											'action' => 'denegado'));
			}
		}
		else
		{
			$this->redirect(array('controller' => 'usuarios',
										'action' => 'login'));
		}
		
		// Revisamos variables de Session.
		if ( $this->Session->check('Controlador.resultado_guardar') )
		{
			if ( $this->Session->read('Controlador.resultado_guardar') == 'exito' )
			{
				$this->set('display_notificacion', 'block');
				$this->set('clase_notificacion', 'clean-ok');
				$this->set('mensaje_notificacion', 'Se han guardado los cambios.');
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
		
		$this->ReparacionSolicitud->recursive = 1;
		$solicitud_info = $this->ReparacionSolicitud->read(null, $id);
		
		if ( !empty($solicitud_info) )
		{
			$nombre_oficina = mb_convert_case($solicitud_info['CentroCosto']['Cencos_nombre'], MB_CASE_TITLE, "UTF-8");
			$solicitud_info['CentroCosto']['Cencos_nombre'] = $nombre_oficina;
			$tmp = split(' ', $solicitud_info['ReparacionSolicitud']['created']);
			$fecha = $tmp[0];
			list($anio, $mes, $dia) = split('-', $fecha);
			$solicitud_info['ReparacionSolicitud']['fecha_solicitud'] = $this->Tiempo->fecha_espaniol(date('Y-n-j-N', mktime(0,0,0,$mes, $dia, $anio)));
			$opciones_menu = $this->requestAction(array('controller' => 'adm_principal',
																	'action' => 'get_opciones_menu'));
			$funcionarios =  json_decode($this->requestAction(array('controller' => 'funcionarios',
																	'action' => 'cargar_select_activos')));
			$this->set('funcionarios', $funcionarios->opciones);
			$this->set('opciones_menu', $opciones_menu);
			$this->set('solicitud', $solicitud_info);
			$this->set('opcion_seleccionada', 'consultar_reparaciones');
			if ( $solicitud_info['ReparacionSolicitud']['estado'] == 'a' )
			{
				$this->set('display_archivar', 'none');
				$this->set('display_div_ejecutada', 'block');
				$this->set('display_select_ejecutada', 'none');
				$this->set('ejecutada', $this->estados_solucion[$solicitud_info['ReparacionSolicitud']['ejecutada']]);
			}
			else
			{
				$this->set('display_archivar', 'block');
				$this->set('display_div_ejecutada', 'none');
				$this->set('display_select_ejecutada', 'block');
			}
		}
	}

	//--------------------------------------------------------------------------

	function archivar($id)
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		
		if ( !empty($id) )
		{
			$this->data['ReparacionSolicitud']['estado'] = 'a';
			$this->data['ReparacionSolicitud']['archivada'] = date('Y-m-d H:i:s');
			$solicitud_info = $this->ReparacionSolicitud->read(null, $id);
			
			if ( $this->ReparacionSolicitud->save($this->data) )
			{
				$this->Session->write('Controlador.resultado_guardar', 'exito');
				
				// Ahora debemos informar al usuario sobre la solución de su
				// solicitud de servicio (EMAIL)
				/*if ( $this->enviar_email() )
				{
					$this->Session->write('Controlador.resultado_guardar', 'exito');
				}*/
			}
			else
			{
				$this->Session->write('Controlador.resultado_guardar', 'error');
			}
			
			$this->redirect($this->referer());
		}
	}
	
	//--------------------------------------------------------------------------
	
	function exportar_xls($frase_busqueda, $criterio_fecha, $fecha_1, $fecha_2, $mostrar_solicitudes, $criterio_campo, $tipo_servicio, $criterio_oficina, $criterio_funcionario)
	{
		$datos = $this->requestAction('/reparacion_solicitudes/buscar_xls/'.$frase_busqueda.'/'.$criterio_fecha.'/'.$fecha_1.'/'.$fecha_2.'/'.$mostrar_solicitudes.'/'.$criterio_campo.'/'.$tipo_servicio);
		$this->set('filas_tabla',utf8_decode($datos['filas_tabla']));
		$this->set('total_registros',$datos['count']);
		$this->render('exportar_xls','exportar_xls');
	}
	
	//--------------------------------------------------------------------------
	
	function _cargar_tipos_servicio()
	{
		$tipos_servicio = array();
		$this->loadModel('TipoServicio');
		$tipos_servicio_info = $this->TipoServicio->find('all');
		foreach ( $tipos_servicio_info as $ts )
		{
			$tipos_servicio[$ts['TipoServicio']['id']] = $ts['TipoServicio']['name'];
		}
		return $tipos_servicio;
	}
	
	//--------------------------------------------------------------------------

	function buscar($frase_busqueda, $criterio_fecha, $fecha_1, $fecha_2, $mostrar_solicitudes, $criterio_campo, $tipo_servicio, $criterio_oficina, $criterio_funcionario)
	{
		$this->autoLayout = false;
		$this->autoRender = false;

		// Construimos el Query de Búskeda.
		$condiciones = array();
		$pre_con = array();
		$pre_con_like = array();
		if ( $criterio_fecha == 'anio_mes' )
		{
			if ( $fecha_1 != 0 )
			{
				$pre_con['YEAR(ReparacionSolicitud.created)'] = $fecha_1;
				if ( $fecha_2 != 0 )
				{
					$pre_con['MONTH(ReparacionSolicitud.created)'] = $fecha_2;
				}
			}
		}
		else if ( $criterio_fecha == 'rango_fecha' )
		{
			$pre_con['DATE(ReparacionSolicitud.created) >='] = $fecha_1;
			$pre_con['DATE(ReparacionSolicitud.created) <='] = $fecha_2;
		}
		if ( $tipo_servicio != 0 )
		{
			$pre_con['tipo_servicio'] = $tipo_servicio;
		}
		if ( $mostrar_solicitudes != 'todas' )
		{
			$pre_con['estado'] = $mostrar_solicitudes;
		}
		if ( $criterio_oficina != 0 )
		{
			$pre_con['Cencos_id'] = $criterio_oficina;
		}
		if ( $criterio_funcionario != 0 )
		{
			$pre_con['id_funcionario'] = $criterio_funcionario;
		}
		if ( $frase_busqueda != 'null' )
		{
			if ( $criterio_campo != 'todos' )
			{
				$condiciones[$criterio_campo.' LIKE'] = '%'.$frase_busqueda.'%';
			}
			else
			{
				$pre_con_like['solicitante LIKE'] = '%'.$frase_busqueda.'%';
				$pre_con_like['lugar LIKE'] = '%'.$frase_busqueda.'%';
				$pre_con_like['descripcion LIKE'] = '%'.$frase_busqueda.'%';
				$pre_con_like['observaciones LIKE'] = '%'.$frase_busqueda.'%';
				$pre_con_like['observaciones_solucion LIKE'] = '%'.$frase_busqueda.'%';
				$condiciones['OR'] = $pre_con_like;
			}
		}
		if ( count($pre_con) > 0 )
		{
			foreach ( $pre_con as $criterio => $crit_valor )
			{
				$condiciones[$criterio] = $crit_valor;
			}
		}
		
		$solicitudes = $this->ReparacionSolicitud->find('all', array
		(
			'conditions' => $condiciones
		));
		return json_encode($this->_crear_filas($solicitudes));
	}
	
	//--------------------------------------------------------------------------
	
	function buscar_xls($frase_busqueda, $criterio_fecha, $fecha_1, $fecha_2, $mostrar_solicitudes, $criterio_campo, $tipo_servicio, $criterio_oficina, $criterio_funcionario)
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		
		// Construimos el Query de Búskeda.
		$condiciones = array();
		$pre_con = array();
		$pre_con_like = array();
		if ( $criterio_fecha == 'anio_mes' )
		{
			if ( $fecha_1 != 0 )
			{
				$pre_con['YEAR(created)'] = $fecha_1;
				if ( $fecha_2 != 0 )
				{
					$pre_con['MONTH(created)'] = $fecha_2;
				}
			}
		}
		else if ( $criterio_fecha == 'rango_fecha' )
		{
			$pre_con['DATE(created) >='] = $fecha_1;
			$pre_con['DATE(created) <='] = $fecha_2;
		}
		if ( $tipo_servicio != 0 )
		{
			$pre_con['tipo_servicio'] = $tipo_servicio;
		}
		if ( $mostrar_solicitudes != 'todas' )
		{
			$pre_con['estado'] = $mostrar_solicitudes;
		}
		if ( $criterio_oficina != 0 )
		{
			$pre_con['Cencos_id'] = $criterio_oficina;
		}
		if ( $frase_busqueda != 'null' )
		{
			if ( $criterio_campo != 'todos' )
			{
				$condiciones[$criterio_campo.' LIKE'] = '%'.$frase_busqueda.'%';
			}
			else
			{
				$pre_con_like['solicitante LIKE'] = '%'.$frase_busqueda.'%';
				$pre_con_like['lugar LIKE'] = '%'.$frase_busqueda.'%';
				$pre_con_like['encargado_servicio LIKE'] = '%'.$frase_busqueda.'%';
				$pre_con_like['descripcion LIKE'] = '%'.$frase_busqueda.'%';
				$pre_con_like['observaciones LIKE'] = '%'.$frase_busqueda.'%';
				$pre_con_like['observaciones_solucion LIKE'] = '%'.$frase_busqueda.'%';
				$condiciones['OR'] = $pre_con_like;
			}
		}
		if ( count($pre_con) > 0 )
		{
			foreach ( $pre_con as $criterio => $crit_valor )
			{
				$condiciones[$criterio] = $crit_valor;
			}
		}
		
		$solicitudes_info = $this->ReparacionSolicitud->find('all', array
		(
			'conditions' => $condiciones
		));
		return $this->_crear_filas_xls($solicitudes_info);
	}
	
	//--------------------------------------------------------------------------
	
	function _crear_filas($solicitudes_info)
	{
		$datos_json['resultado'] = false;
		if ( !empty($solicitudes_info) )
		{
			$filas_tabla = '';
			$ts = $this->_cargar_tipos_servicio();
			foreach ( $solicitudes_info as $solicitud )
			{
				$nombre_oficina = mb_convert_case($solicitud['CentroCosto']['Cencos_nombre'], MB_CASE_TITLE, "UTF-8");
				$filas_tabla .= '<tr><td><a href="/reparacion_solicitudes/ver/'.$solicitud['ReparacionSolicitud']['id'].'" title="Ver información completa de la solicitud" alt="Ver información completa de la solicitud" target="_self">'.$solicitud['ReparacionSolicitud']['id'].'</a></td>';
				$filas_tabla .= '<td>'.$nombre_oficina.'</td>';
				$filas_tabla .= '<td>'.$solicitud['ReparacionSolicitud']['solicitante'].'</td>';
				$filas_tabla .= '<td>'.$solicitud['ReparacionSolicitud']['lugar'].'</td>';
				$filas_tabla .= '<td>'.$ts[$solicitud['ReparacionSolicitud']['tipo_servicio']].'</td>';
				$filas_tabla .= '<td>'.$solicitud['ReparacionSolicitud']['created'].'</td>';
				$filas_tabla .= '<td>'.$this->estados[$solicitud['ReparacionSolicitud']['estado']].'</td></tr>';
			}
			$datos_json['filas_tabla'] = $filas_tabla;
			$datos_json['count'] = count($solicitudes_info);
			$datos_json['resultado'] = true;
		}
		return $datos_json;
	}
	
	//--------------------------------------------------------------------------
	
	function _crear_filas_xls($solicitudes_info)
	{
		$datos_json['resultado'] = false;
		if ( !empty($solicitudes_info) )
		{
			$ts = $this->_cargar_tipos_servicio();
			$asterisco = '*';
			foreach ( $solicitudes_info as $solicitud )
			{
				if ( empty($solicitud['ReparacionSolicitud']['descripcion']) )
				{
					$solicitud['ReparacionSolicitud']['descripcion'] = $asterisco;
				}
				if ( empty($solicitud['ReparacionSolicitud']['observaciones']) )
				{
					$solicitud['ReparacionSolicitud']['observaciones'] = $asterisco;
				}
				if ( empty($solicitud['ReparacionSolicitud']['observaciones_solucion']) )
				{
					$solicitud['ReparacionSolicitud']['observaciones_solucion'] = $asterisco;
				}
				if ( empty($solicitud['ReparacionSolicitud']['tiempo_estimado']) )
				{
					$solicitud['ReparacionSolicitud']['tiempo_estimado'] = $asterisco;
				}
				$nombre_oficina = mb_convert_case($solicitud['CentroCosto']['Cencos_nombre'], MB_CASE_TITLE, "UTF-8");
				$filas_tabla .= '<tr><td>'.$solicitud['ReparacionSolicitud']['id'].'</td>';
				$filas_tabla .= '<td>'.$nombre_oficina.'</td>';
				$filas_tabla .= '<td>'.$solicitud['ReparacionSolicitud']['solicitante'].'</td>';
				$filas_tabla .= '<td>'.$solicitud['ReparacionSolicitud']['email_solicitante'].'</td>';
				$filas_tabla .= '<td>'.$solicitud['ReparacionSolicitud']['lugar'].'</td>';
				$filas_tabla .= '<td>'.$ts[$solicitud['ReparacionSolicitud']['tipo_servicio']].'</td>';
				$filas_tabla .= '<td>'.$solicitud['ReparacionSolicitud']['descripcion'].'</td>';
				$filas_tabla .= '<td>'.$solicitud['ReparacionSolicitud']['observaciones'].'</td>';
				$filas_tabla .= '<td>'.$solicitud['Funcionario']['nombre'].'</td>';
				$filas_tabla .= '<td>'.$solicitud['ReparacionSolicitud']['tiempo_estimado'].'</td>';
				$filas_tabla .= '<td>'.$solicitud['ReparacionSolicitud']['observaciones_solucion'].'</td>';
				$filas_tabla .= '<td>'.$solicitud['ReparacionSolicitud']['created'].'</td>';
				$filas_tabla .= '<td>'.$solicitud['ReparacionSolicitud']['archivada'].'</td>';
				$filas_tabla .= '<td>'.$this->estados_solucion[$solicitud['ReparacionSolicitud']['ejecutada']].'</td>';
				$filas_tabla .= '<td>'.$this->estados[$solicitud['ReparacionSolicitud']['estado']].'</td></tr>';
			}
			$datos_json['filas_tabla'] = $filas_tabla;
			$datos_json['count'] = count($solicitudes_info);
			$datos_json['resultado'] = true;
		}
		return $datos_json;
	}
	
	//--------------------------------------------------------------------------
	
	function email()
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		$this->Email->template = 'email/default';
		
		$id_solicitud = $this->Session->read('Email.id_solicitud');
		$email_solicitante = $this->Session->read('Email.email_solicitante');
		$solicitud_info = $this->ReparacionSolicitud->read(null, $id_solicitud);
		if ( !empty($solicitud_info) )
		{
			$nombre_oficina = mb_convert_case($solicitud_info['CentroCosto']['Cencos_nombre'], MB_CASE_TITLE, "UTF-8");
			$solicitud_info['CentroCosto']['Cencos_nombre'] = $nombre_oficina;
			$tmp = split(' ', $solicitud_info['ReparacionSolicitud']['created']);
			$fecha = $tmp[0];
			list($anio, $mes, $dia) = split('-', $fecha);
			$solicitud_info['ReparacionSolicitud']['fecha_solicitud'] = $this->Tiempo->fecha_espaniol(date('Y-n-j-N', mktime(0,0,0,$mes, $dia, $anio)));
			$this->set('solicitud', $solicitud_info);
			$this->Email->to = $email_solicitante;
			$this->Email->subject = 'Información: Solicitud de Reparación #'.$id_solicitud;
			
			//$this->Email->attach($fully_qualified_filename, optionally $new_name_when_attached);
			// You can attach as many files as you like.
			
			$result = $this->Email->send();
			if ( !$result )
			{
				return 'false';
			}
			else
			{
				return 'true';
			}
		}
		else
		{
			return 'false';
		}
	}
	
	//--------------------------------------------------------------------------
}
?>
