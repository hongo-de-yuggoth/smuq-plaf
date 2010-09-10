<?php
class UsuariosController extends AppController
{
	var $name = 'Usuarios';
	var $helpers = array('Html', 'Form', 'Javascript');
	var $id_grupo = '*';
	
	//--------------------------------------------------------------------------
	
	function exportar_xls($accion, $parametro)
	{
		// Se obtienen los resultados de la acción+parametros
		$filas_tabla = $this->requestAction('/usuarios/'.$accion.'/'.$parametro);
		
		// Separamos el valor final (total registros)
		$tmp = array();
		$tmp = split("_-_@", $filas_tabla);
		
		$this->set('filas_tabla',utf8_decode($tmp[0]));
		$this->set('total_registros',$tmp[1]);
		$this->render('exportar_xls','exportar_xls');
	}
	
	//--------------------------------------------------------------------------
	
	function _autenticado($data)
	{
		if ( !empty($data) )
		{
			$this->Usuario->recursive = 1;
			$usuario = $this->Usuario->find('first', array
			(
				'conditions' => array
				(
					'Usuario.login' => strtolower($data['Usuario']['login']),
					'Usuario.clave' => Security::hash($data['Usuario']['clave'], null, true)
				)
			));
			
			if ( !empty($usuario) )
			{
				$this->Session->write('Usuario.id', $usuario['Usuario']['id']);
				$this->Session->write('Usuario.id_grupo', $usuario['Usuario']['id_grupo']);
				$this->Session->write('Usuario.nombre', mb_convert_case($usuario['CentroCosto']['Cencos_nombre'], MB_CASE_TITLE, "UTF-8"));
				return true;
			}
			else
			{
				$this->Session->delete('Usuario.id');
				$this->Session->delete('Usuario.id_grupo');
			}
		}
		return false;
	}
	

	//--------------------------------------------------------------------------

	function login()
	{
		// Si no está autenticado, mire a ver si autentica o nó.
		if ( !$this->Session->check('Usuario.id') )
		{
			// Si se envió datos de login -> Autenticar
			if ( !empty($this->data) )
			{
				if ( $this->_autenticado($this->data) )
				{
					$this->data = null;
					$this->Session->write('Controlador.resultado', '');
					$this->redirect(array('controller' => 'usuarios',
												 'action' => 'ir_a_casa'));
				}
				else
				{
					$this->data = null;
					$this->Session->write('Controlador.resultado', 'error');
					$this->set('mensaje_notificacion', 'No se pudo iniciar la sesión. Por favor revise su login y clave.');
				}
			}
			else
			{
				// Revisamos variables de Session.
				if ( $this->Session->check('Controlador.resultado') )
				{
					if ( $this->Session->read('Controlador.resultado') == 'error' )
					{
						$this->set('mensaje_notificacion', 'No se pudo iniciar la sesión. Por favor revise su login y clave.');
					}
				}
				
				$this->set('mensaje_notificacion', 'Viene de ningun lado...');
				$this->Session->write('Controlador.resultado', '');
			}
		}
		else
		{
			$this->data = null;
			$this->Session->write('Controlador.resultado', '');
			$this->redirect(array('controller' => 'usuarios',
										'action' => 'ir_a_casa'));
		}
	}
	
	//--------------------------------------------------------------------------
	
	function logout()
	{
		$this->Session->destroy();
		$this->redirect(array('controller' => 'usuarios',
									 'action' => 'login'));
	}
	
	//--------------------------------------------------------------------------
	
	function denegado()
	{
		$this->set('refererido', $this->Session->read('referer'));
		//$this->Session->delete('referer');
	}
	
	//--------------------------------------------------------------------------
	
	function index()
	{
	}
	
	//--------------------------------------------------------------------------
	
	function ir_a_casa()
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		
		if ( $this->Session->check('Usuario.id_grupo') )
		{
			$id_grupo = $this->Session->read('Usuario.id_grupo');
			// Se define a que grupo pertenece el usuario y luego se le lleva a su "casa"
			if ( $id_grupo == '1' )
			{
				$this->redirect(array('controller' => 'adm_principal',
											'action' => 'consultar_apoyo_eventos'));
			}
			else if ( $id_grupo == '2' )
			{
				$this->redirect(array('controller' => 'usr_cenco',
											'action' => 'crear_solicitud_apoyo_evento'));
			}
		}
		$this->redirect($this->referer());
	}
	
	//--------------------------------------------------------------------------
	
	function existe_cedula($cedula)
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		
		$usuario = $this->Usuario->find('first', array('conditions' => array('Usuario.cedula' => $cedula)));
		if ( !empty($usuario) )
		{
			return 'true';
		}
		else
		{
			return 'false';
		}
	}
	
	//--------------------------------------------------------------------------
	
	function existe_login($login)
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		
		$usuario = $this->Usuario->find('first', array('conditions' => array('Usuario.login' => strtolower($login))));
		if ( !empty($usuario) )
		{
			echo 'true';
		}
		else
		{
			echo 'false';
		}
	}
	
	//--------------------------------------------------------------------------
	
	function cargar_select($id_dependencia)
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		
		$usuarios_info = $this->Usuario->find('all', array('conditions' => array('Usuario.id_dependencia' => $id_dependencia)));
		
		$opciones = '';
		foreach ( $usuarios_info as $usuario )
		{
			$opciones .= '<option value="'.$usuario['Usuario']['id'].'">'.$usuario['Usuario']['nombre'].'</option>';
		}
		
		return $opciones;
	}
	
	//--------------------------------------------------------------------------
	
	function cargo_ajax($id_usuario)
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		
		$usuario = $this->Usuario->findById($id_usuario);
		if ( !empty($usuario) )
		{
			echo $usuario['Usuario']['cargo'];
		}
		else
		{
			echo '';
		}
	}
	
	//--------------------------------------------------------------------------
	
	function buscar_usuario_modificar($cedula)
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		$this->loadModel('Edificio');
		$this->loadModel('Dependencia');
		
		$usuario_info = $this->Usuario->find('first', array('conditions' => array('Usuario.cedula' => $cedula)));
		
		if ( !empty($usuario_info) )
		{
			// Revisamos que este usuario no sea un ADMIN PRINCIPAL.
			if ( $usuario_info['Usuario']['id_grupo'] != '1' )
			{
				$dependencia_info = $this->Dependencia->findById($usuario_info['Usuario']['id_dependencia']);
				
				if ( !empty($dependencia_info) )
				{
					$edificio_info = $this->Edificio->findById($dependencia_info['Dependencia']['id_edificio']);
					
					if ( !empty($edificio_info) )
					{
						// creamos inputs hidden
						$input_id = '<input id="id_usuario" name="data[Usuario][id]" type="hidden" value="'.$usuario_info['Usuario']['id'].'"/>';
						$input_login = '<input id="login_usuario" type="hidden" value="'.$usuario_info['Usuario']['login'].'"/>';
						$input_tipo_usuario = '<input id="tipo_usuario_usuario" type="hidden" value="'.$usuario_info['Usuario']['id_grupo'].'"/>';
						$input_id_dependencia = '<input id="id_dependencia_usuario" type="hidden" value="'.$usuario_info['Usuario']['id_dependencia'].'"/>';
						$input_nombre = '<input id="nombre_usuario" type="hidden" value="'.$usuario_info['Usuario']['nombre'].'"/>';
						$input_cedula = '<input id="cedula_usuario" type="hidden" value="'.$cedula.'"/>';
						$input_cargo = '<input id="cargo_usuario" type="hidden" value="'.$usuario_info['Usuario']['cargo'].'"/>';
						$input_email = '<input id="email_usuario" type="hidden" value="'.$usuario_info['Usuario']['email'].'"/>';
						$input_id_edificio = '<input id="id_edificio_usuario" type="hidden" value="'.$dependencia_info['Dependencia']['id_edificio'].'"/>';
						$input_dependencia = '<input id="dependencia" name="data[Usuario][id_dependencia]" type="hidden" value="'.$usuario_info['Usuario']['id_dependencia'].'"/>';
						$input_nombre_edificio = '<input id="nombre_edificio" type="hidden" value="'.$edificio_info['Edificio']['name'].'"/>';
						$input_nombre_dependencia = '<input id="nombre_dependencia" type="hidden" value="'.$dependencia_info['Dependencia']['name'].'"/>';
						$input_encontro ='<input id="encontro" type="hidden" value="true"/>';
						
						return	$input_id.
									$input_nombre.
									$input_cedula.
									$input_login.
									$input_email.
									$input_cargo.
									$input_tipo_usuario.
									$input_id_edificio.
									$input_id_dependencia.
									$input_dependencia.
									$input_nombre_edificio.
									$input_nombre_dependencia.
									$input_encontro;
					}
				}
			}
		}
		
		return '<input id="encontro" type="hidden" value="false" />';
	}
	
	//--------------------------------------------------------------------------
	
	/*function crear()
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		
		if ( !empty($this->data) )
		{
			$this->data['Usuario']['clave'] = Security::hash($this->data['Usuario']['clave'], 'sha1', true);
			$this->data['Usuario']['login'] = strtolower($this->data['Usuario']['login']);
			$this->Usuario->create();
			
			if ( $this->Usuario->save($this->data) )
			{
				$this->Session->write('Controlador.resultado_guardar', 'exito');
			}
			else
			{
				$this->Session->write('Controlador.resultado_guardar', 'error');
			}
			
			$this->redirect($this->referer());
		}
	}*/
	
	//--------------------------------------------------------------------------
	
	/*
	 Función que permite resetear la cuenta del administrador principal del sistema.
		login: admin
		clave: a1b2c3
	*/
	function crear_admin_unico()
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		$this->Usuario->create();
		$this->data['Usuario']['id'] = 1;
		$this->data['Usuario']['clave'] = Security::hash('a1b2c3', 'sha1', true);
		$this->data['Usuario']['login'] = 'admin';
		$this->data['Usuario']['email'] = 'mantenimiento@uniquindio.edu.co';
		$this->data['Usuario']['id_grupo'] = 1;
		if ( $this->Usuario->save($this->data) )
		{
			$this->Session->write('Controlador.resultado_guardar', 'exito');
		}
		else
		{
			$this->Session->write('Controlador.resultado_guardar', 'error');
		}
		
		$this->redirect($this->referer());
	}
	
	//--------------------------------------------------------------------------
	
	/*
	 Función para crear todos los usuarios de cada centro de costo.
	*/
	function crear_usuarios()
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		$this->loadModel('CentroCosto');
		
		$cencos = $this->CentroCosto->find('all');
		$i = 0;
		foreach ( $cencos as $cenco )
		{
			$this->Usuario->create();
			$data = array();
			$data['Usuario']['login'] = $cenco['CentroCosto']['Cencos_id'];
			$data['Usuario']['id_grupo'] = '2';
			$data['Usuario']['clave'] = Security::hash($cenco['CentroCosto']['Cencos_id'], 'sha1', true);
			$data['Usuario']['Cencos_id'] = $cenco['CentroCosto']['Cencos_id'];
			if ( $this->Usuario->save($data) )
			{
				echo $i.': Cenco# '.$cenco['CentroCosto']['Cencos_id'].'  Salvado :)';
			}
			else
			{
				echo $i.': Cenco# '.$cenco['CentroCosto']['Cencos_id'].'  No pudo ser salvado :(';
			}
			$i++;
		}
	}
	
	//--------------------------------------------------------------------------
	
	function modificar()
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		
		if ( !empty($this->data) )
		{
			if ( $this->data['Usuario']['clave'] != '' )
			{
				$this->data['Usuario']['clave'] = Security::hash($this->data['Usuario']['clave'], 'sha1', true);
			}
			else
			{
				unset($this->data['Usuario']['clave']);
			}
			
			$this->data['Usuario']['login'] = strtolower($this->data['Usuario']['login']);
			$this->Usuario->read(null, $this->data['Usuario']['id']);
			
			if ( $this->Usuario->save($this->data) )
			{
				$this->Session->write('Controlador.resultado_guardar', 'exito');
			}
			else
			{
				$this->Session->write('Controlador.resultado_guardar', 'error');
			}
			
			$this->redirect($this->referer());
		}
	}
	
	//--------------------------------------------------------------------------
	
	function eliminar()
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		$this->loadModel('Equipo');
		$this->loadModel('Solicitud');
		
		$this->Session->write('Controlador.resultado_guardar', 'error');
		
		if ( !empty($this->data) )
		{
			// Primero se verifica si hay solicitudes y equipos dependientes.
			$solicitud = $this->Solicitud->find('first', array('conditions'=>array('Solicitud.id_usuario'=>$this->data['Usuario']['id'])));
			if ( empty($solicitud) )
			{
				$equipo = $this->Equipo->find('first', array('conditions'=>array('Equipo.id_usuario'=>$this->data['Usuario']['id'])));
				if ( empty($equipo) )
				{
					if ( $this->Usuario->delete($this->data['Usuario']['id']) )
					{
						$this->Session->write('Controlador.resultado_guardar', 'exito');
					}
				}
			}
		}
		
		$this->redirect($this->referer());
	}
	
	//--------------------------------------------------------------------------
	
	function __crear_filas($usuarios_info)
	{
		if ( !empty($usuarios_info) )
		{
			$filas_tabla = '';
			foreach ( $usuarios_info as $usuario )
			{
				$filas_tabla .= '<tr><td><a target="_blank" href="/smuqlab/usuarios/ver/'.$usuario['Usuario']['id'].'">'.$usuario['Usuario']['nombre'].'</a></td>';
				$filas_tabla .= '<td>'.$usuario['Usuario']['cedula'].'</td>';
				$filas_tabla .= '<td>'.$usuario['Usuario']['login'].'</td>';
				$filas_tabla .= '<td>'.$usuario['Dependencia']['name'].'</td>';
				$filas_tabla .= '<td>'.$usuario['Grupo']['name'].'</td></tr>';
			}
			
			return $filas_tabla;
		}
		else
		{
			return 'false';
		}
	}
	
	//--------------------------------------------------------------------------
	
	function de_una_dependencia($id_dependencia)
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		$this->Solicitud->recursive = 1;
		
		if ( $id_dependencia == '0' )
		{
			$usuarios_info = $this->Usuario->find('all', array('order' => array('Grupo.name', 'Dependencia.name')));
		}
		else
		{
			$usuarios_info = $this->Usuario->find('all',  array('conditions' => array('Usuario.id_dependencia' => $id_dependencia)));
		}
		
		$filas = $this->__crear_filas($usuarios_info);
		if ( $filas == 'false' )
		{
			return $filas;
		}
		else
		{
			return $filas.'_-_@'.count($usuarios_info);
		}
	}
	
	//--------------------------------------------------------------------------
	
	function buscar_administradores()
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		$this->Solicitud->recursive = 1;
		
		$usuarios_info = $this->Usuario->find('all',  array('conditions' => array('Usuario.id_grupo' => '2'),
																			 'order' => array('Usuario.nombre')));
		
		$filas = $this->__crear_filas($usuarios_info);
		if ( $filas == 'false' )
		{
			return $filas;
		}
		else
		{
			return $filas.'_-_@'.count($usuarios_info);
		}
	}
	
	//--------------------------------------------------------------------------
	
	function buscar_principales()
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		$this->Solicitud->recursive = 1;
		
		$usuarios_info = $this->Usuario->find('all',  array('conditions' => array('Usuario.id_grupo' => '1'),
																			 'order' => array('Usuario.nombre')));
		
		$filas = $this->__crear_filas($usuarios_info);
		if ( $filas == 'false' )
		{
			return $filas;
		}
		else
		{
			return $filas.'_-_@'.count($usuarios_info);
		}
	}
	
	//--------------------------------------------------------------------------
	
	function con_cedula($cedula)
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		$this->Usuario->recursive = 2;
		
		$usuario = $this->Usuario->find('first',  array('conditions' => array('Usuario.cedula' => $cedula)));
		
		if ( !empty($usuario) )
		{
			$filas_tabla = '<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
			<tr align="left">
				<td class="subtitulo" width="50">Nombre:</td>
				<td width="210">'.$usuario['Usuario']['nombre'].'</td>
			</tr>
			<tr><td height="10" colspan="2"/></tr>
			<tr align="left">
				<td class="subtitulo" width="50">Cédula:</td>
				<td width="210">'.$usuario['Usuario']['cedula'].'</td>
			</tr>
			<tr><td height="10" colspan="2"/></tr>
			<tr align="left">
				<td class="subtitulo" width="50">Login:</td>
				<td width="210">'.$usuario['Usuario']['login'].'</td>
			</tr>
			<tr><td height="10" colspan="2"/></tr>
			<tr align="left">
				<td class="subtitulo" width="50">Email:</td>
				<td width="210">'.$usuario['Usuario']['email'].'</td>
			</tr>
			<tr><td height="10" colspan="2"/></tr>
			<tr><td height="1" class="linea" colspan="2"/></tr>
			<tr><td height="10" colspan="2"/></tr>
			<tr align="left">
				<td class="subtitulo" width="50">Tipo de Usuario:</td>
				<td>'.$usuario['Grupo']['name'].'</td>
			</tr>
			<tr><td height="10" colspan="2"/></tr>
			<tr align="left">
				<td class="subtitulo" width="50">Edificio:</td>
				<td>'.$usuario['Dependencia']['Edificio']['name'].'</td>
			</tr>
			<tr><td height="10" colspan="2"/></tr>
			<tr align="left">
				<td class="subtitulo" width="50">Dependencia:</td>
				<td>'.$usuario['Dependencia']['name'].'</td>
			</tr>
			<tr><td height="10" colspan="2"/></tr>
			<tr align="left">
				<td class="subtitulo" width="50">Cargo:</td>
				<td>'.$usuario['Usuario']['cargo'].'</td>
			</tr>
			</tbody></table>';
			
			return $filas_tabla;
		}
		else
		{
			return 'false';
		}
	}
	
	//--------------------------------------------------------------------------
}
?>
