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
 * @subpackage Validation
 * @version 1.0 - 2006-12-14 09:12:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 */

class ValidationException extends Exception{}

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
 * Classe responsável por validação de dados
 * @package Framework
 * @subpackage Validation
 * @version 1.0 - 2006-12-14 09:12:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

class Validation
{
   
   /** 
    * Attributes:
    */

   /**
    * Descrição do atributo.
    * @var $arAttributes
	* @var array
	* @access private
	*/		
	private $arAttributes = array();
   
//---------------------------------------------------------------------------------------   

   /** 
    * Properties:
    */

   /**
	* Método para setar o valor do atributo $arAttributes e realizar a validação básica de seu valor.
	* @param string $strAttribute Nome do atributo a ser validado
	* @param mixed $strValue Valor do atributo a ser validado
	* @param string $strType Tipo do atributo
	* @param integer $intSize Tamanho máximo permitido para o atributo
	* @param boolean $blnNull Se o atributo for obrigatório informe false, caso contrário true
	* @return void		 
	* @access public
	*/
		public function addAttribute($strAttribute, $strValue, $strType, $intSize, $blnNull)
		{
		     // Substitui aspas simples por duplas em formato html
			 $strValue = str_replace("'"     , "&quot;", $strValue);
		     $strValue = str_replace(chr(34) , "&quot;", $strValue); // chr(34): aspas duplas (")
		     $strValue = str_replace(chr(39) , "&quot;", $strValue); // chr(39): aspas simples (')
	    
			 // Remove espaços em branco no início e fim do texto
			 $strValue = trim($strValue); 

			 // #DOUGLAS sql_regcase() é obsoleto e foi removido com
			 // substituição equivalente:
			 // Remove palavras restritas contra sql inject
			 // $strValue = preg_replace(sql_regcase("/(select|insert|delete|drop table|drop|where|show tables|or 1=1|\*|--|)/"), "", $strValue);
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
			 	$strValue = str_ireplace($strItem, '', $strValue);
			 }
			 
			 array_push($this->arAttributes, array("name"  => $strAttribute, 
			                                       "value" => $strValue, 
												   "type"  => $strType, 
												   "size"  => $intSize, 
												   "null"  => $blnNull));
		}

   /**
	* Método para retornar o valor do atributo $arAttributes
	* @return string $arAttributes
	* @access public
	*/
		public function GetAttributes()
		{
			 return $this->arAttributes;
		}

//---------------------------------------------------------------------------------------   
   
   /** 
    * Methods:
    */
   
   /**
	* Método construtor da classe
	* @return void
	* @access public
	*/
	    public function __construct(){}

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
	* Valida os atributos informados $this->addAttribute
	* @param array $arValidate (Opcional) Atributos a serem validados
	* @return boolean
	* @throws ValidationException
	* @access public
	*/
	    public function Validate($arValidate = NULL)
	    {
		    $arInvalids = array();
			
			$i = 0;
			
			foreach($this->GetAttributes() as $arAttribute)
			{
				
			    if((is_array($arValidate) && $arValidate[0] == "save") && !in_array($arAttribute['name'], $arValidate[1])) 
				{
				    continue;
				}
				else if(is_array($arValidate) && $arValidate[0] == "ignore" && in_array($arAttribute['name'], $arValidate[1]))
				{
					continue;
				}

				// Se o atributo não pode ser null:
				if(!$arAttribute['null'])
				{
				    if(is_null($arAttribute['value']) || $arAttribute['value'] == "") 
					{
					    $arInvalids[$i]['name']        = $arAttribute['name'];
						$arInvalids[$i]['description'] = "Conteúdo não informado";
						
						$i++;
						continue;						
					}
				}
				elseif(is_null($arAttribute['value']) || $arAttribute['value'] == "")
				{
				    $i++;
					continue;
				}

                // Verificando se o tamanho está dentro dos limite permitido:
				if(strlen($arAttribute['value']) > $arAttribute['size']) 
				{
				    $arInvalids[$i]['name']        = $arAttribute['name'];
					$arInvalids[$i]['description'] = "Quantidade de caracteres "
					 							   . "(" . strlen($arAttribute['value']).") "
					 							   . "maior que o permitido "
					 							   . "(" . $arAttribute['size']. ") => "
					 							   . $arAttribute['value'];
					$i++;
					continue;
				}	
				
				// Verificando o tipo do atributo:
				switch($arAttribute['type'])
				{
				    case 'int'      : 
				    case 'smallint' : 
					{
					    if(!is_numeric($arAttribute['value']))
						{ 
						    $arInvalids[$i]['name']        = $arAttribute['name'];
					        $arInvalids[$i]['description'] = "Conteúdo não numérico";
						}	
						break;
					}
					
					case 'real' : 
					{
					    if(!is_numeric(Utils::MoneyFormat($arAttribute['value'], 0)))
						{
						    $arInvalids[$i]['name']        = $arAttribute['name'];
					        $arInvalids[$i]['description'] = "Conteúdo não fracionário";
						}
						break;
					}
					
					case 'string' : 
					{
					    if(!is_string($arAttribute['value'])) 
						{
						    $arInvalids[$i]['name']        = $arAttribute['name'];
					        $arInvalids[$i]['description'] = "Conteúdo inválido";
						}
						break;
					}
					
					case 'blob' : 
					{
					    if(!is_string($arAttribute['value']))
						{
						    $arInvalids[$i]['name']        = $arAttribute['name'];
					        $arInvalids[$i]['description'] = "Conteúdo inválido";
						}
						break;
					}
					
					case 'date' : 
					{
						if(!empty($arAttribute['value']))
						{
							$objDate = new Date;
						
							list($strYear, $strMonth, $strDay) = explode("-", Date::Format($arAttribute['value'], 3));
							
							if(!@checkdate($strMonth, $strDay, $strYear))
							{
								$arInvalids[$i]['name']        = $arAttribute['name'];
								$arInvalids[$i]['description'] = "Data inválida";
							}
						}	
						break;
					}
					
					case 'timestamp' : 
					case 'datetime'  : 
					{
					    list($strDate, $strTime) = explode(" ", Date::Format($arAttribute['value'], 1));
						
						// Validando a data:
						list($strYear, $strMonth, $strDay) = explode("-", $strDate);
						
						if(!@checkdate($strMonth, $strDay, $strYear))
						{
						    $arInvalids[$i]['name']        = $arAttribute['name'];
					        $arInvalids[$i]['description'] = "Data inválida";
						}
						
						break;
					}
				}
			 
			    $i++;			
			}
			
			// Informando os campos inválidos
			if(count($arInvalids) == 0)
			{
				return true;
			}
			else
			{
				$strMessage = "Por favor verifique os seguintes campos:\n\n";
				
				foreach($arInvalids as $strAttribute)
				{
				    // Remove o prefixo do campo
					//$arField = explode("_", $strAttribute['name']);
					$strMessage.= "- " . $strAttribute['name'] . ": " . $strAttribute['description'] . "\n";
				}
				
				throw new ValidationException($strMessage);
			}
		}
		
    /**
     * Valida o CPF informado
     * @param string $strCPF
     * @return boolean
	 * @throws ValidationException
     * @access public
     */
         public function ValidarCPF($strCPF)
         {
			 // Retira .- do CPF:
			 $strCPF = preg_replace("@[.-]@", "", $strCPF);
			 
			 if(strlen($strCPF) <> 11 || !is_numeric($strCPF)) return false;
			 
			 // Verifica se o CPF é constituído de números 
			 // repetidos de 11111111111 até 99999999999
			 for($i = 0; $i <= 9; $i++)
			 { 
				 $strRepetido = "";
				 if($strCPF == str_pad($strRepetido, 11, $i)) return false;
			 }
			 
			 // Obtém o dígito verificador
			 $intDVInformado = substr($strCPF, 9,2);
		
			 for($i = 0; $i <= 8; $i++) 
			 {
				 $arDigito[$i] = substr($strCPF, $i, 1);
			 }
		
			 //Calcula o valor do 10o. dígito de verificação
			 $intPosicao = 10;
			 $intSoma    = 0;
		
			 for($i = 0; $i <= 8; $i++) 
			 {
				 $intSoma    += $arDigito[$i] * $intPosicao;
				 $intPosicao  = $intPosicao - 1;
			 }
		
			 $arDigito[9] = $intSoma % 11;
			 $arDigito[9] = ($arDigito[9] < 2) ? 0 : 11 - $arDigito[9];
		
			 //Calcula o valor do 11o. dígito de verificação
			 $intPosicao = 11;
			 $intSoma    = 0;
		
			 for($i = 0; $i <= 9; $i++) 
			 {
				 $intSoma    += $arDigito[$i] * $intPosicao;
				 $intPosicao  = $intPosicao - 1;
			 }
		
			 $arDigito[10] = $intSoma % 11;
			 $arDigito[10] = ($arDigito[10] < 2) ? 0 : 11 - $arDigito[10];
		
			 // Verifica se o DV calculado é igual ao informado
			 $intDV = $arDigito[9] * 10 + $arDigito[10];

			 if($intDV != $intDVInformado)
			 {
			     throw new ValidationException("CPF inválido");
			 }
			 else
			 {
			     return true;
			 }
         }

    /**
     * Valida o CNPJ informado
     * @param string $strCNPJ
     * @return boolean
	 * @throws ValidationException
     * @access public
     */
         public function ValidarCNPJ($strCNPJ)
         {
			 // Retira .-/ do CNPJ:
			 $strCNPJ = preg_replace("@[./-]@", "", $strCNPJ);
			 
			 if(strlen($strCNPJ) <> 14 || !is_numeric($strCNPJ)) return false;

			 // Verifica se o CNPJ é constituído de números 
			 // repetidos de 11111111111111 até 99999999999999
			 for($i = 0; $i <= 9; $i++)
			 { 
				 $strRepetido = "";
				 if($strCNPJ == str_pad($strRepetido, 14, $i)) return false;
			 }
			 
			 $intK     = 6;
			 $intSoma1 = "";
			 $intSoma2 = "";
			 
			 for($i = 0; $i < 13; $i++)
			 {
				 $intK      = $intK == 1 ? 9 : $intK;
				 $intSoma2 += ($strCNPJ{$i} * $intK);
				 
				 $intK--;
				 
				 if($i < 12)
				 {            
					 if($intK == 1)
					 {
						 $intK      = 9;
						 $intSoma1 += ($strCNPJ{$i} * $intK);
						 $intK      = 1;
					 }
					 else
					 {
						 $intSoma1 += ($strCNPJ{$i} * $intK );    
					 }
				 }            
			 }    
		
			 $intDigito1 = $intSoma1 % 11 < 2 ? 0 : 11 - $intSoma1 % 11;
			 $intDigito2 = $intSoma2 % 11 < 2 ? 0 : 11 - $intSoma2 % 11;
			 
			 if($strCNPJ{12} == $intDigito1 && $strCNPJ{13} == $intDigito2)
			 {
			     return true;
			 }
			 else
			 {
			     throw new ValidationException("CNPJ inválido");
			 }         
		}
		
    /**
     * Valida o CEP informado
     * @param string $strCEP
     * @return boolean
	 * @throws ValidationException
     * @access public
     */		
		public function ValidarCEP($strCEP)
		{
			if(ereg("^[0-9]{5}-[0-9]{3}$", trim($strCEP)))
			{
                return true;
			}
			else
			{
			    throw new ValidationException("CEP inválido");
			}
		}
		
    /**
     * Valida o e-mail informado
     * @param string $strEmail
     * @return boolean
	 * @throws ValidationException
     * @access public
     */		
		public function ValidarEmail($strEmail)
		{
			$strExpressao = "^([0-9,a-z,A-Z]+)([.,_]([0-9,a-z,A-Z]+))*[@]([0-9,a-z,A-Z]+)";
			$strExpressao.= "([.,_,-]([0-9,a-z,A-Z]+))*[.]([0-9,a-z,A-Z]){2}([0-9,a-z,A-Z])?$";
			
			if(ereg($strExpressao, $strEmail))
			{
                return true;
			}
			else
			{
			    throw new ValidationException("Email inválido");
			}
		}		
}
