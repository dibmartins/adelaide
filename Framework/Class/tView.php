<?php 

require_once(SystemConfig::PATH.SystemConfig::SMARTY_ROOT . "Smarty.class.php");

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
 * @subpackage MVC
 * @version 1.0 - 2006-10-26 17:06:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright  2009 RG Sistemas - Todos os diretos reservados.
 */

class ViewException extends Exception{}

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
 * Classe responsável pela exibição dos dados na tela
 * @package Framework
 * @subpackage MVC
 * @version 1.0 - 2006-10-26 17:06:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright  2009 RG Sistemas - Todos os direitos reservados
 */

class View
{
   /**
    * Attributes:
    */
   
   /**
	* @var object $objRequest
	* @access private
	*/
	    private $objRequest;

   /**
	* @var string $objSmarty
	* @access private
	*/
	    private $objSmarty;

   /**
	* @var object $objAjax
	* @access private
	*/
	    private $objAjax;	
	
   /**
	* @var object $objAjaxResponse
	* @access private
	*/
	    private $objAjaxResponse;

   /**
	* @var object $objCrypt
	* @access private
	*/
	    private $objCrypt;

   /**
    * Script executado quando o template é carregado
	* @var string $strOnLoadScript
	* @access private
	*/
	    private $strOnLoad;

   /**
	* @var object $objDataGrid
	* @access private
	*/
	    private $objDataGrid;			

   /**
	* @var object $objShortcutBar
	* @access private
	*/
	    private $objShortcutBar;			
	
//---------------------------------------------------------------------------------------------	
	
   /** 
    * Properties:
    */   

   /**
	* Método para setar o valor do atributo $objRequest
	* @param object $objRequest Objeto carregado com a requisição HTTP
	* @return void		 
	* @access public
	*/
		public function SetRequest(Request $objRequest)
		{
			 $this->objRequest = $objRequest;
		}

   /**
	* Método para retornar o valor do atributo $objRequest
	* @return Valor do atributo $objRequest
	* @access public
	*/
		public function GetRequest()
		{
			 return $this->objRequest;
		}

   /**
	* Método para setar o valor do atributo $objSmarty
	* @param object $objSmarty
	* @return void		 
	* @access public
	*/
		public function SetSmarty($value)
		{
			$this->objSmarty = $value;
		}

   /**
	* Método para retornar o valor do atributo $objSmarty
	* @return object $objSmarty
	* @access private
	*/
		public function GetSmarty()
		{
			return $this->objSmarty;
		}

   /**
	* Método para setar o valor do atributo $objAjax 
	* @param object $objAjax Objeto Ajax
	* @return void		 
	* @access public
	*/
		public function SetAjax(Ajax $objAjax)
		{
			$this->objAjax = $objAjax;
		}

   /**
	* Método para retornar o valor do atributo $objAjax
	* @return object $objAjax
	* @access private
	*/
		public function GetAjax()
		{
			return $this->objAjax;
		}

   /**
	* Método para setar o valor do atributo $objAjaxResponse 
	* @param object $objAjaxResponse
	* @return void		 
	* @access public
	*/
		public function SetAjaxResponse(AjaxResponse $objAjaxResponse)
		{
			$this->objAjaxResponse = $objAjaxResponse;
		}

   /**
	* Método para retornar o valor do atributo $objAjax
	* @return object $objAjax
	* @access private
	*/
		public function GetAjaxResponse()
		{
		    return $this->objAjaxResponse;
		}

   /**
	* Método para setar o valor do atributo $objCrypt
	* @param object $objCrypt Objeto Crypt
	* @return void		 
	* @access public
	*/
		public function SetCrypt(Crypt $objCrypt)
		{
			$this->objCrypt = $objCrypt;
		}

   /**
	* Método para retornar o valor do atributo $objCrypt
	* @return object $objCrypt
	* @access private
	*/
		public function GetCrypt()
		{
			return $this->objCrypt;
		}

   /**
	* Método para setar o valor do atributo $strOnLoad
	* @param string $strOnLoad
	* @return void		 
	* @access public
	*/
		public function onLoad($strOnLoad)
		{
			// Adiciona o código com espaço em branco no final:
			$this->strOnLoad.= $strOnLoad.chr(32);
		}

   /**
	* Método para retornar o valor do atributo $strOnLoad
	* @return string $strOnLoad
	* @access private
	*/
		public function GetOnLoad()
		{
			return $this->strOnLoad;
		}

   /**
	* Método para setar o valor do atributo $objDataGrid
	* @param object $objDataGrid
	* @return void		 
	* @access public
	*/
		public function SetDataGrid(DataGrid $objDataGrid)
		{
			$this->objDataGrid = $objDataGrid;
		}

   /**
	* Método para retornar o valor do atributo $objDataGrid
	* @return object $objDataGrid
	* @access private
	*/
		public function GetDataGrid()
		{
		    return $this->objDataGrid;
		}

   /**
	* Método para setar o valor do atributo $objShortcutBar
	* @param object $objShortcutBar Objeto carregado com a requisição HTTP
	* @return void		 
	* @access public
	*/
		public function SetShortcutBar(ShortcutBar $objShortcutBar)
		{
			 $this->objShortcutBar = $objShortcutBar;
		}

   /**
	* Método para retornar o valor do atributo $objShortcutBar
	* @return Valor do atributo $objShortcutBar
	* @access public
	*/
		public function GetShortcutBar()
		{
			 return $this->objShortcutBar;
		}

//---------------------------------------------------------------------------------------------	
		
   /** 
    * Methods:
    */
	
   /**
	* Método construtor da classe
	* @param string $strPage Página que está efetuando uma requisição
	* @param object $objChild Objeto da classe filha responsável por $strPage 
	* @return void
	* @access public
	*/
		public function __construct()
		{
			if(func_num_args())
			{
				// Seta a instância Ajax passada como primeiro parâmetro ou então cria uma nova:
				$objAjax = is_a(current(func_get_arg(0)), "Ajax") ? current(func_get_arg(0)) : new Ajax;
			}
			else
			{
			    $objAjax = new Ajax;
			}
			
			$this->SetAjax($objAjax);
			$this->SetRequest(new Request);
			$this->SetShortcutBar(new ShortcutBar);
			$this->SetSmarty(new Smarty());
			$this->SetAjaxResponse(new AjaxResponse());
			$this->SetCrypt(new Crypt());
			
			$this->configSmarty();
			$this->configAjax();
		}

   /**
	* Configura o objeto Smarty
	* @return void
	* @access public
	*/
		public function configSmarty()
		{
			$this->GetSmarty()->compile_dir    = SystemConfig::PATH.SystemConfig::SMARTY_COMPILE;
			$this->GetSmarty()->config_dir     = SystemConfig::PATH.SystemConfig::SMARTY_CONFIG;
			$this->GetSmarty()->cache_dir      = SystemConfig::PATH.SystemConfig::SMARTY_CACHE;
			$this->GetSmarty()->caching        = SystemConfig::SMARTY_CACHE_ON;
			$this->GetSmarty()->cache_lifetime = SystemConfig::SMARTY_LIFE_TIME;
			$this->GetSmarty()->force_compile  = SystemConfig::SMARTY_FORCE_COMPILE;
			$this->GetSmarty()->compile_check  = SystemConfig::SMARTY_COMPILE_CHECK;
			$this->GetSmarty()->debugging      = SystemConfig::SMARTY_DEBUG;
			$this->GetSmarty()->template_dir   = SystemConfig::SMARTY_TEMPLATE_DIR;
		}

   /**
	* Configura o objeto Ajax
	* @return void
	* @access public
	*/
		public function configAjax()
		{
			// Habilita a exibição de mensagens: 
			if(SystemConfig::AJAX_STATUS_MSG_ON)
			{
			    $this->GetAjax()->StatusMessagesOn();
			}
			
			// Habilita o debuging:
			if(SystemConfig::AJAX_DEBUG_ON)
			{
			    $this->GetAjax()->DebugOn();
			}
		}

   /**
	* Retorna o template correspondente ao arquivo informado
	* @param string $strFile Nome do arquivo que se deseja obter o template
	* @return string Template
	* @access public
	*/
		public function GetTemplate($strFile = NULL)
		{
		    if(is_null($strFile))
			{
			    $strFile = $_SERVER['SCRIPT_NAME'];
			}
			
			return basename($strFile, ".php") . ".tpl";
		}
		
   /**
	* Método para iniciar o javascript da biblioteca Ajax
	* @return void
	* @access public
	*/
		public function InitAjax()
		{
			return $this->GetAjax()->PrintJavascript(SystemConfig::AJAX_ROOT);
		}
		
   /**
	* Método de chamada a funções Ajax
	* @param array $arFunction Array contendo o objeto e o(s) método(s) a ser(em) registrado(s)
	* @return void
	* @access public
	*/
		public function Register($arFunction)
		{
		    list($objMixedObject, $mxdMethods) = $arFunction;
		    
			// $mxdMethods pode ser um array com vários métodos
			// ou uma string caso seja apenas um método
		    if(is_array($mxdMethods))
			{
				foreach($mxdMethods as $strMethod)
				{
					// Registrando o método que irá executar a ação solicitada:
					$this->GetAjax()->RegisterFunction(array($strMethod, &$objMixedObject, $strMethod));
				}
			}
			else
			{
			   // Registrando o método que irá executar a ação solicitada:
			   $this->GetAjax()->RegisterFunction(array($mxdMethods, &$objMixedObject, $mxdMethods));
			}
		}

   /**
	* Método de gerenciamento de requisições Ajax
	* Chame este método somente após ter registrado todos os métodos a serem utilizados
	* @return void
	* @access public
	*/
		public function ProcessRequests()
		{
		    $this->GetAjax()->ProcessRequests();
		}

   /**
	* Limpa os campos do formulário 
	* @param string $strIdForm (Opcional) Id do formulário a ser reiniciado
	* @return void
	* @access public
	*/
		public function ClearForm()
		{
		    $this->GetAjaxResponse()->AddScript("objForm.clear();");
		}
		
   /**
	* Exibe a mensagem de retorno de uma requisição
	* @param string $strMessage Mensagem de resposta
	* @param string $strDivId Nome do ID da div a ser exibida a mensagem. Opcional.
	* @param boolean $blnReturn true para que o método retorne o objeto AjaxResponse. Opcional.
	* @return Object AjaxResponse
	* @access public
	*/
		public function Response($strMessage, $strDivId = "Aviso", $blnReturn = true)
		{
		    $this->GetAjaxResponse()->AddScript("scroll(0,0);");
			$this->GetAjaxResponse()->AddAssign($strDivId, "style.display", "block");
			$this->GetAjaxResponse()->AddAssign($strDivId, "innerHTML", "<div class=\"Message_OK\">" . $strMessage . "</div>");
			
			if($blnReturn)
			{
			    return $this->GetAjaxResponse();
			}	
		}

   /**
	* Exibe a mensagem de erro de uma requisição
	* @param mixed $mxdMessage Este parâmetro pode ser tanto um objeto Exception 
	* @param string $strDivId Nome do ID da div a ser exibida a mensagem. Opcional.
	* @param boolean $blnReturn true para que o método retorne o objeto AjaxResponse. Opcional
	* quando uma string contendo uma mensagem de erro
	* @return Object AjaxResponse
	* @access public
	*/
		public function Error($mxdMessage, $strDivId = "Aviso", $blnReturn = true)
		{
		    // Se for um objeto Exception
			if(is_object($mxdMessage))
			{
				$objMessage = new Message();
				$objMessage->SetException($mxdMessage);
				
				$arException = $objMessage->FormatExceptionMessage(SystemConfig::MSG_DEBUG_TRACE);
				
				$this->GetAjaxResponse()->AddScript("scroll(0,0);");
				$this->GetAjaxResponse()->AddAssign($strDivId, "style.display", "block");
				$this->GetAjaxResponse()->AddAssign($strDivId, "innerHTML", "<div class=\"Message_ERROR\">" . $arException[0] . "</div>");
				
				// Caso esteja habilitado exibe o Debug BackTrace
				if(!is_null($arException[1]))
				{
					$this->GetAjaxResponse()->AddAlert($arException[1]);
				}
			}
			else
			{
				$this->GetAjaxResponse()->AddScript("scroll(0,0);");
				$this->GetAjaxResponse()->AddAssign($strDivId, "style.display", "block");
				$this->GetAjaxResponse()->AddAssign($strDivId, "innerHTML", "<div class=\"Message_ERROR\">" . $mxdMessage . "</div>");
			}	
			
			if($blnReturn)
			{
			    return $this->GetAjaxResponse();
			}
		}
  /**
	* Exibe a mensagem de retorno de uma requisição
	* @param string $strUrl Url de redirecionamento
	* @param string $strDivId Nome do Id da div a ser exibida a mensagem. Opcional.
	* @param boolean $blnReturn true para que o método retorne o objeto AjaxResponse. Opcional.
	* @return Object AjaxResponse
	* @access public
	*/
		public function Redirect($strUrl, $strDivId = "Aviso", $blnReturn = true)
		{
		    $this->GetAjaxResponse()->AddAssign($strDivId, "innerHTML", "<div class=\"Message_OK\">Sucesso! Aguarde o carregamento...</div>");
		    $this->GetAjaxResponse()->AddRedirect($strUrl);
			
			if($blnReturn)
			{
			    return $this->GetAjaxResponse();
			}
		}
		
  /**
	* Recarrega a página atual
	* @param boolean $blnReturn true para que o método retorne o objeto AjaxResponse. Opcional.	
	* @return Object AjaxResponse
	* @access public
	*/
		public function Reload($blnReturn = true)
		{
		    $this->GetAjaxResponse()->AddScript("window.location.reload();");
			
			if($blnReturn)
			{
			    return $this->GetAjaxResponse();
			}
		}
				
   /**
	* Atribui o valor do atributo do objeto informado a sua respectiva variável smarty na interface
	* Campos que são chave estrangeira são ignorados, devendo ser setados manualmente.
	* Ex.: {value_cli_nome} $objSmarty->assign("value_cli_nome", $objCliente->GetCli_nome());
	* @param object $objObjectLoaded
	* @param string $strPrefix (Opcional) Prefixo do campo no formulário Ex.: value_cli_nome (_value)
	* @param string $strPosfix (Opcional) Sufixo do campo no formulário Ex.: value_end_numero_entrega (_entrega)
	* @return void
	* @access public
	*/
		public function AutoAssign($blnEdit = true, $objObjectLoaded, $strPrefix = '', $strSuffix = '')
		{
		    if(!is_object($objObjectLoaded))
			{
			    throw new ViewException("O parâmetro informado não é um objeto válido");
			}
			
			// Reflexão do objeto informado:
			$objRClass = new ReflectionClass(get_class($objObjectLoaded));
			
			// Percorre o objeto setando o conteúdo de cada atributo
			// na sua respectiva variável do template:
			foreach($objRClass->GetProperties() as $objRProperty)
			{
				$strMethod = Utils::BuildProperty("Get", $objRProperty->name);
				$strField  = $strPrefix . $objRProperty->name . $strSuffix;
				
				if($blnEdit)
				{
				    // Formato textarea:
					$strValue = Utils::BrToNl($objObjectLoaded->$strMethod());
				}
				else
				{
				    // Formato html:
					$strValue = $objObjectLoaded->$strMethod();
				}				
				
				$this->GetSmarty()->assign($strField, $strValue);				
			}
		}

    /**
     * Define na variável {$action} o método a ser chamado pela controladora
	 * @param string $strMethod Valor da contante pré-definida __METHOD__.
     * @return void
     * @access public
     */
		 public function Action($strMethod)
		 {
			 try
			 {
				 // ViewCliente::frmCadastrar => cadastrar
				 if(strpos($strMethod, "::") > 0){
					 $strAction = strtolower((str_replace("frm", "", next(explode("::", $strMethod))))); 
			     }
				 else{
					 $strAction = $strMethod;
				 }
				 
				 $this->GetSmarty()->assign("action", $this->GetCrypt()->ShortEncrypt($strAction));
			 }
			 catch(Exception $e)
			 {
				 throw $e;
			 }
		 }

   /**
	* Carrega os plugins JQuery em requisições Ajax
	* @param array $arPlugins Plugins a serem inseridos no form
	* @return void
	* @access public
	*/
		public function LoadJQueryPlugins($arPlugins = NULL)
		{
			try
			{
				$arValidPlugins = array("tooltip", "calendar");
				$strLoadFunctions = "";
				
				// Se os plugins não foram informados carrega todos:
				if(is_null($arPlugins))
				{
				    $arPlugins = $arValidPlugins;
				}	
			
				foreach($arPlugins as $strPlugin)
				{
					if(in_array($strPlugin, $arValidPlugins))
					{
						$strLoadFunctions .= "objJQueryLibs.plugin".ucfirst($strPlugin)."(); ";
					}
					else
					{
						throw new ViewException($strPlugin . " não é um plugin JQuery válido");
					}
				}
				
				// Executando a chamada das fuções dos plugins novamente.
				$this->onLoad($strLoadFunctions);
			}
			catch(Exception $e)
			{
				throw $e;
			}
		}
}