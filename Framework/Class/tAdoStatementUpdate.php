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
 * @subpackage Ado
 * @version 1.0 - 2011-10-18 09:36:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright  2011 RG Sistemas - Todos os diretos reservados.
 */

class AdoStatementUpdateException extends AdoStatementException{}

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
 * Gerencia as operações de inserção de registros na base de dados
 * @package Framework
 * @subpackage Ado
 * @version 1.0 - 2011-10-18 09:36:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2011 Diego Botelho - Todos os direitos reservados
 */

class AdoStatementUpdate extends AdoStatement
{ 
   /** 
    * Attributes:
    */ 
	
//------------------------------------------------------------------------------

    /** 
     * Properties:
     */
	 
//------------------------------------------------------------------------------

    /** 
     * Methods:
     */

    /** 
     * Construtor da classe.
	 * @return void
	 * @access public
     */ 
         public function __construct()
         {
		     try
			 {
			 	 parent::__construct();    
			 }
			 catch(Exception $e)
			 {
				 throw $e;
			 }
         }

//------------------------------------------------------------------------------
		
   /**
	* Constrói o comando UPDATE.
	* 
	* @param object $objObject objeto com os dados a serem 
	* inseridos em $strTable
	* 
	* @param string $strTable Tabela onde os dados serão armazenados
	*  
    * @param array $arAttributes (Opcional) Atributos 
    * da operação, 1º elemento do array deve ser 'save' 
    * ou 'ignore' o segundo deve ser um array com os 
    * campos a serem salvos ou ignorados
	* 
	* @param string $strUserCondition (Opcional) Condição do update, 
	* Ex.: "expiracao >= CURDATE()" se não informada a condição será 
	* baseada na(s) chave(s) primária(s) da tabela 
	* Ex.: "id = '".$objeto->GetId()."'"
	*  
	* @return boolean true se o comando foi realizado com sucesso, 
	* caso contrário false, gerando uma exceção
	* 
	* @access public
	*/
		public function Execute($objObject, 
							    $strTable, 
							    $arAttributes     = NULL, 
							    $strUserCondition = NULL)
		{
		    try
			{
			    if(!is_object($objObject) && empty($strTable))
				{
					throw new AdoStatementUpdateException('Parâmetros inválidos para cláusula UPDATE');	
				}
				
				$strCondition = '';
				$strFields    = '';
				$strValues    = '';
				
				$arrGetTableFields = parent::GetTableFields($strTable);
				
				if(is_array($arrGetTableFields))
				{
					foreach($arrGetTableFields as $arField)
					{
						// Criando a Condição caso ela não tenha sido setada
						if(is_null($strUserCondition))
						{
							// Obtendo a chave primária da tabela
							if(in_array('primary_key', $arField['flags']))
							{
								$strPrimaryKey      = $arField['name'];
								$strPrimaryKeyValue = parent::GetAttributeValue($objObject, $arField['name']);
								
								if(empty($strPrimaryKeyValue))
								{
									throw new AdoStatementUpdateException("O código de atualização do registro (".$arField['name']."), não foi informado");
								}
								
								$strCondition .= !empty($strCondition) ? 'AND ' : '';
								$strCondition .= $strPrimaryKey . ' = "' . $strPrimaryKeyValue . '" ';
								
								// Campos chave-primária não são atualizados:
								continue;
							}
						}
						else
						{
						    $strCondition = $strUserCondition;
						}
						
						// Campos especificos para serem salvos ou ignorados na operação
						if(!is_null($arAttributes))
						{
						    if(!is_array($arAttributes) || (($arAttributes[0] != "save") && ($arAttributes[0] != "ignore")) || (!is_array($arAttributes[1])) )
							{
							    throw new AdoStatementUpdateException("Os atributos não foram informados corretamente: array('save|ignore', array('att1', 'att2'...));");  
							}
							
							// Salvando ou ignorando campos informados:
							switch($arAttributes[0])
							{
							    case 'save':
								{
								    if(in_array($arField['name'], $arAttributes[1]))
									{
										$strFields .= $arField['name'] . ' = '; 
										
										// Verifica se o campo esté entre os que devem ser salvos:
										if(parent::IsCrypted($arField['name']))
										{
											// Obtendo os valores dos campos
											$strFields .= parent::GetAttributeValue($objObject, $arField['name']) . ', ';	
										}
										else
										{
											$strValue  = parent::GetAttributeValue($objObject, $arField['name']);
											
											if($strValue === NULL)
											{
												$strFields.= 'NULL, ';
											}
											// Formata o valor do atributo
											// se ele não for null	
											else
											{
												$strValue  = parent::FormatToDataBase($arField['type'], $strValue);
												$strValue  = Utils::CheckSQLInjection($strValue);
												$strFields.= "'$strValue', ";
											}
										}
									}
									else
									{
									    continue;
									}
									break;										
						       }
							   case 'ignore':
							   {
									if(!in_array($arField['name'], $arAttributes[1]))
									{
									    $strFields .= $arField['name'] . ' = '; 
										
										// Verifica se o campo está entre os que devem ser ignorados:
										if(parent::IsCrypted($arField['name']))
										{
											// Obtendo os valores dos campos
											$strFields .= parent::GetAttributeValue($objObject, $arField['name']) . ', ';	
										}
										else
										{
											$strValue  = parent::GetAttributeValue($objObject, $arField['name']);
											
											if($strValue === NULL)
											{
												$strFields.= 'NULL, ';
											}
											// Formata o valor do atributo
											// se ele não for null	
											else
											{
												$strValue  = parent::FormatToDataBase($arField['type'], $strValue);
												$strValue  = Utils::CheckSQLInjection($strValue);
												$strFields.= "'$strValue', ";
											}												
                                            }
									}
									else
									{
									    continue;
									}
									break;
							   }
							   default : 
							   {
							       throw new AdoStatementUpdateException("Especifique 'save' ou 'ignore' no primeiro elemento do array de atributos");
							   }	
						   }
						}
						else
						{
						    $strFields .= $arField['name'] . ' = '; 
						    
							if(parent::IsCrypted($arField['name']))
							{
							    // Obtendo os valores dos campos
							    $strFields .= parent::GetAttributeValue($objObject, $arField['name']) . ', ';
							}
							else
							{
							    // Obtendo os valores dos campos
							    $strValue = parent::GetAttributeValue($objObject, $arField['name']);
								
								if($strValue === NULL)
								{
									$strFields.= 'NULL, ';
								}
								// Formata o valor do atributo
								// se ele não for null	
								else
								{
									$strValue  = parent::FormatToDataBase($arField['type'], $strValue);
									$strValue  = Utils::CheckSQLInjection($strValue);
									$strFields.= "'$strValue', ";
								}								    
							}
						}  
					}
				}	
				
				// Verificando se o registro existe:
				if(parent::FindRecord($strTable, $strCondition))
				{
					// Retirando a virgula do último campo.
					$strFields = Utils::CutLastChar($strFields, 2);
					
					// Gerando a query sql
					$strUpdate = "UPDATE $strTable SET $strFields "
					           . "WHERE $strCondition "; 
					
					return parent::GetAdoConnection()->Execute($strUpdate);
				}
			}
			catch(Exception $e)
			{
				throw $e;
			}
		}
		
//------------------------------------------------------------------------------

}