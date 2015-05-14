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
 * @subpackage Crypt
 * @version 1.0 - 2006-11-16 15:05:00 
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class CryptException extends Exception{}

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
 * Classe responsável por criptografar e descriptografar dados sigilosos
 * @package Framework
 * @subpackage Crypt
 * @version 1.0 - 2006-11-16 15:05:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class Crypt
{
   /** 
    * Attributes:
    */

   /**
    * Chave da criptografia
    * @var $strKey
	* @access private
	*/		
	private $strKey;   

   /**
    * Algoritmo utilizado para criptografar
    * @var $strAlgorithm
	* @access private
	*/		
	private $strAlgorithm;   

   /**
    * Define se será utilizado modo binário ou não
    * @var $blnBinMode
	* @access private
	*/		
	private $blnBinMode;

   /**
    * números utilizados na criptografia
    * @var $arNumbers
	* @access private
	*/		
	private $arNumbers;

   /**
    * Letras utilizadas na criptografia
    * @var $arChars
	* @access private
	*/		
	private $arChars;

   
//---------------------------------------------------------------------------------------   

   /** 
    * Properties:
    */

   /**
	* Método para setar o valor do atributo $strKey
	* @return void		 
	* @access public
	*/
		public function SetKey($strKey)
		{
			 $this->strKey = $strKey;
		}

   /**
	* Método para retornar o valor do atributo $strKey
	* @return string $strKey
	* @access public
	*/
		public function GetKey()
		{
			 return $this->strKey;
		}    
   
   /**
	* Método para setar o valor do atributo $strAlgorithm
	* @return void		 
	* @access public
	*/
		public function SetAlgorithm($strAlgorithm)
		{
			 $this->strAlgorithm = $strAlgorithm;
		}

   /**
	* Método para retornar o valor do atributo $SetAlgorithm
	* @return string $SetAlgorithm
	* @access public
	*/
		public function GetAlgorithm()
		{
			 return $this->SetAlgorithm;
		}
		
   /**
	* Método para setar o valor do atributo $blnBinMode
	* @return void		 
	* @access public
	*/
		public function SetBinMode($blnBinMode)
		{
			 $this->blnBinMode = $blnBinMode;
		}

   /**
	* Método para retornar o valor do atributo $blnBinMode
	* @return string $blnBinMode
	* @access public
	*/
		public function GetBinMode()
		{
			 return $this->blnBinMode;
		}
		
   /**
	* Método para setar o valor do atributo $arNumbers
	* @return void		 
	* @access public
	*/
		public function SetNumbers($arNumbers)
		{
			 $this->arNumbers = $arNumbers;
		}

   /**
	* Método para retornar o valor do atributo $strKey
	* @return string $arNumbers
	* @access public
	*/
		public function GetNumbers()
		{
			 return $this->arNumbers;
		}				   
   
   /**
	* Método para setar o valor do atributo $arChars
	* @return void		 
	* @access public
	*/
		public function SetChars($arChars)
		{
			 $this->arChars = $arChars;
		}

   /**
	* Método para retornar o valor do atributo $arChars
	* @return string $arChars
	* @access public
	*/
		public function GetChars()
		{
			 return $this->arChars;
		}   

//---------------------------------------------------------------------------------------   
   
   /** 
    * Methods:
    */
   
   /**
	* Método construtor da classe
	* Valor padrão dos parâmetros definidos na classe de configuração
	* @return void
	* @access public
	*/   
       public function __construct($strAlgorithm = SystemConfig::ENCRYPT_ALGORITHM,
	   							   $blnBinMode   = SystemConfig::ENCRYPT_BIN_MODE,
								   $strKey       = SystemConfig::ENCRYPT_KEY)
       {
			$this->SetAlgorithm($strAlgorithm);
			$this->SetBinMode($blnBinMode);
			$this->SetKey($strKey);
			
			//Define os números e as letras utilizados na criptografia
			$this->SetNumbers(array('0', '1', '2', '3', '4', '5'));
			$this->SetChars(array('a', 'b', 'c', 'd', 'e', 'f'));
			
			if(!in_array($this->strAlgorithm, hash_algos())) 
			{
				throw new CryptException('Algoritmo '. $this->strAlgorithm.' não disponível.');			
			}
			
			if($this->blnBinMode) 
			{			
				if(!function_exists('gzdeflate') || !function_exists('gzinflate')) 
				{			
					throw new CryptException('Modo binário não disponível');
				}
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
	* Exibe uma lista completa de algoritmos disponíveis
	* no sistema para o uso nesta classe. Até o presente momento é recomendado
	* o uso do sha512, que é o mais seguro.
	* @autor Douglas <xxx@xxxx.com.br>
	* @return string
	* @access public
    */
	public function AvailableAlgorithms()
	{
		$arAlgorithms = hash_algos();
		
		if( $intTotal = count($arAlgorithms) ) 
		{
			
			$strText = '<fieldset><legend>Algoritmos - total: ' . $intTotal . '</legend>';
			
			foreach ($arAlgorithms as $strAlgorithm) 
			{
				$intSize = strlen( hash($strAlgorithm, 'a') );
				
				$strText .= '<li>' . $strAlgorithm . ' - Tamanho da string: ' . $intSize . '</li>';
			}
			
			$strText .= '</fieldset>';
			
			return $strText;
		}
	}

   /**
	* Método que gera um texto cifrado de linha única, representado em
	* caracteres "hexadecimais" disfarçados. Se o modo binário estiver ativo,
	* o texto não será mais disposto em caracteres hexadecimais legíveis. A
	* chave secreta é opcional, mas é mais seguro usá-la, pois só poderá
	* decifrar o conteúdo do texto cifrado quem conhecer e informar a chave
	* para o método que decifra.
	* @autor Douglas <xxx@xxxx.com.br>
	* @param string $strText Texto limpo (não cifrado)
	* @return String Texto cifrado
	*/ 	   
	   public function Encrypt($strText)
	   {
			if($this->blnBinMode) 
			{
				$strKey = strrev( hash($this->strAlgorithm, $this->strKey) );
			}
			else 
			{
				$strKey = strrev( hash($this->strAlgorithm, $this->strKey . strlen($strText)) );
			}

			$intTextSize = strlen($strText);
			$intKeySize  = strlen($strKey);

			$strCrypt = '';

			for($i = 0, $j = 0; $i < $intTextSize; $i++) 
			{
				if($j < ($intKeySize - 1)) $j++;
				else $j = 0;

				$strCrypt .= sprintf('%03d', (ord($strText[$i]) + ord($strKey[$j])));
			}
			
			if($this->blnBinMode) 
			{
				return gzdeflate(str_replace($this->arNumbers, $this->arChars, $strCrypt));
			}
			
			return str_replace($this->arNumbers, $this->arChars, $strCrypt);	   
	   }
	   
	/**
	 * Método responsável por decifrar o conteúdo do texto cifrado
	 * pelo método Encrypt() desta classe. O texto só poderá ser decifrado com o
	 * conhecimento da chave, ou se a chave não foi usada na operação de cifra.
	 * @autor Douglas <xxx@xxxx.com.br>
	 * @param String $strCrypt Texto cifrado
	 * @return String Texto decifrado
	 */ 	   
	   public function Decrypt($strCrypt)
	   {
			if($this->blnBinMode)
			{
				$strKey   = strrev( hash($this->strAlgorithm, $this->strKey) );
				$strCrypt = gzinflate($strCrypt);
			}
			else
			{
				$strKey = strrev( hash($this->strAlgorithm, $this->strKey . ( strlen($strCrypt)/3)));
			}
			
			$strText = str_replace($this->arChars, $this->arNumbers, $strCrypt);
			
			$intTextSize = strlen($strText);
			$intKeySize  = strlen($strKey);
			
			$strCleanText = '';
			
			$arChars = str_split($strText, 3);
			
			for($i = 0, $j = 0; $i < (($intTextSize / 3)); $i++) 
			{
				if( $j < ($intKeySize - 1) ) $j++;
				else $j = 0;
				
				$strCleanText .= chr($arChars[$i] - ord($strKey[$j]));
			}
			
			return $strCleanText;
	   }
   
   /**
	* Gera o hash do método ShortEncrypt
	* @return string Hash
	* @access private
	*/ 
	   private function ShortHash($strString) 
	   { 
	       $strHash  = md5($this->GetKey()); 
		   $strCount = 0; 
		   $strCrypt = ""; 
		  
		   for($i = 0; $i < strlen($strString); $i++) 
		   { 
		       if($strCount == strlen($strHash)) 
			   {
			       $strCount = 0; 
			   }	 
			 
			   $strCrypt .= substr($strString, $i, 1) ^ substr($strHash, $strCount, 1); 
			 
			   $strCount++; 
		  } 
		  
		  return $strCrypt; 
	   } 
	   
   /**
    * Criptografa a string passada como parâmetro
	* @param $strString String a ser criptografada
	* @return string String criptografada
	* @access public
	*/ 	   
	   public function ShortEncrypt($strString)
	   { 
		   srand((double) microtime() * 1000000); 
	   
		   $strHash  = md5(rand(0, 32000)); 
		   $strCount = 0;
		   $strCrypt = ""; 
	   
		   for($i = 0; $i < strlen($strString); $i++)
		   { 
		       if($strCount == strlen($strHash)) $strCount = 0;
			 
			   $strCrypt .= substr($strHash, $strCount, 1) . (substr($strString, $i, 1) ^ substr($strHash, $strCount, 1)); 
		       
			   $strCount++; 
		   } 
		  
		   return base64_encode($this->ShortHash($strCrypt)); 
	   } 
	   
   /**
    * Descriptografa a string passada como parâmetro
	* @param $strString String a ser descriptografada
	* @return string String descriptografada
	* @access public
	*/	   
	   public function ShortDecrypt($strString) 
	   { 
	       $strString = $this->ShortHash(base64_decode($strString)); 
		   $strCrypt = ""; 
		  
		   for ($i = 0; $i < strlen($strString); $i++)
		   {
		       $strKeyd5 = substr($strString, $i, 1); 
			 
			   $i++; 
			 
			   $strCrypt .= (substr($strString, $i, 1) ^ $strKeyd5); 
		   } 
		  
		   return $strCrypt; 
	   }
	   
	/**
	 * Método usado para criptografar uma senha que contenha no mínimo um
	 * caracter e no máximo dez caracteres. A senha criptografada, seja qual for
	 * o seu tamanho (compreendido entre um e dez caracteres) irá ser gerada com
	 * trinta e dois caracteres em formato "hexadecimal" disfarçado. O mesmo
	 * Método servirá para criptografar ou descriptografar a senha. Uma senha
	 * criptografada sempre conterá trinta e dois caracteres, nos quais os dois
	 * últimos representam o número de caracteres reais da senha informada. Para
	 * decriptar a senha e exibi-la novamente conforme foi digitada, basta
	 * aplicar este mesmo método na senha criptografada.
	 * @param String $strPassword Password limpa ou criptografada
	 * @return String Password limpa ou criptografada
	 */
	public function Password($strPassword)
	{
		$intPasswordSize = sprintf('%02d', strlen($strPassword) );
		
		if(((int) $intPasswordSize > 10   && 
			(int) $intPasswordSize != 32) || 
			(int) $intPasswordSize == 0) 
		{
			throw new CryptException('A senha deve ter no mínimo 1 e no máximo 10 caracteres');
		}
		
		// Se a senha é a senha crua, cifrar a mesma:
		if( (int)$intPasswordSize <= 10 ) 
		{
			$strHash = strrev( hash($this->strAlgorithm, $intPasswordSize) );
			
			$strCriptedPassword = '';
			
			for($i=0; $i<(int)$intPasswordSize; $i++) 
			{
				$strCriptedPassword .= sprintf('%03d', (ord($strPassword[$i]) + ord($strHash[$i])));
			}
	
			$strCriptedPassword = str_replace($this->arNumbers, $this->arChars, $strCriptedPassword);
			
			// Completando com valores de onde termina a senha até 30 caracteres
			$strCompleteness = hash($this->strAlgorithm, $strPassword);
			
			for($i=(strlen($strCriptedPassword) - 1); $i < 29; $i++) 
			{
				$strCriptedPassword .= $strCompleteness[$i];
			}
			
			return $strCriptedPassword . $intPasswordSize;
		}
		
		// Se a senha é a senha cifrada, decifrar a mesma:
		else 
		{
			$intPasswordSize      = substr($strPassword, 30);
			$strHash              = strrev( hash($this->strAlgorithm, $intPasswordSize) );
			$strCleanPassword     = substr($strPassword, 0, ( (int)$intPasswordSize * 3) );
			$strPasswordNums      = str_replace($this->arChars, $this->arNumbers, $strCleanPassword);
			$strDecriptedPassword = '';
			$arChars              = str_split($strPasswordNums, 3);
			
			for($i=0; $i<(int)$intPasswordSize; $i++) 
			{
				$strDecriptedPassword .= chr($arChars[$i] - ord($strHash[$i]) );
			}
			
			return $strDecriptedPassword;
		}
	}
	
   /**
    * Método que gera uma senha aleatória com no máximo dez caracteres.
	* @param int $intMinSize Tamanho mínimo de caracteres para a senha
	* @return string Senha gerada
	*/
	public function MakePassword($intMinSize = 3)
	{
		return substr(str_shuffle(uniqid()), 0, mt_rand($intMinSize, 10));
	}		   
}