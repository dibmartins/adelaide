<?php 

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

class ReportException extends Exception{}

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
 * Classe de geração de relatórios gráficos
 * @package Framework
 * @subpackage Reports
 * @version 1.0 - 2006-11-14 08:54:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class Report
{
   
   /** 
    * Attributes:
    */

   /**
    * Título do relatório
    * @var 	$strTitle
	* @access 	private
	*/		
	private $strTitle;

   /**
    * Título do relatório
    * @var 	$strHeader
	* @access 	private
	*/		
	private $strHeader;

   /**
    * Título do relatório
    * @var 	$strFooter
	* @access 	private
	*/		
	private $strFooter;

   /**
    * Logotipo do relatório
    * @var 	$strLogo
	* @access 	private
	*/		
	private $strLogo;

   /**
    * Tipo de gráfico a ser utilizado
    * @var 	$objGraph
	* @access 	private
	*/		
	private $objGraph;

   /**
    * diretório temporário onde são salvos os gráficos
    * @var 	$strTempDir
	* @access 	private
	*/		
	private $strTempDir;
	
//---------------------------------------------------------------------------------------   

   /** 
    * Properties:
    */

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
	* Método para setar o valor do atributo $strHeader
	* @return void		 
	* @access public
	*/
		public function SetHeader($strHeader)
		{
			 $this->strHeader = $strHeader;
		}

   /**
	* Método para retornar o valor do atributo $strHeader
	* @return string $strHeader
	* @access public
	*/
		public function GetHeader()
		{
			 return $this->strHeader;
		}

   /**
	* Método para setar o valor do atributo $strFooter
	* @return void		 
	* @access public
	*/
		public function SetFooter($strFooter)
		{
			 $this->strFooter = $strFooter;
		}

   /**
	* Método para retornar o valor do atributo $strFooter
	* @return string $strFooter
	* @access public
	*/
		public function GetFooter()
		{
			 return $this->strFooter;
		}

   /**
	* Método para setar o valor do atributo $strLogo
	* @return void		 
	* @access public
	*/
		public function SetLogo($strLogo)
		{
			 $this->strLogo = $strLogo;
		}

   /**
	* Método para retornar o valor do atributo $strLogo
	* @return string $strLogo
	* @access public
	*/
		public function GetLogo()
		{
			 return $this->strLogo;
		}

   /**
	* Método para setar o tipo de gráfico a ser gerado no relatório
	* Tipos Suportados:
	* Pie, Bars, Points e Straps (Caso seja NULL seja setado, nenhum gráfico é exibido)
	* @return void		 
	* @access public
	*/
		public function SetGraph($strGraphType)
		{
			 $this->objGraph = ReportGraphFactory::Graph($strGraphType);
		}	 

   /**
	* Método para retornar o valor do atributo $objGraphType
	* @return string $objGraphType
	* @access public
	*/
		public function Graph()
		{
			 return $this->objGraph;
		}

   /**
	* Método para setar o valor do atributo $strTempDir
	* @return void		 
	* @access public
	*/
		public function SetTempDir($strTempDir)
		{
			 $this->strTempDir = $strTempDir;
		}

   /**
	* Método para retornar o valor do atributo $strTempDir
	* @return string $strTempDir
	* @access public
	*/
		public function GetTempDir()
		{
			 return $this->strTempDir;
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
		    $this->SetTitle("Título do Rbrigató");
			$this->SetHeader("Cabeçalho do Rbrigató");
			$this->SetFooter("Rodapé do Rbrigató");
			$this->SetLogo("");
			$this->SetGraph(NULL);
			$this->SetTempDir(SystemConfig::PATH . "/Web/Plugins/jpgraph/temp/");
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
	* Retorna a data de geração do relatório
	* @return void
	* @access public
	*/
	    public function CreationDate()
	    {
		    return "Gerado em " . date("d/m/Y") . " às " . date("H:i:s") . "h";
		}
}
