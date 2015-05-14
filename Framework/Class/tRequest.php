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
 * @subpackage HTTP Request
 * @version 1.0 - 2006-09-27 13:52:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */
 
class RequestException extends Exception{} 

/**
 * Classe de gerenciamento de requisições HTTP
 *
 * Em dados enviados via POST o form deve possuir um campo hidden chamado "action" com a ação a ser tomada pela classe controladora 
 * Ex.: <input name="action" type="hidden" id="action" value="cadastrar" />
 *
 * Em dados enviados via GET a url deve possuir uma variável chamada "action" com a ação a ser tomada pela classe controladora
 * Ex.: class.ControladoraCliente.php?action=excluir&id=5
 * @package Framework
 * @subpackage HTTP Request
 * @version 1.0 - 2006-09-27 13:52:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class Request
{
   /** 
    * Attributes:
    */   
   
   /**
	* @var object $objGet
	* @access private
	*/
	private $objGet;
   
   /**
	* @var object $objPost
	* @access private
	*/
	private $objPost;
	
   /**
	* @var object $objFiles
	* @access private
	*/
	private $objFiles;
	
   /**
	* @var string $strAction
	* @access private
	*/
	private $strAction;	
	
   /**
	* @var string $strAction
	* @access private
	*/
	private $strController;	
	
//---------------------------------------------------------------------------------------------	
	
   /** 
    * Properties:
    */

   /**
	* Método para setar o valor do atributo $objGet
	* @param array $objGet Conteúdo do array $_GET
	* @return void		 
	* @access public
	*/
		public function SetGet($objGet)
		{
			 $this->objGet = $objGet;
		}

   /**
	* Método para retornar o valor do atributo $objGet
	* @return string $objGet
	* @access public
	*/
		public function Get()
		{
			if(!is_object($this->objGet))
			{
			   throw new RequestException('Requisição inválida via GET');
			}			      
			return $this->objGet;
		}

   /**
	* Método para setar o valor do atributo $objPost
	* @param array $objPost Conteúdo do array $_POST
	* @return void		 
	* @access public
	*/
		public function SetPost($objPost)
		{
			 $this->objPost = $objPost;
		}

   /**
	* Método para retornar o valor do atributo $objPost
	* @return string $objPost
	* @access public
	*/
		public function Post()
		{
			if(!is_object($this->objPost))
			{
			   throw new RequestException('Requisição inválida via POST');
			}			 
			return $this->objPost;
		}

   /**
	* Método para setar o valor do atributo $objFiles
	* @param array $objPost Conteúdo do array $_FILES
	* @return void		 
	* @access public
	*/
		public function SetFiles($objFiles)
		{
			 $this->objFiles = $objFiles;
		}

   /**
	* Método para retornar o valor do atributo $objFiles
	* @return string $objFiles
	* @access public
	*/
		public function Files()
		{
			 return $this->objFiles;
		}

   /**
	* Método para setar o valor do atributo $strAction
	* @param string $strAction Ação solicitada por $_POST ou $_GET
	* @return void		 
	* @access public
	*/
		public function SetAction($strAction)
		{
			 $this->strAction = $strAction;
		}

   /**
	* Método para retornar o valor do atributo $strAction
	* @return string $strAction
	* @access public
	*/
		public function GetAction()
		{
			 return $this->strAction;
		}

   /**
	* Método para setar o valor do atributo $strController
	* @param string $strAction Controladora solicitada por $_POST ou $_GET
	* @return void		 
	* @access public
	*/
		public function SetController($strController)
		{
			 $this->strController = $strController;
		}

   /**
	* Método para retornar o valor do atributo $strController
	* @return string $strController
	* @access public
	*/
		public function GetController()
		{
			 return $this->strController;
		}

//---------------------------------------------------------------------------------------------	
		
   /** 
    * Methods:
    */

   /**
	* Método construtor da classe
	* @return void
	* @access public
	*/
		public function __construct($arAjaxRequest = NULL, $strType = 'Post')
		{
			 $objCrypt = new Crypt();
			 
			 // Em requisições via Ajax, $_POST e $_GET não são setados
			 // Nesse caso eles tem que ser setados manualmente com os valores de $arAjaxRequest
			 if(!is_null($arAjaxRequest))
			 {
			     switch($strType)
				 {
				         case "Post" : $_POST = $arAjaxRequest; break;
					 case "Get"  : $_GET  = $arAjaxRequest; break;
					 default     : throw new RequestException("O tipo de requisição não foi informado");
				 }
			 }
			 
			 // Setando o valor de action e retirando-o da requisição:			 
			 if(isset($_POST["action"]))
			 {
				 $this->SetAction($objCrypt->ShortDecrypt($_POST["action"]));
			 }
			 elseif(isset($_GET["action"]))
			 {
				 $this->SetAction($objCrypt->ShortDecrypt($_GET["action"]));
			 }
			 
			 // Setando o valor de controller e retirando-o da requisição:			 
			 if(isset($_POST["controller"]))
			 {
				 $this->SetController($objCrypt->ShortDecrypt($_POST["controller"]));
			 }
			 elseif(isset($_GET["controller"]))
			 {
				 $this->SetController($objCrypt->ShortDecrypt($_GET["controller"]));
			 }
			 
			 $this->SetGet(count($_GET) > 0 ? new RequestGet() : NULL);
			 $this->SetPost(count($_POST) > 0 ? new RequestPost() : NULL);
			 $this->SetFiles(count($_FILES) > 0 ? new RequestFile() : NULL);
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
	* Carrega o objeto com os dados passados na requisição http
	* Se nenhum dados foi passado carrega o objeto com string vazia ""
	* @param object $objLoaded Referência do Objeto a ser carregado com a requisição
	* @param string $strRequest Tipo de requisição $_GET ou $_POST
	* @param string $strExtract Parte do nome do campo que deve ser retirado
	* Isto serve para campos diferentes mais que devem ser gravados na mesma tabela
	* Ex. end_complemento e end_complemento_entrega, ambos serão carregados em objetos endereço
	* mas para que o objeto possa ser carregado a string '_entrega' tem que ser concatenada
	* @return object Objeto carregado com as informações da requisição
	* @access public
	*/
	    public function &Load(&$objLoaded, $strRequest = 'Post', $strDiff = '')
	    {	
			if(is_object($objLoaded))
			{
				// Setando cada atributo da classe com o seu respectivo campo na requisição: 
				foreach($this->$strRequest() as $strAttribute => $mxdValue)
				{
					$strMethod = Utils::BuildProperty("Set", $strAttribute);
					
					$strAttribute .= $strDiff;
					$objLoaded->$strMethod($this->$strRequest()->$strAttribute);
				}
				
				return $objLoaded;
			}
			else
			{
			    throw new RequestException("O parâmetro informado não é um objeto válido");
			}	
		}	
}
