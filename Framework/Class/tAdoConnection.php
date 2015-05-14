<?php 

require_once("iAdoConnection.php");

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
 * 
 * @package Framework
 * @subpackage Ado
 * @version 1.0 - 2006-08-12 17:00:00
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os diretos reservados.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
 
class AdoServerException extends Exception {}

/**
 * Adelaide Framework  
 * Copyright (C) 2006,2013 Diego Botelho Martins
 *
 * Este programa é um software livre; você pode redistribui-lo e/ou 
 * modifica-lo dentro dos termos da Licença Pública Geral GNU como 
 * publicada pela Fundação do Software Livre (FSF); na versão 3 da 
 * Licença, ou (a seu critério) qualquer versão.
 * 
 * Este programa é distribuido na esperança que possa ser  util, 
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
 * along with this program. If not, see <http://www.gnu.org/licenses/> * 
 * 
 * Classe base para gerenciar conexões com SGBD's. 
 * Suas classes filhas devem implementar os métodos difinidos na interface IAdoConnection.
 * @package Framework
 * @subpackage Ado
 * @version 1.0 - 2006-08-12 17:00:00 
 * @author Diego Botelho Martins <dibmartins@yahoo.com.br>
 * @link http://www.php.net/manual/pt_BR/language.oop5.overloading.php
 * @link http://www.diegobotelho.com.br
 * @copyright 2009 Diego Botelho - Todos os direitos reservados
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

abstract class AdoConnection implements InterfaceAdoConnection
{

   /** 
    * Attributes:
    */   
   
   /**
	* @var string $strHost
	* @access private
	*/
	private $strHost;
	
   /**
	* @var int $intPort
	* @access private
	*/
	private $intPort;	
		
   /**
	* @var string $strUser
	* @access private
	*/
	private $strUser;

   /**
	* @var string $strPassword
	* @access private
	*/
	private $strPassword;

   /**
	* @var string $strDatabase
	* @access private
	*/
	private $strDatabase;
	
   /**
	* @var string $strDSN
	* @access private
	*/
	private $strDSN;	
	
   /**
	* @var string $strConnection
	* @access private
	*/
	private $strConnection;
	
   /**
	* @var string $strSQL
	* @access private
	*/
	private $strSQL;
   
   /**
	* @var int $intRows
	* @access private
	*/
	private $intRows;
	
   /**
	* @var int $intInsertId
	* @access private
	*/
	private $intInsertId;	
	
   /**
	* @var string $strPathBackup
	* @access private
	*/
	private $strPathBackup;

   /**
	* @var resource $rscResult
	* @access private
	*/
	private $rscResult;

//---------------------------------------------------------------------------------------------	

   /** 
    * Properties:
    */   
   
   /**
	* Método para setar o valor do atributo $strHost
	* @param string $host Endereço IP do servidor de banco de dados
	* @return void		 
	* @access public
	*/
		public function SetHost($host)
		{
			 $this->strHost = (string) $host;				
		}

   /**
	* Método para retornar o valor do atributo $strHost
	* @return string $strHost
	* @access public
	*/
		public function GetHost()
		{
			 return $this->strHost;
		} 
	
   /**
	* Método para setar o valor do atributo $intPort
	* @param int $port Porta de conexão do servidor de banco de dados
	* @return void		 
	* @access public
	*/
		public function SetPort($port)
		{
			 $this->intPort = (string) $port;				
		}

   /**
	* Método para retornar o valor do atributo $intPort
	* @return int $intPort
	* @access public
	*/
		public function GetPort()
		{
			 return $this->intPort;
		} 	
	
   /**
	* Método para setar o valor do atributo $strUser
	* @param string $user usuário de acesso ao bando de dados
	* @return void		 
	* @access public
	*/
		public function SetUser($user)
		{
			 $this->strUser = (string) $user;				
		}

   /**
	* Método para retornar o valor do atributo $strUser
	* @return string $strUser
	* @access public
	*/
		public function GetUser()
		{
			 return $this->strUser;
		}	

   /**
	* Método para setar o valor do atributo $strPassword
	* @param string $password Senha de acesso ao bando de dados
	* @return void		 
	* @access public
	*/
		public function SetPassword($password)
		{
			 $this->strPassword = (string) $password;				
		}

   /**
	* Método para retornar o valor do atributo $strPassword
	* @return string $strPassword
	* @access public
	*/
		public function GetPassword()
		{
			 return $this->strPassword;
		}
		
   /**
	* Método para setar o valor do atributo $strDatabase
	* @param string $database Banco de dados a ser utilizado
	* @return void		 
	* @access public
	*/
		public function SetDatabase($database)
		{
			 $this->strDatabase = (string) $database;				
		}

   /**
	* Método para retornar o valor do atributo $strDatabase
	* @return string $strDatabase
	* @access public
	*/
		public function GetDatabase()
		{
			 return $this->strDatabase;
		}

   /**
	* Método para setar o valor do atributo $strDSN
	* @param string $dsn string DSN para conexão com servidor de banco de dados via ODBC
	* @return void		 
	* @access public
	*/
		public function SetDSN($dsn)
		{
			 $this->strDSN = $dsn;
		}

   /**
	* Método para retornar o valor do atributo $strDSN
	* @return string $strDSN
	* @access public
	*/
		public function GetDSN()
		{
			 return $this->strDSN;
		}

   /**
	* Método para setar o valor do atributo $strConnection
	* @param string $connection Handler de conexão com o SGBD
	* @return void		 
	* @access public
	*/
		public function SetConnection($connection)
		{
			 $this->strConnection = $connection;				
		}

   /**
	* Método para retornar o valor do atributo $strConnection
	* @return string $strConnection
	* @access public
	*/
		public function GetConnection()
		{
			 return $this->strConnection;
		}	

   /**
	* Método para setar o valor do atributo $strSQL
	* @param string $sql Comando a ser executado no SGBD
	* @return void		 
	* @access public
	*/
		public function SetSQL($sql)
		{
			 $this->strSQL = (string) $sql;
		}

   /**
	* Método para retornar o valor do atributo $strSQL
	* @return string $strSQL
	* @access public
	*/
		public function GetSQL()
		{
			 return $this->strSQL;
		}

   /**
	* Método para setar o valor do atributo $intRows
	* @param int $rows Linhas afetadas pela consulta SQL
	* @return void		 
	* @access public
	*/
		public function SetRows($rows)
		{
			 $this->intRows = (int) $rows;				
		}

   /**
	* Método para retornar o valor do atributo $intRows
	* @return int $intRows
	* @access public
	*/
		public function GetRows()
		{
			 return $this->intRows;
		}		

   /**
	* Método para setar o valor do atributo $intInsertId
	* @param int $rows último id inserido no banco de dados
	* @return void		 
	* @access public
	*/
		public function SetInsertId($id)
		{
			 $this->intInsertId = (int) $id;				
		}

   /**
	* Método para retornar o valor do atributo $intInsertId
	* @return int $intInsertId
	* @access public
	*/
		public function GetInsertId()
		{
			 return $this->intInsertId;
		}		
		
   /**
	* Método para setar o valor do atributo $strPathBackup
	* @param string $path Armazena o diretório onde será gerado o backup da base.
	* @return void		 
	* @access public
	*/
		public function SetPathBackup($path)
		{
			 $this->strPathBackup = (string) $path;				
		}

   /**
	* Método para retornar o valor do atributo $strPathBackup
	* @return string $strPathBackup
	* @access public
	*/
		public function GetPathBackup()
		{
		     return $this->strPathBackup;
		} 

   /**
	* Método para setar o valor do atributo $rscResult
	* @param resource $result Resultado da consulta
	* @return void		 
	* @access public
	*/
		public function SetResult($result)
		{
			 $this->rscResult = $result;
		}

   /**
	* Método para retornar o valor do atributo $rscResult
	* @return string $rscResult
	* @access public
	*/
		public function GetResult()
		{
			 return $this->rscResult;
		}

//---------------------------------------------------------------------------------------------	
		
   /** 
    * Methods:
    */
   
   /**
	* Método construtor da classe
	* Configura os dados de conexão
	* @return void
	* @access protected
	*/
		protected function __construct()
		{
			 $this->SetHost(SystemConfig::ADO_HOST);
			 $this->SetPort(SystemConfig::ADO_PORT);
			 $this->SetUser(SystemConfig::ADO_USER);
			 $this->SetPassword(SystemConfig::ADO_PASSWORD);
			 $this->SetDatabase(SystemConfig::ADO_DATABASE);
			 $this->SetDSN(SystemConfig::ADO_DSN);
			 $this->SetPathBackup(SystemConfig::ADO_PATH_BACKUP);
			 $this->SetConnection(NULL);
			 $this->SetResult(NULL);
			 $this->SetRows(0);
			 $this->SetInsertId(0);
			 $this->SetSql('');
		}
		
   /**
	* Envia uma mensagem de e-mail relatando o erro do servidor de banco de dados:
	* AdoConnection::strReportError tem que estar setado como true para que o e-mail seja enviado
	* @param string $strErrorMessage Mensagem de erro do servidor
	* @param string $strErrorCode código do erro do servidor
	* @return void
	* @access protected
	*/
		protected function reportError($strErrorMessage, $intErrorCode = '')
		{
			try
			{
				if(SystemConfig::ADO_REPORT_ERROR)
				{
					$strTexto = "<p>Abaixo segue informações detalhadas sobre o erro gerado pelo <strong>Servidor de Banco de Dados</strong>.</p>";
					$strTexto.= "<p>Por favor, tente corrigi-lo o mais rápido possível.</p>";
					
					$arInformacoes = array( $intErrorCode          => $strErrorMessage,
											"Página" 		       => $_SERVER["SCRIPT_NAME"], 
											"Navegador utilizado"  => $_SERVER["HTTP_USER_AGENT"], 
											"Endereço IP"   	   => $_SERVER["REMOTE_ADDR"],
											"Gerado em"		       => date('d/m/Y, H:i:s'));
					
					// Configurando os dados de envio
					$objEmail = new EmailContato();
					$objEmail->SetArquivo(SystemConfig::PATH . "/Web/utils/emails/admin.htm");
					$objEmail->SetAssunto("[ ERRO ] Servidor de Banco de Dados");
					$objEmail->SetTextoChamada($strTexto);
					$objEmail->SetInformacoes($arInformacoes);
					$objEmail->Priority = 1;
					
					// Configurando o remetente da mensagem
					$objEmail->From     = SystemConfig::SYSTEM_EMAIL;
					$objEmail->FromName = "RG Sistemas";
					
					// Configurando o destinatário da mensagem
					$objEmail->AddAddress(SystemConfig::SYSTEM_EMAIL, "Suporte Técnico");
					
					// Se o envio a RG Sistemas for OK, envie ao usuário em questáo também.
					$objEmail->Enviar();
				}
			}
			catch(Exception $e)
			{
			    throw $e;
			}
	    }

   /**
	* Reinicia os atributos da classe
	* Configura os dados de conexão
	* @return void
	* @access protected
	*/
		protected function __Clear()
		{
			 $this->SetResult(NULL);
			 $this->SetRecordSet(NULL);
			 $this->SetRows(0);
			 $this->SetInsertId(0);
			 $this->SetSql('');			 
		}
}
