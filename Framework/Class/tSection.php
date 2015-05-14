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
 * @subpackage Section
 * @version 1.0 - 2006-12-20 13:32:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */
 
class SectionException extends Exception{} 

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
 * Classe de gerenciamento de requisições HTTP
 * @package Framework
 * @subpackage Section
 * @version 1.0 - 2006-12-20 13:32:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class Section
{
   /** 
    * Attributes:
    */   
   
   /**
	* 
	* @var string $strDefaultPage
	* @access private
	*/
	private $strDefaultPage;
	
   /**
	* 
	* @var string $strURLVar
	* @access private
	*/
	private $strURLVar;

//---------------------------------------------------------------------------------------------	
	
   /** 
    * Properties:
    */

       /**
	* Método para setar o valor do atributo $strDefaultPage
	* @param string $strDefaultPage Página padrão a ser incluída caso nenhuma outra seja informada
	* @return void		 
	* @access public
	*/
		public function SetDefaultPage($strDefaultPage)
		{
			 $this->strDefaultPage = $strDefaultPage;
		}

       /**
	* Método para retornar o valor do atributo $strDefaultPage
	* @return string $strDefaultPage
	* @access public
	*/
		public function GetDefaultPage()
		{
			 return $this->strDefaultPage;
		}

       /**
	* Método para setar o valor do atributo $strURLVar
	* @param string $strURLVar Variável passada na url para identificar qual página deve ser exibida
	* @return void		 
	* @access public
	*/
		public function SetURLVar($strURLVar)
		{
			 $this->strURLVar = $strURLVar;
		}

       /**
	* Método para retornar o valor do atributo $strURLVar
	* @return string $strURLVar
	* @access public
	*/
		public function GetURLVar()
		{
			 return $this->strURLVar;
		}

//---------------------------------------------------------------------------------------------	
		
   /** 
    * Methods:
    */

       /**
	* Método construtor da classe
	* @param string $strDefaultPage Página padrão a ser exibida, caso nenhuma outra seja informada
	* @return void
	* @access public
	*/
	    public function __construct()
	    {
		     $this->SetDefaultPage("");
		     $this->SetURLVar("");
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
	* Exibe o conteúdo da página requisitada
	* @return void
	* @access public
	*/
	    public function Display($blnSmarty = true)
	    {	
			$objRequest = new Request();
			
			$strDefaultPage = $this->GetDefaultPage();
			$strURLVar      = $this->GetURLVar();
			$strURLVar      = $objRequest->Get()->$strURLVar;
			
			if(!empty($strDefaultPage) && empty($strURLVar))
			{
				if($blnSmarty)
				{
				    return $strDefaultPage . ".php";
				}
				else
				{
				    include($strDefaultPage . ".php");
				}	
			}
			elseif((!$this->Verify($_SERVER['QUERY_STRING'])) || (!file_exists($strURLVar . ".php")))
			{
				// Página inválida ou não encontrada
				return 404;
			}
			else
			{
				if($blnSmarty)
				{
				    return $strURLVar . ".php";
				}
				else
				{
			        include($strURLVar . ".php");
				}
			}
		}
		
   /**
	* Verifica se a seção é valida
	* @param string $strValue String a ser validada
	* @return boolean true caso a seção seja válida, caso contrário false
	* @access public
	*/
	    public function Verify($strValue)
	    {	
			$strValue = strtolower($strValue);
			
			// Se a seção tiver caracteres inválidos , retorne false:
			if(ereg("http|ftp|https|www|wget", $strValue) == true)
			{
				return false;
			}
			
			// Se a seção estiver estiver vazia, retorne false;
			if(empty($strValue))
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		
	/**
	 * Exibe o erro caso a página não seja encontrada
	 * @return void
	 * @access private
	 */	
		public function displayError($blnSmarty = true)
		{
			$strError = '<h3>Página não encontrada!</h3><br />';
			$strError.= '<p><b><a href="http://' . $_SERVER['HTTP_HOST'] . '" target="_top">Clique aqui</a></b> ';
			$strError.= 'para retornar ao site ou <br />aguarde 5 segundos para ser redirecionado automaticamente.</p>';
			$strError.= '<meta http-equiv="refresh" content="5;URL=http://' . $_SERVER['HTTP_HOST'] . '">';
			
			if($blnSmarty)
			{
				return $strError;
			}
			else
			{
				echo $strError;
			}
		}		
}
