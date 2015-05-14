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
 * @version 1.0 - 2006-09-27 16:30:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class RequestGetException extends Exception{}

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
 * Classe de gerenciamento e validação de requisições via GET
 * Esta classe utiliza as classes ArrayAccess e IteratorAggregate do pacote SPL do PHP
 *
 * Os métodos offset... e getIterator não seguem a convenção de codificação
 * pois são nativas das interfacesArrayAccess, IteratorAggregate
 * @package Framework
 * @subpackage HTTP Request
 * @version 1.0 - 2006-09-27 16:30:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class RequestGet implements ArrayAccess, IteratorAggregate
{
   /** 
    * Atributos:
    */   
   
   /**
	* @var array $arGet
	* @access private
	*/
	private $arGet;
	
//---------------------------------------------------------------------------------------------	
	
   /** 
    * Propriedades:
    */

   /**
	* Método para setar o valor do atributo $arGet
	* @param array $arGet Conteúdo do array $_GET
	* @return void		 
	* @access public
	*/
		public function SetGet($arGet)
		{
		    $this->arGet = $arGet;
		}

   /**
	* Método para retornar o valor do atributo $arGet
	* @return string $arGet
	* @access public
	*/
		public function GetGet()
		{
		    return $this->arGet;
		}
		
//---------------------------------------------------------------------------------------------	
		
   /** 
    * Métodos:
    */

   /**
	* Método construtor da classe
	* @return void
	* @access public
	*/
		public function __construct()
		{
		    // Inicializando $_GET caso ele tenha sido setado:
			if(isset($_GET))
			{
			    // Validando cada elemento de $_POST:
				$this->SetGet(array_map(array(__CLASS__, 'Validate'), $_GET));
			}
			else
			{
			    $this->SetGet(NULL);
			}
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
	* Método de sobrecarga para retornar os valores de $_GET
	* @param strAtribute Nome do elemento de $this->arGet que se deseja obter o valor 
	* @return mixed Valor de $this->arGet[strAtribute]
	* @access public
	*/		
		public function __get($strAtribute)
		{
		     return $this->arGet[$strAtribute];			
		}

   /**
	* Método de sobrecarga para setar os valores de $_GET
	* @param strAtribute Nome do elemento de $this->arGet que se deseja setar o valor
	* @param mixed $mxdValue Valor a ser setado em $this->arGet
	* @return void
	* @access public
	*/
	    public function __set($strAtribute, $mxdValue)
	    {
		    $this->arGet[$strAtribute] = $mxdValue;
	    }

   //** Métodos necessários da classe Iterator
   
   /**
	* Método Iterator 
	* @return boolean
	* @access public
	*/  
	    public function offsetExists($offset)
	    {         
		    if(isset($this->arGet[$offset]))  
			{
			    return true;
			}	
		    else 
			{
			    return false;
			}	
	    }   

   /**
	* Método Iterator 
	* @return boolean
	* @access public
	*/  
	    public function offsetGet($offset)
	    { 
		    if ($this->offsetExists($offset))  
		    {
			    return $this->arGet[$offset];
		    }	   
		    else 
		    {
			   return (false);
		    }	   
	    }
  
   /**
	* Método Iterator 
	* @return void
	* @access public
	*/  
	    public function offsetSet($offset, $value)
	    {         
		    if ($offset)  
			{
			    $this->arGet[$offset] = $value;
		    }
			else  
			{
			    $this->arGet[] = $value;
			}	
	    }
  
   /**
	* Método Iterator 
	* @return void
	* @access public
	*/  
	    public function offsetUnset($offset)
	    {
		    unset ($this->arGet[$offset]);
	    }
  
   /**
	* Método Iterator 
	* @return array
	* @access public
	*/     
        public function &getIterator()
        {
            if(is_array($this->arGet))
	    {
	       $objIterator = new ArrayIterator($this->arGet);
	       
	       return $objIterator;
	    }
	    else
	    {
		throw new RequestGetException("Nenhuma requisição via GET foi solicitada");
	    }	
        }
   
   //** Fim dos métodos da classe Iterator

   /**
	* Retorna a string sem caracteres e palavras inválidas. 
	* @param string $strString String a ser verificada.
	* @return string $strString
	* @static método estático
	* @access private
	*/		
		private static function Validate($strString)
		{
		    if(is_array($strString) || is_object($strString)) 
			{ 
			    return $strString;
			}
			else
			{			
			    return Utils::CheckSQLInjection($strString);
			}	
		}
		
   /**
	* Retorna o post como uma string XML
	* @param string $strSaveToFile (Opcional) arquivo XML onde a string gerada será salva.
	* @param boolean $blnCrypt Se true o conteúdo das tags XML será criptografado
	* @return string RecordSet no formato de string XML 
	* @access public
	*/
	    public function ExportToXML($strSaveToFile = '', $blnCrypt = false)
	    {
		    try
			{
				$objXML = new XML();
	
				$objXML->push('request');
				
				if($blnCrypt) $objCrypt = new Crypt;
				
				$objXML->push('row');
				
				foreach($this as  $strField => $strValue) 
				{
				    $strValue = $blnCrypt ? $objCrypt->ShortEncrypt($strValue) : "<![CDATA[".$strValue."]]>";
					
					$objXML->element($strField, $strValue);
				}
				
				$objXML->pop();
				$objXML->pop();
				
				$strXml = $objXML->GetXml();
				
				// Salvando o xml em arquivo:
				if(!empty($strSaveToFile))
				{
				    $objFile = new File($strSaveToFile,'w+');
                    $objFile->Open();
                    $objFile->Write($strXml);
                    $objFile->Close();
				}
				
				return $strXml;
			}
			catch(Exception $e)
			{
			   throw new AdoRecordSetException($e->GetMessage());
			}
		}		
}
