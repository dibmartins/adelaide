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
 * @subpackage Utils
 * @version 1.0 - 2007-02-15 13:37:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class AMFDebugException extends Exception{}
class UtilsException    extends Exception{}

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
 * Classe utilitária contendo diversos métodos estáticos para tarefas comuns
 * @package Framework
 * @subpackage Utils
 * @version 1.0 - 2007-02-15 13:37:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class Utils
{
    /** 
     * Attributes:
     */   
   
    /**
     * Marca o início da execução do script
     * @var float
     * @access private
     */
         private static $fltStartTime;
		 
    /**
     * Marca o fim da execução do script
     * @var float
     * @access private
     */
         private static $fltEndTime;		 
   
//------------------------------------------------------------------------------	
	
    /** 
     * Properties:
     */

//------------------------------------------------------------------------------	
		
   /** 
    * Methods:
    */

   /**
	* Método construtor da classe
	* @return void
	* @access public
	*/
		private function __construct(){}

   /**
	* Método destrutor da classe
	* @return void
	* @access public
	*/
	    private function __destruct()
	    {	
		    unset($this);
	    }

	/**
	 * Método que retorna o texto sem caracteres e palavras inválidas. 
	 * @param string $strString Dado a ser verificado.
	 * @static método estático
	 * @return string Dado validado
	 * @access public
     */		
		 public static function CheckSQLInjection($strString)
		 {	
		 	 $strString = trim($strString);
			 $strString = mysql_escape_string($strString);
		 
			 //$strBlackList = '/(select|insert|delete|drop table|';
			 //$strBlackList.= 'drop|where|show tables|or 1=1|\*|--|)/';		 
			 
			 // #DIEGO 
			 // A partir da versão 5.3.0 do PHP sql_regcase 
			 // está obsoleto e não há uma função equivalente
			 // O array abaixo substitui o uso dessa função
			 // http://php.net/manual/en/function.sql-regcase.php
			 //$strString = preg_replace(sql_regcase($strBlackList), '', $strString);
			 
			 $arrBlackList = array('select ', 'select(',
			 					   'insert ', 'insert(',
			 					   'delete ', 'delete(',
			 					   'drop '  , 
			 					   'table ' , 
			 					   'update ', 
			 					   'where ' , 
			 					   'show tables', 
			 					   'or 1=1');
			 
			 // Remove da string cada item da lista
			 foreach($arrBlackList as $strItem)
			 {
			 	$strString = str_ireplace($strItem, '', $strString);
			 }
			 
			 return $strString;		
		}
		
   /**
	* Retira $intNumPos caracteres do final de uma string
	* 
	* $intNumPos = 1 : "PHP" -> "PH"
	* $intNumPos = 2 : "PHP" -> "P"
	*
	* @param string $strString String a ser formatada
	* @param int $intNumPos Quantidade de caracteres a serem retirados no final da string
	* @static método estático
	* @return string String sem o espaço em branco e a virgula no final
	* @access public
	*/
		public static function CutLastChar($strString, $intNumPos)
		{
		    return substr($strString, 0, (strlen($strString) - $intNumPos)); 
		}
		
   /**
	* Inverso de htmlentities. Converte HTML entities para caracteres normais
    *
	* @param string $strString String a ser formatada
	* @static método estático
	* @return string
	* @access public
	*/		
		public static function UnHTMLEntities($strString)
		{
		    $strTranslationTable = get_html_translation_table(HTML_ENTITIES);
		    $strTranslationTable = array_flip($strTranslationTable);
		    $strString           = strtr($strString, $strTranslationTable);
		   
		    return str_replace(chr(34), "&quot;", $strString);
		}

   /**
	* Inverso de htmlentities. Converte HTML entities para caracteres normais
    *
	* @param string $strString String a ser formatada
	* @static método estático
	* @return string
	* @access public
	*/		
		public static function StripSlashes($strString)
		{
		    return stripslashes($strString);
		}
		
   /**
	* Retira todas as tags html.
    *
	* @param string $strString String a ser formatada
	* @static método estático
	* @return string
	* @access public
	*/		
		public static function StripTags($strString)
		{
		    return strip_tags($strString);
		}
		
  /**
	* Garante a exibição do conteúdo em html com os espaços e
	* as quebras de linha.
    *
	* @param string $strString String a ser formatada
	* @static método estático
	* @return string
	* @access public
	*/		
		public static function HtmlEntityDecodes($strString)
		{
		    return html_entity_decode($strString);
		}

   /**
	* Verifica os caracteres especiais e fomata para a exibição.
    *
	* @param string $strString String a ser formatada
	* @static método estático
	* @return string
	* @access public
	*/		
		public static function Utf8Encode($strString)
		{
		    return utf8_encode($strString);
		}

   /**
	* Gera uma string única, para ser utilizada como identificador
	* @param int $intStringSize Tamanho da string a ser retornada, o padrão é 10
	* @static método estático
	* @return string String aleatória
	* @access public
	*/
	    public static function UniqueId($intStringSize = 10)
	    {
		    return substr(md5(uniqid(time())), 0, $intStringSize);
		}

   /**
	* Retorna o ip do usuário
	* @static método estático
	* @return string
	* @access public
	*/
	    public static function UserIP()
	    {
		    return $_SERVER['REMOTE_ADDR'];
		}

     /**
	  * Converte o valor para o formato de moeda especificado
	  * 
	  * $intFormat = 0 : 00.000,00   -> 00000.00
	  * $intFormat = 1 : 00000.00    -> 00.000,00
	  * $intFormat = 2 : 00000.00    -> 00000,00
	  * $intFormat = 3 : 0000.000000 -> 0.000,000000
	  *
	  * @param string $strString Valor a ser formatado
	  * @param int $intFormat Formato a ser gerado.
	  * @static método estático
	  * @return float Valor formatado
 	  * @access public
	  */
	      public static function MoneyFormat($strString = 0, $intFormat = 1)
	      {
		      switch ($intFormat)
		      {
			      case 0:  
			      {
			      	  // Caso a formatação já esteja correta não formata
			      	  // #DIEGO: Adicionei essa condição pois como iremos 
			      	  // trabalhar com atributos Number dos objetos tModel
			      	  // no frontend, os valores já virão formatados, então
			      	  // não haverá necessidade de formatação. 
			      	  if(substr($strString, -3, 1) == '.') return $strString;
			      	
			      	  $strString = str_replace('.', '' , $strString);
					  $strString = str_replace(',', '.', $strString);
					  
					  return $strString;
					  
					  break;
			      }			
				  case 1:  
				  {
				  	  $strString = number_format($strString, 2, ',', '.');

				  	  return $strString;
					  
				  	  break;
				  }			
				  case 2:  
				  {
				  	  $strString = str_replace('.', '', $strString);
				  	  $strString = str_replace(',', '.', $strString);
				  	  $strString = number_format($strString, 2, ',', '');

				  	  return $strString;
					  break;
				  }
				  case 3:  
				  {
				  	  $strString = number_format($strString, 6, ',', '.');
					  return $strString;
					  break;
				  }	  
		      }   
	      }

    /**
	 * Método para formatação de textos inserindo quebra de linhas e parágrafos.
	 * @param  string $strString Valor a ser formatado
	 * @static método estático
	 * @return string Campo formatado
 	 * @access public
	 */
	     public static function BlobFormat($strString)
		 {
		     $strString = str_replace(chr(13), "<br>", $strString);
			 $strString = str_replace("\\n", "<br>", $strString);
			 $strString = str_replace("\\", "", $strString);
			 $strString = self::TextFormat($strString);

			 return self::UnHTMLEntities($strString);
		 }

    /**
	 * Método para formatação de textos.
	 * @param  string $strString Valor a ser formatado
	 * @static método estático
	 * @return string Texto formatado
 	 * @access public
	 */
	     public static function TextFormat($strString)
		 {
		     $strString = self::UnHTMLEntities($strString);
			 $strString = self::StripSlashes($strString);
			 
			 return $strString;
		 }

   /**
	* Converte <br /> para \n 
	* @param string $strValue Valor a ser formatado
	* @return string
	* @access public
	*/
		public function BrToNl($strValue)
		{
		    $strValue = str_replace(chr(13), "<br>", $strValue);
		    $strValue = str_replace("<br>", chr(10), $strValue); 
		    
			return $strValue;
		}
		 
   /**
	* Retorna o prefixo e o nome da propriedade de uma classe a partir do método informado
    * Ex.: Para o método "GetCli_nome" irá retornar array("Get","cli_nome")
	*
	* @param string $strMethod método a ser formatado getNomePropriedade ou setNomePropriedade
	* @static método estático
	* @return array
	* @access public
	*/		
		public static function BuildAttribute($strMethod)
		{
			// Tipos nativos do php que podem ser usados 
			// nos atributos dos objetos, se algum tipo 
			// estiver faltando, adicionar neste array. 
			$arrNativeTypes = array('bln', 
									'flt', 
									'int', 
									'arr', 
									'str');
		
			$strOperation    =  substr($strMethod, 0, 3); //.......... Get|Set
			$strPrefix       =  substr($strMethod, 3, 3); //.......... cli|int|flt... 
			$blnHavePrefix   = (substr($strMethod, 6, 1) == '_'); //.. é do tipo Cli_
		    $blnIsNativeType = (in_array(strtolower($strPrefix), $arrNativeTypes));
		    
		    // Se o atributo for do tipo pre_algumaCoisa ou tipoAlgumaCoisa
			if($blnHavePrefix || $blnIsNativeType)
			{
			    $strProperty = strtolower($strPrefix).substr($strMethod, 6);
            }
            // Se for um objeto de negócio
			else
			{
                $strProperty = "obj" . substr($strMethod, 3, 3).substr($strMethod, 6);
			}
			
			return array($strOperation, $strProperty);
		}
		
   /**
	* Retorna a propriedade de acesso de uma classe a partir do prefixo e do atributo informado
    * Ex.: BuildProperty("Get","cli_nome") irá retornar getCli_nome
	*
	* @param string $strAttribute método a ser formatado getNomePropriedade
	* @static método estático
	* @return string
	* @access public
	*/		
		public static function BuildProperty($strOperation, $strAttribute)
		{		
		    return $strOperation . ucfirst(substr($strAttribute, 0, 3)).substr($strAttribute, 3);
		}
		
   /**
	* Retorna o alfabeto em um array indexado por "letra" => "letra"
	*
	* @static método estático
	* @return array
	* @access public
	*/		
		public static function GetAlphabet($arFirstElement = NULL)
		{		
		    // Inserindo o primeiro elemento no array para customização:
			// Ex.: array(0 => "Selecione") ou array(0 => "Indiferente") 
			if(!is_null($arFirstElement) && is_array($arFirstElement)) $arAlphabet = $arFirstElement;
			
			// Criando um array com o alfabeto
			for($i = 65; $i <= 90; $i++)
			{ 
			    $arAlphabet[chr($i)] = chr($i); 
			}
			
			return $arAlphabet;
		}

   /**
	* Retorna uma saudação de acordo com a hora atual
	* @return string
	* @static método estático
	* @access public
	*/
		public static function GetGreeting()
		{
			$strHour = date('H');
			
			if(($strHour >= 6) && ($strHour <= 11)) $strGreeting = 'Bom dia';
			if(($strHour > 11) && ($strHour <= 17)) $strGreeting = 'Boa tarde';
			if(($strHour < 6 || $strHour > 18))   	$strGreeting = 'Boa noite';
		
			return $strGreeting;
		}

   /**
	* Retorn o microtime no momento da chamada a este método
	*
	* @static método estático
	* @return float
	* @access public
	*/		
		public static function GetMicrotime()
		{		
		    list($fltMSec, $fltSec) = explode(' ', microtime());
		    
			return $fltMSec + $fltSec;
		}
		
   /**
	* Método utilizado para cálculo do tempo gasto na execução de um trecho de código
	* Define em $fltStartTime o início da execução do script
	*
	* @static método estático
	* @return void
	* @access public
	*/		
		public static function StartExecution()
		{		
		    self::$fltStartTime = self::GetMicrotime();
		}
		
   /**
	* Método utilizado para cálculo do tempo gasto na execução 
	* de um trecho de código 
	* Define em $fltEndTime o término da execução do script

	* @static Método estático
	* @return float Tempo de execução em segundos
	* @access public
	*/		
		public static function EndExecution()
		{		
		    self::$fltEndTime = self::GetMicrotime();
		    
		    return number_format(self::$fltEndTime - self::$fltStartTime, 2);
		}
		
   /**
	* Retorna um array contendo a contagem do inicio ao fim informados
	*
	* @param int $intStart Inicio da contagem
	* @param int $intEnd Final da contagem
	* @param boolean $blnZeroFill Se true preenche os números menores que 10 com 0 é esquerda
	* @param boolean $blnAsc true ordem crescente de contagem, false ordem decrescente
	* @static método estático
	* @return array $arCounter array(00 => 00, 01 => 01, ...)
	* @access public
	*/
		public static function Counter($intStart, $intEnd, $blnZeroFill = true, $blnAsc = true)
		{
		     for($i = $intStart; $i <= $intEnd; $i++)
			 {
			      $intValue = $blnZeroFill ? str_pad($i, 2, 0, STR_PAD_LEFT) : $i;
				  
				  $arCounter[$i] = $intValue;
			 }
			 
			 return $blnAsc ? $arCounter : array_reverse($arCounter, true);
		}
		
   /**
	* Retora o buffer de saída
	* @static Método estático
	* @return string
	* @access public
	*/
	    public static function OutputBuffer($mxdVar)
	    {
         	ob_start();
         	
            echo '<print>';
            print_r($mxdVar);
            echo '</print>';
             
            $strOutput = ob_get_contents();
             
            ob_clean();
             
            $strOutput = str_replace('<print>','', $strOutput);
            $strOutput = str_replace('</print>','', $strOutput);
             
            return $strOutput;
		}

   /**
	* Dispara uma excessão com o conteúdo informado
	* @static Método estático
	* @return void
	* @access public
	*/
	    public static function AMFDebug($mxdVar)
	    {
	        try 	
	        {
		    	throw new AMFDebugException(self::OutPutBuffer($mxdVar));
	        }
	        catch(Exception $e)
	        {
	        	throw $e;
	        }	
		}

   /**
	* Formata uma mensagem para ser exibida na tela da aplicação
	* quando ocorre uma excessão do tipo AdoDuplicateEntryException
	* Onde o registro que se deseja cadastrar já existe no sistema
	* Recebe um array('Label' => 'Valor') para mostrar os indices únicos repetidos
	* 
	* @param array $arrIndicesUnicos
	* @param string $strMsg
	* 
	* @static Método estático
	* @return string Mensagem formatada
	* @access public
	*/
	    public static function FormatUniqueIndices(array $arrIndicesUnicos, $strMsg = '')
	    {
	    	$strIndicesUnicos = '';	
	    
	    	foreach($arrIndicesUnicos as $strLabel => $mxdValue)
	    	{
	    		$strIndicesUnicos.= $strLabel.': ' . utf8_encode($mxdValue) . PHP_EOL;	
	    	}

	    	// Se nenhuma mensagem foi informada, utiliza a mensagem padrão 
	    	if(empty($strMsg))
	    	{
            	$strMsg = 'Já existe um registro com a(s) seguinte(s) informaçõe(s):';
	    	}
            
            $strMsg.= PHP_EOL.PHP_EOL;
            $strMsg.= $strIndicesUnicos;

            return $strMsg;
		}

   /**
	* Retorna se a licenca do ioncube espirou
	* 
	* Ioncube Loader API
	* 
	* No arquivo de licenca, existe uma chave chamada expira e o seu valor foi setado para 09/04/2010
	* aqui checo a data com as informações da licenca (um array com as chaves e seus valores)
	* Com isso podemos criar um validador customizado.
	* 
	* Usamos a Loader API do ioncube, veja que não é
	* necessário importarmos nada para o nosso arquivo
	* pois os métodos usados fazem parte do Loader do ioncube
	* instalado no apache. 
	*
	* @static Método estático
	* @return boolean
	* @access public
	*/		
		public static function LicenseExpired()
		{
			// #DIEGO #MARCELO
			// Apagar este return. Está aguardando o código ser 
			// criptografado e o arquivo de licenca ser gerado.
			return false;
		
			$arrLicenseProperties = ioncube_license_properties();
			
			$strDate        = date('d/m/Y');
			$strLicenseDate = $arrLicenseProperties['expiraem']['value'];
					
			list($strCurrentDay, $strCurrentMonth, $strCurrentYear) = explode('/', $strDate);
			list($strLicenseDay, $strLicenseMonth, $strLicenseYear) = explode('/', $strLicenseDate);
			
			$intCurrentDate = (int)($strCurrentYear.$strCurrentMonth.$strCurrentDay);
			$intLicenseDate = (int)($strLicenseYear.$strLicenseMonth.$strLicenseDay);
			
			$blnLicenseExpired = ($intCurrentDate > $intLicenseDate);
			
			return $blnLicenseExpired;
			
			
		}

    /**
     * Retorna uma string de $intQuantidade espaços em branco
     * @param int $intQuantity
     * @return string
     * @access private
     * @throws Exception Dispara uma exceção caso ocorra algum erro
     */
         public static function WhiteSpaces($intQuantity)
         {
             try
             {
             	 $strEspaces = '';
             
             	 for($i = 0; $i < $intQuantity; $i++)
             	 {
             	 	$strEspaces .= chr(32);
             	 }

                 return $strEspaces;                  				
             }
             catch(Exception $e)
             {
                 throw $e;
             }
         }		

    /**
     * Retorna $intNumber preenchido com $intZeros zeros a esquerda
     * @param int $intNumber
     * @param int $intZeros
     * @return string
     * @access public
     * @throws Exception Dispara uma exceção caso ocorra algum erro
     */
         public static function ZeroFill($intNumber, $intZeros)
         {
             try
             {
             	 return str_pad($intNumber, $intZeros, '0', STR_PAD_LEFT);                  				
             }
             catch(Exception $e)
             {
                 throw $e;
             }
         }		

    /**
     * Retorna $strString preenchido com $intSize 
     * caracteres ($strChar) à direita ou esquerda
     * 
     * @param string $strString
     * @param int $intSize
     * @param string $strChar
     * @param int $intSide STR_PAD_LEFT | STR_PAD_RIGHT (default)
     * @param boolean $blnCutIfOversize Se true retorna a string no tamanho $intSize
     * eliminando os caracteres restantes
     * @return string
     * @access public
     * @throws Exception Dispara uma exceção caso ocorra algum erro
     */
         public static function CharFill($strString, 
         								 $intSize, 
         								 $strChar, 
         								 $intSide = STR_PAD_RIGHT,
         								 $blnCutIfOversize = false)
         {
             try
             {
             	 $strString = str_pad($strString, $intSize, $strChar, $intSide);                  				
             	 
             	 // Corta a string no tamanho $intSize,
     			 // eliminando os caracteres restantes
             	 if($blnCutIfOversize) $strString = substr($strString, 0, $intSize);

             	 return $strString;
             }
             catch(Exception $e)
             {
                 throw $e;
             }
         }		
		
    /**
     * Converte recursivamente o array informado para objeto
     * @param array
     * @return object
     * @access public
     * @throws Exception Dispara uma exceção caso ocorra algum erro
     */         
		 public function ArrayToObject($arrArray) 
		 {
		     try
             {		 
				 $objStdClass = new stdClass();
			
				 foreach ($arrArray as $strKey => $mxdValue) 
				 {
					 if (is_array($mxdValue)) 
					 {
						 $objStdClass->$strKey = Utils::ArrayToObject($mxdValue);
					 }
					 else 
					 {
						 $objStdClass->$strKey = $mxdValue;
					 }
				 }
			
				 return $objStdClass;
             }	 
             catch(Exception $e)
             {
                 throw $e;
             }				 
		 }

//------------------------------------------------------------------------------

     /**
     * Retorna a hora final de acordo com o intervalo multiplicado 
     * pela quantidade.
     * 
     * @param  int    $intHorarioInicial
     * @param  int    $intIntervalo
     * @param  int    $intQuantidade
     * @return string $strHorarioFinal
     * @access public
     *
     * @throws Exception Dispara uma exceção caso ocorra algum erro
     * @see Collection 
     */         
         public function TimeIncrement($intHorarioInicial,
         							   $intIntervalo,
         							   $intQuantidade)
         {
         	try
         	{	
	         	$intHorarioInicial = strtotime($intHorarioInicial);
	         	
	         	for ($i = 1; $i <=$intQuantidade; $i++) 
	         	{
	    			$intHorarioInicial += ($intIntervalo * 60);
	    			$strHorarioFinal   = date('H:i', $intHorarioInicial);
				}
	         	
         		return $strHorarioFinal;
         	}
         	catch(Exception $e)
         	{
         		throw $e;
         	}
         }
         
//------------------------------------------------------------------------------ 
		
         /**
          * Completa $strCampo com espaços em branco até
          * sua string atingir o tamanho $intTamanho
          *
          * @param string $strCampo
          * @param int $intTamanho
          * @return string
          * @access private
          * @throws Exception Dispara uma exceção caso ocorra algum erro
          */
         public function Completar($strCampo, $intTamanho)
         {
         	try
         	{
         		return Utils::CharFill($strCampo,
         				$intTamanho,
         				' ',
         				STR_PAD_RIGHT,
         				true);
         	}
         	catch(Exception $e)
         	{
         		throw $e;
         	}
         }

//------------------------------------------------------------------------------ 

}
