<?php 

require_once(SystemConfig::PATH . "/Web/Plugins/jpgraph/jpgraph.php");
require_once(SystemConfig::PATH . "/Web/Plugins/jpgraph/jpgraph_pie.php");
require_once(SystemConfig::PATH . "/Web/Plugins/jpgraph/jpgraph_pie3d.php");

/**
 * Adelaide Framework  
 * Copyright (C) 2006,2013 Diego Botelho Martins
 *
 * Este programa é um software livre; você pode redistribui-lo e/ou 
 * modifica-lo dentro dos termos da Licença Pública Geral GNU como 
 * publicada pela Fundação do Software Livre (FSF); na versão 3 da 
 * Licença, ou (a seu critério) qualquer versão.
 * 
 * Este programa é distribuido na esperança que possa ser util, 
 * mas SEM NENHUMA GARANTIA; sem uma garantia implicita de ADEQUAÇÂO 
 * a qualquer MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a
 * Licença Pública Geral GNU para maiores detalhes.
 * 
 * Você deve ter recebido uma cópia da Licença Pública Geral GNU
 * junto com este programa, se não, veja <http://www.gnu.org/licenses/>
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>
 * 
 * Classe de geração de gráficos no formato de pizza
 * @package Framework
 * @subpackage Reports
 * @version 1.0 - 2006-11-16 09:14:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class ReportPieGraph extends ReportGraph
{
   /**
    * Attributes:
    */

//---------------------------------------------------------------------------------------   

   /** 
    * Properties:
    */

//---------------------------------------------------------------------------------------   
   
   /** 
    * Methods:
    */
   
   /**
	* Método construtor da classe
	* @return void
	* @access public
	*/
	    public function __construct()
	    {	
			parent::__construct();
	    }

   /**
	* Método destrutor da classe
	* @return void
	* @access public
	*/
	    public function __destruct()
	    {	
		    unset($this);
	    }
		
   /**
	* Salva o arquivo do gráfico
	* @param $strDir diretório onde o gráfico será salvo
	* @return void
	* @access public
	*/
	    public function Save($strDir)
	    {	
			parent::Validate();
			
			$objGraph = new PieGraph(680, 370, "auto");
			
			// Adicionando o efeito de sombra
			$objGraph->SetShadow();
	
			// Setando o título do gráfico
			$objGraph->title->Set(parent::GetTitle());
			$objGraph->title->SetFont(FF_ARIAL, FS_BOLD, 12); 
			$objGraph->title->SetColor("black");
			
			// Setando o gráfico no formato de pizza
			$objPlot = new PiePlot3d(parent::GetData());
			
			// Setando as legendas do gráfico:
			$arLabels = parent::GetLabels();
			if(is_array($arLabels) && count($arLabels) > 0)
			{
			    $objPlot->SetLegends($arLabels);
			}
			
			$objPlot->SetTheme("sand");
			$objPlot->SetCenter(0.35);
			$objPlot->SetAngle(50);
			$objPlot->value->SetFont(FF_ARIAL, FS_NORMAL,10);
			$objPlot->value->SetColor("black");
			
			return parent::Stroke($strDir, $objGraph, $objPlot);
	    }		
}
