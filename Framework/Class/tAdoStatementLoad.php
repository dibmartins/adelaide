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

class AdoStatementLoadException extends AdoStatementException{}

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

class AdoStatementLoad extends AdoStatement
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
     * Carrega o objeto com os dados armazenados em meio persistente.
	 * @param object reference &$objLoaded Referencia do Objeto a ser carregado
	 * @param string $strTable Tabela que se deseja recuperar o registro
	 * @param array $arAttributes (Opcional) Atributos a serem carregados
	 * @param string $strCondition (Opcional) Condição para carregar o objeto, 
	 * se não informado carrega pela chave primária do mesmo que deve ser informada
	 * @return object Objeto completamente inicializado
	 * @access public
	 */ 
        public function Execute(&$objLoaded, 
        						 $strTable, 
        						 $arAttributes = NULL, 
        						 $strCondition = NULL, 
        						 $blnFilter    = false)
        {
        	try
        	{
        		if(!is_object($objLoaded)) 
				{
					throw new AdoStatementLoadException('O parâmetro informado não é um objeto válido');
				}        		
        		
		        $arrGetTableFields = parent::GetTableFields($strTable);
		        
				if(!is_array($arrGetTableFields))
		        {
		        	throw new AdoStatementLoadException('Não foi possível obter os campos da tabela');
		        }
		        
		        // Formatação dos atributos a serem carregados
		        // Se os atributos não foram informados $arAttributes == NULL
		        // carrega todos as colunas da tabeça
				if(is_null($arAttributes))
				{
				    $arAttributes = array();
					
					foreach($arrGetTableFields as $arField)
					{
					    array_push($arAttributes, $arField['name']);
					}
				}
				// Caso contrário verifica quais são os atributos a serem
				// carregados e quais devem ser ignorados
				else
				{
					if(!is_array($arAttributes)         || 
					   (($arAttributes[0] != 'load')    && 
					   ( $arAttributes[0] != 'ignore')) || 
					   (!is_array($arAttributes[1])) )
					{
						throw new AdoStatementLoadException('Os atributos não foram informados corretamente: array("load|ignore", array("att1", "att2"...));');  
					}
					else
					{
						switch($arAttributes[0])
						{
							case 'load':
							{
							    // Os campos informados que não existem na tabela são descartados
							    // do carregamento
								if($blnFilter)
								{
									// Campos da tabela
									$arTableFields = array();
							        
									foreach($arrGetTableFields as $arField)
									{
									    array_push($arTableFields, $arField['name']);
									}
	
									// Pega a interseção entre os campos da tabela 
									// e os campos informados uso array_values para 
									// zerar as chaves do array já que array_intersect
									// mantém as chaves originais 
									$arFields = array_values(array_intersect($arTableFields, 
																			 $arAttributes[1]));
								}
								else
								{
									$arFields = $arAttributes[1];
								}	
								
								if(count($arFields) == 0) return;
								
								break;
							}
							case 'ignore':
							{
								$arFields = array();
						
								foreach($arrGetTableFields as $arField)
								{
									if(!in_array($arField['name'], $arAttributes[1]))
									{
										array_push($arFields, $arField['name']);
									}	
								}
								
								break;
							}
							
							default : throw new AdoStatementLoadException('Especifique \"load\" ou \"ignore\" no primeiro elemento do array de atributos');
						}
						
						$arAttributes = $arFields;
					}	
				}
				
				// Montagem da condição para carregamento
				
				// Se a condição não foi informada monta ela automaticamente
				// de acordo com a(s) chave(s) primária(s) da tabela
				if(is_null($strCondition))
				{
					$strCondition = '';
					
					// O registro a ser carregado no objeto é encontrado 
					// através da(s) sua(s) chave(s) primária(s)
					foreach($arrGetTableFields as $arField)
					{
						// Obtém a chave primária da tabela
						if(in_array('primary_key', $arField['flags']))
						{
							$strPrimaryKey      = $arField['name'];
							$strPrimaryKeyValue = parent::GetAttributeValue($objLoaded, $arField['name']);
							
							if(empty($strPrimaryKeyValue))
							{
								throw new AdoStatementLoadException('O código de localização do registro ('.$arField['name'].'), não foi informado');
							}
							
							$strCondition .= !empty($strCondition) ? 'AND ' : '';
							$strCondition .= $strPrimaryKey . " = '" . $strPrimaryKeyValue . "' ";
						}
					}
				}

        		// Uma vez obtida a condição verifica se o registro existe:
				if(!parent::FindRecord($strTable, $strCondition))
				{
					throw new AdoNoRecordFoundException();	
				}				
				
        		// Uma vez que foi obtido os atributos a serem carregados
				// inserimos o comando que descriptografa aqueles que 
				// estiverem criptografarados no banco
				$arDecodedAttributes = array();
				
				for($i = 0; $i < count($arAttributes); $i++)
				{
				    if(parent::IsCrypted($arAttributes[$i]))
					{
					    // Guardo o nome e a posição do atributo descriptografado
						// para depois recuperá-lo
						$arDecodedAttributes[$i] = $arAttributes[$i];
						
						// Criando o comando SQL para descriptografar o campo:
						$arAttributes[$i] = "DECODE("
						                  . $arAttributes[$i]
						                  . ",'"
						                  . SystemConfig::ENCRYPT_KEY 
						                  ."') AS " 
						                  . $arAttributes[$i];
					}
				}				
				
				$objSQLBuilder = new AdoSQLBuilder();
				$objSQLBuilder->Fields($arAttributes);
				$objSQLBuilder->From(array($strTable));
				$objSQLBuilder->Where(array($strCondition));
				$objSQLBuilder->Limit(array(1));
				
				$objRecordSet = parent::GetAdoConnection()->Query($objSQLBuilder->Select());
				
				//$objRecordSet->Display(); exit();
				
				if(is_array($arDecodedAttributes))
				{
					foreach($arDecodedAttributes as $strIndex => $strField)
					{
						$arAttributes[$strIndex] = $strField;
					}
	            }					
						
				// Seta cada atributo da classe com o seu respectivo campo no recordSet: 
				foreach($arAttributes as $strAttribute)
				{
					$strMethod = Utils::BuildProperty('Set', $strAttribute);
					$objLoaded->$strMethod($objRecordSet->First()->$strAttribute);
				}
        	}	
        	catch(Exception $e)
			{
				throw $e;
			}				
        }
		
//------------------------------------------------------------------------------

}