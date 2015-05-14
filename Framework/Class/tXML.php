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
 * Classe responsável por montar strings de comando SQL SELECT
 * @package Framework
 * @subpackage XML
 * @version 1.0 - 2006-10-24 15:30:00 
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class XML
{
   /** 
    * Attributes:
    */   
   
   /**
	* @name string $strXML
	* @access private
	*/
	private $strXML;

   /**
	* @name string $strIndent
	* @access private
	*/
   
    private $strIndent;

   /**
	* @name array $arStack
	* @access private
	*/
    private $arStack = array();
    
//---------------------------------------------------------------------------------------------	
	
   /** 
    * Properties:
    */   
   
   /**
	* Método para setar o valor do atributo $strFile
	* @param string $xml String XML a ser gerada
	* @return void		 
	* @access public
	*/
		public function SetXML($xml)
		{
			 $this->strXML = (string) $xml;
		}

   /**
	* Método para retornar o valor do atributo $strXML
	* @return string $strXML
	* @access public
	*/
		public function GetXML()
		{
			 return $this->strXML;
		}	

   /**
	* Método para setar o valor do atributo $strIndent
	* @param string $indent String constituida de espaços em branco para indentação do arquivo
	* @return void		 
	* @access public
	*/
		public function SetIndent($indent)
		{
			 $this->strIndent = (string) $indent;
		}

   /**
	* Método para retornar o valor do atributo $strIndent
	* @return string $strIndent
	* @access public
	*/
		public function GetIndent()
		{
			 return $this->strIndent;
		}

   /**
	* Método para setar o valor do atributo $arStack
	* @param string $stack
	* @return void		 
	* @access public
	*/
		public function SetStack($stack)
		{
			 $this->arStack = (string) $stack;
		}

   /**
	* Método para retornar o valor do atributo $arStack
	* @return string $arStack
	* @access public
	*/
		public function GetStack()
		{
			 return $this->arStack;
		}
			
//---------------------------------------------------------------------------------------------	
		
   /** 
    * Methods:
    */	

   /**
    * Método construtor da classe
	* @param string $strCSS Folha de estilo do arquivo XML
	* @param string $strIndent Indentação do XML
	* @param string $strEncoding Tipo de codificação do arquivo (iso-8859-1, utf-8), O padrão é iso-8859-1
	* @access public
	*/
		public function __construct($strIndent = '  ', $strEncoding = 'iso-8859-1') 
		{
			try
			{
				$this->SetIndent($strIndent);
				$this->strXML    = "<?xml version=\"1.0\" encoding=\"" . $strEncoding . "\" ?>" . "\n";
			}
			catch(Exception $e)
			{
			    throw $e;
			}	
			
		}

   /**
    * Concatena a string com a indentação
	* @access private
	*/
		private function Indent() 
		{
			for($i = 0; $i < count($this->arStack); $i++) 
			{
				$this->strXML .= $this->GetIndent();
			}
		}

   /**
    * Abre um novo item na string XML
	* @param string $strItem Item a ser adicionado
	* @param array $arAttributes Atributos do item
	* @access public
	*/
		public function Push($strItem, $arAttributes = array()) 
		{
			$this->Indent();
			$this->strXML .= "<" . $strItem;
		
			foreach($arAttributes as $key => $value) 
			{
				$this->strXML .= ' '.$key.'="'.$value.'"';
			}
		
			$this->strXML   .= ">\n";
			$this->arStack[] = $strItem;
		}

   /**
    * Fecha um item na string XML
	* @access public
	*/
		public function Pop() 
		{
			$strElement = array_pop($this->arStack);
			
			$this->Indent();
			$this->strXML .= "</" . $strElement . ">\n";
		}
		
   /**
    * Adiciona um elemento na string XML
	* @param string $strElement Elemento a ser adicionado
	* @param string $strContent Conteúdo do elemento a ser adicionado
	* @param array $arAttributes Atributos do elemento
	* @access public
	*/
		public function Element($strElement, $strContent, $arAttributes = array()) 
		{
			$this->Indent();
			$this->strXML .= "<".$strElement;
			
			foreach($arAttributes as $key => $value) 
			{
				$this->strXML .= " " . $key ."=' " . $value . '"';
			}
			
			$this->strXML .= ">" . $strContent . "</" . $strElement . ">" . "\n";
		}
		
   /**
    * Adiciona um elemento vazio ou seja que só possui tag de abertura
	* @param string $strElement Elemento a ser adicionado
	* @param array $arAttributes Atributos do elemento
	* @access public
	*/		
		public function EmptyElement($strElement, $arAttributes = array()) 
		{
			$this->Indent();
			$this->strXML .= "<" . $strElement;
			
			foreach($arAttributes as $key => $value) 
			{
				$this->strXML .= ' '.$key.'="'.$value.'"';
			}
			
			$this->strXML .= " />\n";
		}
		
   /**
    * Carrega o conteúdo de um arquivo XML para um objeto SimpleXMLElement
	* @param string $strXMLFile Arquivo XML a ser carregado
	* @return object SimpleXMLElement Objeto contendo os dados do arquivo xml
	* @access public
	*/		
		public function LoadFile($strXMLFile) 
		{
			return @simplexml_load_file($strXMLFile, 'SimpleXMLElement', LIBXML_NOCDATA);
		}
		
   /**
    * Carrega o conteúdo de uma string XML para um objeto SimpleXMLElement
	* @param string $strXMLString string XML a ser carregada
	* @return object SimpleXMLElement Objeto contendo os dados da string xml
	* @access public
	*/
		public function LoadString($strXMLString) 
		{
			return simplexml_load_string($strXMLString);
		}
		
    /**
     * Retorna a resposta em formato xml
     * @param object SimpleXMLElement $objSimpleXML
	 * @return string XML com a resposta
     * @access public
     * @throws Exception Dispara uma exceção caso ocorra algum erro
     */
         public function ArrayToXML($arResponse, $blnCrypt = false, $strMainNode = 'result')
         {
             try
             {
				 $this->push($strMainNode);
				 
				 if($blnCrypt) $objCrypt = new Crypt;
				
				 $this->push('row');
								 
				 foreach($arResponse as $strKey => $strValue)
				 {
				     $strValue = $blnCrypt ? $objCrypt->ShortEncrypt($strValue) : "<![CDATA[".$strValue."]]>";
					 $this->element($strKey, $strValue);
				 }	 
				 
				 $this->pop();
				 $this->pop();
				
				 return $this->GetXml();
             }
             catch(Exception $e)
             {
                 throw $e;
             }
		}

		/**
		* ATENÇÃO AINDA NÃO ESTÁ 100%
		* 
		* @param array $data
		* @param string $rootNodeName - what you want the root node to be - defaultsto data.
		* @param SimpleXMLElement $xml - should only be used recursively
		* @return string XML
		*/

		public static function toXml($data, $rootNodeName = 'data', $xml = null, $strEncoding = 'iso-8859-1')
		{
			// turn off compatibility mode as simple xml throws a wobbly if you don't.
			if (ini_get('zend.ze1_compatibility_mode') == 1)
			{
				ini_set ('zend.ze1_compatibility_mode', 0);
			}
	
			if ($xml == null)
			{
				$xml = simplexml_load_string("<?xml version='1.0' encoding='".$strEncoding."' ?><$rootNodeName />");
			}
	
			// loop through the data passed in.
			foreach($data as $key => $value)
			{
				// no numeric keys in our xml please!
				if (is_numeric($key))
				{
					// make string key...
					$key = "noDesconhecido_". (string) $key;
				}
	
				// replace anything not alpha numeric
				//$key = preg_replace('/[^a-z]/i', '', $key);
	
				// if there is another array found recrusively call this function
				if (is_array($value))
				{
					$node = $xml->addChild($key);
	
					// recrusive call.
					self::toXml($value, $rootNodeName, $node);
				}
				elseif(!is_object($value))
				{
					// add single node.
					$value = htmlentities($value);
	
					$value = "<![CDATA[".$value."]]>";
					
					$xml->addChild($key,$value);
				}
	
			}
	
			// pass back as string. or simple xml object if you want!
			return $xml->asXML();

	   }		
}
