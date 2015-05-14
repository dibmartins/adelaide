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

class AdoStatementCollectionException extends AdoStatementException{}

/** 
 * 
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
 * 
 * Gerencia as operações de inserção de registros na base de dados
 * @package Framework
 * @subpackage Ado
 * @version 1.0 - 2011-10-18 09:36:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2011 Diego Botelho - Todos os direitos reservados
 */

class AdoStatementCollection extends AdoStatement
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
     * Lista os registros de uma tabela.
	 * @param string $strClassName Nome da Classe que se deseja obter uma lista de objetos carregados
	 * @param string $strTable Tabela que se deseja carregar cada objeto da lista
	 * @param array  $arAttributes Somente os campos informados nesse array serão carregados
	 * @param array $arOrderBy Array com os campos da cláusula, e a ordem de exibição.
	 * @return array $arCollection Array de objetos $strClassName
	 * @access public
	 */ 
        public function Execute($strClassName, 
        					    $strTable, 
        						$arAttributes = NULL, 
        						$arOrderBy    = NULL)
        {
		    try
			{
				if(empty($strTable))
				{
					throw new AdoStatementCollectionException('Nenhuma tabela informada para carregar o registro, '
															. 'verifique se a Dao utilizada possui o método GetTable().');
				}
				
				if(is_null($arAttributes))
				{
					$arTableFields = parent::GetTableFields($strTable);
					
					$arAttributes = array();
				
					foreach($arTableFields as $arField)
					{
						array_push($arAttributes, $arField['name']);
					}
				}
				elseif(!is_array($arAttributes))
				{
					throw new AdoStatementCollectionException('Os atributos a serem carregados não foram informados corretamente');
				}

				// Comentei por questões de performance 
				// porque no esus não trabalhamos com colunas _crypt
				/*for($i = 0; $i < count($arAttributes); $i++)
				{
					if(parent::IsCrypted($arAttributes[$i]))
					{
						$arAttributes[$i] = "DECODE("
						                  .$arAttributes[$i]
						                  .",'"
						                  . SystemConfig::ENCRYPT_KEY 
						                  ."') AS " 
						                  . $arAttributes[$i];
					}
				}*/
				
				$objSQLBuilder = new AdoSQLBuilder();
				$objSQLBuilder->Fields($arAttributes);
				$objSQLBuilder->From(array($strTable));
				
				if(is_array($arOrderBy))
				{
					list($arFields, $strOrder) = $arOrderBy;	
					
					$objSQLBuilder->OrderBy(array($arFields, $strOrder));
				}
				
				$strSQL = $objSQLBuilder->Select();
				
				// Executando a consulta:
				$objRecordSet = parent::GetAdoConnection()->Query($strSQL);

				// Retornando os objetos carregados:
				return $objRecordSet->GetRecordSet();				
			}
			catch(Exception $e)
			{
				throw $e;
			}
        }
		
//------------------------------------------------------------------------------

}