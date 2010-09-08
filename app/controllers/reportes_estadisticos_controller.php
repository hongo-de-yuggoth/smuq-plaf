<?php
App::import('Vendor', 'phplot', array('file' => 'class.phplot.php'));

//-----------------------------------------------------------------------------

class ReportesEstadisticosController extends AppController
{
	var $name = 'ReportesEstadisticos';
	var $uses = array();
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
	
	function beforeFilter(){}
	
	//--------------------------------------------------------------------------
	
	function solicitudes_apoyo_eventos_por_años($param, $año_inicial, $año_final)
	{
		$this->loadModel('ApoyoEventoSolicitud');
		
		// Obtenemos los años existentes, segun el parámetro de configuración.
		$param_año = '';
		if ( $param == 'rango' )
		{
			if ( $año_inicial == $año_final )
			{
				$años[] = array(array('year'=>$año_inicial));
			}
			else
			{
				$param_año = 'AND YEAR(archivada)>= '.$año_inicial.' AND YEAR(archivada)<= '.$año_final;
			}
		}
		
		if ( !isset($años) )
		{
			$años = $this->ApoyoEventoSolicitud->query("SELECT YEAR(archivada) AS year FROM apoyo_evento_solicitudes WHERE estado='a' ".$param_año." GROUP BY YEAR(archivada)");
		}
		
		if ( !empty($años) )
		{
			$total = array();
			foreach ( $años as $año )
			{
				$cant_solicitudes = $this->ApoyoEventoSolicitud->query("SELECT COUNT(*) AS cuenta FROM apoyo_evento_solicitudes WHERE estado='a' AND YEAR(archivada)=".$año[0]['year']);
				$total[$año[0]['year']] = $cant_solicitudes;
			}
			
			if ( !empty($total) )
			{
				$arreglo_plot = array();
				foreach ( $total as $año=>$arreglo_año )
				{
					$arreglo_plot[] = array($año, $arreglo_año[0][0]['cuenta']);
				}
				
				$plot = new PHPlot(700, 450);
				$plot->SetDataValues($arreglo_plot);
				$plot->SetDataType('text-data');
				
				// Fuentes
				$plot->SetUseTTF(true);
				$plot->SetFontTTF('legend', 'FreeSans.ttf', 9);
				$plot->SetFontTTF('title', 'FreeSans.ttf', 14);
				$plot->SetFontTTF('y_label', 'FreeSans.ttf', 10);
				$plot->SetFontTTF('x_label', 'FreeSans.ttf', 10);
				$plot->SetFontTTF('y_title', 'FreeSans.ttf', 14);
				$plot->SetFontTTF('x_title', 'FreeSans.ttf', 12);
				
				// Titulos
				$plot->SetTitle("\nSolicitudes de\napoyo a eventos por años\n");
				$plot->SetXTitle('AÑOS');
				$plot->SetYTitle('# SOLICITUDES');
				
				// Etiquetas
				$plot->SetXTickLabelPos('none');
				$plot->SetXTickPos('none');
				$plot->SetYTickLabelPos('none');
				$plot->SetYTickPos('none');
				$plot->SetYDataLabelPos('plotin');
				$plot->SetDrawXGrid(true);
				
				// Leyenda
				$leyenda = array('Solicitudes de Apoyo a Eventos');
				$plot->SetLegend($leyenda);
				$plot->SetLegendPixels(484, 0);
				$plot->SetPlotType('bars');
				$plot->SetShading(7);
				
				$plot->DrawGraph();
			}
		}
	}
	
	//--------------------------------------------------------------------------
	
	function solicitudes_reparacion_por_años($param, $año_inicial, $año_final)
	{
		$this->loadModel('ReparacionSolicitud');
		
		// Obtenemos los años existentes, segun el parámetro de configuración.
		$param_año = '';
		if ( $param == 'rango' )
		{
			if ( $año_inicial == $año_final )
			{
				$años[] = array(array('year'=>$año_inicial));
			}
			else
			{
				$param_año = 'AND YEAR(archivada)>= '.$año_inicial.' AND YEAR(archivada)<= '.$año_final;
			}
		}
		
		if ( !isset($años) )
		{
			$años = $this->ReparacionSolicitud->query("SELECT YEAR(archivada) AS year FROM reparacion_solicitudes WHERE estado='a' ".$param_año." GROUP BY YEAR(archivada)");
		}
		
		if ( !empty($años) )
		{
			$total = array();
			foreach ( $años as $año )
			{
				$cant_solicitudes = $this->ReparacionSolicitud->query("SELECT COUNT(*) AS cuenta FROM reparacion_solicitudes WHERE estado='a' AND YEAR(archivada)=".$año[0]['year']);
				$total[$año[0]['year']] = $cant_solicitudes;
			}
			
			if ( !empty($total) )
			{
				$arreglo_plot = array();
				foreach ( $total as $año=>$arreglo_año )
				{
					$arreglo_plot[] = array($año, $arreglo_año[0][0]['cuenta']);
				}
				
				$plot = new PHPlot();
				$plot->SetDataValues($arreglo_plot);
				$plot->SetDataType('text-data');
				
				// Fuentes
				$plot->SetUseTTF(true);
				$plot->SetFontTTF('legend', 'FreeSans.ttf', 9);
				$plot->SetFontTTF('title', 'FreeSans.ttf', 14);
				$plot->SetFontTTF('y_label', 'FreeSans.ttf', 10);
				$plot->SetFontTTF('x_label', 'FreeSans.ttf', 10);
				$plot->SetFontTTF('y_title', 'FreeSans.ttf', 14);
				$plot->SetFontTTF('x_title', 'FreeSans.ttf', 12);
				
				// Titulos
				$plot->SetTitle("\nSolicitudes de\nreparación por años\n");
				$plot->SetXTitle('AÑOS');
				$plot->SetYTitle('# SOLICITUDES');
				
				// Etiquetas
				$plot->SetXTickLabelPos('none');
				$plot->SetXTickPos('none');
				$plot->SetYTickLabelPos('none');
				$plot->SetYTickPos('none');
				$plot->SetYDataLabelPos('plotin');
				$plot->SetDrawXGrid(true);
				
				// Leyenda
				$leyenda = array('Solicitudes de Reparación');
				$plot->SetLegend($leyenda);
				$plot->SetLegendPixels(416, 0);
				$plot->SetPlotType('bars');
				$plot->SetShading(7);
				
				$plot->DrawGraph();
			}
		}
	}
	
	//--------------------------------------------------------------------------
	
	function solicitudes_reparacion_por_meses($año)
	{
		$this->loadModel('ReparacionSolicitud');
		$meses = $this->ReparacionSolicitud->query("SELECT MONTH(archivada) AS mes FROM reparacion_solicitudes WHERE estado='a' AND YEAR(archivada)=".$año." GROUP BY MONTH(archivada)");
		if ( !empty($meses) )
		{
			// Inicializamos el arreglo en ceros (para los meses ke no tienen solicitudes).
			$total = array();
			for ( $i=1; $i <= 12; $i++ )
			{
				$total[$i][0][0] = array('cuenta'=>0);
			}
			
			foreach ( $meses as $mes )
			{
				$cant_solicitudes = $this->ReparacionSolicitud->query("SELECT COUNT(*) AS cuenta FROM reparacion_solicitudes WHERE estado='a' AND YEAR(archivada)=".$año." AND MONTH(archivada)=".$mes[0]['mes']);
				$total[$mes[0]['mes']] = $cant_solicitudes;
			}
			
			if ( !empty($total) )
			{
				foreach ( $total as $mes=>$arreglo_mes )
				{
					$arreglo_plot[] = array($this->meses[$mes], $arreglo_mes[0][0]['cuenta']);
				}
				
				$plot = new PHPlot(890, 450);
				$plot->SetDataValues($arreglo_plot);
				$plot->SetDataType('text-data');
				
				// Fuentes
				$plot->SetUseTTF(true);
				$plot->SetFontTTF('legend', 'FreeSans.ttf', 9);
				$plot->SetFontTTF('title', 'FreeSans.ttf', 14);
				$plot->SetFontTTF('y_label', 'FreeSans.ttf', 10);
				$plot->SetFontTTF('x_label', 'FreeSans.ttf', 10);
				$plot->SetFontTTF('y_title', 'FreeSans.ttf', 14);
				
				// Titulos
				$plot->SetTitle("\nSolicitudes de\nreparación del año ".$año."\n");
				//$plot->SetXTitle('AÑO '.$año);
				$plot->SetYTitle('# SOLICITUDES');
				
				// Etiquetas
				$plot->SetXTickLabelPos('none');
				$plot->SetXTickPos('none');
				$plot->SetYTickLabelPos('none');
				$plot->SetYTickPos('none');
				$plot->SetYDataLabelPos('plotin');
				$plot->SetDrawXGrid(true);
				
				// Leyenda
				$leyenda = array('Solicitudes de Reparación');
				$plot->SetLegend($leyenda);
				$plot->SetLegendPixels(703, 0);
				$plot->SetPlotType('bars');
				$plot->SetShading(7);
				
				$plot->DrawGraph();
			}
		}
	}
	
	//--------------------------------------------------------------------------
	
	function solicitudes_apoyo_eventos_por_meses($año)
	{
		$this->loadModel('ApoyoEventoSolicitud');
		$meses = $this->ApoyoEventoSolicitud->query("SELECT MONTH(archivada) AS mes FROM apoyo_evento_solicitudes WHERE estado='a' AND YEAR(archivada)=".$año." GROUP BY MONTH(archivada)");
		if ( !empty($meses) )
		{
			// Inicializamos el arreglo en ceros (para los meses ke no tienen solicitudes).
			$total = array();
			for ( $i=1; $i <= 12; $i++ )
			{
				$total[$i][0][0] = array('cuenta'=>0);
			}
			
			foreach ( $meses as $mes )
			{
				$cant_solicitudes = $this->ApoyoEventoSolicitud->query("SELECT COUNT(*) AS cuenta FROM apoyo_evento_solicitudes WHERE estado='a' AND YEAR(archivada)=".$año." AND MONTH(archivada)=".$mes[0]['mes']);
				$total[$mes[0]['mes']] = $cant_solicitudes;
			}
			
			if ( !empty($total) )
			{
				foreach ( $total as $mes=>$arreglo_mes )
				{
					$arreglo_plot[] = array($this->meses[$mes], $arreglo_mes[0][0]['cuenta']);
				}
				
				$plot = new PHPlot(890, 450);
				$plot->SetDataValues($arreglo_plot);
				$plot->SetDataType('text-data');
				
				// Fuentes
				$plot->SetUseTTF(true);
				$plot->SetFontTTF('legend', 'FreeSans.ttf', 9);
				$plot->SetFontTTF('title', 'FreeSans.ttf', 14);
				$plot->SetFontTTF('y_label', 'FreeSans.ttf', 10);
				$plot->SetFontTTF('x_label', 'FreeSans.ttf', 10);
				$plot->SetFontTTF('y_title', 'FreeSans.ttf', 14);
				
				// Titulos
				$plot->SetTitle("\nSolicitudes de\napoyo a eventos del año ".$año."\n");
				//$plot->SetXTitle('AÑO '.$año);
				$plot->SetYTitle('# SOLICITUDES');
				
				// Etiquetas
				$plot->SetXTickLabelPos('none');
				$plot->SetXTickPos('none');
				$plot->SetYTickLabelPos('none');
				$plot->SetYTickPos('none');
				$plot->SetYDataLabelPos('plotin');
				$plot->SetDrawXGrid(true);
				
				// Leyenda
				$leyenda = array('Solicitudes de Apoyo a Eventos');
				$plot->SetLegend($leyenda);
				$plot->SetLegendPixels(671, 0);
				$plot->SetPlotType('bars');
				$plot->SetShading(7);
				
				$plot->DrawGraph();
			}
		}
	}
	
	//--------------------------------------------------------------------------
	
	function solicitudes_apoyo_eventos_por_oficina($id_oficina, $año)
	{
		$this->loadModel('ApoyoEventoSolicitud');
		$meses = $this->ApoyoEventoSolicitud->query("SELECT MONTH(archivada) AS mes FROM apoyo_evento_solicitudes WHERE estado='a' AND YEAR(archivada)=".$año." GROUP BY MONTH(archivada)");
		if ( !empty($meses) )
		{
			// Inicializamos el arreglo en ceros (para los meses ke no tienen solicitudes).
			$total = array();
			for ( $i=1; $i <= 12; $i++ )
			{
				$total[$i][0][0] = array('cuenta'=>0);
			}
			
			foreach ( $meses as $mes )
			{
				$cant_solicitudes = $this->ApoyoEventoSolicitud->query("SELECT COUNT(*) AS cuenta FROM apoyo_evento_solicitudes WHERE Cencos_id=".$id_oficina." AND estado='a' AND YEAR(archivada)=".$año." AND MONTH(archivada)=".$mes[0]['mes']);
				$total[$mes[0]['mes']] = $cant_solicitudes;
			}
			
			if ( !empty($total) )
			{
				$cenco = $this->ApoyoEventoSolicitud->findByCencosId($id_oficina);
				foreach ( $total as $mes=>$arreglo_mes )
				{
					$arreglo_plot[] = array($this->meses[$mes], $arreglo_mes[0][0]['cuenta']);
				}
				
				$plot = new PHPlot(890, 450);
				$plot->SetDataValues($arreglo_plot);
				$plot->SetDataType('text-data');
				
				// Fuentes
				$plot->SetUseTTF(true);
				$plot->SetFontTTF('legend', 'FreeSans.ttf', 9);
				$plot->SetFontTTF('title', 'FreeSans.ttf', 14);
				$plot->SetFontTTF('y_label', 'FreeSans.ttf', 10);
				$plot->SetFontTTF('x_label', 'FreeSans.ttf', 10);
				$plot->SetFontTTF('y_title', 'FreeSans.ttf', 14);
				
				// Titulos
				$plot->SetTitle("\nSolicitudes de\napoyo a eventos realizadas\npor ".
				mb_convert_case($cenco['CentroCosto']['Cencos_nombre'], MB_CASE_TITLE, "UTF-8").
				"  en el año ".$año."\n");
				//$plot->SetXTitle('AÑO '.$año);
				$plot->SetYTitle('# SOLICITUDES');
				
				// Etiquetas
				$plot->SetXTickLabelPos('none');
				$plot->SetXTickPos('none');
				$plot->SetYTickLabelPos('none');
				$plot->SetYTickPos('none');
				$plot->SetYDataLabelPos('plotin');
				$plot->SetDrawXGrid(true);
				
				// Leyenda
				$leyenda = array('Solicitudes de Apoyo a Eventos');
				$plot->SetLegend($leyenda);
				$plot->SetLegendPixels(671, 0);
				$plot->SetPlotType('bars');
				$plot->SetShading(7);
				
				$plot->DrawGraph();
			}
		}
	}
	
	//--------------------------------------------------------------------------
	
	function solicitudes_reparacion_por_oficina($id_oficina, $año)
	{
		$this->loadModel('ReparacionSolicitud');
		$meses = $this->ReparacionSolicitud->query("SELECT MONTH(archivada) AS mes FROM reparacion_solicitudes WHERE estado='a' AND YEAR(archivada)=".$año." GROUP BY MONTH(archivada)");
		
		if ( !empty($meses) )
		{
			// Inicializamos el arreglo en ceros (para los meses ke no tienen solicitudes).
			$total = array();
			for ( $i=1; $i <= 12; $i++ )
			{
				$total[$i][0][0] = array('cuenta'=>0);
			}
			
			foreach ( $meses as $mes )
			{
				$cant_solicitudes = $this->ReparacionSolicitud->query("SELECT COUNT(*) AS cuenta FROM reparacion_solicitudes WHERE Cencos_id=".$id_oficina." AND estado='a' AND YEAR(archivada)=".$año." AND MONTH(archivada)=".$mes[0]['mes']);
				$total[$mes[0]['mes']] = $cant_solicitudes;
			}
			
			if ( !empty($total) )
			{
				$cenco = $this->ReparacionSolicitud->findByCencosId($id_oficina);
				foreach ( $total as $mes=>$arreglo_mes )
				{
					$arreglo_plot[] = array($this->meses[$mes], $arreglo_mes[0][0]['cuenta']);
				}
				
				$plot = new PHPlot(890, 450);
				$plot->SetDataValues($arreglo_plot);
				$plot->SetDataType('text-data');
				
				// Fuentes
				$plot->SetUseTTF(true);
				$plot->SetFontTTF('legend', 'FreeSans.ttf', 9);
				$plot->SetFontTTF('title', 'FreeSans.ttf', 14);
				$plot->SetFontTTF('y_label', 'FreeSans.ttf', 10);
				$plot->SetFontTTF('x_label', 'FreeSans.ttf', 10);
				$plot->SetFontTTF('y_title', 'FreeSans.ttf', 14);
				
				// Titulos
				$plot->SetTitle("\nSolicitudes de reparación\nrealizadas por\n".
				mb_convert_case($cenco['CentroCosto']['Cencos_nombre'], MB_CASE_TITLE, "UTF-8").
				"  en el año ".$año."\n");
				//$plot->SetXTitle('AÑO '.$año);
				$plot->SetYTitle('# SOLICITUDES');
				
				// Etiquetas
				$plot->SetXTickLabelPos('none');
				$plot->SetXTickPos('none');
				$plot->SetYTickLabelPos('none');
				$plot->SetYTickPos('none');
				$plot->SetYDataLabelPos('plotin');
				$plot->SetDrawXGrid(true);
				
				// Leyenda
				$leyenda = array('Solicitudes de Reparación');
				$plot->SetLegend($leyenda);
				$plot->SetLegendPixels(703, 0);
				$plot->SetPlotType('bars');
				$plot->SetShading(7);
				
				$plot->DrawGraph();
			}
		}
	}
	
	//--------------------------------------------------------------------------
	
	function solicitudes_reparacion_por_operario($id_operario, $año)
	{
		$this->loadModel('ReparacionSolicitud');
		$this->loadModel('Funcionario');
		$meses = $this->ReparacionSolicitud->query("SELECT MONTH(archivada) AS mes FROM reparacion_solicitudes WHERE estado='a' AND ejecutada=1 AND YEAR(archivada)=".$año." GROUP BY MONTH(archivada)");
		
		if ( !empty($meses) )
		{
			// Inicializamos el arreglo en ceros (para los meses ke no tienen solicitudes).
			$total = array();
			for ( $i=1; $i <= 12; $i++ )
			{
				$total[$i][0][0] = array('cuenta'=>0);
			}
			
			foreach ( $meses as $mes )
			{
				$cant_solicitudes = $this->ReparacionSolicitud->query("SELECT COUNT(*) AS cuenta FROM reparacion_solicitudes WHERE id_funcionario=".$id_operario." AND estado='a' AND ejecutada=1 AND YEAR(archivada)=".$año." AND MONTH(archivada)=".$mes[0]['mes']);
				$total[$mes[0]['mes']] = $cant_solicitudes;
			}
			
			if ( !empty($total) )
			{
				$operario = $this->Funcionario->find('first', array
				(
					'conditions' => array('Funcionario.id' => $id_operario),
					'fields' => array('Funcionario.nombre')
				));
				foreach ( $total as $mes=>$arreglo_mes )
				{
					$arreglo_plot[] = array($this->meses[$mes], $arreglo_mes[0][0]['cuenta']);
				}
				
				$plot = new PHPlot(890, 450);
				$plot->SetDataValues($arreglo_plot);
				$plot->SetDataType('text-data');
				
				// Fuentes
				$plot->SetUseTTF(true);
				$plot->SetFontTTF('legend', 'FreeSans.ttf', 9);
				$plot->SetFontTTF('title', 'FreeSans.ttf', 14);
				$plot->SetFontTTF('y_label', 'FreeSans.ttf', 10);
				$plot->SetFontTTF('x_label', 'FreeSans.ttf', 10);
				$plot->SetFontTTF('y_title', 'FreeSans.ttf', 14);
				
				// Titulos
				$plot->SetTitle("\nSolicitudes de reparación\natendidas por ".
				mb_convert_case($operario['Funcionario']['nombre'], MB_CASE_TITLE, "UTF-8"));
				$plot->SetXTitle('AÑO '.$año);
				$plot->SetYTitle('# SOLICITUDES');
				
				// Etiquetas
				$plot->SetXTickLabelPos('none');
				$plot->SetXTickPos('none');
				$plot->SetYTickLabelPos('none');
				$plot->SetYTickPos('none');
				$plot->SetYDataLabelPos('plotin');
				$plot->SetDrawXGrid(true);
				
				// Leyenda
				$leyenda = array('Solicitudes de Reparación');
				$plot->SetLegend($leyenda);
				$plot->SetLegendPixels(703, 0);
				$plot->SetPlotType('bars');
				$plot->SetShading(7);
				
				$plot->DrawGraph();
			}
		}
	}
	
	//--------------------------------------------------------------------------
}
?>
