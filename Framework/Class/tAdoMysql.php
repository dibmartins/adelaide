<?php 

class AdoException extends Exception{}

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
 * Classe de gerenciamento de conexões com Mysql
 * O código de exemplo mostra como utilizar esta classe mas a altamente recomendável 
 * a utilização da classe AdoFactory para receber uma instância desta classe
 * @package Framework
 * @subpackage Ado
 * @final Atenção! Esta classe não pode ser herdada.
 * @version 1.0 - 2006-08-12 17:48:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.php.net/manual/pt_BR/ref.mysql.php
 * @link http://www.oodesign.com.br/patterns/Singleton.html  
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

final class AdoMysql extends AdoConnection
{
   
   /** 
    * Attributes:
    */
	
	const CLIENT_MULTI_RESULTS = 131072;

   /**
    * Armazena a instância desta classe.
    * @static Atributo estático
	* @var 	$objAdoMysql
	* @access private
	*/		
	static private $objAdoMysql = NULL;
   
//---------------------------------------------------------------------------------------   

   /** 
    * Properties:
    */

//---------------------------------------------------------------------------------------   
   
   /** 
    * Methods:
    */
   
   /**
	* Método construtor da classe
	* Se ocorrer um erro uma excessão é gerada.
	* @param string $strHost IP do servidor de banco de dados (Opcional)
	* @param string $strUser usuário de acesso ao servidor (Opcional)
	* @param string $strPassword Senha de acesso ao servidor (Opcional)
	* @param int $intPort Porta de conexão com o servidor (Opcional)
	* @param string $strDataBase Base de dados a ser selecionada (Opcional)
	* @return void
	* @access protected
	*/
	    protected function __construct($strHost = '', $strUser = '', $strPassword = '', $intPort = SystemConfig::ADO_PORT, $strDataBase = '')
	    {	
		    parent::__construct(); 
			
		    $blnConectado = $this->Connect($strHost, $strUser, $strPassword, $intPort);
			
			if(!$blnConectado)
			{
			    $this->ErrorHandler();
			}
			elseif(!$this->SelectDataBase($strDataBase))
			{
			    $this->ErrorHandler();
			}
			
		    parent::SetHost($strHost);
			parent::SetPort($intPort);
			parent::SetUser($strUser);
			parent::SetPassword($strPassword);
			parent::SetDatabase($strDataBase);			
	    }

   /**
	* Método destrutor da classe
	* @return void
	* @access public
	*/
	    public function __destruct()
	    {	
		    if($this->Connected())
			{
			    $this->CloseConnection();
			}
	    }

   /**
	* Reporta o erro e lança uma AdoServerException
	* @return void
	* @access public
	*/
	    public function ErrorHandler()
	    {
	    	try
	    	{
			    // Formatando a mensagem:
				$objMessage = new Message;
				$strError = $objMessage->FormatDataBaseMessage(mysql_errno(), mysql_error());
				
				// Reportando o erro para o administrador do sistema:
				parent::reportError($strError, mysql_errno());
				
				// Disparando excessões para podermos 
				// tratar os diferentes tipos de erros
				switch(mysql_errno())
				{
					//case 2013 : 
					case 1049 : throw new AdoUnableToConnectException($strError, mysql_errno()); break;
					case 1062 : 
					{
						// Verifica se um erro customizado foi disparado
						// A tabela erros_customizados tem que ter um índice
						// composto pelas colunas codigo e descricao, e o nome 
						// desse índice deve ser 'erro_customizados' 
						$blnCustomError = strpos($strError, 'erros_customizados');
						
						if($blnCustomError)
						{
							throw new AdoCustomException($strError);	
						}
						else
						{
							throw new AdoDuplicateEntryException($strError, mysql_errno());
						}	 
						
						break;
					}	
					
					case 1216 : 
					case 1217 : 
					case 1451 : throw new AdoUnableDeleteEntryException($strError, mysql_errno()); break;

					default   : throw new AdoServerException($strError, mysql_errno()); break;
				}
	    	}
	    	catch(Exception $e)
	    	{
	    		throw $e;
	    	}	
		}
		
   /**
	* Implementa o padrão Singleton para conectar uma única vez o banco de dados.
	* @param string $strHost IP do servidor de banco de dados (Opcional)
	* @param string $strUser usuário de acesso ao servidor (Opcional)
	* @param string $strPassword Senha de acesso ao servidor (Opcional)
	* @param int $intPort Porta de conexão com o servidor (Opcional)
	* @param $strDataBase Base a ser selecionada (Opcional)
	* @return object $objAdoMysql
	* @access public
	*/
	    static public function Singleton($strHost 	  = '', 
	    								 $strUser 	  = '', 
	    								 $strPassword = '', 
	    								 $intPort     = '', 
	    								 $strDataBase = '') 
	    {
	    	// Se ainda não existe uma conexão cria uma				
		    if (self::$objAdoMysql == NULL) 
			{
				$class = __CLASS__;
				
				self::$objAdoMysql = new $class($strHost, 
											    $strUser, 
											    $strPassword, 
											    $intPort, 
											    $strDataBase);
			}
			// Se existe uma conexão mas as credenciais 
			// são diferentes das informadas sobrescreve a conexão atual
			else
			{
				if($strHost     != self::$objAdoMysql->GetHost()     ||
				   $strUser     != self::$objAdoMysql->GetUser()     ||
				   $strPassword != self::$objAdoMysql->GetPassword() ||
				   $strDataBase != self::$objAdoMysql->GetDatabase()  )
				{
					$class = __CLASS__;			
				    
					self::$objAdoMysql->CloseConnection();
				    
				    self::$objAdoMysql = new $class($strHost, 
				    								$strUser, 
				    								$strPassword, 
				    								$intPort, 
				    								$strDataBase);
				}
			}

			return self::$objAdoMysql; 
	    }	

   /**
	* Verifica se já existe uma conexão estabelecida com servidor de banco de dados
	* @return boolean true se a conexão estiver estabelecida, caso contrário false
	* @access public
	*/
	    public function Connected()
	    {	
		    if(is_resource(parent::GetConnection()) && mysql_ping(parent::GetConnection()))
			{
			    return true;
			}
			else
			{
			    return false;
			}
		} 
   
   /**
	* Estabelece conexão com o servidor de banco de dados.
	* Caso os parâmetros de conexão não sejam informados, 
	* esta função irá assumir os valores de conexão definidos na classe AdoConnection.
	* @param string $strHost IP do servidor de banco de dados (Opcional)
	* @param string $strUser usuário de acesso ao servidor (Opcional)
	* @param string $strPassword Senha de acesso ao servidor (Opcional)
	* @param int $intPort Porta de conexão com o servidor (Opcional)
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
	    public function Connect($strHost 	 = '', 
	    						$strUser     = '', 
	    						$strPassword = '', 
	    						$intPort     = '')
	    {	
		    // Setando a conexão com os dados informados
			if(empty($strHost) && empty($strUser) && empty($strPassword))
			{
			    $strHost     = parent::GetHost();
				$strUser     = parent::GetUser();
				$strPassword = parent::GetPassword();
				$intPort     = parent::GetPort();
			}
			
			if(!empty($intPort))
			{
			    $intPort = ':' . $intPort; 
			}
			
			//echo "$strHost, $intPort, $strUser, $strPassword <br>";
			//Utils::StartExecution();
			// Efetuando a conexão:
			parent::SetConnection(mysql_connect($strHost.$intPort,
												$strUser,
												$strPassword,
												NULL,
												//Este parâmetro permiti o uso de procedures habilitando
												//os resultados múltiplos.
												//Adicionado em 11/02/2012 as 15:00.  
												self::CLIENT_MULTI_RESULTS));
			//$count = Utils::EndExecution();
			//if($count > 0) echo 'Conectar: ' . Utils::EndExecution() . '<br>';												
			 
		    if($this->Connected())
			{
			    return true;
			}
			else
			{
			    return false;
			}
		}
	
   /**
	* Encerra a conexão com o servidor de banco de dados
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
	    public function CloseConnection()
	    {	
		    if(mysql_close(parent::GetConnection()))
			{
			    parent::SetConnection(NULL);
				parent::SetResult(NULL);
			 	return true;
			}
			else
			{
			    return false;
			}
		}	
		
   /**
	* Seleciona a base de dados informada como parâmetro
	* Se nenhuma base for informada será assumida a base definida na classe AdoConnection.
	* @param $strDataBase Base a ser selecionada (Opcional)
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access private
	*/
		private function SelectDataBase($strDataBase = '')
		{	
		    if(empty($strDataBase))
			{
			    $strDataBase = parent::GetDatabase();
			}			
			
			if(mysql_select_db($strDataBase))
			{
			    return true;
			}
			else
			{
			    return false;
			}
		}
		
   /**
	* Realiza uma consulta ao banco de dados
	* Seta em RecorSet os registros retornados
	* Seta em Rows o número de registros retornados
	* Se ocorrer um erro uma excessão é gerada.
	* @param string $strSQL Comando SQL
	* @param string $strRecordSetMode (Opcional) Modo de armazenamento do recordSet ('object' ou 'array') 
	* @param boolean $blnFreeResult (Opcional) false para que a consulta fique armazenada na memória do servidor
	* @param boolean $blnFormat (Opcional) false para que a consulta seja retornada sem formatação
	* @return object AdoRecordSet
	* @access public
	*/
		public function Query($strSQL, 
							  $strRecordSetMode = 'object', 
							  $blnFreeResult    = true, 
							  $blnFormat 	    = true)
		{
			try
			{
			    // Verificando se existe uma conexão aberta:
				if(!$this->Connected())
				{
				    $this->ErrorHandler();
				}
				
				parent::SetSQL($strSQL);
				 
				// Realizando a consulta:
				parent::SetResult(mysql_query(parent::GetSQL()));
				
				// Se a consulta foi realizada com sucesso: 
				if(parent::GetResult())
				{
				    // Verificando o modo de armazenamento do recordSet
					switch($strRecordSetMode)
					{
					    // O recordSet será um array contendo os registros em forma de objeto.
						case 'object': 
						{
						    while($objRecord = mysql_fetch_object(parent::GetResult()))
							{
								$arRecords[] = $objRecord; 
							}
							break;
						}
						// O recordSet será um array contendo os registros em forma de array.
						case 'array': 
						{
						    while($objRecord = mysql_fetch_array(parent::GetResult(), MYSQL_ASSOC))
							{
								$arRecords[] = $objRecord; 
							}
							break;
						}
						// O modo padrão é o recordSet como objeto
						default:
						{
						    while($objRecord = mysql_fetch_object(parent::GetResult()))
							{
								$arRecords[] = $objRecord; 
							}
							break;
						}	
					}
					
	                if(!isset($arRecords)) $arRecords = array();

					// Setando o atributo recordSet da consulta.
					$objRecordSet = new AdoRecordSet();
					$objRecordSet->SetFields($this->FieldsInfo());
					$objRecordSet->SetRecordSet($arRecords, $blnFormat);
					$objRecordSet->SetServerInfo($this->HostInfo());
					$objRecordSet->SetSql(parent::GetSQL());
					$objRecordSet->SetDataBase(parent::GetDataBase());
					
					// Setando o numero de linhas da consulta.
					parent::SetRows(mysql_num_rows(parent::GetResult()));
					
					// Liberando a memória do servidor:  
					if($blnFreeResult)
					{
						$this->FreeResult();
					}
					
					return $objRecordSet;
				}
				else
				{
				    $this->ErrorHandler();
				}
			}
			catch(Exception $e)
			{
				throw $e;
			}	
		}				 
		
   /**
	* Executa uma stored procedure no banco de dados
	* 
	* Funciona somente a partir do PHP 5.3.1
	* 
	* Seta em RecorSet os registros retornados
	* Seta em Rows o número de registros retornados
	* Se ocorrer um erro uma excessão é gerada.
	* @param string $strProcedure Nome da procedure a ser executada
	* @param string $strRecordSetMode (Opcional) Modo de armazenamento do recordSet ('object' ou 'array') 
	* @param boolean $blnFreeResult (Opcional) false para que a consulta fique armazenada na memória do servidor
	* @param boolean $blnFormat (Opcional) false para que a consulta seja retornada sem formatação
	* @return object AdoRecordSet
	* @access public
	*/
		public function Call($strProcedure, 
							 $strRecordSetMode = 'object', 
							 $blnFreeResult    = true, 
							 $blnFormat 	   = true)
		{	
		    try
		    {
		    	$strSQL = "CALL $strProcedure; ";
		    	
		    	return $this->Query($strSQL, 
		    						$strRecordSetMode,
		    						$blnFreeResult, 
		    						$blnFormat);
		    }
		    catch(Exception $e)
		    {
		    	throw $e;
		    }
		}				 
		
   /**
	* Executa uma consulta ao banco de dados
	* Seta em Rows o número de registros retornados
	* Seta em InsertId o último id inserido no banco
	* Se ocorrer um erro uma excessão é gerada.
	* @param string $strSQL Comando SQL
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
		public function Execute($strSQL)
		{
			try
			{	
			    // Verificando se existe uma conexão aberta:
				if(!$this->Connected())
				{
				    $this->ErrorHandler();
				}
				
				parent::SetSQL($strSQL);
				 
				parent::SetResult(mysql_query(parent::GetSQL()));
				 
				if(parent::GetResult())
				{
				    parent::SetRows(mysql_affected_rows());
				    
					if(strpos(parent::GetSQL(), 'INSERT') !== false)
					{
					    parent::SetInsertId(mysql_insert_id());
					}
					 
					return true;
				}
				else
				{
				    $this->ErrorHandler();
				}
			}
			catch(Exception $e)
			{
				throw $e;
			}	
		}

   /**
	* Limpa o cache de memória do servidor
	* Se ocorrer um erro uma excessão é gerada.
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
		public function FreeResult()
		{	
		    if(is_resource(parent::GetResult()))
			{
				if(mysql_free_result(parent::GetResult()))
				{
					return true;
				}
				else
				{
					$this->ErrorHandler();
				}
			}
			else
			{
				$this->ErrorHandler();
			}	
		}

   /**
	* Ativa ou desativa o autocommit no banco de dados
	* @param boolean $blnActivate true para ativar e false para desativar
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
		public function AutoCommit($blnActivate = true)
		{
			try
			{
				return $this->Execute('SET AUTOCOMMIT = '. (int) $blnActivate .'; ');
			}
			catch(Exception $e)
			{
				throw $e;
			}	
		}
   
   /**
	* Inicia uma transação no banco de dados.
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
		public function Begin()
		{	
			try
			{
				// Desabilitando o autocommit:
				$this->AutoCommit(false);
				
				// Iniciando a transação.
			    return $this->Execute('START TRANSACTION;');
			}
			catch(Exception $e)
			{
				throw $e;
			}			
		}

   /**
	* Finaliza a transação gravando os resultados das inserções/exclusões etc...
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
		public function Commit()
		{	
		    // Iniciando a transação.
		    if($this->Execute('COMMIT;'))
			{
			    // Habilitando o autocommit:
			    $this->AutoCommit(false); 
			 
			    return true;
			}
			else
			{
			    return false;
			}
		}

   /**
	* Cancela toda a transação, caso ocorra erro, sem gravar nada no banco de dados
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/
		public function RollBack()
		{	
		    // Iniciando a transação.
			if($this->Execute('ROLLBACK;'))
			{
			    // Habilitando o autocommit:
			    $this->AutoCommit(true); 

			    return true;
			}
			else
			{
			    return false;
			}
		}		
		
   /**
	* Lista as tabelas de um banco.
	* Exemplo para percorrer as tabelas listadas: 
	* $arTables = AdoConnection()->GetTables();
	* foreach($arTables[AdoConnection()->GetDataBase()] as $strTable){...}
	* @return array Um array com as tabelas é retornado. 
	* @access public
	*/	
	    public function GetTables()
		{
			parent::SetResult(mysql_list_tables(parent::GetDatabase()));
			
			$arTables = array();
			
			while($strTable = mysql_fetch_row(parent::GetResult())) 
			{
                if(($strTable[0] != '_tabelas') && ($strTable[0] != '_tabelas_relacionamentos'))
				{
				    $arTables[parent::GetDataBase()][] = $strTable[0];
				}	
            }

			return $arTables;
		}

   /**
	* Retorna um array contendo as tabelas filhas relacionadas com a tabela mãe ($strTable) 
	* e os índices desses relacionamentos.
	* @param $strTable Tabela mãe que desejamos obter seus relacionamentos
	* @return array tabelas relacionadas com $strTable
	* @access public
	*/
	    public function GetRelationships($strTable) 
	    {		
	        // Obtendo o comando de criação da tabela:
			$objRecordSet       = $this->Query('SHOW CREATE TABLE '.parent::GetDataBase().'.'.$strTable.';');
			$strCreateTable     = 'Create Table';
			$strShowCreateTable = $objRecordSet->First()->$strCreateTable;
			
			$arMatches = array();

            if(!preg_match_all("/FOREIGN KEY \(`(.*?)`\) REFERENCES `(.*?)` \(`(.*?)`\)/", $strShowCreateTable, $arMatches)) 
			{
			    return false;
            }
			
			$arRelationships  = array();	 	 
            $intNumIndexes    = count($arMatches[0]);
			
            for($i = 0;  $i < $intNumIndexes; $i ++ ) 
			{
                $arField      = explode('`, `', $arMatches[1][$i]);
                $strTableRef  = $arMatches[2][$i];
                $arIndex      = explode('`, `', $arMatches[3][$i]);

                $intNumFields = count($arField);
                
				for($j = 0; $j < $intNumFields; $j ++) 
				{
                    $arRelationships[$i]['table'] = $strTableRef;
					$arRelationships[$i]['pk']    = $arIndex[$j];
					$arRelationships[$i]['fk']    = $arField[$j];
                }
            }
         
            return $arRelationships;
	    }
		
   /**
	* Retorna todas as tabelas mões que utilizam a tabela filha ($strTable).
	* @param $strTable Tabela filha que desejamos obter seus relacionamentos
	* @return array Um array com as tabelas é retornado. 
	* @access public
	*/	
	    public function GetParentTables($strTable)
		{
			// Obtendo o nome de todas as tabelas do banco de dados:
			$arTables = $this->GetTables();
			
			// Para cada tabela do banco de dados
			// Verifique se ela possui referência com $strTable
			// Se possuir inclua ela no array de tabelas que se relacionam com $strTable
			$i = 0;
			
			foreach($arTables[parent::GetDataBase()] as $strParentTable)
			{
			    // Obtendo os relacionamentos de cada tabela do banco de dados
				$arRelationships = $this->GetRelationships($strParentTable);
				
				// Toda vez que $strTable estiver entre as tabelas listadas do banco
				// inclua a tabela do banco no array de tabelas que utilizam $strTable 
				if(@in_array($strTable,array_keys($arRelationships)))
				{
					$arParentTables[$i]['tabela']     = $strParentTable;
					$arParentTables[$i]['foreignkey'] = $arRelationships[$strTable]['id'];					
				}
				else
				{
					continue;
				}
				
				$i++;
			}
			
			return $arParentTables;
		}

   /**
	* Retorna um resource com os campos de uma tabela.
	* @param string $strTable Nome da tabela
	* @return resource Um ponteiro de resultado dos campos é retornado. 
	* @access public
	*/	
	    public function ListFields($strTable)
        {
            return mysql_list_fields(parent::GetDatabase(), (string) $strTable);
        }

   /**
	* Retorna o número de campos de um resultado.
	* @param resource $rscFields Resultado retornado em $this->GetFields($strTable) (Opcional)
	* Se $rscFields for omitido, então o resultado da última consulta será utilizado.
	* @return int Total de campos do resultado
	* @access public
	*/	
	    public function TotalFields($rscFields = '')
		{
		    if(empty($rscFields))
			{
			    $rscFields = parent::GetResult();
			}
			
			return mysql_num_fields($rscFields);
		}
		
   /**
	* Retorna o nome do campo especificado.
	* @param resource $rscFields Resultado retornado em $this->GetFields($strTable) (Opcional)
	* Se $rscFields for omitido, então o resultado da última consulta será utilizado.
	* @param int $intIndex Numero da posição do campo. índice.
	* @return string Nome do campo.
	* @access public
	*/		    
	    public function FieldName($rscFields = '', $intIndex)
		{
			if(empty($rscFields))
			{
			    $rscFields = parent::GetResult();
			}
			
			return mysql_field_name($rscFields, $intIndex);
		}
		
   /**
	* Retorna o tipo do campo especificado.
	* @param resource $rscFields Resultado retornado em $this->GetFields($strTable) (Opcional)
	* Se $rscFields for omitido, então o resultado da última consulta será utilizado.
	* @param int $intIndex Numero da posição do campo. índice.
	* @return string Tipo do campo.
	* @access public
	*/		    
		public function FieldType($rscFields = '', $intIndex)
		{
			if(empty($rscFields))
			{
			    $rscFields = parent::GetResult();
			}
			
			return mysql_field_type($rscFields, $intIndex);
		}
   
   /**
	* Retorna o tamanho do campo especificado.
	* @param resource $rscFields Resultado retornado em $this->GetFields($strTable) (Opcional)
	* Se $rscFields for omitido, então o resultado da última consulta será utilizado.
	* @param int $intIndex número da posição do campo. índice.
	* @return string Tipo do campo.
	* @access public
	*/		    
		public function FieldSize($rscFields = '', $intIndex)
		{
			if(empty($rscFields))
			{
			    $rscFields = parent::GetResult();
			}
			
			return mysql_field_len($rscFields, $intIndex);
		}		
	
   /**
	* Retorna um array com as flags do campo especificado.
	* As seguintes flags são retornadas: "not_null", "primary_key", "unique_key"...
	* @param resource $rscFields Resultado retornado em $this->GetFields($strTable) (Opcional)
	* Se $rscFields for omitido, então o resultado da última consulta será utilizado.
	* @param int $intIndex número da posição do campo. índice.
	* @return array Flags do campo.
	* @access public
	*/		    
		public function FieldFlags($rscFields = '', $intIndex)
		{
			if(empty($rscFields))
			{
			    $rscFields = parent::GetResult();
			}
			
			return explode(' ', mysql_field_flags($rscFields, $intIndex));
		}
		
   /**
	* Retorna as informações dos campos utilizados na consulta atual
 	* Para utilizar este método, desabilite a opção de liberar memória 
	* setando o 3º parâmetro do método query para false
	* @param resource $rscFields Resultado retornado em $this->GetFields($strTable) (Opcional)
	* Se $rscFields for omitido, então o resultado da última consulta será utilizado.
	* @return array Info dos campos
	* @access public
	*/	   
	    public function FieldsInfo($rscFields = '')
	    {
		     if(empty($rscFields))
		     {
			    $rscFields = parent::GetResult();
		     }
		
             $arFields = '';
                	
		     for ($i = 0; $i < $this->TotalFields($rscFields); $i++) 
		     {
	             $arFields[$i]['name']  = $this->FieldName($rscFields, $i);
			 	 $arFields[$i]['type']  = $this->FieldType($rscFields, $i);
				 $arFields[$i]['size']  = $this->FieldSize($rscFields, $i);
				 $arFields[$i]['flags'] = $this->FieldFlags($rscFields, $i);
             }
		   
		     return $arFields; 
	    }

   /**
	* Retorna a string com as aspas simples e duplas escapadas.
	* @param string $strValue String a ser formatada.
	* @return string String formatada.
	* @access public
	*/		    
	    public function Escape($strValue)
		{
			if(function_exists('mysql_real_escape_string') && $this->Connected()) 
			{
                return mysql_real_escape_string($strValue,parent::GetConnection());
            } 
			else 
			{
                return mysql_escape_string($strValue);
            }
		}

   /**
	* Retorna a informação da sessão
	* @return string Informação da sessão
	* @access public
	*/
	    public function ServerInfo() 
	    {
            return mysql_info();
	    }

   /**
	* Retorna a informação do host
	* @return string Informação do host
	* @access public
	*/
	    public function HostInfo() 
	    {
            return 'Servidor Mysql '.$this->Version().' rodando em ' . mysql_get_host_info();
	    }
   
   /**
	* Retorna as informações do status do servidor de banco de dados em um recordSet.
	* Se ocorrer um erro uma excessão é gerada.
	* @param string $rscLinkId Resource de identificação da conexão.
	* @return object RecordSet com os registros de status do servidor
	* @access public
	*/
	    public function Status() 
	    {
		    try
		    {		   
		        $this->Query('SHOW STATUS;');
		    }
		    catch(Exception $e)
		    {
		        $this->ErrorHandler();
		    }
	    }

   /**
	* Retorna a versão do servidor
	* @return string Versão do servidor
	* @access public
	*/
	    public function Version() 
	    {
            $strVersion = mysql_get_server_info();
			
			return substr($strVersion, 0, strpos($strVersion, '-'));
	    }

   /**
	* Gera um arquivo sql com a estrutura e os dados das tabelas da base informada.
	* Se ocorrer um erro uma excessão é gerada.
	* @todo Implementar este método
	* @return boolean true se o comando foi realizado com sucesso, caso contrário false
	* @access public
	*/	
		public function Backup(){ /* não implementado! */ }
}