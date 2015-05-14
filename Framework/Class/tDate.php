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
 * @subpackage Date
 * @version 1.0 - 2009-04-06 09:53:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class DateException extends Exception{}

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
 * Classe de gerenciamento de datas
 * @package Framework 
 * @subpackage Date
 * @version 1.0 - 2007-02-15 13:37:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class Date
{
    /** 
     * Attributes:
     */   
		 const MIN_YEAR = 1850;
		 const MAX_YEAR = 2100;
		 const DAYS     = 1;
		 const WEEKS    = 2;
		 const MONTHS   = 3;
		 const YEARS    = 4;
		 
		 const MIN_DATE = '1850-01-01';
		 const MAX_DATE = '2100-12-31';
   
    /**
     * número de dias em cada mês
     * @var array
     * @access private
     */
         private $arDays;
		 
   
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
		public function __construct()
		{
			date_default_timezone_set("America/Sao_Paulo");
			
			$this->arDays = array(31,28,31,30,31,30,31,31,30,31,30,31);
		}

//------------------------------------------------------------------------------		
		
   /**
	* Método destrutor da classe
	* @return void
	* @access public
	*/
	    public function __destruct()
	    {	
		    unset($this);
	    }

//------------------------------------------------------------------------------	    
	    
   /**
	* Soma ou subtrai dias na data informada
	* @param string $strDate data ser adicionado ou removidos o(s) dia(s)
	* @param int $intDays Número de dias
	* @param string $strOperation operação a ser realizada '+' para somar ou '-' para subtrair
	* @return string
	* @access public
	*/
	    public function Calculate($strDate, $intDays, $strOperation)
	    {
		    switch($strOperation)
			{
			    case '+' : return date("Y-m-d", strtotime($strDate) + ($intDays * 86400)); break;
				case '-' : return date("Y-m-d", strtotime($strDate) - ($intDays * 86400)); break;
			}				
		}

//------------------------------------------------------------------------------		
		
   /**
	* Retorna a data e hora atual
	* @return string
	* @access public
	*/
	    public function Now($strFormat = 'Y-m-d H:i:s')
	    {
		    return date($strFormat);				
		}

//------------------------------------------------------------------------------		
		
   /**
	* Retorna a data atual
	* @return string
	* @access public
	*/
	    public function Today($strFormat = 'Y-m-d')
	    {
		    return date($strFormat);				
		}		

//------------------------------------------------------------------------------		
		
    /**
	 * Formatação de data e hora
	 * Atenção! Substituir em todo framework Utils::DateFormat() por Date::Format()
	 * $intFormat = 1 : 00/00/000  00:00:00 -> 0000-00-00 00:00:00
	 * $intFormat = 2 : 0000-00-00 00:00:00 -> 00/00/000 00:00:00		
	 * $intFormat = 3 : 00/00/0000          -> 0000-00-00
	 * $intFormat = 4 : 0000-00-00          -> 00/00/0000
	 * $intFormat = 5 : 0000/00/00 00:00:00 -> 00/00/0000 00:00:00
	 * $intFormat = 6 : 0000/00/00 			-> 00/00/0000
	 * $intFormat = 7 : 00/00/0000 			-> 0000/00/00
	 *
	 * @param string $strString Data a ser formatada
	 * @param  int $intFormat Formato a ser gerado.
	 * @return string Data formatada
	 * @access public
	 */	
	     public static function Format($strString, $intFormat = 4)
		 {
		     switch ($intFormat)
			 {
				 case 1: 
				 {
					 if(empty($strString)) return "0000-00-00 00:00:00";
					 
					 list($strDate, $strHour) = explode(' ', $strString);
					 return implode('-', array_reverse(explode('/', $strDate))).' '.$strHour;
					 
					 break;
				 }
				 case 2: 
				 {
				     if($strString == '0000-00-00 00:00:00') return '';
					 
				     return date('d/m/Y H:i:s', strtotime($strString));
					 break;
				 }	
				 case 3: 
				 {
				     if(empty($strString)) return '0000-00-00';
					 
				     return implode("-", array_reverse(explode("/", $strString)));
					 break;
				 }	
				 case 4: 
				 {
				     if(empty($strString) || $strString == '0000-00-00') return '';
                     
				     $objDateTime = new DateTime($strString);
                     
				     return $objDateTime->format('d/m/Y');
					 break;
				 }
 				 case 5: 
				 {
				     if(empty($strString) || $strString == '0000-00-00 00:00:00') return '';
					 
				     return date('d/m/Y H:i', strtotime($strString));
					 break;
				 }
				 case 6: 
				 {
				     if(empty($strString) || $strString == '0000/00/00') return '';
		             
				     return date('d/m/Y', strtotime($strString));
					 break;
				 }			 
				 case 7: 
				 {
				     if(empty($strString) || $strString == '00/00/0000') return '';
		             
				     return implode("/", array_reverse(explode("/", $strString)));
					 break;
				 }			 
			 }
	   }

//------------------------------------------------------------------------------	   
	   
   /**
	* Retorna o dia da semana 
	* de acordo com a data informada no formato Y-m-d
	* 
	* O dia retornado é um array onde a primeira posição
	* é um inteiro no formato iso8601 e a segunda posição 
	* é o nome do dia da semana.
	* 
	* 0, DOMINGO
	* 1, SEGUNDA
	* 2, TERÇA
	* 3, QUARTA
	* 4, QUINTA
	* 5, SEXTA
	* 6, SÁBADO
	*  
	* @param string $strDate No formato Y-m-d
	* 
	* @return array
	* @see WeekName
	*/
	    public function GetWeekDay($strDate)
	    {
			$intWeek     = date('w', strtotime($strDate));
			$strWeekName = $this->WeekName($intWeek);
			
			return array($intWeek, $strWeekName);
		}
	   
//------------------------------------------------------------------------------

    /**
     * Retorna o nome do mês
     * @param int $intMonth
	 * @return string
     */
         public function MonthName($intMonth)
         {
             switch ($intMonth) 
             {
			     case 1  : return 'Janeiro'   ; break;
			     case 2  : return 'Fevereiro' ; break;
			     case 3  : return 'Marco'     ; break;
				 case 4  : return 'Abril'     ; break;
			     case 5  : return 'Maio'      ; break;
				 case 6  : return 'Junho'     ; break;
			     case 7  : return 'Julho'     ; break;
				 case 8  : return 'Agosto'    ; break;
				 case 9  : return 'Setembro'  ; break;
				 case 10 : return 'Outubro'   ; break;
				 case 11 : return 'Novembro'  ; break;
				 case 12 : return 'Dezembro'  ; break;
			 }        
         }
		
//------------------------------------------------------------------------------

    /**
     * Retorna o nome do dia da semana de acordo 
     * com o número informado no formato iso8601, ou seja:
     * 
	 * 0 - DOMINGO
	 * 1 - SEGUNDA
	 * 2 - TERÇA
	 * 3 - QUARTA
	 * 4 - QUINTA
	 * 5 - SEXTA
	 * 6 - SÁBADO 
     * 
     * @param int $intMonth
	 * @return string
	 * @see GetWeekDay()
     */
         public function WeekName($intWeek)
         {
             switch($intWeek) 
             {
             	 case 0  : return 'Domingo'; 	   break;
			     case 1  : return 'Segunda-feira'; break;
			     case 2  : return 'Terça-feira';   break;
				 case 3  : return 'Quarta-feira';  break;
			     case 4  : return 'Quinta-feira';  break;
				 case 5  : return 'Sexta-feira';   break;
			     case 6  : return 'Sábado'; 	   break;
			 }        
         }		
		
//------------------------------------------------------------------------------         
         
   /**
	* Devolve um intervalo entre datas por dias
	* @param int $strInicialDate
	* @param int $strFinalDate
	* @return string
	*/
	    public function RangeInDays($strInicialDate = 1, $strFinalDate = false )
	    {
			if(!$strFinalDate) 
			{
				$strFinalDate = $strInicialDate + 7;
			} 
			else 
			{
				if( $strInicialDate > $strFinalDate ) 
				{
					throw new DateException("A data inicial deve ser menor que a data final");
				}
			}
	
			$strToday = date("Y/m/d");
	
			$strBegin = "";
			$strEnd = "";
	
			$strBegin = $this->Decrement( $strToday, $strInicialDate );
			$strEnd   = $this->Decrement( $strToday, $strFinalDate );
	
			return $strBegin . ',' . $strEnd;
		}
		
//------------------------------------------------------------------------------		
		
   /**
	* Devolve um intervalo entre datas por anos
	* @param data $intAge
	* @param data $intFinalAge
    * @return String
	*/
	    public function RangeInYears($intAge, $intFinalAge = false )
	    {
			$strToday      = date("d");
			$strAtualMonth = date("m");
			$strAtualYear  = date("Y");
	
			$strResult = "";
	
			$intInicialDay = $strToday + 1;
			$intInicialMonth = $strAtualMonth;
			
			if(!$intFinalAge) 
			{
				$intInicialYear = $strAtualYear - ($intAge + 1);
			} 
			else 
			{
				$intInicialYear = $strAtualYear - ($intFinalAge + 1);
			}
	
			if ( $intInicialDay > $this->arDays[ $strAtualMonth - 1 ] ) 
			{
				switch($intInicialMonth) 
				{
					case 2:
					case 02:
						if ( $intInicialDay > 28 && !checkdate('2','29',$intInicialYear ) ) 
						{
							$intInicialDay = 1;
							
							if( $intInicialMonth == 12 ) 
							{
								$intInicialMonth = 1;
								$intInicialYear++;
							}
							else
							{
								$intInicialMonth++;
							}
						} 
						elseif ( $intInicialDay > 29 ) 
						{
							$intInicialDay = 1;

							if( $intInicialMonth == 12)
							{
								$intInicialMonth = 1;
								$intInicialYear++;
							}
							else
							{
								$intInicialMonth++;
							}
						}
						break;
					
					default:

						$intInicialDay = 1;

						if ( $intInicialMonth == 12 ) 
						{
							$intInicialMonth = 1;
							$intInicialYear++;
						}
						else
						{
							$intInicialMonth++;
						}
						break;
				}
			}
	
			$strInicialDate = $intInicialYear."/".$intInicialMonth."/".$intInicialDay;
	
			if ( $strAtualMonth == 2 && $strToday == 29 && checkdate('2','29',$strAtualYear) ) 
			{
				$strToday--;
			}
	
			$strFinalDate = $strAtualYear - $intAge."/".$strAtualMonth."/".$strToday;
	
			$blnInicialValid = checkdate($intInicialMonth, $intInicialDay, $intInicialYear);
			$blnFinalValid   = checkdate($strAtualMonth, $strToday, $strAtualYear - $intAge);
	
			$strResult = $strInicialDate . "," . $strFinalDate;
	
			if($blnInicialValid && $blnFinalValid) return $strResult;
	
			return false;
		}	   

//------------------------------------------------------------------------------		
		
   /**
	 * Incrementa uma data passada no formato $strFormat. A unidade de
	 * incremento padrão é 1 e o tempo padrão é em dia, podendo ser também
	 * semana, mês, e ano (day, week, month, year).
	 * 
	 * @param String $strDate
	 * @param int $intIncrease
	 * @param String $strTimeUnit
	*/
		public function Increase($strDate, 
								 $intIncrease = 1, 
								 $strTimeUnit = 'day',
								 $strFormat   = 'Y/m/d')
	    {
			list($intYear, 
				 $intMonth, 
				 $intDay) = preg_split('@[^0-9]{1}@', $strDate);
	
			if( checkdate($intMonth, $intDay, $intYear) ) 
			{
				$strNewDate = new DateTime($strDate);
				$strNewDate->modify("+$intIncrease $strTimeUnit");
	
				return $strNewDate->format($strFormat);
			}

			return false;
		}
		
//------------------------------------------------------------------------------		
		
   /**
	* Decrementa uma data passada no formato ano/mes/dia. A unidade de
	* incremento padrão é 1 e o tempo padrão é em dia, podendo ser também
	* semana, mês, e ano (day, week, month, year).
	* @param String $strDate
	* @param int $intIncrease
	* @param String $strTimeUnit
	*/
		public function Decrement($strDate, $intDecrement = 1, $strTimeUnit = 'day')
	    {
			list($intYear, $intMonth, $intDay) = preg_split('@[^0-9]{1}@', $strDate);
	
			if( checkdate($intMonth, $intDay, $intYear) ) 
			{
				$strNewDate = new DateTime($strDate);
				$strNewDate->modify("-$intDecrement $strTimeUnit");
	
				return $strNewDate->format('Y/m/d');
			}

			return false;
		}	   

//------------------------------------------------------------------------------		
		
   /**
	* Recebe uma data de nascimento e retorna a idade exata (dias, meses e anos) do indivíduo. 
	* O retorno é no formato aaaa/mm/dd. P.ex. Se o indivíduo tem menos de um ano, 
	* p.ex, 11 meses e 3 dias, o retorno será 0/11/3.
	* @param String $strDate Data de nascimento do indivíduo
	* @param Boolean $blnUntil
	* @return array Anos, meses e dias
	*/
		public function GetAge($strDate, $blnUntil = false)
	    {
			list($intYear, $intMonth, $intDay) = preg_split('@[^0-9]{1}@', $strDate);
	
			if( isset($intYear, $intMonth, $intDay) && checkdate($intMonth, $intDay, $intYear) ) 
			{
				$strToday      = date("d");
				$strAtualMonth = date("m");
				$strAtualYear  = date("Y");
	
				if($blnUntil) 
				{
					list($strAtualYear, $strAtualMonth, $strToday) = preg_split('@[^0-9]{1}@', $blnUntil);
				}
	
				if( $strToday < $intDay ) 
				{
	
					$strToday += 30;
					$strAtualMonth--;
				}
	
				$intDays = $strToday - $intDay;
	
				if($strAtualMonth < $intMonth ) 
				{
					$strAtualMonth += 12;
					$strAtualYear--;
				}
	
				$intMonths = $strAtualMonth - $intMonth;
	
				$intYears = $strAtualYear - $intYear;
	
				return array('years' => $intYears, 'months' => $intMonths, 'days' => $intDays);
			}
			else
			{
				throw new DateException('Data inválida para obter a idade');
			}
		}
		
//------------------------------------------------------------------------------		
		
   /**
	* Retorna a quantidade de dias baseando-se em uma faixa de tempo (dias, meses e anos) enviada como argumento. 
	* Esta data deve estar no formato anos/meses/dias.
	* @param String $intAge Data no formato anos/meses/dias
	* @return int Dias totais
	*/
		public function AgeToDays($intAge)
	    {
			list($intYears, $intMonths, $intDays) = explode('/', $intAge);

			return ($intYears * 365 + $intMonths * 30 + $intDays);
		}	   

//------------------------------------------------------------------------------		
		
   /**
	* Comparação entre duas datas
	* @param string $strDate data ser adicionado ou removidos o(s) dia(s)
	* @return string
	* @access public
	*/
	    public function Compare($strDate1, $strOperator, $strDate2 = 'today')
	    {
			$arrOperators = array('<', '>', '<=', '>=', '==', '!=');
			
			if(!in_array($strOperator, $arrOperators))	    
			{
				throw new DateException('O operador informado é inválido');
			}
			
			$strDateA = new DateTime("$strDate1 00:00:00 GMT");
			
			if($strDate2 == 'today') $strDateB = new DateTime(date('Y-m-d') . ' 00:00:00 GMT');
			else $strDateB = new DateTime("$strDate2 00:00:00 GMT");
			
			$strDateOne = $strDateA->format('U');
			$strDateTwo = $strDateB->format('U');
			
			eval("\$strResult = ($strDateOne $strOperator $strDateTwo);");

			if( isset($strResult) ) return $strResult;

			return false;
		}	   

//------------------------------------------------------------------------------

   /**
	* Valida o padrão da data 
	* @param string $strDate data ser adicionado ou removidos o(s) dia(s)
	* @return boolean
	* @access public
	*/
	    public function CheckStandard($strDate)
	    {
			$arDividersSymbols = array('-', '.', ' ', '|', '\\');
			
			$strDate = str_replace($arDividersSymbols, '/', $strDate);
			
			if ( strlen($strDate) == 10 && $strDate[2] == '/' && $strDate[5] == '/' ) 
			{
				if ( substr_count( $strDate, '/' ) == 2 ) 
				{
					$intPointer = 0;
				
					for ( $intPointer=0; $intPointer < strlen($strDate); $intPointer++ ) 
					{
						if ( substr_count('1234567890/', $strDate[$intPointer] ) == 0 ) 
						{
							return false;
						} 
						else 
						{
							list($intDay, $intMonth, $intYear) = explode('/', $strDate);
							if ( !checkdate($intMonth, $intDay, $intYear) ) return false;
						}
					}
				
					return true;				
				}
			}
			
			return false;	
		}
		
//------------------------------------------------------------------------------		
		
   /**
	* Converte a data informada para dias
	* @param String $strDate
	* @return boolean
	*/
	    public function ConvertToDays($strDate)
	    {
			if( $this->CheckStandard($strDate))
			{
				$arDays = array (31,28,31,30,31,30,31,31,30,31,30,31);
				
				list( $intDay, $intMonth, $intYear ) = explode('/', $strDate);	
				
				$intTotal = $intYear * 365;
				
				$intPointer = 0;
				
				$intDaysPerYear = 0;
				
				if( $intMonth > 0 )
				{
					for( $intPointer = 0; $intPointer < $intMonth - 1 ; $intPointer++ ) 
					{
						$intDaysPerYear += $arDays[$intPointer];
					}
				}
				
				$intDaysPerYear += $intDay;
				$intTotal += $intDaysPerYear;
				
				return $intTotal;
			}	
			
			return false;
		}

//------------------------------------------------------------------------------		
		
   /**
	* Valida a data informada
	* @param String $strDate
	* @return boolean true se for uma data válida, caso contrário false
	*/
	    protected function Validate($strDate)
	    {
			list($intDay, $intMonth, $intYear) = preg_split('@[^0-9]{1}@', $strDate);
	
			if( isset($intDay, $intMonth, $intYear) ) 
			{
				$intYear = $this->FormatYear($intYear);
	
				$blnVerifyYear = ($intYear > self::MIN_YEAR && $intYear < self::MAX_YEAR);
	
				$blnComplete = checkdate($intMonth, $intDay, $intYear);
	
				if($blnVerifyYear && $blnComplete)	return true;
			}
	
			return false;
		}

//------------------------------------------------------------------------------		
		
   /**
	* 
	* @param string $strDate data ser adicionado ou removidos o(s) dia(s)
	* @static método estático
	* @return string
	* @access protected
	*/
	    protected function FormatYear($intYear)
	    {
			if($intYear >= 50 && $intYear < 100) $intYear += 1900;
			elseif($intYear < 50) $intYear += 2000;
	
			return $intYear;
		}

//------------------------------------------------------------------------------		
		
   /**
	* Converte os dias informados para a unidade de tempo (anos, meses, semanas ou dias)
	* @param int $intDays
	* @return mixed boolean|string
	*/
    	public function DateUnit($strData,$strUnit)
	    {	
	    	 list($intYear, $intMonth, $intDay) = explode('/',$strData);
	    	 
	    	 switch ($strUnit)
			 {
				 case "Y": 
				 { 
					 return $intYear;
					 break;
				 }
				 case "M": 
				 {
				     return $intMonth;
					 break;
				 }	
				 case "D": 
				 {
				     return $intDay;
					 break;
				 }			 
			 }		
		}	   
		
//------------------------------------------------------------------------------		

   /**
	* Converte os dias informados para a unidade de tempo (anos, meses, semanas ou dias)
	* @param int $intDays
	* @return mixed boolean|string
	*/
    	public function TimeUnitConvert($intDays)
	    {
			if ($intDays > 0) 
			{
				if($intDays % 360 == 0) 
				{
					return $intDays / 360 . ' ano(s)';
				}

				if($intDays % 365 == 0) 
				{
					return $intDays / 365 . ' ano(s)';
				}

				if($intDays % 30 == 0) 
				{
					return $intDays / 30 . ' mes(es)';
				}

				if($intDays % 7 == 0) 
				{
					return $intDays / 7 . ' semana(s)';
				}

				return $intDays . ' dia(s)';
			}
			
			return false;		
		}	   

//------------------------------------------------------------------------------		
		
   /**
	* Converte dias para unidade de tempo
	* @param int $intQuantity
	* @param int $intUnit
	* @return int
	*/
		public function TimeUnitConvertToDays($intQuantity, $intUnit)
	    {
			switch ($intUnit) 
			{
				case self::DAYS :
					return $intQuantity;
					break;
	
				case self::WEEKS :
					return  $intQuantity * 7;
					break;
	
				case self::MONTHS :
					return  $intQuantity * 30;
					break;
	
				case self::YEARS :
					return $intQuantity * 365;
					break;
	
				default: return $intQuantity;
					break;
			}
		}
}