<?php
class ApoyoEventoSolicitudesController extends AppController
{
	var $name = 'ApoyoEventoSolicitudes';
	var $uses = array('ApoyoEventoSolicitud', 'Insumo', 'InsumosEvento');
	var $components = array('Tiempo', 'Email');
	var $helpers = array('Html', 'Javascript', 'Xls');
	var $id_grupo = '*';
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
	var $encabezado_apoyo_evento_pdf =
	'<table width="100%" cellspacing="0" cellpadding="3" border="1"><tbody>
		<tr align="left">
			<td width="85"><img src="http://smuqplaf.uniquindio.edu.co/img/logouq.gif" alt="" /></td>
			<td width="*" colspan="3" align="right"><br/><br/><b>UNIVERSIDAD DEL QUINDIO<br/>SISTEMA INTEGRADO DE GESTIÓN</b></td>
		</tr>
		<tr align="right" valign="middle">
			<td width="85"></td>
			<td width="200"><b>Código:</b> A.AC-01.00.03.F.01</td>
			<td width="160"><b>Versión:</b> 3</td>
			<td width="*"><b>Fecha:</b> 2010/5/12</td>
		</tr>
		<tr align="left"><td width="*" align="center" colspan="4"><b>FORMATO DE SOLICITUD DE APOYO A EVENTOS</b></td></tr>
	</tbody></table>';

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

	function _info_solicitud_pdf($id)
	{
		$solicitud_info = $this->ApoyoEventoSolicitud->read(null, $id);
		if ( !empty($solicitud_info) )
		{
			$tmp = split(' ', $solicitud_info['ApoyoEventoSolicitud']['created']);
			$fecha = $tmp[0];
			list($anio, $mes, $dia) = split('-', $fecha);
			$solicitud_info['ApoyoEventoSolicitud']['fecha_solicitud'] = $this->Tiempo->fecha_espaniol(date('Y-n-j-N', mktime(0,0,0,$mes, $dia, $anio)));

			list($anio, $mes, $dia) = split('-', $solicitud_info['ApoyoEventoSolicitud']['fecha_evento']);
			$solicitud_info['ApoyoEventoSolicitud']['fecha_evento'] = $this->Tiempo->fecha_espaniol(date('Y-n-j-N', mktime(0,0,0,$mes, $dia, $anio)));
			$nombre_oficina = mb_convert_case($solicitud_info['CentroCosto']['Cencos_nombre'], MB_CASE_TITLE, "UTF-8");

			$insumos = '';
			$insumos_del_evento = $this->InsumosEvento->find('all', array
			(
				'fields' => array('InsumosEvento.id_insumo'),
				'conditions' => array('InsumosEvento.id_evento'=>$id)
			));
			if ( !empty($insumos_del_evento) )
			{
				$insumos = '<ul>';
				$insumos_actuales = $this->Insumo->find('list');
				foreach ( $insumos_del_evento as $insumo )
				{
					$insumos .= '<li>'.$insumos_actuales[$insumo['InsumosEvento']['id_insumo']].'</li>';
				}
				$insumos .= '</ul>';
			}

			$solucionada = '';
			if ( $solicitud_info['ApoyoEventoSolicitud']['estado'] == 'a' )
			{
				$solucionada = '
				<tr align="left"><td width="*" align="center"><b>SOLUCIÓN A LA SOLICITUD</b></td></tr>
				<tr align="left">
					<td width="163"><b>La solicitud fué:</b></td>
					<td width="*" colspan="2">'.$this->estados_solucion[$solicitud_info['ApoyoEventoSolicitud']['ejecutada']].'</td>
				</tr>
				<tr align="left">
					<td width="163"><b>Observaciones a la solución:</b></td>
					<td width="*" colspan="2">'.$solicitud_info['ApoyoEventoSolicitud']['observaciones_solucion'].'</td>
				</tr>';
			}

			$filas_tabla =
			'<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
				<tr align="left">
					<td colspan="2">'.$this->encabezado_apoyo_evento_pdf.'</td>
				</tr>

				<tr><td height="15" colspan="2"></td></tr>
				<tr align="left">
					<td colspan="2" width="*"><div>
						<table width="100%" cellspacing="0" cellpadding="5" border="1"><tbody>
							<tr align="left">
								<td width="163"><b>Solicitud No:</b></td>
								<td width="*">'.$solicitud_info['ApoyoEventoSolicitud']['id'].'</td>
							</tr>
							<tr align="left">
								<td width="163"><b>Fecha de la solicitud:</b></td>
								<td width="*">'.$solicitud_info['ApoyoEventoSolicitud']['fecha_solicitud'].'</td>
							</tr>
							<tr align="left">
								<td width="163"><b>Estado de la solicitud:</b></td>
								<td width="*">'.$this->estados[$solicitud_info['ApoyoEventoSolicitud']['estado']].'</td>
							</tr>
							<tr align="left">
								<td width="163"><b>Oficina que solicita el apoyo:</b></td>
								<td width="*">'.$nombre_oficina.'</td>
							</tr>
						</tbody></table>
					</div></td>
				</tr>

				<tr><td height="15" colspan="2"></td></tr>

				<tr align="left">
					<td colspan="2" width="*"><div>
						<table width="100%" cellspacing="0" cellpadding="5" border="1"><tbody>
							<tr align="left">
								<td width="163"><b>Nombre del evento:</b></td>
								<td width="*">'.$solicitud_info['ApoyoEventoSolicitud']['nombre'].'</td>
							</tr>
							<tr align="left">
								<td width="163"><b>Fecha del evento:</b></td>
								<td width="*">'.$solicitud_info['ApoyoEventoSolicitud']['fecha_evento'].'</td>
							</tr>
							<tr align="left">
								<td width="163"><b>Lugar del evento:</b></td>
								<td width="*">'.$solicitud_info['ApoyoEventoSolicitud']['lugar'].'</td>
							</tr>
							<tr align="left">
								<td width="163"><b>Solicitante:</b></td>
								<td width="*">'.$solicitud_info['ApoyoEventoSolicitud']['solicitante'].'</td>
							</tr>
							<tr align="left">
								<td width="163"><b>No. de Asistentes al evento:</b></td>
								<td width="*">'.$solicitud_info['ApoyoEventoSolicitud']['num_asistentes'].'</td>
							</tr>
							<tr align="left">
								<td width="163"><b>Insumos:</b></td>
								<td width="*">'.$insumos.'</td>
							</tr>
							<tr align="left">
								<td width="163"><b>Observaciones:</b></td>
								<td width="*"><div class="div_solucion">'.$solicitud_info['ApoyoEventoSolicitud']['observaciones'].'</div></td>
							</tr>
						</tbody></table>
					</div></td>
				</tr>

				<tr><td height="15" colspan="2"></td></tr>

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
					<td width="*" align="center"><b>FIRMA SOLICITANTE</b></td>
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
		$solicitudes_info = $this->ApoyoEventoSolicitud->find('all', array
		(
			'conditions' => array('ApoyoEventoSolicitud.id'=>$id)
		));
		return json_encode($this->_crear_filas($solicitudes_info));
	}

	//--------------------------------------------------------------------------

	function crear()
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		if ( !empty($this->data) )
		{
			$this->data['ApoyoEventoSolicitud']['estado'] = 'p';
			if ( $this->ApoyoEventoSolicitud->save($this->data) )
			{
				if ( isset($this->data['insumos']) )
				{
					$id_nueva_solicitud = $this->ApoyoEventoSolicitud->id;
					$insumos_del_evento = array();
					foreach ( $this->data['insumos'] as $insumo )
					{
						$insumos_del_evento['InsumosEvento'][] = array
						(
							'id_evento'=>$id_nueva_solicitud,
							'id_insumo'=>$insumo
						);
					}
					$this->InsumosEvento->saveAll($insumos_del_evento['InsumosEvento']);
				}
				$this->Session->write('Email.id_solicitud', $this->ApoyoEventoSolicitud->id);
				$this->Session->write('Email.email_solicitante', $this->data['ApoyoEventoSolicitud']['email_solicitante']);
				if ( $this->requestAction('apoyo_evento_solicitudes/email', array('return'=>'')) == 'true' )
				{
					$this->Session->write('Controlador.resultado_email', 'exito');
				}
				else
				{
					$this->Session->write('Controlador.resultado_email', 'error');
				}
				$this->Session->write('Controlador.resultado_guardar', 'exito');
				$this->Session->write('Controlador.resultado_id', $this->ApoyoEventoSolicitud->id);
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

		$solicitud_info = $this->ApoyoEventoSolicitud->read(null, $id);

		if ( !empty($solicitud_info) )
		{
			$tmp = split(' ', $solicitud_info['ApoyoEventoSolicitud']['created']);
			$fecha = $tmp[0];
			list($anio, $mes, $dia) = split('-', $fecha);
			$solicitud_info['ApoyoEventoSolicitud']['fecha_solicitud'] = $this->Tiempo->fecha_espaniol(date('Y-n-j-N', mktime(0,0,0,$mes, $dia, $anio)));

			$nombre_evento = mb_convert_case($solicitud_info['ApoyoEventoSolicitud']['nombre'], MB_CASE_TITLE, "UTF-8");
			$solicitud_info['ApoyoEventoSolicitud']['nombre'] = $nombre_evento;

			$nombre_cenco = mb_convert_case($solicitud_info['CentroCosto']['Cencos_nombre'], MB_CASE_TITLE, "UTF-8");
			$solicitud_info['CentroCosto']['Cencos_nombre'] = $nombre_cenco;

			list($anio, $mes, $dia) = split('-', $solicitud_info['ApoyoEventoSolicitud']['fecha_evento']);
			$solicitud_info['ApoyoEventoSolicitud']['fecha_evento'] = $this->Tiempo->fecha_espaniol(date('Y-n-j-N', mktime(0,0,0,$mes, $dia, $anio)));

			$insumos = '<ul>';
			$insumos_del_evento = $this->InsumosEvento->find('all', array
			(
				'fields' => array('InsumosEvento.id_insumo'),
				'conditions' => array('InsumosEvento.id_evento'=>$id)
			));
			if ( !empty($insumos_del_evento) )
			{
				$insumos_actuales = $this->Insumo->find('list');
				foreach ( $insumos_del_evento as $insumo )
				{
					$insumos .= '<li>'.$insumos_actuales[$insumo['InsumosEvento']['id_insumo']].'</li>';
				}
				$insumos .= '</ul>';
			}

			$opciones_menu = $this->requestAction(array('controller' => 'adm_principal',
																		  'action' => 'get_opciones_menu'));
			$this->set('opciones_menu', $opciones_menu);
			$this->set('insumos', $insumos);
			$this->set('solicitud', $solicitud_info);
			$this->set('opcion_seleccionada', 'consultar_apoyo_eventos');
			if ( $solicitud_info['ApoyoEventoSolicitud']['estado'] == 'a' )
			{
				$this->set('display_archivar', 'none');
				$this->set('display_div_ejecutada', 'block');
				$this->set('display_select_ejecutada', 'none');
				$this->set('ejecutada', $this->estados_solucion[$solicitud_info['ApoyoEventoSolicitud']['ejecutada']]);

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
			$this->data['ApoyoEventoSolicitud']['estado'] = 'a';
			$this->data['ApoyoEventoSolicitud']['archivada'] = date('Y-m-d H:i:s');
			$solicitud_info = $this->ApoyoEventoSolicitud->read(null, $id);

			if ( $this->ApoyoEventoSolicitud->save($this->data) )
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

	function exportar_xls($frase_busqueda, $criterio_fecha, $fecha_1, $fecha_2, $mostrar_solicitudes, $criterio_campo, $criterio_oficina)
	{
		// Se obtienen los resultados de la acción+parametros
		$datos = $this->requestAction('/apoyo_evento_solicitudes/buscar_xls/'.$frase_busqueda.'/'.$criterio_fecha.'/'.$fecha_1.'/'.$fecha_2.'/'.$mostrar_solicitudes.'/'.$criterio_campo.'/'.$criterio_oficina);
		$this->set('filas_tabla',utf8_decode($datos['filas_tabla']));
		$this->set('total_registros',$datos['count']);
		$this->render('exportar_xls','exportar_xls');
	}

	//--------------------------------------------------------------------------

	function buscar($frase_busqueda, $criterio_fecha, $fecha_1, $fecha_2, $mostrar_solicitudes, $criterio_campo, $criterio_oficina)
	{
		$this->autoLayout = false;
		$this->autoRender = false;

		// Construimos el Query de Búsqueda.
		$condiciones = array();
		$pre_con = array();
		$pre_con_like = array();
		if ( $criterio_fecha == 'anio_mes' )
		{
			if ( $fecha_1 != 0 )
			{
				$pre_con['YEAR(fecha_evento)'] = $fecha_1;
				if ( $fecha_2 != 0 )
				{
					$pre_con['MONTH(fecha_evento)'] = $fecha_2;
				}
			}
		}
		else if ( $criterio_fecha == 'rango_fecha' )
		{
			$pre_con['DATE(fecha_evento) >='] = $fecha_1;
			$pre_con['DATE(fecha_evento) <='] = $fecha_2;
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
				$pre_con_like['nombre LIKE'] = '%'.$frase_busqueda.'%';
				$pre_con_like['lugar LIKE'] = '%'.$frase_busqueda.'%';
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

		$solicitudes = $this->ApoyoEventoSolicitud->find('all', array
		(
			'conditions' => $condiciones
		));
		return json_encode($this->_crear_filas($solicitudes));
	}

	//--------------------------------------------------------------------------

	function buscar_xls($frase_busqueda, $criterio_fecha, $fecha_1, $fecha_2, $mostrar_solicitudes, $criterio_campo, $criterio_oficina)
	{
		$this->autoLayout = false;
		$this->autoRender = false;

		// Construimos el Query de Búsqueda.
		$condiciones = array();
		$pre_con = array();
		$pre_con_like = array();
		if ( $criterio_fecha == 'anio_mes' )
		{
			if ( $fecha_1 != 0 )
			{
				$pre_con['YEAR(fecha_evento)'] = $fecha_1;
				if ( $fecha_2 != 0 )
				{
					$pre_con['MONTH(fecha_evento)'] = $fecha_2;
				}
			}
		}
		else if ( $criterio_fecha == 'rango_fecha' )
		{
			$pre_con['DATE(fecha_evento) >='] = $fecha_1;
			$pre_con['DATE(fecha_evento) <='] = $fecha_2;
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
				$pre_con_like['nombre LIKE'] = '%'.$frase_busqueda.'%';
				$pre_con_like['lugar LIKE'] = '%'.$frase_busqueda.'%';
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

		$solicitudes_info = $this->ApoyoEventoSolicitud->find('all', array
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
			foreach ( $solicitudes_info as $solicitud )
			{
				$nombre_standard = mb_convert_case($solicitud['CentroCosto']['Cencos_nombre'], MB_CASE_TITLE, "UTF-8");
				$filas_tabla .= '<tr><td><a href="/apoyo_evento_solicitudes/ver/'.$solicitud['ApoyoEventoSolicitud']['id'].'" title="Ver información completa de la solicitud" alt="Ver información completa de la solicitud" target="_self">'.$solicitud['ApoyoEventoSolicitud']['id'].'</a></td>';
				$filas_tabla .= '<td>'.$nombre_standard.'</td>';
				$filas_tabla .= '<td>'.$solicitud['ApoyoEventoSolicitud']['solicitante'].'</td>';
				$filas_tabla .= '<td>'.$solicitud['ApoyoEventoSolicitud']['lugar'].'</td>';
				$filas_tabla .= '<td>'.$solicitud['ApoyoEventoSolicitud']['fecha_evento'].'</td>';
				$filas_tabla .= '<td>'.$this->estados[$solicitud['ApoyoEventoSolicitud']['estado']].'</td></tr>';

				//$filas_tabla .= '<td>'.$solicitud['ApoyoEventoSolicitud']['archivada'].'</td></tr>';
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
			foreach ( $solicitudes_info as $solicitud )
			{
				$insumos = '';
				$insumos_del_evento = $this->InsumosEvento->find('all', array
				(
					'fields' => array('InsumosEvento.id_insumo'),
					'conditions' => array('InsumosEvento.id_evento'=>$solicitud['ApoyoEventoSolicitud']['id'])
				));
				if ( !empty($insumos_del_evento) )
				{
					$insumos_actuales = $this->Insumo->find('list');
					foreach ( $insumos_del_evento as $insumo )
					{
						$insumos .= $insumos_actuales[$insumo['InsumosEvento']['id_insumo']].', ';
					}
					$insumos = substr($insumos, 0, -2);
				}
				if ( empty($solicitud['ApoyoEventoSolicitud']['observaciones']) )
				{
					$solicitud['ApoyoEventoSolicitud']['observaciones'] = '*';
				}
				$nombre_oficina = mb_convert_case($solicitud['CentroCosto']['Cencos_nombre'], MB_CASE_TITLE, "UTF-8");
				$filas_tabla .= '<tr><td>'.$solicitud['ApoyoEventoSolicitud']['id'].'</td>';
				$filas_tabla .= '<td>'.$nombre_oficina.'</td>';
				$filas_tabla .= '<td>'.$solicitud['ApoyoEventoSolicitud']['solicitante'].'</td>';
				$filas_tabla .= '<td>'.$solicitud['ApoyoEventoSolicitud']['email_solicitante'].'</td>';
				$filas_tabla .= '<td>'.$solicitud['ApoyoEventoSolicitud']['nombre'].'</td>';
				$filas_tabla .= '<td>'.$solicitud['ApoyoEventoSolicitud']['lugar'].'</td>';
				$filas_tabla .= '<td>'.$solicitud['ApoyoEventoSolicitud']['num_asistentes'].'</td>';
				$filas_tabla .= '<td>'.$insumos.'</td>';
				$filas_tabla .= '<td>'.$solicitud['ApoyoEventoSolicitud']['observaciones'].'</td>';
				$filas_tabla .= '<td>'.$solicitud['ApoyoEventoSolicitud']['fecha_evento'].'</td>';
				$filas_tabla .= '<td>'.$solicitud['ApoyoEventoSolicitud']['created'].'</td>';
				$filas_tabla .= '<td>'.$this->estados[$solicitud['ApoyoEventoSolicitud']['estado']].'</td>';
				$filas_tabla .= '<td>'.$solicitud['ApoyoEventoSolicitud']['archivada'].'</td>';
				$filas_tabla .= '<td>'.$solicitud['ApoyoEventoSolicitud']['observaciones_solucion'].'</td>';
				$filas_tabla .= '<td>'.$this->estados_solucion[$solicitud['ApoyoEventoSolicitud']['ejecutada']].'</td></tr>';
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
		$solicitud_info = $this->ApoyoEventoSolicitud->read(null, $id_solicitud);
		if ( !empty($solicitud_info) )
		{
			$tmp = split(' ', $solicitud_info['ApoyoEventoSolicitud']['created']);
			$fecha = $tmp[0];
			list($anio, $mes, $dia) = split('-', $fecha);
			$solicitud_info['ApoyoEventoSolicitud']['fecha_solicitud'] = $this->Tiempo->fecha_espaniol(date('Y-n-j-N', mktime(0,0,0,$mes, $dia, $anio)));
			list($anio, $mes, $dia) = split('-', $solicitud_info['ApoyoEventoSolicitud']['fecha_evento']);
			$solicitud_info['ApoyoEventoSolicitud']['fecha_evento'] = $this->Tiempo->fecha_espaniol(date('Y-n-j-N', mktime(0,0,0,$mes, $dia, $anio)));
			$solicitud_info['ApoyoEventoSolicitud']['estado'] = $this->estados[$solicitud_info['ApoyoEventoSolicitud']['estado']];
			$solicitud_info['CentroCosto']['Cencos_nombre'] = mb_convert_case($solicitud_info['CentroCosto']['Cencos_nombre'], MB_CASE_TITLE, "UTF-8");
			$solicitud_info['ApoyoEventoSolicitud']['ejecutada'] = $this->estados_solucion[$solicitud_info['ApoyoEventoSolicitud']['ejecutada']];

			$insumos = '<ul>';
			$insumos_del_evento = $this->InsumosEvento->find('all', array
			(
				'fields' => array('InsumosEvento.id_insumo'),
				'conditions' => array('InsumosEvento.id_evento'=>$id_solicitud)
			));
			if ( !empty($insumos_del_evento) )
			{
				$insumos_actuales = $this->Insumo->find('list');
				foreach ( $insumos_del_evento as $insumo )
				{
					$insumos .= '<li>'.$insumos_actuales[$insumo['InsumosEvento']['id_insumo']].'</li>';
				}
				$insumos .= '</ul>';
			}

			$this->set('encabezado_pdf', $this->encabezado_apoyo_evento_pdf);
			$this->set('solicitud', $solicitud_info);
			$this->set('insumos', $insumos);
			$this->Email->to = $email_solicitante;
			$this->Email->subject = 'Información: Solicitud de Apoyo a Eventos #'.$id_solicitud;

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
