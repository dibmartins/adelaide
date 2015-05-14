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

class AdoStatementDeleteException extends AdoStatementException{}

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

class AdoStatementDelete extends AdoStatement
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
	* Constrói o comando DELETE.
	* @param object $objObject objeto com os dados a serem inseridos em $strTable
	* @param string $strTable Tabela onde os dados serão armazenados 
    * @param string $strUserCondition (Opcional) Condição do delete, Ex.: "expiracao >= CURDATE()"
	* se não informada a Condição será baseada na(s) 
	* chave(s) primária(s) da tabela Ex.: "id = '".$objeto->GetId()."'"
	*  
	* @return boolean true se o comando foi realizado com sucesso, 
	* caso contrário false, gerando uma exceção
	* @access public
	*/
		public function Execute($objObject, 
							    $strTable, 
							    $strUserCondition = NULL)
		{
			try
			{
				if(!is_object($objObject) || empty($strTable))
				{
					throw new AdoStatementDeleteException('Parâmetros inválidos para cláusula DELETE');	
				}				
				
			    $strCondition = '';
				
			    $arrGetTableFields = parent::GetTableFields($strTable);
			    
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
							$strPrimaryKeyValue = parent::FormatToDataBase($arField['type'], $strPrimaryKeyValue);
							$strPrimaryKeyValue = Utils::CheckSQLInjection($strPrimaryKeyValue);
							
							if(empty($strPrimaryKeyValue))
							{
								throw new AdoStatementDeleteException('O código de atualização do registro ('.$arField['name'].'), não foi informado');
							}
							
							$strCondition .= !empty($strCondition) ? 'AND ' : '';
							$strCondition .= $strPrimaryKey . ' = "' . $strPrimaryKeyValue . '" ';
							
							// Campos chave-primária não são atualizados:
							continue;
						}
						
						// Verificando se o registro existe:
						if(parent::FindRecord($strTable, $strCondition))
						{
							$strDelete = "DELETE FROM $strTable WHERE $strCondition; ";
							
							return parent::GetAdoConnection()->Execute($strDelete);
						}
						else
						{
							throw new AdoNoRecordFoundException();
						}
					}
					else
					{
						$strDelete = "DELETE FROM $strTable WHERE $strUserCondition; ";

						//echo $strDelete;
						
						return parent::GetAdoConnection()->Execute($strDelete);						
					}	
				}
			}
			catch(Exception $e)
			{
				throw $e;
			}
		}
		
//------------------------------------------------------------------------------

}