<?php
class FuncionariosController extends AppController
{
	var $name = 'Funcionarios';
	var $uses = array('Funcionario');
	//--------------------------------------------------------------------------
	
	function beforeFilter(){}
	
	//--------------------------------------------------------------------------
	
	function crear($nombre_funcionario) //**
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		$resultado = false;
		$nombre_standard = mb_convert_case($nombre_funcionario, MB_CASE_TITLE, "UTF-8");
		$this->Funcionario->set('nombre', $nombre_standard);
		$this->Funcionario->set('activo', true);
		if ( $this->Funcionario->save() )
		{
			$resultado = true;
		}
		return json_encode(array('resultado'=>$resultado));
	}
	
	//--------------------------------------------------------------------------
	
	function modificar($id, $nuevo_nombre, $nuevo_estado) //**
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		$resultado = false;
		$this->Funcionario->read(null, $id);
		
		if ( $nuevo_nombre != '0' )
		{
			$nombre_standard = mb_convert_case($nuevo_nombre, MB_CASE_TITLE, "UTF-8");
			$this->Funcionario->set('nombre', $nombre_standard);
		}
		$this->Funcionario->set('activo', $nuevo_estado);
		if ( $this->Funcionario->save() )
		{
			$resultado = true;
		}
		return json_encode(array('resultado'=>$resultado));
	}
	
	//--------------------------------------------------------------------------
	
	function eliminar($id) //***
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		$this->loadModel('ReparacionSolicitud');
		$resultado = false;
		$reparacion = $this->ReparacionSolicitud->find('first', array
		(
			'fields' => array('ReparacionSolicitud.id'),
			'conditions' => array('ReparacionSolicitud.id_funcionario'=>$id)
		));
		if ( empty($reparacion) )
		{
			if ( $this->Funcionario->delete($id) )
			{
				$resultado = true;
			}
		}
		return json_encode(array('resultado'=>$resultado));
	}
	
	//--------------------------------------------------------------------------
	
	function existe_funcionario($nombre_funcionario) //**
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		
		$resultado = true;
		// Aca Standarizamos el formato del nombre.
		$nombre_standard = mb_convert_case($nombre_funcionario, MB_CASE_TITLE, "UTF-8");
		$funcionario_info = $this->Funcionario->findByNombre($nombre_standard);
		
		if ( empty($funcionario_info) )
		{
			$resultado = false;
		}
		return json_encode(array('resultado'=>$resultado));
	}
	
	//--------------------------------------------------------------------------
	
	function estado_actual($id_funcionario) //**
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		$json_data['resultado'] = false;
		$funcionario = $this->Funcionario->findByid($id_funcionario);
		if ( !empty($funcionario) )
		{
			$json_data['resultado'] = true;
			$json_data['activo'] = $funcionario['Funcionario']['activo'];
		}
		return json_encode($json_data);
	}
	
	//--------------------------------------------------------------------------
	
	/*
	 Genera Select con todos los funcionarios sin importar el estado.
	*/
	function cargar_select() //**
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		
		$json_data['resultado'] = false;
		$opciones = '';
		$funcionarios_info = $this->Funcionario->find('all', array
		(
			'fields' => array('Funcionario.id', 'Funcionario.nombre'),
			'order' => array('Funcionario.nombre')
		));
		if ( !empty($funcionarios_info) )
		{
			foreach ( $funcionarios_info as $funcionario )
			{
				$opciones .= '<option value="'.$funcionario['Funcionario']['id'].'">'.$funcionario['Funcionario']['nombre'].'</option>';
			}
			$json_data['resultado'] = true;
		}
		else
		{
			$opciones = '<option value="0">No hay funcionarios</option>';
		}
		$json_data['opciones'] = $opciones;
		return json_encode($json_data);
	}
	
	//--------------------------------------------------------------------------
	
	/*
	 Genera Select con todos los funcionarios ACTIVOS.
	*/
	function cargar_select_activos() 
	{
		$this->autoLayout = false;
		$this->autoRender = false;
		
		$json_data['resultado'] = false;
		$opciones = '';
		$funcionarios_info = $this->Funcionario->find('all', array
		(
			'fields' => array('Funcionario.id', 'Funcionario.nombre'),
			'order' => array('Funcionario.nombre'),
			'conditions' => array('Funcionario.activo' => 1)
		));
		if ( !empty($funcionarios_info) )
		{
			foreach ( $funcionarios_info as $funcionario )
			{
				$opciones .= '<option value="'.$funcionario['Funcionario']['id'].'">'.$funcionario['Funcionario']['nombre'].'</option>';
			}
			$json_data['resultado'] = true;
		}
		else
		{
			$opciones = '<option value="0">No hay funcionarios</option>';
		}
		$json_data['opciones'] = $opciones;
		return json_encode($json_data);
	}
	
	//--------------------------------------------------------------------------
}
?>
