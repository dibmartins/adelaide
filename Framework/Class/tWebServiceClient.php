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
 *
 * @package Framework
 * @subpackage WebServices
 * @version 1.0 - 2007-05-05 10:41:20
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class WebServiceClientException extends Exception{}

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

class WebServiceClient extends soapclient
{
    /**
     * Attributes:
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
         public function __construct($strServer)
         {
			 parent::__construct(SystemConfig::SYSTEM_URL . SystemConfigECommerce::WSDL_URL . $strServer . "?wsdl", true);
		 }

    /**
     * Chama o serviço requisitado
     * @param string $strService
	 * @param array $arParams
     * @return object XML
     * @access public
     * @throws WebServiceClientException Dispara uma exceção caso ocorra algum erro
     */
         public function Call($strService, $arParams)
         {
             try
             {
			     // Chama pelo serviço solicitado:
				 $strResult = parent::call($strService, $arParams);
			
			     // Verifica se algum erro ocorreu:
			     if($this->GetError()) 
				 {
				     throw new WebServiceClientException($this->GetError());
				 }	 
				 elseif($this->fault)  
				 {
				     throw new WebServiceClientException($strResult);
				 }	 
				 else
				 {
					 $objXML = new XML();
					 
					 // Transforma em objeto o XML retornado pelo WebService:
					 $objXMLResult = $objXML->loadString($strResult);
					 
					 // Decodifica as informações do XML
					 if(is_a($objXMLResult, "SimpleXMLElement"))
					 {
					     $this->decode($objXMLResult);
					 }
					 
					 // Retorna o objeto XML decodificado:
					 return $objXMLResult;
				 }
             }
             catch(Exception $e)
             {
                 throw $e;
             }
		 }
		 
    /**
     * Decodifica o valor de cada elemento no objeto XML
     * @param object SimpleXMLElement $objSimpleXML
	 * @return object SimpleXMLElement
     * @access public
     * @throws Exception Dispara uma exceção caso ocorra algum erro
     */
         public function Decode(SimpleXMLElement $objSimpleXML)
         {
             try
             {
			     $objCrypt = new Crypt;

				 foreach($objSimpleXML->row as $objSimpleXML)
				 {
					 foreach(get_object_vars($objSimpleXML) as $strAttribute => $strValue)
					 {
						 // Decodifica:
						 $strValue = $objCrypt->ShortDecrypt(Utils::UnHTMLEntities($strValue));
						 
						 // Escapa o caractere &
						 $strValue = strpos($strValue, "&") ? htmlentities($strValue) : $strValue;
						 
						 $objSimpleXML->$strAttribute = $strValue;
					 }
				 }
				 
				 return $objSimpleXML;
             }
             catch(Exception $e)
             {
                 throw $e;
             }
		}	 			 		 
}
