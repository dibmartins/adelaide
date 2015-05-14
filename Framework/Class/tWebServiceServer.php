<?php 

require_once('class.NuSoap.php');

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
 * @subpackage WebServices
 * @version 1.0 - 2006-11-21 15:13:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class WebServiceServerException extends Exception{}

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
 * Classe de gerenciamento de clientes Web Services
 * @package Framework
 * @subpackage WebServices
 * @version 1.0 - 2006-11-21 15:13:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class WebServiceServer extends soap_server
{
   /** 
    * Attributes:
    */

   /**
	* @var object $objCrypt
	* @access private
	*/
	    private $objCrypt;
		
   /**
	* @var object $objXML
	* @access private
	*/
	    private $objXML;		

//---------------------------------------------------------------------------------------------	
	
   /** 
    * Properties:
    */

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
	* Método para setar o valor do atributo $objXML
	* @param object $objXML Objeto XML
	* @return void		 
	* @access public
	*/
		public function SetXML(XML $objXML)
		{
			$this->objXML = $objXML;
		}

   /**
	* Método para retornar o valor do atributo $objXML
	* @return object $objXML
	* @access private
	*/
		public function GetXML()
		{
			return $this->objXML;
		}		

//---------------------------------------------------------------------------------------------	

   /** 
    * Methods:
    */	

   /**
    * Registra como webservice cada método do objeto informado
	* @param string $strWSDL Nome do WSDL a ser gerado
	* @return object SimpleXMLElement Objeto contendo os dados da string xml
	* @access public
	*/
		public function RegisterServices($strWSDL)
		{
			try
			{
				$this->configureWSDL($strWSDL, 'urn:' . $strWSDL);
				
				foreach($this->GetServices() as $arService)
				{
					$strName          = get_class($this) . "." . $arService["service"];
					$arOut            = array("return" => "xsd:string");
					$strNamespace     = "urn:".$strName;
					$strSoapAction    = $strName."#".$strName;
					$strStyle         = "rpc";
					$strUse           = "encoded";
					$strDocumentation = $arService["docs"];
				
					if(is_array($arService["params"]))
					{
						foreach($arService["params"] as $strKey => $strParam)
						{
							$arParams[$strParam] = "xsd:string";
						}
					}	
					
					$this->register($strName, 
									$arParams, 
									$arOut, 
									$strNamespace, 
									$strSoapAction, 
									$strStyle, 
									$strUse, 
									$strDocumentation);
										 
					unset($arParams);					 
				}
			}
			catch(Exception $e)
			{
				return $e->GetMessage();
			}				
		}
		
	/**
     * Retorna as informações dos métodos desta classe para que sejam registrados como WebService
     * @return array
	 * @access public
     */
		public function GetServices()
		{
			try
			{
				// métodos que não devem ser registrados:
				$arIgnore = array("__construct");
				$arIgnore = array_merge($arIgnore, get_class_methods(__CLASS__));
				
				foreach(get_class_methods($this) as $intKey => $strMethod)
				{
					if(in_array($strMethod, $arIgnore)) continue;
					
					$objReflection = new ReflectionMethod(get_class($this), $strMethod);
					
					$arServices[$intKey]["service"] = $strMethod;
					
					foreach($objReflection->GetParameters() as $objReflectionParameter)
					{
						$arServices[$intKey]["params"][] = $objReflectionParameter->name;
					}
					
					$arServices[$intKey]["docs"] = $objReflection->GetDocComment();	
				}

				return $arServices;
			}
			catch(Exception $e)
			{
				return $e->GetMessage();
			}
		}
}
