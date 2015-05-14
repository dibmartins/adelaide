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
 * @copyright  2011 Diego Botelho - Todos os diretos reservados.
 */

class AdoStatementInsertException extends AdoStatementException{}

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
 * @copyright  2011 Diego Botelho - Todos os direitos reservados
 */

class AdoStatementInsert extends AdoStatement
{ 
   /** 
    * Attributes:
    */ 
	
	const INSERT  = 'INSERT';
	const IGNORE  = 'INSERT IGNORE';
	const REPLACE = 'REPLACE';
	const UPDATE  = 'UPDATE';
	
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
	* Constrói o comando INSERT.
	* @param object $objObject objeto com os dados a serem 
	* inseridos em $strTable
	* 
	* @param string $strTable Tabela onde os dados serão armazenados
	*  
	* @param array $arAttributes (Opcional) Atributos da operação, 
	* 1º elemento do array deve ser 'save' ou 'ignore'
	* 
	* @param string $strCondition (Opcional) Condição para inserção, 
	* muito utilizado para tratamento de concorrência. 
	* Saiba mais nas referências abaixo:
	* http://dev.mysql.com/doc/refman/4.1/pt/select.html
	* http://en.wikipedia.org/wiki/DUAL_table
	*  
	* @param boolean $blnIgnoreIfExists = false
	* Setado para true gera a instrução INSERT IGNORE 
	* que só executa o cadastro se o registro ainda não 
	* existir na tabela.
	*  
	* @param String $strType
	* Valores possíveis:
	* AdoStatementInsert::INSERT  -> Cadastra um novo registro. Dispara erro se for duplicado. 
	* AdoStatementInsert::IGNORE  -> Só cadastra se o registro não existir na tabela.
	* AdoStatementInsert::REPLACE -> Cadastra um novo registro. Atualiza se for duplicado, porém incrementa a chave primária.
	* AdoStatementInsert::UPDATE  -> Cadastra um novo registro. Atualiza se for duplicado, não altera a chave primária.
	* 
	* o segundo deve ser um array com os campos a serem salvos ou ignorados
    * @return boolean true se o comando foi realizado com sucesso, caso 
    * contrário false, gerando uma exceção
    * 
	* @access public
	*/
		public function Execute($objObject, 
							    $strTable, 
							    $arAttributes = NULL,
							    $strCondition = NULL,
							    $strType 	  = AdoStatementInsert::INSERT)
		{
		    try
			{
				if(!is_object($objObject) || empty($strTable))
				{
					throw new AdoStatementInsertException('Parâmetros inválidos para cláusula INSERT');	
				}					
				
			    $strFields 		   = '';
				$strValues 		   = '';
				$arrOnUpdateFields = array();
				
				$arrGetTableFields = parent::GetTableFields($strTable);
				
				if(is_array($arrGetTableFields))
				{
					foreach($arrGetTableFields as $arField)
					{
						// Campos auto-increment não são inseridos:
						if(in_array('auto_increment', $arField['flags'])) continue;
						
						// Campos especificos para serem salvos ou ignorados na operação
						if(!is_null($arAttributes))
						{
							if(!is_array($arAttributes) || 
							  (($arAttributes[0] != 'save') && 
							  ($arAttributes[0] != 'ignore')) || 
							  (!is_array($arAttributes[1])) )
							{
								$strErro = 'Os atributos não foram informados corretamente: '
										 . 'array(\"save|ignore\", array(\"att1\", \"att2\"...));';
								
							    throw new AdoStatementInsertException($strErro);  
							}
							
							// Salvando ou ignorando campos informados:
							switch($arAttributes[0])
							{
							    case 'save':
								{
									if(in_array($arField['name'], $arAttributes[1]))
									{
										// Obtendo os campos a serem inseridos:
										$strFields .= $arField['name'] . ', ';
										
										// #ON_UPDATE
										array_push($arrOnUpdateFields, $arField['name']);										
										
										if(parent::IsCrypted($arField['name']))
										{
											// Obtendo os valores dos campos
											$strValues .= parent::GetAttributeValue($objObject, $arField['name']) . ", ";	
										}
										else
										{
											$strValue = parent::GetAttributeValue($objObject, $arField['name']);
											
											if($strValue === NULL)
											{
												$strValues.= 'NULL, ';
											}
											// Formata o valor do atributo
											// se ele não for null	
											else
											{
												$strValue  = parent::FormatToDataBase($arField['type'], $strValue);
												$strValue  = Utils::CheckSQLInjection($strValue);
												$strValues.= "'$strValue', ";
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
									// Verifica se o campo está entre os que devem ser ignorados:
									if(!in_array($arField['name'], $arAttributes[1]))
									{
									    // Obtendo os campos a serem inseridos:
										$strFields .= $arField['name'] . ", ";
										
										// #ON_UPDATE
										array_push($arrOnUpdateFields, $arField['name']);										
										
										if(parent::IsCrypted($arField['name']))
										{
											// Obtendo os valores dos campos
											$strValues .= parent::GetAttributeValue($objObject, $arField['name']) . ', ';	
										}
										else
										{
											$strValue  = parent::GetAttributeValue($objObject, $arField['name']);
											
											if($strValue === NULL)
											{
												$strValues.= 'NULL, ';
											}
											// Formata o valor do atributo
											// se ele não for null	
											else
											{
												$strValue  = parent::FormatToDataBase($arField['type'], $strValue);
												$strValue  = Utils::CheckSQLInjection($strValue);
												$strValues.= "'$strValue', ";
											}												
										}	
									}
									else
									{
									    continue; 
									}
									break;
								}
								
								default : throw new AdoStatementInsertException("Especifique 'save' ou 'ignore' no primeiro elemento do array de atributos");
							}
						}
						else
						{
							// Obtendo os campos a serem inseridos:
							$strFields .= $arField['name'] . ', ';
							
							// #ON_UPDATE
							array_push($arrOnUpdateFields, $arField['name']);
							
							if(parent::IsCrypted($arField['name']))
							{
							    // Obtendo os valores dos campos
							    $strValues .= parent::GetAttributeValue($objObject, $arField['name']) . ', ';
							}
							else
							{
								$strValue  = parent::GetAttributeValue($objObject, $arField['name']);
								
								if($strValue === NULL)
								{
									$strValues.= 'NULL, ';
								}
								// Formata o valor do atributo
								// se ele não for null	
								else
								{
									$strValue  = parent::FormatToDataBase($arField['type'], $strValue);
									$strValue  = Utils::CheckSQLInjection($strValue);
									$strValues.= "'$strValue', ";
								}									
							}	
						}
					}
				}	
				
				// Retirando a virgula do último campo:
				$strFields = Utils::CutLastChar($strFields, 2);
				
				// Retirando a virgula do último valor:
				$strValues = Utils::CutLastChar($strValues, 2);
				
				// INSERT INTO tabela (val1, val2)...
				// Onde 'INSERT' também pode ser INSERT IGNORE, REPLACE.
				// No caso de $strType == AdoStatementInsert::UPDATE
				// a instrução UPDATE será substituida por INSERT e 
				// será adicionada a instrução ON DUPLICATE KEY UPDATE
				// REPLACE e ON DUPLICATE fazem a mesma coisa, ou seja,
				// atualizam um registro caso ele já exista, porém replace
				// funciona como um DELETE INSERT incrementando a chave primária.
				// Já ON DUPLICATE mantém a chave primária com o mesmo valor. 
				$strInsert = "$strType INTO $strTable ($strFields) ";
				
				// Veja um exemplo de uso em:
				// EscalaAgendamento::AlterarEmLote
				// EscalaAgendamento::Cadastrar
				if(isset($strCondition))
				{
					// Atenção $strCondition tem que ficar entre parenteses
					$strInsert .= "SELECT $strValues FROM dual WHERE ($strCondition) ";
				}
				else
				{
					$strInsert .= "VALUES ($strValues) ";
				}
				
				// campo1 = VALUES(campo1), campo2 = VALUES(camp2o),...
				if($strType == AdoStatementInsert::UPDATE)
				{
					$strOnUpdate = '';
					
					foreach($arrOnUpdateFields as $strOnUpdateField)
					{
						$strOnUpdate .= "$strOnUpdateField = VALUES($strOnUpdateField), ";
					}
					
					$strOnUpdate = Utils::CutLastChar($strOnUpdate, 2);
					
					$strInsert = str_replace('UPDATE', 'INSERT', $strInsert);
					
					$strInsert .= "ON DUPLICATE KEY UPDATE $strOnUpdate ";
				}				
				
				$strInsert .= ';';
				
				//echo $strInsert;
				
				// Se o comando foi executado com sucesso, retorna o id do novo registro:
				if(parent::GetAdoConnection()->Execute($strInsert))
				{
					return parent::GetAdoConnection()->GetInsertId();
				}
			}
			catch(Exception $e)
			{
				throw $e;
			}
		}
		
//------------------------------------------------------------------------------

}