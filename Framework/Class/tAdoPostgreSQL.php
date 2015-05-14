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
 * Classe de gerenciamento de conexões com PostgreSQL
 * O código de exemplo mostra como utilizar esta classe mas é altamente recomendável 
 * a utilização da classe AdoFactory para receber uma instância desta classe
 * @package Framework
 * @subpackage Ado
 * @final Atenção! Esta classe não pode ser herdada.
 * @version 1.0 - 2006-09-19 16:43:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.php.net/manual/pt_BR/function.pg-connect.php
 * @link http://www.oodesign.com.br/patterns/Singleton.html  
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 */

final class AdoPostgreSQL extends AdoConnection
{
   
   /** 
    * Attributes:
    */

   /**
    * Armazena a instancia desta classe.
    * @static Atributo estático
	* @var 	$instance 
	* @access 	private
	*/		
	static private $instance  = NULL;
   
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
	* @return void
	* @access protected
	*/
	    protected function __construct($strHost = '', $strUser = '', $strPassword = '', $intPort = '', $strDataBase = '')
	    {	
		    parent::__construct(); 
			
			$this->Connect($strHost, $strUser, $strPassword, $intPort);
			
			if(!$this->Connected())
			{
			    throw new Exception("não foi possível estabelecer conexão com o servidor");
			}
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
	* Implementa o padrão Singleton para conectar uma única vez o banco de dados.
	* @param string $strHost IP do servidor de banco de dados (Opcional)
	* @param string $strUser usuário de acesso ao servidor (Opcional)
	* @param string $strPassword Senha de acesso ao servidor (Opcional)
	* @param int $intPort Porta de conexão com o servidor (Opcional)
	* @param $strDataBase Base a ser selecionada (Opcional)
	* @return object $instance 
	* @access public
	*/
	    static public function Singleton($strHost = '', $strUser = '', $strPassword = '', $intPort = '', $strDataBase = '') 
	    { 					
		    if (self::$instance  == NULL) 
			{ 
				$class = __CLASS__; 
				
				self::$instance  = new $class($strHost, $strUser, $strPassword, $intPort, $strDataBase);
			}
			
			return self::$instance ; 
	    }	

   /**
	* Verifica se já existe uma conexão estabelecida com servidor de banco de dados
	* @return boolean true se a conexão estiver estabelecida, caso contrário false
	* @access public
	*/
	    public function Connected()
	    {	
	  		if(pg_connection_Status(parent::GetConnection()) === 0)
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
	* esta função serão assumidos os valores de conexão definidos na classe AdoConnection.
	* @param string $strHost IP do servidor de banco de dados (Opcional)
	* @param string $strUser usuário de acesso ao servidor (Opcional)
	* @param string $strPassword Senha de acesso ao servidor (Opcional)
	* @param int $intPort Porta de conexão com o servidor (Opcional)
	* @return boolean true se o comando foi realizado com suxesso, caso contrário false
	* @access public
	*/
	    public function Connect($strHost = '', $strUser = '', $strPassword = '', $intPort = '', $strDataBase = '')
	    {	
		    // Setando a conexão com os dados informados
			if(empty($strHost) && empty($strUser) && empty($strPassword) && empty($intPort))
			{
			    $strHost     = parent::GetHost();
				$strUser     = parent::GetUser();
				$strPassword = parent::GetPassword();
				$intPort     = parent::GetPort();
				$strDataBase = parent::GetDataBase();
			}
			
			// Construindo a string de conexão:
			$strConString = "host="     . $strHost     . " "; 
			$strConString.= "port="     . $intPort     . " ";
			$strConString.= "dbname="   . $strDataBase . " ";
			$strConString.= "user="     . $strUser     . " ";
			$strConString.= "password=" . $strPassword . "";
			
			// Efetuando a conexão:
			parent::SetConnection(pg_Connect($strConString));
			 
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
	* @return boolean true se o comando foi realizado com suxesso, caso contrário false
	* @access public
	*/
	    public function CloseConnection()
	    {	
		    if(@pg_close(parent::GetConnection()))
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
	* Realiza uma consulta ao banco de dados
	* Seta em RecorSet os registros retornados
	* Seta em Rows o número de registros retornados
	* Se ocorrer um erro uma excessão é gerada.
	* @param string $strSQL Comando SQL
	* @param string $strRecordSetMode (Opcional) Modo de armazenamento do recordSet ('object' ou 'array') 
	* @param boolean $blnFreeResult (Opcional) false para que a consulta fique armazenada na memória do servidor
	* @return boolean true se o comando foi realizado com suxesso, caso contrário false
	* @access public
	*/
		public function Query($strSQL, $strRecordSetMode = 'object', $blnFreeResult = true)
		{	
		    // Verificando se existe uma conexão aberta:
			if(!$this->Connected())
			{
			    throw new Exception(pg_last_notice(parent::GetConnection()));
			}
			
			parent::SetSQL($strSQL);
			 
			// Realizando a consulta:
			parent::SetResult(pg_Query(parent::GetConnection(), parent::GetSQL()));
			
			// Se a consulta foi realizada com sucesso: 
			if(parent::GetResult())
			{
			    // Verificando o modo de armazenamento do recordSet
				switch($strRecordSetMode)
				{
				    // O recordSet será um array contendo os registros em forma de objeto.
					case 'object': 
					{
					    while($objRecord = pg_fetch_object(parent::GetResult()))
						{
							$arRegistros[] = $objRecord; 
						}
						break;
					}
					// O recordSet será um array contendo os registros em forma de array.
					case 'array': 
					{
					    while($objRecord = pg_fetch_array(parent::GetResult()))
						{
							$arRegistros[] = $objRecord; 
						}
						break;
					}
					// O modo padrão é o recordSet como objeto
					default:
					{
					    throw new Exception("Tipo de recordSet inválido");
					}	
				}
				
				// Setando o atributo recordSet da consulta.
				$objRecordSet = new AdoRecordSet();
				$objRecordSet->SetRecordSet($arRegistros);
				$objRecordSet->SetServerInfo($this->HostInfo());
				$objRecordSet->SetSql(parent::GetSQL());
				$objRecordSet->SetDataBase(parent::GetDataBase());
				$objRecordSet->SetCampos($this->FieldsInfo()); 
				
				// Setando o numero de linhas da consulta.
				parent::SetRows(pg_num_rows(parent::GetResult()));
				
				// Liberando a memória do servidor:  
				if($blnFreeResult)
				{
					$this->FreeResult();
				}
				
				return $objRecordSet;
			}
			else
			{
			    // A consulta contém erros!
				throw new Exception(pg_last_notice(parent::GetConnection()));				 
			}
		}				 
		
   /**
	* Executa uma consulta ao banco de dados
	* Seta em Rows o número de registros retornados
	* Seta em InsertId o último id inserido no banco
	* Se ocorrer um erro uma excessão é gerada.
	* @param string $strSQL Comando SQL
	* @return boolean true se o comando foi realizado com suxesso, caso contrário false
	* @access public
	*/
		public function Execute($strSQL)
		{	
		    // Verificando se existe uma conexão aberta:
			if(!$this->Connected())
			{
			    throw new Exception(pg_last_notice(parent::GetConnection()));
			}
			
			parent::SetSQL($strSQL);
			 
			parent::SetResult(@pg_Query(parent::GetConnection(), parent::GetSQL()));
			 
			if(@pg_affected_rows(parent::GetResult()) > 0)
			{
			    parent::SetRows(@pg_affected_rows(parent::GetResult()));
			    
				if(strpos(parent::GetSQL(), 'INSERT') !== false)
				{
				    parent::SetInsertId(@pg_last_oid(parent::GetResult()));
				}
				 
				return true;
			}
			else
			{
			    throw new Exception(pg_last_notice(parent::GetConnection()));
			}
		}

   /**
	* Limpa o cache de memória do servidor
	* Se ocorrer um erro uma excessão é gerada.
	* @return boolean true se o comando foi realizado com suxesso, caso contrário false
	* @access public
	*/
		public function FreeResult()
		{	
		    if(is_resource(parent::GetResult()))
			{
				if(@pg_free_result(parent::GetResult()))
				{
					return true;
				}
				else
				{
					throw new Exception(pg_last_notice(parent::GetConnection()));
				}
			}
			else
			{
				throw new Exception(pg_last_notice(parent::GetConnection()));
			}	
		}

   /**
	* Ativa ou desativa o autocommit no banco de dados
	* @param boolean $blnActivate true para ativar e false para desativar
	* @return boolean true se o comando foi realizado com suxesso, caso contrário false
	* @access public
	*/
		public function AutoCommit($blnActivate = true)
		{	
		    return $this->Execute("SET AUTOCOMMIT = ". (int) $blnActivate ."; ");
		}
   
   /**
	* Inicia uma transação no banco de dados.
	* @return boolean true se o comando foi realizado com suxesso, caso contrário false
	* @access public
	*/
		public function Begin()
		{	
		    // Desabilitando o autocommit:
			$this->AutoCommit(false);
			
			// Iniciando a transação.
		    return $this->Execute("START TRANSACTION;");
		}

   /**
	* Finaliza a transação gravando os resultados das inserções/exclusões etc...
	* @return boolean true se o comando foi realizado com suxesso, caso contrário false
	* @access public
	*/
		public function Commit()
		{	
		    // Iniciando a transação.
		    if($this->Execute("COMMIT;"))
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
	* Cancela toda a transação, caso ocorra erro, sem gravar nada no banco de dados
	* @return boolean true se o comando foi realizado com suxesso, caso contrário false
	* @access public
	*/
		public function Rollback()
		{	
		    // Iniciando a transação.
			if($this->Execute("ROLLBACK;"))
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
	* $arTabelas = AdoConnection()->GetTables();
	* foreach($arTabelas[AdoConnection()->GetDataBase()] as $strTable){...}
	* @return array Um array com as tabelas é retornado. 
	* @access public
	*/	
	    public function GetTables()
		{
			parent::SetResult(mysql_list_tables(parent::GetDatabase()));
			
			while($strTable = pg_fetch_row(parent::GetResult())) 
			{
                if(($strTable[0] != "_tabelas") && ($strTable[0] != "_tabelas_relacionamentos"))
				{
				    $arTabelas[parent::GetDataBase()][] = $strTable[0];
				}	
            }

			return $arTabelas;
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
			$objRecordSet       = $this->Query("SHOW CREATE TABLE ".parent::GetDataBase().".".$strTable.";");
			$strCreateTable     = "Create Table";
			$strShowCreateTable = $objRecordSet->First()->$strCreateTable;
			
			$arOcorrencias = array();

            if(!preg_match_all("/FOREIGN KEY \(`(.*?)`\) REFERENCES `(.*?)` \(`(.*?)`\)/", $strShowCreateTable, $arOcorrencias)) 
			{
			    return false;
            }
			
			$arRelacionamentos = array();	 	 
            $intNumIndexes     = count($arOcorrencias[0]);
			
            for($i = 0;  $i < $intNumIndexes; $i ++ ) 
			{
                $arCampo      = explode('`, `', $arOcorrencias[1][$i]);
                $strTableRef = $arOcorrencias[2][$i];
                $arIndex     = explode('`, `', $arOcorrencias[3][$i]);

                $arRelacionamentos[$strTableRef] = array();
                $intNumCampos = count($arCampo);
                
				for($j = 0; $j < $intNumCampos; $j ++) 
				{
                    $arRelacionamentos[$strTableRef][$arIndex[$j]] = $arCampo[$j];                    
                }
            }
         
            return $arRelacionamentos;
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
			$arTabelas = $this->GetTables();
			
			// Para cada tabela do banco de dados
			// Verifique se ela possui referencia com $strTable
			// Se possuir inclua ela no array de tabelas que se relacionam com $strTable
			$i = 0;
			
			foreach($arTabelas[parent::GetDataBase()] as $strTableMae)
			{
			    // Obtendo os relacionamentos de cada tabela do banco de dados
				$arRelacionamentos = $this->GetRelationships($strTableMae);
				
				// Toda vez que $strTable estiver entre as tabelas listadas do banco
				// inclua a tabela do banco no array de tabelas que utilizam $strTable 
				if(@in_array($strTable,array_keys($arRelacionamentos)))
				{
					$arTabelasMae[$i]['tabela']     = $strTableMae;
					$arTabelasMae[$i]['foreignkey'] = $arRelacionamentos[$strTable]['id'];
					
				}
				else
				{
					continue;
				}
				
				$i++;
			}
			
			return $arTabelasMae;
		}

   /**
	* Lista os campos de uma tabela do banco.
	* @param string $strTable Nome da tabela
	* @return resource Um ponteiro de resultado dos campos é retornado. 
	* @access public
	*/	
	    public function GetFields($strTable)
		{
			return mysql_list_fields(parent::GetDatabase(), (string) $strTable);
		}
		    
   /**
	* Retorna o número de campos de um resultado.
	* @return int Total de campos do resultado
	* @access public
	*/	
	    public function TotalFields()
		{
		    return mysql_num_fields(parent::GetResult());
		}
		
   /**
	* Retorna o nome do campo especificado.
	* @param int $intIndex Numero da posição do campo. índice.
	* @return string Nome do campo.
	* @access public
	*/		    
	    public function FieldName($intIndex)
		{
			return mysql_field_name(parent::GetResult(), $intIndex);
		}
		
   /**
	* Retorna o tipo do campo especificado.
	* @param int $intIndex Numero da posição do campo. índice.
	* @return string Tipo do campo.
	* @access public
	*/		    
		public function FieldType($intIndex)
		{
			return mysql_field_type(parent::GetResult(), $intIndex);
		}
   
   /**
	* Retorna o tamanho do campo especificado.
	* @param int $intIndex número da posição do campo. índice.
	* @return string Tipo do campo.
	* @access public
	*/		    
		public function FieldSize($intIndex)
		{
			return mysql_field_len(parent::GetResult(), $intIndex);
		}		
	
   /**
	* Retorna um array com as flags do campo especificado.
	* As seguintes flags são retornadas: "not_null", "primary_key", "unique_key"...
	* @param int $intIndex número da posição do campo. índice.
	* @return array Flags do campo.
	* @access public
	*/		    
		public function FieldFlags($intIndex)
		{
			return explode(" ",mysql_field_flags(parent::GetResult(), $intIndex));
		}
		
   /**
	* Retorna as informações dos campos utilizados na consulta atual
 	* Para utilizar este método, desabilite a opção de liberar memória 
	* setando o 3o. parâmetro do método query para false
	* @return array Info dos campos
	* @access public
	*/	   
	    public function FieldsInfo()
	    {
		    for ($i = 0; $i < $this->TotalFields(); $i++) 
		    {
                $arFields[$i]['nome']    = $this->FieldName($i);
			    $arFields[$i]['tipo']    = $this->FieldType($i);
			    $arFields[$i]['tamanho'] = $this->FieldSize($i);
			    $arFields[$i]['flags']   = $this->FieldFlags($i);
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
			return @pg_escape_string($strValue);            
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
            return "Servidor PostgreSQL ".$this->Version()." rodando em " . mysql_get_host_info();
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
		        $this->Query("SHOW STATUS;");
		    }
		    catch(Exception $e)
		    {
		        throw new Exception($e->GetMessage(),$e->GetCode());   
		    }
	    }

   /**
	* Retorna a versão do servidor
	* @return string Versão do servidor
	* @access public
	*/
	    public function Version() 
	    {
            $strVersao = mysql_get_server_info();
			
			return substr($strVersao, 0, strpos($strVersao, "-"));
	    }

   /**
	* Gera um arquivo sql com a estrutura e os dados das tabelas da base informada.
	* Se ocorrer um erro uma excessão é gerada.
	* @return boolean true se o comando foi realizado com suxesso, caso contrário false
	* @access public
	*/	
		public function Backup(){ /* Falta implementar! */ }
}
