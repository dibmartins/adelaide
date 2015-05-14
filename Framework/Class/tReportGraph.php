<?php 

require_once("iReportGraph.php");

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
 * Classe responsável pelo gerenciamento de erros 
 * @package Framework
 * @subpackage Reports
 * @version 1.0 - 2006-11-14 08:54:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class GraphException extends Exception{}

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
 * Classe de geração de gráficos
 * @package Framework
 * @subpackage Reports
 * @version 1.0 - 2006-11-14 08:54:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

abstract class ReportGraph implements InterfaceReportGraph
{
   /**
    * Attributes:
    */

   /**
    * Nome do arquivo do gráfico
    * @var 	$strFileName
	* @access 	private
	*/		
	private $strFileName;

   /**
    * Título do gráfico
    * @var 	$strTitle
	* @access 	private
	*/		
	private $strTitle;

   /**
    * Armazena os dados do relatório
    * @var 	$arData
	* @access 	private
	*/		
	private $arData;
	
   /**
    * Legenda do gráfico
    * @var 	$arLabels
	* @access 	private
	*/		
	private $arLabels;

//---------------------------------------------------------------------------------------   

   /** 
    * Properties:
    */

   /**
	* Método para setar o valor do atributo $strFileName
	* @return void		 
	* @access public
	*/
		public function SetFileName($strFileName)
		{
			 $this->strFileName = $strFileName;
		}

   /**
	* Método para retornar o valor do atributo $strFileName
	* @return string $strFileName
	* @access public
	*/
		public function GetFileName()
		{
			 return $this->strFileName;
		}

   /**
	* Método para setar o valor do atributo $strTitle
	* @return void		 
	* @access public
	*/
		public function SetTitle($strTitle)
		{
			 $this->strTitle = $strTitle;
		}

   /**
	* Método para retornar o valor do atributo $strTitle
	* @return string $strTitle
	* @access public
	*/
		public function GetTitle()
		{
			 return $this->strTitle;
		}

   /**
	* Método para setar o valor do atributo $arData
	* @return void		 
	* @access public
	*/
		public function SetData($arData)
		{
			 $this->arData = $arData;
		}

   /**
	* Método para retornar o valor do atributo $arData
	* @return string $arData
	* @access public
	*/
		public function GetData()
		{
			 return $this->arData;
		}
		
   /**
	* Método para setar o valor do atributo $arLabels
	* @return void		 
	* @access public
	*/
		public function SetLabels($arLabels)
		{
			 $this->arLabels = $arLabels;
		}

   /**
	* Método para retornar o valor do atributo $arLabels
	* @return string $arLabels
	* @access public
	*/
		public function GetLabels()
		{
			 return $this->arLabels;
		} 		

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
			$this->SetFileName($this->UniqueName());
			$this->SetTitle("");
			$this->SetData("");
			$this->SetLabels("");
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
	* Gera um nome para o arquivo temporário contendo o gráfico
	* @return void
	* @access public
	*/
	    public function UniqueName()
	    {
		    return "graph_" . substr(md5(uniqid(time())), 0, 10) . ".png";
		}

   /**
	* Salva o gráfico gerado em um arquivo de imagem png no diretório temporário informado em $this->SetTempDir()
	* @param $strDir diretório onde será salvo o gráfico 
	* @param $objGraph Objeto jpGraph configurado
	* @param $objPlot Objeto Plot do tipo informado em $this->SetType()
	* @return void
	* @access public
	*/
	    public function Stroke($strDir, $objGraph, $objPlot)
	    {
		    // Obtendo o nome do arquivo temporário com o gráfico:
			$strGraphTempFile = $strDir . $this->GetFileName();
			
			// Salvando o arquivo temporário:
		    $objGraph->Add($objPlot);
			$objGraph->Stroke($strGraphTempFile);
			
			$this->SetFileName($strGraphTempFile);
			
			return $strGraphTempFile;
		}

   /**
	* Verifica se os dados para geração dos gráficos foram setados corretamente
	* @return void
	* @access public
	*/
	    public function Validate()
	    {
		    if(empty($this->strTitle)) 
			{
			    throw new GraphException("O título do gráfico não foi informado");
			}	
			if(!is_array($this->arData) || count($this->arData) == 0) 
			{
			    throw new GraphException("Os dados do gráfico não foram informados");
			}
		}		
}
